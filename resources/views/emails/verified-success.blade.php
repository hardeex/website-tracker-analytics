<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Verified Successfully</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes bounce-in {
            0% { transform: scale(0) rotate(0deg); opacity: 0; }
            50% { transform: scale(1.1) rotate(180deg); opacity: 0.8; }
            100% { transform: scale(1) rotate(360deg); opacity: 1; }
        }
        @keyframes slide-up {
            0% { transform: translateY(20px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(34, 197, 94, 0.3); }
            50% { box-shadow: 0 0 30px rgba(34, 197, 94, 0.5); }
        }
        .bounce-in { animation: bounce-in 0.8s ease-out; }
        .slide-up { animation: slide-up 0.6s ease-out; }
        .pulse-glow { animation: pulse-glow 2s infinite; }
        .animate-delay-1 { animation-delay: 0.2s; animation-fill-mode: both; }
        .animate-delay-2 { animation-delay: 0.4s; animation-fill-mode: both; }
        .animate-delay-3 { animation-delay: 0.6s; animation-fill-mode: both; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 flex items-center justify-center p-4">
    
    <!-- Main Container -->
    <div class="bg-white/80 backdrop-blur-lg rounded-3xl shadow-2xl border border-white/20 p-8 md:p-12 max-w-md w-full text-center">
        
        <!-- Success Icon -->
        <div class="mx-auto w-20 h-20 bg-gradient-to-r from-emerald-400 to-teal-500 rounded-full flex items-center justify-center mb-6 bounce-in pulse-glow">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        
        <!-- Title -->
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 slide-up animate-delay-1">
            <span class="bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                Email Verified!
            </span>
        </h1>
        
        <!-- Subtitle -->
        <p class="text-gray-600 text-lg mb-8 slide-up animate-delay-2 leading-relaxed">
            Your email has been successfully verified. You can now access all features of your account.
        </p>
        
        <!-- Success Details -->
        <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-6 mb-8 slide-up animate-delay-2">
            <div class="flex items-center justify-center space-x-2 text-emerald-700 mb-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span class="font-semibold">Verification Complete</span>
            </div>
            <ul class="text-sm text-emerald-600 space-y-2 text-left">
                <li class="flex items-center space-x-2">
                    <div class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></div>
                    <span>Account activated and ready to use</span>
                </li>
                <li class="flex items-center space-x-2">
                    <div class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></div>
                    <span>Email notifications enabled</span>
                </li>
                <li class="flex items-center space-x-2">
                    <div class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></div>
                    <span>Full access to all features</span>
                </li>
            </ul>
        </div>
        
        <!-- Action Buttons -->
        <div class="space-y-4 slide-up animate-delay-3">
            <button onclick="goToDashboard()" class="w-full bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-emerald-300">
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    <span>Go to Analytics</span>
                </div>
            </button>
            
            <button onclick="goToLogin()" class="w-full bg-white/70 hover:bg-white/90 text-gray-700 font-semibold py-3 px-6 rounded-xl border border-gray-200 transition-all duration-300 hover:shadow-md focus:outline-none focus:ring-4 focus:ring-gray-200">
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Back to Login</span>
                </div>
            </button>
        </div>
        
        <!-- Footer -->
        <div class="mt-8 pt-6 border-t border-gray-200 slide-up animate-delay-3">
            <p class="text-sm text-gray-500">
                Need help? 
                <a href="#" onclick="contactSupport()" class="text-emerald-600 hover:text-emerald-700 font-medium hover:underline transition-colors">
                    Contact Support
                </a>
            </p>
        </div>
    </div>

    <!-- Background Decorations -->
    <div class="fixed top-10 left-10 w-20 h-20 bg-emerald-200/30 rounded-full blur-xl animate-pulse"></div>
    <div class="fixed bottom-10 right-10 w-32 h-32 bg-teal-200/30 rounded-full blur-xl animate-pulse" style="animation-delay: 1s;"></div>
    <div class="fixed top-1/2 left-5 w-16 h-16 bg-cyan-200/30 rounded-full blur-xl animate-pulse" style="animation-delay: 2s;"></div>

    <script>
        function goToDashboard() {
            // Add loading state
            const btn = event.target.closest('button');
            const originalContent = btn.innerHTML;
            btn.innerHTML = `
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Loading...</span>
                </div>
            `;
            btn.disabled = true;
            
            // Simulate navigation
            setTimeout(() => {
                window.location.href = '/dashboard';
            }, 1500);
        }
        
        function goToLogin() {
            window.location.href = '/';
        }
        
        function contactSupport() {
            window.location.href = 'mailto:support@yourcompany.com';
        }

        // Add confetti effect
        function createConfetti() {
            const colors = ['#10b981', '#14b8a6', '#06b6d4', '#84cc16'];
            for (let i = 0; i < 50; i++) {
                setTimeout(() => {
                    const confetti = document.createElement('div');
                    confetti.style.cssText = `
                        position: fixed;
                        width: 8px;
                        height: 8px;
                        background: ${colors[Math.floor(Math.random() * colors.length)]};
                        top: -10px;
                        left: ${Math.random() * 100}%;
                        border-radius: 50%;
                        pointer-events: none;
                        z-index: 1000;
                        animation: confetti-fall 3s linear forwards;
                    `;
                    document.body.appendChild(confetti);
                    
                    setTimeout(() => confetti.remove(), 3000);
                }, i * 50);
            }
        }

        // Add confetti animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes confetti-fall {
                0% { transform: translateY(-10px) rotate(0deg); opacity: 1; }
                100% { transform: translateY(100vh) rotate(360deg); opacity: 0; }
            }
        `;
        document.head.appendChild(style);

        // Trigger confetti on page load
        window.addEventListener('load', () => {
            setTimeout(createConfetti, 500);
        });
    </script>
</body>
</html>