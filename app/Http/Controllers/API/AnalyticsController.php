<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Click;
use App\Models\PageView;
use App\Models\Site;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AnalyticsController extends Controller
{
    public function pageViews(Request $request)
    {
        $validated = $request->validate([
            'domain' => 'required|string',
            'period' => 'nullable|in:daily,weekly,monthly,total',
        ]);

        $site = Site::where('domain', $validated['domain'])->firstOrFail();
        $user = JWTAuth::user();

        if ($user->id !== $site->user_id) {
            return response()->json(['error' => 'Unauthorized for this site'], 403);
        }

        $query = PageView::where('site_id', $site->id);

        switch ($validated['period'] ?? 'total') {
            case 'daily':
                $query->selectRaw('DATE(created_at) as date, COUNT(*) as views')
                    ->groupBy('date');
                break;
            case 'weekly':
                $query->selectRaw('YEARWEEK(created_at) as week, COUNT(*) as views')
                    ->groupBy('week');
                break;
            case 'monthly':
                $query->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as views')
                    ->groupBy('month');
                break;
            default:
                $query->selectRaw('COUNT(*) as views');
                break;
        }

        $results = $query->get();

        return response()->json($results);
    }

    public function pageViewsByPage(Request $request)
    {
        $validated = $request->validate([
            'domain' => 'required|string',
        ]);

        $site = Site::where('domain', $validated['domain'])->firstOrFail();
        $user = JWTAuth::user();

        if ($user->id !== $site->user_id) {
            return response()->json(['error' => 'Unauthorized for this site'], 403);
        }

        $views = PageView::where('site_id', $site->id)
            ->selectRaw('page_url, COUNT(*) as views')
            ->groupBy('page_url')
            ->get();

        return response()->json($views);
    }

    public function sessionDuration(Request $request)
    {
        $validated = $request->validate([
            'domain' => 'required|string',
            'period' => 'nullable|in:daily,weekly,monthly,total',
        ]);

        $site = Site::where('domain', $validated['domain'])->firstOrFail();
        $user = JWTAuth::user();

        if ($user->id !== $site->user_id) {
            return response()->json(['error' => 'Unauthorized for this site'], 403);
        }

        $query = PageView::where('site_id', $site->id)
            ->whereNotNull('session_duration');

        switch ($validated['period'] ?? 'total') {
            case 'daily':
                $query->selectRaw('DATE(created_at) as date, AVG(session_duration) as avg_duration')
                    ->groupBy('date');
                break;
            case 'weekly':
                $query->selectRaw('YEARWEEK(created_at) as week, AVG(session_duration) as avg_duration')
                    ->groupBy('week');
                break;
            case 'monthly':
                $query->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, AVG(session_duration) as avg_duration')
                    ->groupBy('month');
                break;
            default:
                $query->selectRaw('AVG(session_duration) as avg_duration');
                break;
        }

        $results = $query->get();

        return response()->json($results);
    }

    public function geolocation(Request $request)
    {
        $validated = $request->validate([
            'domain' => 'required|string',
        ]);

        $site = Site::where('domain', $validated['domain'])->firstOrFail();
        $user = JWTAuth::user();

        if ($user->id !== $site->user_id) {
            return response()->json(['error' => 'Unauthorized for this site'], 403);
        }

        $locations = PageView::where('site_id', $site->id)
            ->selectRaw('country, city, COUNT(*) as views')
            ->whereNotNull('country')
            ->groupBy('country', 'city')
            ->get();

        return response()->json($locations);
    }

    public function clicks(Request $request)
    {
        $validated = $request->validate([
            'domain' => 'required|string',
            'period' => 'nullable|in:daily,weekly,monthly,total',
        ]);

        $site = Site::where('domain', $validated['domain'])->firstOrFail();
        $user = JWTAuth::user();

        if ($user->id !== $site->user_id) {
            return response()->json(['error' => 'Unauthorized for this site'], 403);
        }

        $query = Click::where('site_id', $site->id);

        switch ($validated['period'] ?? 'total') {
            case 'daily':
                $query->selectRaw('DATE(created_at) as date, COUNT(*) as clicks')
                    ->groupBy('date');
                break;
            case 'weekly':
                $query->selectRaw('YEARWEEK(created_at) as week, COUNT(*) as clicks')
                    ->groupBy('week');
                break;
            case 'monthly':
                $query->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as clicks')
                    ->groupBy('month');
                break;
            default:
                $query->selectRaw('COUNT(*) as clicks');
                break;
        }

        $results = $query->get();

        return response()->json($results);
    }

    public function clicksByElement(Request $request)
    {
        $validated = $request->validate([
            'domain' => 'required|string',
        ]);

        $site = Site::where('domain', $validated['domain'])->firstOrFail();
        $user = JWTAuth::user();

        if ($user->id !== $site->user_id) {
            return response()->json(['error' => 'Unauthorized for this site'], 403);
        }

        $clicks = Click::where('site_id', $site->id)
            ->selectRaw('element_id, COUNT(*) as clicks')
            ->whereNotNull('element_id')
            ->groupBy('element_id')
            ->get();

        return response()->json($clicks);
    }
}