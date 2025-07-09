 <section id="docs" class="relative z-10 px-6 py-20">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold mb-6 bg-gradient-to-r from-white to-purple-200 bg-clip-text text-transparent">
                    API Documentation
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Everything you need to integrate our privacy-first analytics into your websites
                </p>
            </div>

            <div class="bg-gradient-to-br from-slate-800/50 to-purple-900/30 backdrop-blur-lg rounded-3xl p-8 border border-purple-500/20 shadow-2xl">
                <div class="mb-12">
                    <h3 class="text-3xl font-bold mb-6 text-white">Overview</h3>
                    <p class="text-gray-300 mb-6 leading-relaxed">
                        The <span class="text-purple-300">Analytics API</span> tracks and stores real-time usage data across your websites. Built with Laravel and secured by JWT authentication, this API lets you collect and retrieve data like page views, clicks, session duration, and visitor geolocation — <span class="text-cyan-300">without relying on third-party tools like Google Analytics</span>.
                    </p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-slate-900/50 p-6 rounded-xl border border-purple-500/20">
                            <h4 class="text-xl font-semibold mb-4 text-purple-300">Metrics Tracked</h4>
                            <ul class="space-y-3 text-gray-300">
                                <li class="flex items-start space-x-2">
                                    <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Page Views (daily, weekly, monthly, total)</span>
                                </li>
                                <li class="flex items-start space-x-2">
                                    <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Clicks on specific elements (e.g. CTA buttons, links)</span>
                                </li>
                                <li class="flex items-start space-x-2">
                                    <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Session Duration (time spent on site)</span>
                                </li>
                                <li class="flex items-start space-x-2">
                                    <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Geolocation (country & city via MaxMind GeoLite2)</span>
                                </li>
                            </ul>
                        </div>
                        <div class="bg-slate-900/50 p-6 rounded-xl border border-cyan-500/20">
                            <h4 class="text-xl font-semibold mb-4 text-cyan-300">Key Features</h4>
                            <ul class="space-y-3 text-gray-300">
                                <li class="flex items-start space-x-2">
                                    <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Multi-site Support – Monitor analytics across many domains</span>
                                </li>
                                <li class="flex items-start space-x-2">
                                    <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>JWT Authentication – Secure API access with email verification</span>
                                </li>
                                <li class="flex items-start space-x-2">
                                    <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Visitor Location Tracking – Powered by MaxMind GeoLite2</span>
                                </li>
                                <li class="flex items-start space-x-2">
                                    <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>GDPR/CCPA-Ready – Consent management support</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="mb-12">
                    <h3 class="text-3xl font-bold mb-6 text-white">Getting Started</h3>
                    
                    <div class="mb-8">
                        <h4 class="text-xl font-semibold mb-4 text-purple-300">Step 1: Register an Account</h4>
                        <div class="bg-slate-950 rounded-xl p-6 mb-4 overflow-x-auto">
                            <pre class="text-sm text-gray-300"><code><span class="text-purple-400">// Register a new user</span>
<span class="text-cyan-400">curl</span> -X POST https://analytics.essentialnews.ng/api/register \
  -H <span class="text-green-400">"Content-Type: application/json"</span> \
  -d <span class="text-green-400">'{
    "name": "Your Name",
    "email": "your.email@example.com",
    "password": "YourPassword123",
    "password_confirmation": "YourPassword123",
    "marketing_consent": false
}'</span></code></pre>
                        </div>
                        <p class="text-gray-400 text-sm mb-4">📩 Check your email for a verification link (check spam/junk too).</p>
                        
                        <div class="bg-slate-950 rounded-xl p-6 mb-4 overflow-x-auto">
                            <pre class="text-sm text-gray-300"><code><span class="text-purple-400">// Email Verification</span>
<span class="text-cyan-400">GET</span> https://analytics.essentialnews.ng/api/verify-email?token=YOUR_VERIFICATION_TOKEN</code></pre>
                        </div>
                    </div>
                    
                    <div class="mb-8">
                        <h4 class="text-xl font-semibold mb-4 text-cyan-300">Step 2: Register Your Website</h4>
                        <div class="bg-slate-950 rounded-xl p-6 mb-4 overflow-x-auto">
                            <pre class="text-sm text-gray-300"><code><span class="text-purple-400">// Register a new website/domain</span>
