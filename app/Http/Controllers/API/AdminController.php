<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PageView;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    
    public function allPageViews(Request $request)
{
    $validated = $request->validate([
        'period' => 'nullable|in:daily,weekly,monthly,total',
    ]);

    $query = PageView::query();

    switch ($validated['period'] ?? 'total') {
        case 'daily':
            $query->selectRaw('sites.domain, DATE(page_views.created_at) as date, COUNT(*) as views')
                ->join('sites', 'page_views.site_id', '=', 'sites.id')
                ->groupBy('sites.domain', 'date');
            break;
        case 'weekly':
            $query->selectRaw('sites.domain, YEARWEEK(page_views.created_at) as week, COUNT(*) as views')
                ->join('sites', 'page_views.site_id', '=', 'sites.id')
                ->groupBy('sites.domain', 'week');
            break;
        case 'monthly':
            $query->selectRaw('sites.domain, DATE_FORMAT(page_views.created_at, "%Y-%m") as month, COUNT(*) as views')
                ->join('sites', 'page_views.site_id', '=', 'sites.id')
                ->groupBy('sites.domain', 'month');
            break;
        default:
            $query->selectRaw('sites.domain, COUNT(*) as views')
                ->join('sites', 'page_views.site_id', '=', 'sites.id')
                ->groupBy('sites.domain');
            break;
    }

    $results = $query->get();

    return response()->json($results);
}
}
