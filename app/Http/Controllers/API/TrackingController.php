<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessEvent;
use App\Models\Site;
use App\Models\Analytic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TrackingController extends Controller
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

    protected function standardizedResponse($data, $status = 200)
    {
        return response()->json(array_merge([
            'status' => $status < 400 ? 'success' : 'error',
            'timestamp' => now()->toIso8601String(),
        ], $data), $status);
    }

    public function registerSite(Request $request)
    {
        $validator = $this->validator($request->all(), [
            'domain' => 'required|string|unique:sites|max:255',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            Log::warning('Site registration validation failed', [
                'errors' => $validator->errors()->all(),
                'input' => $request->except('api_key'),
            ]);
            return $this->standardizedResponse([
                'error' => 'Validation failed',
                'details' => $validator->errors()->all(),
            ], 422);
        }

        $apiKey = Str::uuid()->toString();

        try {
            $site = Site::create([
                'domain' => rtrim($request->domain, '/'),
                'name' => $request->name,
                'api_key' => $apiKey,
            ]);

            ProcessEvent::dispatch([
                'site_id' => $site->id,
                'event_type' => 'site_registered',
                'page_url' => $site->domain,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            Log::info('Site registered successfully', [
                'site_id' => $site->id,
                'domain' => $site->domain,
            ]);

            return $this->standardizedResponse([
                'message' => 'Site registered successfully',
                'site' => [
                    'id' => $site->id,
                    'domain' => $site->domain,
                    'name' => $site->name,
                    'api_key' => $site->api_key,
                ],
                'tracking_code' => "<script src=\"".config('app.api_domain')."/api/tracker.js?api_key={$apiKey}\"></script>",
            ], 201);
        } catch (\Exception $e) {
            Log::error('Site registration failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->standardizedResponse([
                'error' => 'Failed to register site',
                'details' => 'An unexpected server error occurred.',
            ], 500);
        }
    }

   public function trackEvent(Request $request)
{
    $validator = $this->validator($request->all(), [
        'api_key' => 'required|string',
        'event_type' => 'required|string|in:pageview,click',
        'page_url' => 'required|url',
        'element_id' => 'nullable|string|max:255',
        'session_duration' => 'nullable|integer|min:0',
        'user_agent' => 'nullable|string|max:1000',
        'session_id' => 'nullable|string', 
    ]);

    if ($validator->fails()) {
        Log::warning('Event tracking validation failed', [
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
        Log::warning('Invalid API key for event tracking', [
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
            'session_id' => $request->session_id ?? null, // Handle null session_id
        ];

        ProcessEvent::dispatch($data);

        Log::info('Event tracked successfully', [
            'site_id' => $site->id,
            'event_type' => $data['event_type'],
            'page_url' => $data['page_url'],
            'session_id' => $data['session_id'],
        ]);

        return $this->standardizedResponse([
            'message' => 'Event tracked successfully',
            'event_type' => $request->event_type,
            'page_url' => $request->page_url,
        ], 202);
    } catch (\Exception $e) {
        Log::error('Event tracking failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        return $this->standardizedResponse([
            'error' => 'Failed to track event',
            'details' => 'An unexpected server error occurred.',
        ], 500);
    }
}

public function getAnalytics(Request $request)
{
    $validator = $this->validator($request->all(), [
        'api_key' => 'required|string',
    ]);

    if ($validator->fails()) {
        Log::warning('Analytics retrieval validation failed', [
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
        Log::warning('Invalid API key for analytics', [
            'api_key' => $request->api_key,
        ]);
        return $this->standardizedResponse([
            'error' => 'Invalid API key',
            'details' => 'The provided API key does not match any registered site.',
        ], 403);
    }

    try {
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

        $periods = [
            'today' => ['start' => $today, 'end' => $todayEnd],
            'yesterday' => ['start' => $yesterday, 'end' => $yesterdayEnd],
            'this_week' => ['start' => $thisWeekStart, 'end' => Carbon::now()],
            'this_month' => ['start' => $thisMonthStart, 'end' => Carbon::now()],
            'last_month' => ['start' => $lastMonthStart, 'end' => $lastMonthEnd],
            'last_two_months' => ['start' => $lastTwoMonthsStart, 'end' => $lastMonthEnd],
            'this_year' => ['start' => $thisYearStart, 'end' => Carbon::now()],
        ];

        $analytics = [];

        foreach ($periods as $period => $range) {
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

            $dailyVisitors = Analytic::where('site_id', $site->id)
                ->where('event_type', 'pageview')
                ->whereBetween('created_at', [$range['start'], $range['end']])
                ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as period, COUNT(DISTINCT COALESCE(session_id, ip_address)) as count')
                ->groupBy('period')
                ->orderBy('period')
                ->get();

            $byCountry = Analytic::where('site_id', $site->id)
                ->where('event_type', 'pageview')
                ->whereBetween('created_at', [$range['start'], $range['end']])
                ->select('country', DB::raw('COUNT(*) as count'))
                ->groupBy('country')
                ->orderByDesc('count')
                ->get();

            $analytics[$period] = [
                'views' => $views,
                'clicks' => $clicks,
                'top_pages' => $topPages,
                'unique_visitors' => $uniqueVisitors,
                'new_visitors' => $newVisitors,
                'returning_visitors' => $returningVisitors,
                'daily_visitors' => $dailyVisitors,
                'by_country' => $byCountry,
            ];
        }

        $allViews = Analytic::where('site_id', $site->id)
            ->where('event_type', 'pageview')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as period, COUNT(*) as count')
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        $allClicks = Analytic::where('site_id', $site->id)
            ->where('event_type', 'click')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as period, COUNT(*) as count')
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        $allTopPages = Analytic::where('site_id', $site->id)
            ->where('event_type', 'pageview')
            ->select('page_url', DB::raw('COUNT(*) as views')) // Fixed typo
            ->groupBy('page_url')
            ->orderByDesc('views')
            ->limit(30)
            ->get();

        $allUniqueVisitors = Analytic::where('site_id', $site->id)
            ->where('event_type', 'pageview')
            ->selectRaw('COUNT(DISTINCT COALESCE(session_id, ip_address)) as count')
            ->first()->count;

        $allNewVisitors = Analytic::where('site_id', $site->id)
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
            ->first()->count;

        $allReturningVisitors = Analytic::where('site_id', $site->id)
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
            ->first()->count;

        $allDailyVisitors = Analytic::where('site_id', $site->id)
            ->where('event_type', 'pageview')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as period, COUNT(DISTINCT COALESCE(session_id, ip_address)) as count')
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        $allByCountry = Analytic::where('site_id', $site->id)
            ->where('event_type', 'pageview')
            ->select('country', DB::raw('COUNT(*) as count'))
            ->groupBy('country')
            ->orderByDesc('count')
            ->get();

        Log::info('Analytics retrieved successfully', [
            'site_id' => $site->id,
            'domain' => $site->domain,
        ]);

        return $this->standardizedResponse([
            'message' => 'Analytics retrieved successfully',
            'data' => [
                'domain' => $site->domain,
                'all_time' => [
                    'views' => $allViews,
                    'clicks' => $allClicks,
                    'top_pages' => $allTopPages,
                    'unique_visitors' => $allUniqueVisitors,
                    'new_visitors' => $allNewVisitors,
                    'returning_visitors' => $allReturningVisitors,
                    'daily_visitors' => $allDailyVisitors,
                    'by_country' => $allByCountry,
                ],
                'breakdowns' => $analytics,
            ],
        ], 200);
    } catch (QueryException $e) {
        Log::error('Database error in analytics retrieval', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        return $this->standardizedResponse([
            'error' => 'Failed to retrieve analytics',
            'details' => 'A database error occurred.',
        ], 500);
    } catch (\Exception $e) {
        Log::error('Analytics retrieval failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        return $this->standardizedResponse([
            'error' => 'Failed to retrieve analytics',
            'details' => 'An unexpected server error occurred.',
        ], 500);
    }
}



    public function getTrackingScript(Request $request)
    {
        $validator = $this->validator($request->all(), [
            'api_key' => 'required|string',
        ]);

        if ($validator->fails()) {
            Log::warning('Tracking script request validation failed', [
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
            Log::warning('Invalid API key for tracking script', [
                'api_key' => $request->api_key,
            ]);
            return $this->standardizedResponse([
                'error' => 'Invalid API key',
                'details' => 'The provided API key does not match any registered site.',
            ], 403);
        }

        try {
            $script = file_get_contents(resource_path('js/tracker.js'));
            $script = str_replace('{{API_KEY}}', $request->api_key, $script);
            $script = str_replace('{{API_DOMAIN}}', config('app.api_domain'), $script);

            Log::info('Tracking script served successfully', [
                'site_id' => $site->id,
                'domain' => $site->domain,
            ]);

            return response($script, 200, [
                'Content-Type' => 'application/javascript',
                'Cache-Control' => 'public, max-age=86400',
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to serve tracking script', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->standardizedResponse([
                'error' => 'Failed to serve tracking script',
                'details' => 'An unexpected server error occurred.',
            ], 500);
        }
    }
}