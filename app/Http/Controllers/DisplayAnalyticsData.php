<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessEvent;
use App\Models\Site;
use App\Models\Analytic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DisplayAnalyticsData extends Controller
{

     protected function validator(array $data, array $rules)
    {
        return Validator::make($data, $rules, [
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute must be a valid string.',
            'unique' => 'The :attribute is already registered.',
            'url' => 'The :attribute must be a valid URL (e.g., https://example.com).',
            'in' => 'The :attribute must be one of: :values.',
            'date' => 'The :attribute must be a valid date (e.g., YYYY-MM-DD).',
            'integer' => 'The :attribute must be an integer.',
            'min' => 'The :attribute must be at least :min.',
            'max' => 'The :attribute may not be greater than :max characters.',
        ]);
    }



    public function showAnalyticsDashboard(Request $request)
    {
        $siteId = $request->input('site_id', 'all');
        $period = $request->input('period', 'this_month');
        $periods = ['today', 'yesterday', 'this_week', 'this_month', 'last_month', 'last_two_months', 'this_year'];

        $today = Carbon::today()->startOfDay();
        $todayEnd = Carbon::today()->endOfDay();
        $yesterday = Carbon::yesterday()->startOfDay();
        $yesterdayEnd = Carbon::yesterday()->endOfDay();
        $thisWeekStart = Carbon::now()->startOfWeek();
        $thisMonthStart = Carbon::now()->startOfMonth();
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();
        $lastTwoMonthsStart = Carbon::now()->subMonths(2)->startOfMonth();
        $thisYearStart = Carbon::now()->startOfYear();

        $periodRanges = [
            'today' => ['start' => $today, 'end' => $todayEnd],
            'yesterday' => ['start' => $yesterday, 'end' => $yesterdayEnd],
            'this_week' => ['start' => $thisWeekStart, 'end' => Carbon::now()],
            'this_month' => ['start' => $thisMonthStart, 'end' => Carbon::now()],
            'last_month' => ['start' => $lastMonthStart, 'end' => $lastMonthEnd],
            'last_two_months' => ['start' => $lastTwoMonthsStart, 'end' => $lastMonthEnd],
            'this_year' => ['start' => $thisYearStart, 'end' => Carbon::now()],
        ];

        $range = $periodRanges[$period] ?? $periodRanges['this_month'];

        $analytics = [];

        if ($siteId === 'all') {
            $sites = Site::all();
            foreach ($sites as $site) {
                $analytics[$site->domain] = $this->getSiteAnalytics($site, $range, $period);
            }

            // Aggregate data for all sites
            $combined = [
                'site_id' => 'all',
                'name' => 'All Sites',
                'all_time' => $this->getCombinedAnalytics($sites),
                'periods' => [
                    $period => $this->getCombinedPeriodAnalytics($sites, $range),
                ],
            ];
            $analytics['combined'] = $combined;
        } else {
            $site = Site::find($siteId);
            if ($site) {
                $analytics[$site->domain] = $this->getSiteAnalytics($site, $range, $period);
            }
        }

        return view('analytics.dashboard', compact('analytics', 'periods'));
    }

    private function getSiteAnalytics($site, $range, $period)
    {
        $views = Analytic::where('site_id', $site->id)
            ->where('event_type', 'pageview')
            ->whereBetween('created_at', [$range['start'], $range['end']])
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as period, COUNT(*) as count')
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        $clicks = Analytic::where('site_id', $site->id)
            ->where('event_type', 'click')
            ->whereBetween('created_at', [$range['start'], $range['end']])
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as period, COUNT(*) as count')
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        // $customEvents = Analytic::where('site_id', $site->id)
        //     ->whereNotIn('event_type', ['pageview', 'click', 'site_registered'])
        //     ->whereBetween('created_at', [$range['start'], $range['end']])
        //     ->selectRaw('event_type, DATE_FORMAT(created_at, "%Y-%m-%d") as period, COUNT(*) as count, custom_data')
        //     ->groupBy('event_type', 'period')
        //     ->orderBy('period')
        //     ->get();

        $customEvents = Analytic::where('site_id', $site->id)
    ->whereNotIn('event_type', ['pageview', 'click', 'site_registered'])
    ->whereBetween('created_at', [$range['start'], $range['end']])
    ->selectRaw('event_type, DATE_FORMAT(created_at, "%Y-%m-%d") as period, COUNT(*) as count, GROUP_CONCAT(custom_data) as custom_data')
    ->groupBy('event_type', 'period')
    ->orderBy('period')
    ->get();

        $topPages = Analytic::where('site_id', $site->id)
            ->where('event_type', 'pageview')
            ->whereBetween('created_at', [$range['start'], $range['end']])
            ->select('page_url', DB::raw('COUNT(*) as views'))
            ->groupBy('page_url')
            ->orderByDesc('views')
            ->limit(30)
            ->get();

        $uniqueVisitors = Analytic::where('site_id', $site->id)
            ->where('event_type', 'pageview')
            ->whereBetween('created_at', [$range['start'], $range['end']])
            ->selectRaw('COUNT(DISTINCT COALESCE(session_id, ip_address)) as count')
            ->first()->count;

        $newVisitors = Analytic::where('site_id', $site->id)
            ->where('event_type', 'pageview')
            ->whereBetween('created_at', [$range['start'], $range['end']])
            ->whereNotExists(function ($query) use ($site, $range) {
                $query->select(DB::raw(1))
                    ->from('analytics')
                    ->whereRaw('COALESCE(analytics.session_id, analytics.ip_address) = COALESCE(session_id, ip_address)')
                    ->where('site_id', $site->id)
                    ->where('event_type', 'pageview')
                    ->where('created_at', '<', $range['start']);
            })
            ->selectRaw('COUNT(DISTINCT COALESCE(session_id, ip_address)) as count')
            ->first()->count;

        $returningVisitors = Analytic::where('site_id', $site->id)
            ->where('event_type', 'pageview')
            ->whereBetween('created_at', [$range['start'], $range['end']])
            ->whereExists(function ($query) use ($site, $range) {
                $query->select(DB::raw(1))
                    ->from('analytics')
                    ->whereRaw('COALESCE(analytics.session_id, analytics.ip_address) = COALESCE(session_id, ip_address)')
                    ->where('site_id', $site->id)
                    ->where('event_type', 'pageview')
                    ->where('created_at', '<', $range['start']);
            })
            ->selectRaw('COUNT(DISTINCT COALESCE(session_id, ip_address)) as count')
            ->first()->count;

        $onlineVisitors = Analytic::where('site_id', $site->id)
            ->where('event_type', 'pageview')
            ->where('created_at', '>=', Carbon::now()->subMinutes(5))
            ->selectRaw('COUNT(DISTINCT COALESCE(session_id, ip_address)) as count')
            ->first()->count;

        $avgSessionDuration = Analytic::where('site_id', $site->id)
            ->where('event_type', 'pageview')
            ->whereBetween('created_at', [$range['start'], $range['end']])
            ->whereNotNull('session_duration')
            ->avg('session_duration');

        $byCountry = Analytic::where('site_id', $site->id)
            ->where('event_type', 'pageview')
            ->whereBetween('created_at', [$range['start'], $range['end']])
            ->select('country', DB::raw('COUNT(*) as count'))
            ->groupBy('country')
            ->orderByDesc('count')
            ->get();

        $allTime = [
            'views' => Analytic::where('site_id', $site->id)
                ->where('event_type', 'pageview')
                ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as period, COUNT(*) as count')
                ->groupBy('period')
                ->orderBy('period')
                ->get(),
            'clicks' => Analytic::where('site_id', $site->id)
                ->where('event_type', 'click')
                ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as period, COUNT(*) as count')
                ->groupBy('period')
                ->orderBy('period')
                ->get(),
            // 'custom_events' => Analytic::where('site_id', $site->id)
            //     ->whereNotIn('event_type', ['pageview', 'click', 'site_registered'])
            //     ->selectRaw('event_type, DATE_FORMAT(created_at, "%Y-%m-%d") as period, COUNT(*) as count, custom_data')
            //     ->groupBy('event_type', 'period')
            //     ->orderBy('period')
            //     ->get(),
            'top_pages' => Analytic::where('site_id', $site->id)
                ->where('event_type', 'pageview')
                ->select('page_url', DB::raw('COUNT(*) as views'))
                ->groupBy('page_url')
                ->orderByDesc('views')
                ->limit(30)
                ->get(),
            'unique_visitors' => Analytic::where('site_id', $site->id)
                ->where('event_type', 'pageview')
                ->selectRaw('COUNT(DISTINCT COALESCE(session_id, ip_address)) as count')
                ->first()->count,
            'new_visitors' => Analytic::where('site_id', $site->id)
                ->where('event_type', 'pageview')
                ->whereNotExists(function ($query) use ($site) {
                    $query->select(DB::raw(1))
                        ->from('analytics as a2')
                        ->whereRaw('COALESCE(a2.session_id, a2.ip_address) = COALESCE(analytics.session_id, analytics.ip_address)')
                        ->where('a2.site_id', $site->id)
                        ->where('a2.event_type', 'pageview')
                        ->whereColumn('a2.created_at', '<', 'analytics.created_at');
                })
                ->selectRaw('COUNT(DISTINCT COALESCE(session_id, ip_address)) as count')
                ->first()->count,
            'returning_visitors' => Analytic::where('site_id', $site->id)
                ->where('event_type', 'pageview')
                ->whereExists(function ($query) use ($site) {
                    $query->select(DB::raw(1))
                        ->from('analytics as a2')
                        ->whereRaw('COALESCE(a2.session_id, a2.ip_address) = COALESCE(analytics.session_id, analytics.ip_address)')
                        ->where('a2.site_id', $site->id)
                        ->where('a2.event_type', 'pageview')
                        ->whereColumn('a2.created_at', '<', 'analytics.created_at');
                })
                ->selectRaw('COUNT(DISTINCT COALESCE(session_id, ip_address)) as count')
                ->first()->count,
            'online_visitors' => Analytic::where('site_id', $site->id)
                ->where('event_type', 'pageview')
                ->where('created_at', '>=', Carbon::now()->subMinutes(5))
                ->selectRaw('COUNT(DISTINCT COALESCE(session_id, ip_address)) as count')
                ->first()->count,
            'avg_session_duration' => round(Analytic::where('site_id', $site->id)
                ->where('event_type', 'pageview')
                ->whereNotNull('session_duration')
                ->avg('session_duration') ?? 0, 2),
            'by_country' => Analytic::where('site_id', $site->id)
                ->where('event_type', 'pageview')
                ->select('country', DB::raw('COUNT(*) as count'))
                ->groupBy('country')
                ->orderByDesc('count')
                ->get(),
        ];

        return [
            'site_id' => $site->id,
            'name' => $site->name,
            'all_time' => $allTime,
            'periods' => [
                $period => [
                    'views' => $views,
                    'clicks' => $clicks,
                    'custom_events' => $customEvents,
                    'top_pages' => $topPages,
                    'unique_visitors' => $uniqueVisitors,
                    'new_visitors' => $newVisitors,
                    'returning_visitors' => $returningVisitors,
                    'online_visitors' => $onlineVisitors,
                    'avg_session_duration' => round($avgSessionDuration ?? 0, 2),
                    'by_country' => $byCountry,
                ],
            ],
        ];
    }

    private function getCombinedAnalytics($sites)
    {
        $allViews = Analytic::whereIn('site_id', $sites->pluck('id'))
            ->where('event_type', 'pageview')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as period, COUNT(*) as count')
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        $allClicks = Analytic::whereIn('site_id', $sites->pluck('id'))
            ->where('event_type', 'click')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as period, COUNT(*) as count')
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        // $allCustomEvents = Analytic::whereIn('site_id', $sites->pluck('id'))
        //     ->whereNotIn('event_type', ['pageview', 'click', 'site_registered'])
        //     ->selectRaw('event_type, DATE_FORMAT(created_at, "%Y-%m-%d") as period, COUNT(*) as count, custom_data')
        //     ->groupBy('event_type', 'period')
        //     ->orderBy('period')
        //     ->get();

        $allTopPages = Analytic::whereIn('site_id', $sites->pluck('id'))
            ->where('event_type', 'pageview')
            ->select('page_url', DB::raw('COUNT(*) as views'))
            ->groupBy('page_url')
            ->orderByDesc('views')
            ->limit(30)
            ->get();

        $allUniqueVisitors = Analytic::whereIn('site_id', $sites->pluck('id'))
            ->where('event_type', 'pageview')
            ->selectRaw('COUNT(DISTINCT COALESCE(session_id, ip_address)) as count')
            ->first()->count;

        $allNewVisitors = Analytic::whereIn('site_id', $sites->pluck('id'))
            ->where('event_type', 'pageview')
            ->whereNotExists(function ($query) use ($sites) {
                $query->select(DB::raw(1))
                    ->from('analytics as a2')
                    ->whereRaw('COALESCE(a2.session_id, a2.ip_address) = COALESCE(analytics.session_id, analytics.ip_address)')
                    ->whereIn('a2.site_id', $sites->pluck('id'))
                    ->where('a2.event_type', 'pageview')
                    ->whereColumn('a2.created_at', '<', 'analytics.created_at');
            })
            ->selectRaw('COUNT(DISTINCT COALESCE(session_id, ip_address)) as count')
            ->first()->count;

        $allReturningVisitors = Analytic::whereIn('site_id', $sites->pluck('id'))
            ->where('event_type', 'pageview')
            ->whereExists(function ($query) use ($sites) {
                $query->select(DB::raw(1))
                    ->from('analytics as a2')
                    ->whereRaw('COALESCE(a2.session_id, a2.ip_address) = COALESCE(analytics.session_id, analytics.ip_address)')
                    ->whereIn('a2.site_id', $sites->pluck('id'))
                    ->where('a2.event_type', 'pageview')
                    ->whereColumn('a2.created_at', '<', 'analytics.created_at');
            })
            ->selectRaw('COUNT(DISTINCT COALESCE(session_id, ip_address)) as count')
            ->first()->count;

        $allOnlineVisitors = Analytic::whereIn('site_id', $sites->pluck('id'))
            ->where('event_type', 'pageview')
            ->where('created_at', '>=', Carbon::now()->subMinutes(5))
            ->selectRaw('COUNT(DISTINCT COALESCE(session_id, ip_address)) as count')
            ->first()->count;

        $allAvgSessionDuration = Analytic::whereIn('site_id', $sites->pluck('id'))
            ->where('event_type', 'pageview')
            ->whereNotNull('session_duration')
            ->avg('session_duration');

        $allByCountry = Analytic::whereIn('site_id', $sites->pluck('id'))
            ->where('event_type', 'pageview')
            ->select('country', DB::raw('COUNT(*) as count'))
            ->groupBy('country')
            ->orderByDesc('count')
            ->get();

        return [
            'views' => $allViews,
            'clicks' => $allClicks,
            //'custom_events' => $allCustomEvents,
            'top_pages' => $allTopPages,
            'unique_visitors' => $allUniqueVisitors,
            'new_visitors' => $allNewVisitors,
            'returning_visitors' => $allReturningVisitors,
            'online_visitors' => $allOnlineVisitors,
            'avg_session_duration' => round($allAvgSessionDuration ?? 0, 2),
            'by_country' => $allByCountry,
        ];
    }

    private function getCombinedPeriodAnalytics($sites, $range)
    {
        $views = Analytic::whereIn('site_id', $sites->pluck('id'))
            ->where('event_type', 'pageview')
            ->whereBetween('created_at', [$range['start'], $range['end']])
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as period, COUNT(*) as count')
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        $clicks = Analytic::whereIn('site_id', $sites->pluck('id'))
            ->where('event_type', 'click')
            ->whereBetween('created_at', [$range['start'], $range['end']])
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as period, COUNT(*) as count')
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        // $customEvents = Analytic::whereIn('site_id', $sites->pluck('id'))
        //     ->whereNotIn('event_type', ['pageview', 'click', 'site_registered'])
        //     ->whereBetween('created_at', [$range['start'], $range['end']])
        //     ->selectRaw('event_type, DATE_FORMAT(created_at, "%Y-%m-%d") as period, COUNT(*) as count, custom_data')
        //     ->groupBy('event_type', 'period')
        //     ->orderBy('period')
        //     ->get();

        $topPages = Analytic::whereIn('site_id', $sites->pluck('id'))
            ->where('event_type', 'pageview')
            ->whereBetween('created_at', [$range['start'], $range['end']])
            ->select('page_url', DB::raw('COUNT(*) as views'))
            ->groupBy('page_url')
            ->orderByDesc('views')
            ->limit(30)
            ->get();

        $uniqueVisitors = Analytic::whereIn('site_id', $sites->pluck('id'))
            ->where('event_type', 'pageview')
            ->whereBetween('created_at', [$range['start'], $range['end']])
            ->selectRaw('COUNT(DISTINCT COALESCE(session_id, ip_address)) as count')
            ->first()->count;

        $newVisitors = Analytic::whereIn('site_id', $sites->pluck('id'))
            ->where('event_type', 'pageview')
            ->whereBetween('created_at', [$range['start'], $range['end']])
            ->whereNotExists(function ($query) use ($sites, $range) {
                $query->select(DB::raw(1))
                    ->from('analytics')
                    ->whereRaw('COALESCE(analytics.session_id, analytics.ip_address) = COALESCE(session_id, ip_address)')
                    ->whereIn('site_id', $sites->pluck('id'))
                    ->where('event_type', 'pageview')
                    ->where('created_at', '<', $range['start']);
            })
            ->selectRaw('COUNT(DISTINCT COALESCE(session_id, ip_address)) as count')
            ->first()->count;

        $returningVisitors = Analytic::whereIn('site_id', $sites->pluck('id'))
            ->where('event_type', 'pageview')
            ->whereBetween('created_at', [$range['start'], $range['end']])
            ->whereExists(function ($query) use ($sites, $range) {
                $query->select(DB::raw(1))
                    ->from('analytics')
                    ->whereRaw('COALESCE(analytics.session_id, analytics.ip_address) = COALESCE(session_id, ip_address)')
                    ->whereIn('site_id', $sites->pluck('id'))
                    ->where('event_type', 'pageview')
                    ->where('created_at', '<', $range['start']);
            })
            ->selectRaw('COUNT(DISTINCT COALESCE(session_id, ip_address)) as count')
            ->first()->count;

        $onlineVisitors = Analytic::whereIn('site_id', $sites->pluck('id'))
            ->where('event_type', 'pageview')
            ->where('created_at', '>=', Carbon::now()->subMinutes(5))
            ->selectRaw('COUNT(DISTINCT COALESCE(session_id, ip_address)) as count')
            ->first()->count;

        $avgSessionDuration = Analytic::whereIn('site_id', $sites->pluck('id'))
            ->where('event_type', 'pageview')
            ->whereBetween('created_at', [$range['start'], $range['end']])
            ->whereNotNull('session_duration')
            ->avg('session_duration');

        $byCountry = Analytic::whereIn('site_id', $sites->pluck('id'))
            ->where('event_type', 'pageview')
            ->whereBetween('created_at', [$range['start'], $range['end']])
            ->select('country', DB::raw('COUNT(*) as count'))
            ->groupBy('country')
            ->orderByDesc('count')
            ->get();

        return [
            'views' => $views,
            'clicks' => $clicks,
            //'custom_events' => $customEvents,
            'top_pages' => $topPages,
            'unique_visitors' => $uniqueVisitors,
            'new_visitors' => $newVisitors,
            'returning_visitors' => $returningVisitors,
            'online_visitors' => $onlineVisitors,
            'avg_session_duration' => round($avgSessionDuration ?? 0, 2),
            'by_country' => $byCountry,
        ];
    }

    public function trackDynamicEvent(Request $request)
    {
        $validator = $this->validator($request->all(), [
            'api_key' => 'required|string',
            'event_type' => 'required|string',
            'page_url' => 'required|url',
            'element_id' => 'nullable|string|max:255',
            'session_duration' => 'nullable|integer|min:0',
            'user_agent' => 'nullable|string|max:1000',
            'session_id' => 'nullable|string',
            'custom_data' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            Log::warning('Dynamic event tracking validation failed', [
                'errors' => $validator->errors()->all(),
                'input' => $request->except('api_key'),
            ]);
            return $this->standardizedResponse([
                'error' => 'Validation failed',
                'details' => $validator->errors()->all(),
            ], 422);
        }

        $site = Site::where('api_key', $request->api_key)->first();

        if (!$site) {
            Log::warning('Invalid API key for dynamic event tracking', [
                'api_key' => $request->api_key,
            ]);
            return $this->standardizedResponse([
                'error' => 'Invalid API key',
                'details' => 'The provided API key does not match any registered site.',
            ], 403);
        }

        $parsedPageUrl = parse_url($request->page_url, PHP_URL_HOST);
        $parsedSiteDomain = parse_url($site->domain, PHP_URL_HOST);
        if ($parsedPageUrl !== $parsedSiteDomain) {
            Log::warning('Page URL does not match site domain', [
                'page_url' => $request->page_url,
                'site_domain' => $site->domain,
            ]);
            return $this->standardizedResponse([
                'error' => 'Invalid page URL',
                'details' => 'The page URL does not belong to the registered site domain.',
            ], 403);
        }

        try {
            $data = [
                'site_id' => $site->id,
                'event_type' => $request->event_type,
                'page_url' => $request->page_url,
                'element_id' => $request->element_id ?? null,
                'ip_address' => $request->ip(),
                'user_agent' => $request->user_agent ?? $request->userAgent(),
                'session_duration' => $request->session_duration ?? null,
                'session_id' => $request->session_id ?? null,
                'custom_data' => $request->custom_data ? json_encode($request->custom_data) : null,
            ];

            ProcessEvent::dispatch($data);

            Log::info('Dynamic event tracked successfully', [
                'site_id' => $site->id,
                'event_type' => $data['event_type'],
                'page_url' => $data['page_url'],
                'session_id' => $data['session_id'],
            ]);

            return $this->standardizedResponse([
                'message' => 'Dynamic event tracked successfully',
                'event_type' => $request->event_type,
                'page_url' => $request->page_url,
            ], 202);
        } catch (\Exception $e) {
            Log::error('Dynamic event tracking failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->standardizedResponse([
                'error' => 'Failed to track dynamic event',
                'details' => 'An unexpected server error occurred.',
            ], 500);
        }
    }

      protected function standardizedResponse($data, $status = 200)
    {
        return response()->json(array_merge([
            'status' => $status < 400 ? 'success' : 'error',
            'timestamp' => now()->toIso8601String(),
        ], $data), $status);
    }
}