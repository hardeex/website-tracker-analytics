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
                <a href="{{route('analytics.dashboard')}}" class="bg-gradient-to-r from-purple-600 to-cyan-600 px-6 py-2 rounded-full hover:from-purple-700 hover:to-cyan-700 transition-all duration-300 transform hover:scale-105">
                    Dashboard
                </a>
            </div>
        </div>
    </nav>