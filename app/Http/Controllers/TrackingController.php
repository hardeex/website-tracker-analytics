<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessClick;
use App\Jobs\ProcessPageView;
use App\Models\Site;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class TrackingController extends Controller
{
    public function trackPageView(Request $request)
    {
        $validated = $request->validate([
            'domain' => 'required|string',
            'page_url' => 'required|url',
            'user_agent' => 'nullable|string',
            'session_duration' => 'nullable|integer|min:0',
        ]);

        $site = Site::where('domain', $validated['domain'])->firstOrFail();
        $user = JWTAuth::user();

        // Check if user has access to the site
        if ($user->id !== $site->user_id) {
            return response()->json(['error' => 'Unauthorized for this site'], 403);
        }

        $data = [
            'site_id' => $site->id,
            'page_url' => $validated['page_url'],
            'ip_address' => $request->ip(),
            'user_agent' => $validated['user_agent'],
            'user_id' => $user->id,
            'session_duration' => $validated['session_duration'] ?? null,
        ];

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
}