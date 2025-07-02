<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics API - Privacy-First Web Analytics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'glow': 'glow 2s ease-in-out infinite alternate',
                        'slide-up': 'slideUp 0.8s ease-out',
                        'fade-in': 'fadeIn 1s ease-out',
                        'bounce-slow': 'bounce 3s infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-20px)' }
                        },
                        glow: {
                            '0%': { boxShadow: '0 0 20px rgba(147, 51, 234, 0.3)' },
                            '100%': { boxShadow: '0 0 40px rgba(147, 51, 234, 0.6)' }
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(100px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' }
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 min-h-screen text-white overflow-x-hidden">
    <!-- Animated Background -->
    <div class="fixed inset-0 opacity-20">
        <div class="absolute top-20 left-10 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl animate-float"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-cyan-500 rounded-full mix-blend-multiply filter blur-xl animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-20 left-20 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl animate-float" style="animation-delay: 4s;"></div>
    </div>

    <!-- Navigation -->
    <nav class="relative z-50 px-6 py-8">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-gradient-to-r from-purple-600 to-cyan-600 rounded-xl flex items-center justify-center animate-glow">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <span class="text-2xl font-bold bg-gradient-to-r from-white to-purple-200 bg-clip-text text-transparent">Analytics API</span>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="#features" class="hover:text-purple-300 transition-colors duration-300">Features</a>
                <a href="#pricing" class="hover:text-purple-300 transition-colors duration-300">Pricing</a>
                <a href="#docs" class="hover:text-purple-300 transition-colors duration-300">Documentation</a>
                <button class="bg-gradient-to-r from-purple-600 to-cyan-600 px-6 py-2 rounded-full hover:from-purple-700 hover:to-cyan-700 transition-all duration-300 transform hover:scale-105">
                    Get Started
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative z-10 px-6 py-20">
        <div class="max-w-7xl mx-auto text-center">
            <div class="animate-slide-up">
                <h1 class="text-6xl md:text-8xl font-bold mb-8 bg-gradient-to-r from-white via-purple-200 to-cyan-200 bg-clip-text text-transparent leading-tight">
                    Privacy-First
                    <span class="block text-transparent bg-gradient-to-r from-purple-400 to-cyan-400 bg-clip-text">Analytics</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-300 mb-12 max-w-4xl mx-auto leading-relaxed">
                    Track website usage across multiple domains with our powerful Laravel-based API. 
                    <span class="text-purple-300 font-semibold">No third-party trackers</span>, 
                    <span class="text-cyan-300 font-semibold">complete privacy</span>, 
                    unlimited possibilities.
                </p>
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center animate-fade-in" style="animation-delay: 0.5s;">
                <button class="bg-gradient-to-r from-purple-600 to-cyan-600 px-12 py-4 rounded-full text-lg font-semibold hover:from-purple-700 hover:to-cyan-700 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl animate-glow">
                    Start Free Trial
                </button>
                <a href="#docs" class="border-2 border-purple-400 px-12 py-4 rounded-full text-lg font-semibold hover:bg-purple-400 hover:bg-opacity-20 transition-all duration-300 transform hover:scale-105">
                    View Documentation
                </a>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mt-20 animate-fade-in" style="animation-delay: 1s;">
                <div class="text-center">
                    <div class="text-4xl font-bold text-purple-400 mb-2">99.9%</div>
                    <div class="text-gray-400">Uptime</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-cyan-400 mb-2">< 50ms</div>
                    <div class="text-gray-400">Response Time</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-pink-400 mb-2">JWT</div>
                    <div class="text-gray-400">Secured</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-emerald-400 mb-2">GDPR</div>
                    <div class="text-gray-400">Compliant</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Dashboard Preview -->
    <section class="relative z-10 px-6 py-20">
        <div class="max-w-6xl mx-auto">
            <div class="bg-gradient-to-br from-slate-800/50 to-purple-900/30 backdrop-blur-lg rounded-3xl p-8 border border-purple-500/20 shadow-2xl animate-float">
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl p-6 border border-gray-700/50">
                    <!-- Mock Dashboard Header -->
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-white">Analytics Dashboard</h3>
                        <div class="flex space-x-2">
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        </div>
                    </div>
                    
                    <!-- Mock Charts -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gradient-to-br from-purple-600/20 to-cyan-600/20 rounded-xl p-6 border border-purple-500/30">
                            <h4 class="text-lg font-semibold mb-4">Page Views</h4>
                            <div class="text-3xl font-bold text-purple-400 mb-2">147,302</div>
                            <div class="text-sm text-gray-400">↗ 12% from last month</div>
                        </div>
                        <div class="bg-gradient-to-br from-cyan-600/20 to-pink-600/20 rounded-xl p-6 border border-cyan-500/30">
                            <h4 class="text-lg font-semibold mb-4">Unique Visitors</h4>
                            <div class="text-3xl font-bold text-cyan-400 mb-2">28,547</div>
                            <div class="text-sm text-gray-400">↗ 8% from last month</div>
                        </div>
                        <div class="bg-gradient-to-br from-pink-600/20 to-purple-600/20 rounded-xl p-6 border border-pink-500/30">
                            <h4 class="text-lg font-semibold mb-4">Session Duration</h4>
                            <div class="text-3xl font-bold text-pink-400 mb-2">4m 32s</div>
                            <div class="text-sm text-gray-400">↗ 15% from last month</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="relative z-10 px-6 py-20">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold mb-6 bg-gradient-to-r from-white to-purple-200 bg-clip-text text-transparent">
                    Powerful Features
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Everything you need to understand your website traffic without compromising user privacy
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature cards -->
                <div class="bg-gradient-to-br from-slate-800/50 to-purple-900/30 backdrop-blur-lg rounded-2xl p-8 border border-purple-500/20 hover:border-purple-400/40 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                    <div class="w-16 h-16 bg-gradient-to-r from-purple-600 to-cyan-600 rounded-2xl flex items-center justify-center mb-6 animate-pulse-slow">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-white">Privacy First</h3>
                    <p class="text-gray-300 leading-relaxed">No cookies, no third-party trackers. GDPR compliant analytics that respects user privacy while delivering actionable insights.</p>
                </div>

                <div class="bg-gradient-to-br from-slate-800/50 to-cyan-900/30 backdrop-blur-lg rounded-2xl p-8 border border-cyan-500/20 hover:border-cyan-400/40 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                    <div class="w-16 h-16 bg-gradient-to-r from-cyan-600 to-purple-600 rounded-2xl flex items-center justify-center mb-6 animate-pulse-slow" style="animation-delay: 1s;">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-white">Lightning Fast</h3>
                    <p class="text-gray-300 leading-relaxed">Built with Laravel for performance. Sub-50ms response times and real-time data processing for instant insights.</p>
                </div>

                <div class="bg-gradient-to-br from-slate-800/50 to-pink-900/30 backdrop-blur-lg rounded-2xl p-8 border border-pink-500/20 hover:border-pink-400/40 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                    <div class="w-16 h-16 bg-gradient-to-r from-pink-600 to-purple-600 rounded-2xl flex items-center justify-center mb-6 animate-pulse-slow" style="animation-delay: 2s;">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-white">Multi-Domain</h3>
                    <p class="text-gray-300 leading-relaxed">Track multiple websites from a single dashboard. Perfect for agencies and businesses with diverse web properties.</p>
                </div>

                <div class="bg-gradient-to-br from-slate-800/50 to-emerald-900/30 backdrop-blur-lg rounded-2xl p-8 border border-emerald-500/20 hover:border-emerald-400/40 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                    <div class="w-16 h-16 bg-gradient-to-r from-emerald-600 to-cyan-600 rounded-2xl flex items-center justify-center mb-6 animate-pulse-slow" style="animation-delay: 3s;">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-white">JWT Secured</h3>
                    <p class="text-gray-300 leading-relaxed">Enterprise-grade security with JWT authentication. Your data stays protected with industry-standard encryption.</p>
                </div>

                <div class="bg-gradient-to-br from-slate-800/50 to-orange-900/30 backdrop-blur-lg rounded-2xl p-8 border border-orange-500/20 hover:border-orange-400/40 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-600 to-red-600 rounded-2xl flex items-center justify-center mb-6 animate-pulse-slow" style="animation-delay: 4s;">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-white">Developer Friendly</h3>
                    <p class="text-gray-300 leading-relaxed">RESTful API with comprehensive documentation. Easy integration with any platform or framework you're using.</p>
                </div>

                <div class="bg-gradient-to-br from-slate-800/50 to-blue-900/30 backdrop-blur-lg rounded-2xl p-8 border border-blue-500/20 hover:border-blue-400/40 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl flex items-center justify-center mb-6 animate-pulse-slow" style="animation-delay: 5s;">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-white">Real-time Analytics</h3>
                    <p class="text-gray-300 leading-relaxed">Get instant insights with real-time tracking. Monitor page views, clicks, sessions, and geolocation data as it happens.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="relative z-10 px-6 py-20">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold mb-6 bg-gradient-to-r from-white to-purple-200 bg-clip-text text-transparent">
                    Simple Pricing
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Choose the plan that fits your needs. All plans include full API access and premium support.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Starter Plan -->
                <div class="bg-gradient-to-br from-slate-800/50 to-gray-900/30 backdrop-blur-lg rounded-2xl p-8 border border-gray-500/20 hover:border-gray-400/40 transition-all duration-300 transform hover:scale-105">
                    <h3 class="text-2xl font-bold mb-4 text-white">Starter</h3>
                    <div class="text-4xl font-bold mb-6 text-gray-300">$19<span class="text-lg text-gray-400">/month</span></div>
                    <ul class="space-y-4 mb-8 text-gray-300">
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Up to 3 domains</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>100K page views/month</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Basic analytics</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Email support</span>
                        </li>
                    </ul>
                    <button class="w-full border-2 border-gray-400 px-8 py-3 rounded-full font-semibold hover:bg-gray-400 hover:bg-opacity-20 transition-all duration-300">
                        Get Started
                    </button>
                </div>

                <!-- Pro Plan (Featured) -->
                <div class="bg-gradient-to-br from-purple-800/50 to-cyan-900/30 backdrop-blur-lg rounded-2xl p-8 border-2 border-purple-500/50 hover:border-purple-400/70 transition-all duration-300 transform hover:scale-105 relative">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-purple-600 to-cyan-600 px-4 py-2 rounded-full text-sm font-semibold animate-bounce-slow">
                        Most Popular
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-white">Pro</h3>
                    <div class="text-4xl font-bold mb-6 text-purple-400">$49<span class="text-lg text-gray-400">/month</span></div>
                    <ul class="space-y-4 mb-8 text-gray-300">
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Up to 15 domains</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>1M page views/month</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Advanced analytics</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Priority support</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Custom reports</span>
                        </li>
                    </ul>
                    <button class="w-full bg-gradient-to-r from-purple-600 to-cyan-600 px-8 py-3 rounded-full font-semibold hover:from-purple-700 hover:to-cyan-700 transition-all duration-300 animate-glow">
                        Get Started
                    </button>
                </div>

                <!-- Enterprise Plan -->
                <div class="bg-gradient-to-br from-slate-800/50 to-gray-900/30 backdrop-blur-lg rounded-2xl p-8 border border-gray-500/20 hover:border-gray-400/40 transition-all duration-300 transform hover:scale-105">
                    <h3 class="text-2xl font-bold mb-4 text-white">Enterprise</h3>
                    <div class="text-4xl font-bold mb-6 text-gray-300">$149<span class="text-lg text-gray-400">/month</span></div>
                    <ul class="space-y-4 mb-8 text-gray-300">
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Unlimited domains</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Unlimited page views</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>White-label solution</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>24/7 phone support</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Dedicated account manager</span>
                        </li>
                    </ul>
                    <button class="w-full border-2 border-gray-400 px-8 py-3 rounded-full font-semibold hover:bg-gray-400 hover:bg-opacity-20 transition-all duration-300">
                        Contact Sales
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Domain Examples Section -->
    <section class="relative z-10 px-6 py-20">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold mb-6 bg-gradient-to-r from-white to-purple-200 bg-clip-text text-transparent">
                    Perfect For Your Websites
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Track analytics across all your domains from one powerful dashboard
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-slate-800/50 to-purple-900/30 backdrop-blur-lg rounded-2xl p-6 border border-purple-500/20 hover:border-purple-400/40 transition-all duration-300 transform hover:scale-105">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-lg font-semibold text-white">example.com</span>
                    </div>
                    <div class="text-2xl font-bold text-purple-400 mb-2">47,382 views</div>
                    <div class="text-sm text-gray-400">Main business website</div>
                </div>

                <div class="bg-gradient-to-br from-slate-800/50 to-cyan-900/30 backdrop-blur-lg rounded-2xl p-6 border border-cyan-500/20 hover:border-cyan-400/40 transition-all duration-300 transform hover:scale-105">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-lg font-semibold text-white">edirect.ng</span>
                    </div>
                    <div class="text-2xl font-bold text-cyan-400 mb-2">28,547 views</div>
                    <div class="text-sm text-gray-400">Directory platform</div>
                </div>

                <div class="bg-gradient-to-br from-slate-800/50 to-pink-900/30 backdrop-blur-lg rounded-2xl p-6 border border-pink-500/20 hover:border-pink-400/40 transition-all duration-300 transform hover:scale-105">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-lg font-semibold text-white">essentialnews.ng</span>
                    </div>
                    <div class="text-2xl font-bold text-pink-400 mb-2">35,291 views</div>
                    <div class="text-sm text-gray-400">News website</div>
                </div>

                <div class="bg-gradient-to-br from-slate-800/50 to-emerald-900/30 backdrop-blur-lg rounded-2xl p-6 border border-emerald-500/20 hover:border-emerald-400/40 transition-all duration-300 transform hover:scale-105">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-lg font-semibold text-white">estore.example.com</span>
                    </div>
                    <div class="text-2xl font-bold text-emerald-400 mb-2">19,847 views</div>
                    <div class="text-sm text-gray-400">E-commerce store</div>
                </div>

                <div class="bg-gradient-to-br from-slate-800/50 to-orange-900/30 backdrop-blur-lg rounded-2xl p-6 border border-orange-500/20 hover:border-orange-400/40 transition-all duration-300 transform hover:scale-105">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-lg font-semibold text-white">ehotel.example.com</span>
                    </div>
                    <div class="text-2xl font-bold text-orange-400 mb-2">12,653 views</div>
                    <div class="text-sm text-gray-400">Hotel booking</div>
                </div>

                <div class="bg-gradient-to-br from-slate-800/50 to-blue-900/30 backdrop-blur-lg rounded-2xl p-6 border border-blue-500/20 hover:border-blue-400/40 transition-all duration-300 transform hover:scale-105">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
                        <span class="text-lg font-semibold text-gray-400">Your domain here</span>
                    </div>
                    <div class="text-2xl font-bold text-blue-400 mb-2">+ Add Site</div>
                    <div class="text-sm text-gray-400">Start tracking today</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Documentation Section -->
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

    <!-- API Code Example -->
    <section class="relative z-10 px-6 py-20">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold mb-6 bg-gradient-to-r from-white to-purple-200 bg-clip-text text-transparent">
                    Developer Friendly
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Get started in minutes with our simple API integration
                </p>
            </div>

            <div class="bg-gradient-to-br from-slate-900/90 to-purple-900/50 backdrop-blur-lg rounded-2xl p-8 border border-purple-500/20 shadow-2xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-white">Quick Integration</h3>
                    <div class="flex space-x-2">
                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                        <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    </div>
                </div>
                
                <div class="bg-slate-950 rounded-xl p-6 overflow-x-auto">
                    <pre class="text-sm text-gray-300"><code><span class="text-purple-400">// Track a page view</span>
<span class="text-cyan-400">fetch</span>(<span class="text-green-400">'https://api.analytics.com/track'</span>, {
  <span class="text-orange-400">method</span>: <span class="text-green-400">'POST'</span>,
  <span class="text-orange-400">headers</span>: {
    <span class="text-green-400">'Authorization'</span>: <span class="text-green-400">'Bearer YOUR_JWT_TOKEN'</span>,
    <span class="text-green-400">'Content-Type'</span>: <span class="text-green-400">'application/json'</span>
  },
  <span class="text-orange-400">body</span>: <span class="text-cyan-400">JSON.stringify</span>({
    <span class="text-orange-400">domain</span>: <span class="text-green-400">'example.com'</span>,
    <span class="text-orange-400">page</span>: <span class="text-green-400">'/home'</span>,
    <span class="text-orange-400">event</span>: <span class="text-green-400">'page_view'</span>,
    <span class="text-orange-400">user_agent</span>: <span class="text-cyan-400">navigator.userAgent</span>
  })
});

<span class="text-purple-400">// Get analytics data</span>
<span class="text-cyan-400">fetch</span>(<span class="text-green-400">'https://api.analytics.com/data/example.com'</span>, {
  <span class="text-orange-400">headers</span>: {
    <span class="text-green-400">'Authorization'</span>: <span class="text-green-400">'Bearer YOUR_JWT_TOKEN'</span>
  }
})
.<span class="text-cyan-400">then</span>(<span class="text-orange-400">response</span> => <span class="text-orange-400">response</span>.<span class="text-cyan-400">json</span>())
.<span class="text-cyan-400">then</span>(<span class="text-orange-400">data</span> => <span class="text-cyan-400">console.log</span>(<span class="text-orange-400">data</span>));</code></pre>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="relative z-10 px-6 py-20">
        <div class="max-w-4xl mx-auto text-center">
            <div class="bg-gradient-to-br from-purple-900/50 to-cyan-900/30 backdrop-blur-lg rounded-3xl p-12 border border-purple-500/20 shadow-2xl">
                <h2 class="text-5xl font-bold mb-6 bg-gradient-to-r from-white to-purple-200 bg-clip-text text-transparent">
                    Ready to Get Started?
                </h2>
                <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                    Join thousands of developers and businesses who trust our analytics API for their privacy-first tracking needs.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                    <button class="bg-gradient-to-r from-purple-600 to-cyan-600 px-12 py-4 rounded-full text-lg font-semibold hover:from-purple-700 hover:to-cyan-700 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl animate-glow">
                        Start Free Trial
                    </button>
                    <button class="border-2 border-purple-400 px-12 py-4 rounded-full text-lg font-semibold hover:bg-purple-400 hover:bg-opacity-20 transition-all duration-300 transform hover:scale-105">
                        Schedule Demo
                    </button>
                </div>

                <div class="mt-8 text-sm text-gray-400">
                    No credit card required • 14-day free trial • Cancel anytime
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="relative z-10 px-6 py-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-gradient-to-r from-purple-600 to-cyan-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-white">Analytics API</span>
                    </div>
                    <p class="text-gray-400 mb-4">Privacy-first analytics for the modern web. Track your websites without compromising user privacy.</p>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">Product</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#features" class="hover:text-purple-300 transition-colors">Features</a></li>
                        <li><a href="#pricing" class="hover:text-purple-300 transition-colors">Pricing</a></li>
                        <li><a href="#docs" class="hover:text-purple-300 transition-colors">API Documentation</a></li>
                        <li><a href="#" class="hover:text-purple-300 transition-colors">Status</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">Company</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-purple-300 transition-colors">About</a></li>
                        <li><a href="#" class="hover:text-purple-300 transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-purple-300 transition-colors">Careers</a></li>
                        <li><a href="#" class="hover:text-purple-300 transition-colors">Contact</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">Support</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-purple-300 transition-colors">Help Center</a></li>
                        <li><a href="#" class="hover:text-purple-300 transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-purple-300 transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-purple-300 transition-colors">GDPR</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
                <p>&copy; 2025 Analytics API. All rights reserved. Built with Laravel & JWT.</p>
            </div>
        </div>
    </footer>

    <script>
        // Add smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add intersection observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all sections for scroll animations
        document.querySelectorAll('section').forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(50px)';
            section.style.transition = 'opacity 0.8s ease-out, transform 0.8s ease-out';
            observer.observe(section);
        });

        // Add hover effects to cards
        document.querySelectorAll('.transform.hover\\:scale-105').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05) translateZ(0)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1) translateZ(0)';
            });
        });
    </script>
</body>
</html>