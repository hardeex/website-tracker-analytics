<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessClick;
use App\Jobs\ProcessPageView;
use App\Models\PageView;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class TrackingController extends Controller
{
    
  public function trackPageView(Request $request)
{
    Log::debug('Incoming page view tracking request.', [
        'payload' => $request->all(),
        'ip' => $request->ip(),
        'headers' => $request->headers->all(),
    ]);

    $validated = $request->validate([
        'domain' => 'required|string',
        'page_url' => 'required|url',
        'user_agent' => 'nullable|string',
        'session_duration' => 'nullable|integer|min:0',
    ]);

    Log::debug('Validated request data.', $validated);

    $site = Site::where('domain', $validated['domain'])->first();

    if (!$site) {
        Log::warning('No site found for domain.', ['domain' => $validated['domain']]);
        return response()->json(['error' => 'Site not found.'], 404);
    }

    $user = JWTAuth::user();
    Log::debug('Authenticated user.', ['user_id' => optional($user)->id]);

    // Check if user has access to the site
    if (!$user || $user->id !== $site->user_id) {
        Log::warning('Unauthorized access attempt.', [
            'user_id' => optional($user)->id,
            'site_user_id' => $site->user_id,
        ]);
        return response()->json(['error' => 'Unauthorized for this site'], 403);
    }

    $data = [
    'site_id' => $site->id,
    'page_url' => $validated['page_url'],
    'ip_address' => $request->ip(),
    'user_agent' => $validated['user_agent'] ?? $request->userAgent(),
    'user_id' => $user->id,
    'session_duration' => $validated['session_duration'] ?? null,
];


    Log::info('Dispatching page view job.', $data);

    ProcessPageView::dispatch($data);

    return response()->json(['message' => 'Page view tracked'], 202);
}

    public function trackClick(Request $request)
    {
        $validated = $request->validate([
            'domain' => 'required|string',
            'element_id' => 'nullable|string',
            'page_url' => 'required|url',
            'user_agent' => 'nullable|string',
        ]);

        $site = Site::where('domain', $validated['domain'])->firstOrFail();
        $user = JWTAuth::user();

        if ($user->id !== $site->user_id) {
            return response()->json(['error' => 'Unauthorized for this site'], 403);
        }

        $data = [
            'site_id' => $site->id,
            'element_id' => $validated['element_id'] ?? null,
            'page_url' => $validated['page_url'],
            'ip_address' => $request->ip(),
            'user_agent' => $validated['user_agent'],
            'user_id' => $user->id,
        ];

        ProcessClick::dispatch($data);

        return response()->json(['message' => 'Click tracked'], 202);
    }


//     public function getPageViews(Request $request)
// {
//     $validated = $request->validate([
//         'domain' => 'required|url',
//     ]);

//     $site = Site::where('domain', $validated['domain'])->first();

//     if (!$site) {
//         return response()->json(['error' => 'Site not found.'], 404);
//     }

//     $user = JWTAuth::user();
//     if (!$user || $user->id !== $site->user_id) {
//         return response()->json(['error' => 'Unauthorized'], 403);
//     }

//     $viewsCount = \App\Models\PageView::where('site_id', $site->id)->count();

//     return response()->json([
//         'domain' => $validated['domain'],
//         'views' => $viewsCount,
//     ]);
// }


public function getPageViews2(Request $request)
{
    $validated = $request->validate([
        'domain' => 'required|url',
    ]);

    $site = Site::where('domain', $validated['domain'])->first();

    if (!$site) {
        return response()->json(['error' => 'Site not found.'], 404);
    }

    $user = JWTAuth::user();
    if (!$user || $user->id !== $site->user_id) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $views = [
        'today' => \App\Models\PageView::where('site_id', $site->id)
                    ->whereDate('created_at', today())->count(),

        'yesterday' => \App\Models\PageView::where('site_id', $site->id)
                    ->whereDate('created_at', today()->subDay())->count(),

        'this_week' => \App\Models\PageView::where('site_id', $site->id)
                    ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                    ->count(),

        'last_week' => \App\Models\PageView::where('site_id', $site->id)
                    ->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
                    ->count(),

        'this_month' => \App\Models\PageView::where('site_id', $site->id)
                    ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                    ->count(),

        'last_month' => \App\Models\PageView::where('site_id', $site->id)
                    ->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])
                    ->count(),

        'total' => \App\Models\PageView::where('site_id', $site->id)->count(),
    ];

    return response()->json([
        'domain' => $validated['domain'],
        'views' => $views,
    ]);
}


public function getPageViews(Request $request)
{
    $validated = $request->validate([
        'domain' => 'required|url',
    ]);

    $site = Site::where('domain', $validated['domain'])->first();

    if (!$site) {
        return response()->json(['error' => 'Site not found.'], 404);
    }

    $user = JWTAuth::user();
    if (!$user || $user->id !== $site->user_id) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $views = [
        'today' => PageView::where('site_id', $site->id)
                    ->whereDate('created_at', today())->count(),

        'yesterday' => PageView::where('site_id', $site->id)
                    ->whereDate('created_at', today()->subDay())->count(),

        'this_week' => PageView::where('site_id', $site->id)
                    ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                    ->count(),

        'last_week' => PageView::where('site_id', $site->id)
                    ->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
                    ->count(),

        'this_month' => PageView::where('site_id', $site->id)
                    ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                    ->count(),

        'last_month' => PageView::where('site_id', $site->id)
                    ->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])
                    ->count(),

        'total' => PageView::where('site_id', $site->id)->count(),
    ];

    $topPages = PageView::where('site_id', $site->id)
        ->select('page_url', DB::raw('count(*) as views'))
        ->groupBy('page_url')
        ->orderByDesc('views')
        ->limit(5)
        ->get();

    $uniqueVisitors = PageView::where('site_id', $site->id)
        ->distinct('ip_address')
        ->count('ip_address');

    $byCountry = PageView::where('site_id', $site->id)
        ->select('country', DB::raw('count(*) as count'))
        ->groupBy('country')
        ->orderByDesc('count')
        ->get();

    return response()->json([
        'domain' => $validated['domain'],
        'views' => $views,
        'top_pages' => $topPages,
        'unique_visitors' => $uniqueVisitors,
        'by_country' => $byCountry,
    ]);
}


public function getPageInsights(Request $request)
{
    $validated = $request->validate([
        'domain' => 'required|url',
    ]);

    $site = Site::where('domain', $validated['domain'])->first();

    if (!$site) {
        return response()->json(['error' => 'Site not found.'], 404);
    }

    $user = JWTAuth::user();
    if (!$user || $user->id !== $site->user_id) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    return response()->json([
        'top_pages' => PageView::where('site_id', $site->id)
            ->select('page_url', DB::raw('count(*) as views'))
            ->groupBy('page_url')
            ->orderByDesc('views')
            ->limit(5)
            ->get(),

        'unique_visitors' => PageView::where('site_id', $site->id)
            ->distinct('ip_address')
            ->count('ip_address'),

        'by_country' => PageView::where('site_id', $site->id)
            ->select('country', DB::raw('count(*) as count'))
            ->groupBy('country')
            ->orderByDesc('count')
            ->get(),
    ]);
}


}