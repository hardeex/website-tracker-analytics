<section id="docs" class="relative z-10 px-6 py-20">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h1 class="text-5xl font-bold mb-6 bg-gradient-to-r from-white to-purple-200 bg-clip-text text-transparent">
                API DOCUMENTATION
            </h1>
            <p class="text-xl text-gray-300 max-w-4xl mx-auto">
                This is a plug-and-play analytics tracking system that works for <strong>any website</strong>. No complex setup. Just copy-paste and start tracking <strong>page views</strong>, <strong>clicks</strong>, and <strong>session time</strong> with detailed analytics.
            </p>
        </div>

        <div class="bg-gradient-to-br from-slate-800/50 to-purple-900/30 backdrop-blur-lg rounded-3xl p-8 border border-purple-500/20 shadow-2xl">
            <!-- Features Section -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold mb-6 text-white">Features</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-slate-900/50 p-6 rounded-xl border border-purple-500/20">
                        <ul class="space-y-3 text-gray-300">
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Simple setup</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Auto-tracks every page view and click</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Tracks how long users stay on each page</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Breakdowns by country, traffic, top pages</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>API access to full analytics</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>No dependencies – pure Vanilla JavaScript</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- How It Works Section -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold mb-6 text-white">🧩 How It Works</h2>
                <div class="bg-slate-900/50 p-6 rounded-xl border border-cyan-500/20">
                    <ol class="space-y-3 text-gray-300">
                        <li class="flex items-start space-x-3">
                            <span class="bg-purple-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold">1</span>
                            <span>Register your website</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <span class="bg-purple-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold">2</span>
                            <span>Get a unique <code class="text-purple-300">api_key</code></span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <span class="bg-purple-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold">3</span>
                            <span>Paste a tracking script on your site - Preferably your base or index layout</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <span class="bg-purple-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold">4</span>
                            <span>Done! Analytics starts flowing ✨</span>
                        </li>
                    </ol>
                </div>
            </div>

            <!-- Step 1: Register Your Website -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold mb-6 text-white">🛠️ Step 1: Register Your Website</h2>
                <p class="text-gray-300 mb-6">Make a <code class="text-purple-300">POST</code> request to register your site.</p>
                
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-4 text-purple-300">➤ Endpoint:</h3>
                    <div class="bg-slate-950 rounded-xl p-6 mb-4 overflow-x-auto">
                        <pre class="text-sm text-gray-300"><code><span class="text-cyan-400">POST</span> https://analytics.essentialnews.ng/api/sites</code></pre>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-4 text-cyan-300">Sample Request (via Postman or Terminal):</h3>
                    <div class="bg-slate-950 rounded-xl p-6 mb-4 overflow-x-auto">
                        <pre class="text-sm text-gray-300"><code><span class="text-cyan-400">curl</span> -X POST https://analytics.essentialnews.ng/api/sites \
  -H <span class="text-green-400">"Content-Type: application/json"</span> \
  -d <span class="text-green-400">'{
    "domain": "https://yourwebsite.com",
    "name": "My Website"
  }'</span></code></pre>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-4 text-emerald-300">Response:</h3>
                    <div class="bg-slate-950 rounded-xl p-6 mb-4 overflow-x-auto">
                        <pre class="text-sm text-gray-300"><code><span class="text-green-400">{
  "site": {
    "api_key": "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"
  },
  "tracking_code": "&lt;script src=\"https://analytics.essentialnews.ng/api/process.js?api_key=xxxxxxxx\"&gt;&lt;/script&gt;"
}</span></code></pre>
                    </div>
                </div>
            </div>

            <!-- Step 2: Add the Script -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold mb-6 text-white">🔧 Step 2: Add the Script to Every Page</h2>
                <p class="text-gray-300 mb-6">Paste the script tag just before <code class="text-purple-300">&lt;/body&gt;</code> or in the <code class="text-purple-300">&lt;head&gt;</code> of your site.</p>
                
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-4 text-purple-300">HTML Example:</h3>
                    <div class="bg-slate-950 rounded-xl p-6 mb-4 overflow-x-auto">
                        <pre class="text-sm text-gray-300"><code><span class="text-purple-400">&lt;!-- Add this to all your pages --&gt;</span>
&lt;script src=<span class="text-green-400">"https://analytics.essentialnews.ng/api/process.js?api_key=xxxxxxxx"</span>&gt;&lt;/script&gt;</code></pre>
                    </div>
                </div>

                <div class="bg-blue-900/30 p-4 rounded-lg border border-blue-500/20">
                    <p class="text-blue-200"><strong>Pro Tip:</strong> If your site uses a layout template (e.g. Laravel Blade, React layout, etc.), paste it once in the layout to apply everywhere.</p>
                </div>
            </div>

            <!-- What It Tracks Automatically -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold mb-6 text-white">What It Tracks Automatically</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-slate-900/50 rounded-lg overflow-hidden">
                        <thead class="bg-purple-900/30">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-purple-300 uppercase tracking-wider">Event</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-purple-300 uppercase tracking-wider">Trigger</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-purple-300 uppercase tracking-wider">Extra Info Sent</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-cyan-400">pageview</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">On page load</td>
                                <td class="px-6 py-4 text-sm text-gray-300">URL, browser, IP</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-cyan-400">click</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">On any click</td>
                                <td class="px-6 py-4 text-sm text-gray-300">element_id (if exists)</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-cyan-400">session_duration</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">On unload</td>
                                <td class="px-6 py-4 text-sm text-gray-300">Seconds spent on page</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p class="text-gray-300 mt-4">No extra setup. Just the script = full tracking. 🚀</p>
            </div>

            <!-- Optional: Track Custom Events -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold mb-6 text-white">Optional: Track Custom Events</h2>
                <p class="text-gray-300 mb-6">Want to track something manually? Use:</p>
                <div class="bg-slate-950 rounded-xl p-6 mb-4 overflow-x-auto">
                    <pre class="text-sm text-gray-300"><code><span class="text-cyan-400">window.tracker</span>?.<span class="text-purple-400">track</span>(<span class="text-green-400">'click'</span>, { <span class="text-cyan-400">element_id</span>: <span class="text-green-400">'my-button'</span> });
