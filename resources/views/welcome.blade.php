<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics API - Essential Web Analytics</title>
    <script src="/js/analytics.js" defer></script>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
      @vite('resources/css/app.css')
   @include('theme')
</head>
<body class="bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 min-h-screen text-white overflow-x-hidden">
    <!-- Animated Background -->
    <div class="fixed inset-0 opacity-20">
        <div class="absolute top-20 left-10 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl animate-float"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-cyan-500 rounded-full mix-blend-multiply filter blur-xl animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-20 left-20 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl animate-float" style="animation-delay: 4s;"></div>
    </div>

    <!-- Navigation -->
    @include('components.nav')

    <!-- Hero Section -->
   @include('components.hero')

    <!-- Dashboard Preview -->
  @include('components.dashboard')

    <!-- Features Section -->
   @include('components.feature')

    <!-- Pricing Section -->
   {{-- @include('components.pricing') --}}

    <!-- Domain Examples Section -->
    @include('components.sample-website')

    <!-- Documentation Section -->
    @include('components.documentation')

    <!-- API Code Example -->
    @include('components.code-example')

    <!-- CTA Section -->
    {{-- @include('components.cta') --}}

    <!-- Footer -->
   @include('components.footer')

  
</body>
</html>