<span class="text-cyan-400">curl</span> -X POST https://analytics.essentialnews.ng/api/sites \
  -H <span class="text-green-400">"Authorization: Bearer your-jwt-token-here"</span> \
  -H <span class="text-green-400">"Content-Type: application/json"</span> \
  -d <span class="text-green-400">'{
    "domain": "edirect.example.com",
    "name": "Edirect"
}'</span></code></pre>
                        </div>
                    </div>
                    
                    <div class="mb-8">
                        <h4 class="text-xl font-semibold mb-4 text-pink-300">Step 3: Add the Tracking Script</h4>
                        <div class="bg-slate-950 rounded-xl p-6 mb-4 overflow-x-auto">
                            <pre class="text-sm text-gray-300"><code><span class="text-purple-400">// Option 1: Use Hosted Script</span>
&lt;script src=<span class="text-green-400">"https://analytics.essentialnews.ng/js/analytics.js"</span>&gt;&lt;/script&gt;

<span class="text-purple-400">// Option 2: Host It Yourself</span>
(<span class="text-cyan-400">function</span> () {
  <span class="text-cyan-400">const</span> apiUrl = <span class="text-green-400">'https://analytics.essentialnews.ng/api'</span>;
  <span class="text-cyan-400">const</span> jwtToken = <span class="text-green-400">'YOUR_JWT_TOKEN'</span>;
  <span class="text-cyan-400">const</span> domain = <span class="text-green-400">'YOUR_WEBSITE_DOMAIN'</span>;

  <span class="text-cyan-400">function</span> trackPageView(sessionDuration = <span class="text-cyan-400">null</span>) {
    <span class="text-cyan-400">fetch</span>(`${apiUrl}/track/pageview`, {
      method: <span class="text-green-400">'POST'</span>,
      headers: {
        <span class="text-green-400">'Authorization'</span>: `Bearer ${jwtToken}`,
        <span class="text-green-400">'Content-Type'</span>: <span class="text-green-400">'application/json'</span>,
      },
      body: <span class="text-cyan-400">JSON.stringify</span>({
        domain: domain,
        page_url: window.location.href,
        user_agent: navigator.userAgent,
        session_duration: sessionDuration,
      }),
    });
  }

  <span class="text-cyan-400">let</span> pageLoadTime = Date.now();
  window.addEventListener(<span class="text-green-400">'load'</span>, () => trackPageView());
  window.addEventListener(<span class="text-green-400">'beforeunload'</span>, () => {
    <span class="text-cyan-400">const</span> sessionDuration = Date.now() - pageLoadTime;
    trackPageView(sessionDuration);
  });
})();</code></pre>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="text-xl font-semibold mb-4 text-emerald-300">Step 4: Retrieve Analytics Data</h4>
                        <div class="bg-slate-950 rounded-xl p-6 mb-4 overflow-x-auto">
                            <pre class="text-sm text-gray-300"><code><span class="text-purple-400">// Get page view analytics</span>
<span class="text-cyan-400">curl</span> -X GET https://analytics.essentialnews.ng/api/analytics/pageviews \
  -H <span class="text-green-400">"Authorization: Bearer your-jwt-token-here"</span></code></pre>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-3xl font-bold mb-6 text-white">API Endpoints</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-slate-900/50 rounded-lg overflow-hidden">
                            <thead class="bg-purple-900/30">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-purple-300 uppercase tracking-wider">Method</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-purple-300 uppercase tracking-wider">Endpoint</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-purple-300 uppercase tracking-wider">Description</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-cyan-400">POST</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">/register</td>
                                    <td class="px-6 py-4 text-sm text-gray-300">Register a new user</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-cyan-400">POST</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">/login</td>
                                    <td class="px-6 py-4 text-sm text-gray-300">Log in and receive JWT token</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-cyan-400">GET</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">/verify-email</td>
                                    <td class="px-6 py-4 text-sm text-gray-300">Verify email with token</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-cyan-400">POST</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">/sites</td>
                                    <td class="px-6 py-4 text-sm text-gray-300">Register a website/domain</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-cyan-400">POST</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">/track/pageview</td>
                                    <td class="px-6 py-4 text-sm text-gray-300">Track a page view</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-cyan-400">POST</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">/track/click</td>
                                    <td class="px-6 py-4 text-sm text-gray-300">Track click on elements</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-cyan-400">GET</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">/analytics/pageviews</td>
                                    <td class="px-6 py-4 text-sm text-gray-300">Get total page views</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-cyan-400">GET</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">/analytics/geolocation</td>
                                    <td class="px-6 py-4 text-sm text-gray-300">Get visitor geolocation</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>