<span class="text-cyan-400">window.tracker</span>?.<span class="text-purple-400">track</span>(<span class="text-green-400">'pageview'</span>, { <span class="text-cyan-400">session_duration</span>: <span class="text-cyan-400">90</span> });</code></pre>
                </div>
            </div>

            <!-- Step 3: View Your Analytics -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold mb-6 text-white">Step 3: View Your Analytics</h2>
                <p class="text-gray-300 mb-6">To get a full report of views, clicks, top pages, and visitors:</p>
                
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-4 text-purple-300">➤ Endpoint:</h3>
                    <div class="bg-slate-950 rounded-xl p-6 mb-4 overflow-x-auto">
                        <pre class="text-sm text-gray-300"><code><span class="text-cyan-400">GET</span> https://analytics.essentialnews.ng/api/analytics?api_key=xxxxxxxx</code></pre>
                    </div>
                </div>

                <div class="bg-slate-900/50 p-6 rounded-xl border border-cyan-500/20">
                    <h4 class="text-lg font-semibold mb-4 text-cyan-300">It returns:</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li>• Daily breakdowns (today, week, month)</li>
                        <li>• Top countries</li>
                        <li>• Top pages</li>
                        <li>• Unique visitors</li>
                    </ul>
                    <p class="text-gray-300 mt-4">Use this data to build a dashboard or show insights.</p>
                </div>
            </div>

            <!-- Want to Inspect Events? -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold mb-6 text-white">Want to Inspect Events?</h2>
                <p class="text-gray-300 mb-4">Open DevTools in your browser:</p>
                <div class="bg-slate-900/50 p-6 rounded-xl border border-purple-500/20">
                    <ol class="space-y-2 text-gray-300">
                        <li>1. Go to <strong>Network → Fetch/XHR</strong></li>
                        <li>2. You'll see calls to <code class="text-purple-300">/api/track</code></li>
                        <li>3. You're live! 🔴</li>
                    </ol>
                </div>
            </div>

            <!-- Common Errors -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold mb-6 text-white">Common Errors</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-slate-900/50 rounded-lg overflow-hidden">
                        <thead class="bg-red-900/30">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-red-300 uppercase tracking-wider">Issue</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-red-300 uppercase tracking-wider">Fix</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-400">Invalid API key</td>
                                <td class="px-6 py-4 text-sm text-gray-300">Ensure your script tag has the correct key</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-400">Validation failed</td>
                                <td class="px-6 py-4 text-sm text-gray-300">Missing required fields or wrong format</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-400">page_url mismatch</td>
                                <td class="px-6 py-4 text-sm text-gray-300">Only pages from the registered domain are accepted</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Safety Notes -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold mb-6 text-white">Safety Notes</h2>
                <div class="bg-yellow-900/30 p-6 rounded-xl border border-yellow-500/20">
                    <ul class="space-y-3 text-yellow-200">
                        <li>• Your site must be accessible via HTTPS (for accurate IP/location).</li>
                        <li>• Do <strong>not</strong> expose your analytics API key in public if you're tracking sensitive data.</li>
                        <li>• CORS must be properly configured if using across origins.</li>
                    </ul>
                </div>
            </div>

            <!-- Quick Summary -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold mb-6 text-white">Quick Summary</h2>
                <div class="bg-slate-900/50 p-6 rounded-xl border border-green-500/20">
                    <ol class="space-y-3 text-gray-300">
                        <li class="flex items-start space-x-3">
                            <span class="bg-green-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold">1</span>
                            <span>Register your site to get an API key</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <span class="bg-green-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold">2</span>
                            <span>Paste the script in your site layout</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <span class="bg-green-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold">3</span>
                            <span>Done! Tracking is automatic</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <span class="bg-green-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold">4</span>
                            <span>View analytics via the <code class="text-purple-300">/analytics</code> endpoint</span>
                        </li>
                    </ol>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center">
                <p class="text-gray-300 mb-4">Made with ❤️ using Laravel, JavaScript, and common sense.</p>
                <p class="text-gray-400">Need help? Open an issue or contact the developer - <a href="mailto:webmasterjdd@gmail.com" class="text-purple-300 hover:text-purple-200">webmasterjdd@gmail.com</a>.</p>
            </div>
        </div>
    </div>
</section>