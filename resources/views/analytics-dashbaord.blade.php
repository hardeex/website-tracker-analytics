<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.2/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .animate-slideIn { animation: slideIn 0.6s ease-out; }
        .animate-pulse-slow { animation: pulse 3s infinite; }
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .sidebar {
            transition: all 0.3s ease;
        }
        .sidebar-collapsed {
            width: 80px;
        }
        .sidebar-expanded {
            width: 250px;
        }
        .main-content {
            transition: all 0.3s ease;
        }
        .content-collapsed {
            margin-left: 80px;
        }
        .content-expanded {
            margin-left: 250px;
        }
        .nav-item {
            transition: all 0.2s ease;
        }
        .nav-item:hover {
            transform: translateX(5px);
        }
        .active-nav {
            background: rgba(255, 255, 255, 0.2);
            border-left: 4px solid white;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen" x-data="analyticsApp()">
    <!-- Sidebar Navigation -->
    <div class="sidebar glass fixed h-full z-10" 
         :class="sidebarCollapsed ? 'sidebar-collapsed' : 'sidebar-expanded'">
        <div class="flex flex-col h-full">
            <!-- Logo -->
            <div class="p-4 flex items-center justify-between border-b border-white border-opacity-20">
                <div class="flex items-center space-x-3" x-show="!sidebarCollapsed">
                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                        </svg>
                    </div>
                    <h1 class="text-white text-xl font-bold">Analytics</h1>
                </div>
                <button @click="sidebarCollapsed = !sidebarCollapsed" 
                        class="text-white hover:bg-white hover:bg-opacity-20 p-2 rounded-full">
                    <i :class="sidebarCollapsed ? 'fas fa-chevron-right' : 'fas fa-chevron-left'"></i>
                </button>
            </div>
            
            <!-- Navigation Menu -->
            <nav class="flex-1 overflow-y-auto py-4">
                <div class="space-y-1 px-4">
                    <!-- Dashboard -->
                    <a href="#" class="nav-item flex items-center space-x-3 py-3 px-4 text-white rounded-lg" 
                       :class="currentPage === 'dashboard' ? 'active-nav' : ''"
                       @click="currentPage = 'dashboard'">
                        <i class="fas fa-tachometer-alt w-6 text-center"></i>
                        <span x-show="!sidebarCollapsed">Dashboard</span>
                    </a>
                    
                    <!-- Analytics -->
                    <a href="#" class="nav-item flex items-center space-x-3 py-3 px-4 text-white rounded-lg" 
                       :class="currentPage === 'analytics' ? 'active-nav' : ''"
                       @click="currentPage = 'analytics'">
                        <i class="fas fa-chart-line w-6 text-center"></i>
                        <span x-show="!sidebarCollapsed">Analytics</span>
                    </a>
                    
                    <!-- User Management -->
                    <div class="mt-6" x-show="!sidebarCollapsed">
                        <p class="text-xs uppercase text-white text-opacity-60 px-4 mb-2">User Management</p>
                    </div>
                    
                    <a href="#" class="nav-item flex items-center space-x-3 py-3 px-4 text-white rounded-lg" 
                       :class="currentPage === 'users' ? 'active-nav' : ''"
                       @click="currentPage = 'users'">
                        <i class="fas fa-users w-6 text-center"></i>
                        <span x-show="!sidebarCollapsed">Users</span>
                    </a>
                    
                    <a href="#" class="nav-item flex items-center space-x-3 py-3 px-4 text-white rounded-lg" 
                       :class="currentPage === 'roles' ? 'active-nav' : ''"
                       @click="currentPage = 'roles'">
                        <i class="fas fa-user-shield w-6 text-center"></i>
                        <span x-show="!sidebarCollapsed">Roles & Permissions</span>
                    </a>
                    
                    <!-- Authentication -->
                    <div class="mt-6" x-show="!sidebarCollapsed">
                        <p class="text-xs uppercase text-white text-opacity-60 px-4 mb-2">Authentication</p>
                    </div>
                    
                    <a href="#" class="nav-item flex items-center space-x-3 py-3 px-4 text-white rounded-lg" 
                       :class="currentPage === 'login' ? 'active-nav' : ''"
                       @click="currentPage = 'login'">
                        <i class="fas fa-sign-in-alt w-6 text-center"></i>
                        <span x-show="!sidebarCollapsed">Login</span>
                    </a>
                    
                    <a href="#" class="nav-item flex items-center space-x-3 py-3 px-4 text-white rounded-lg" 
                       :class="currentPage === 'register' ? 'active-nav' : ''"
                       @click="currentPage = 'register'">
                        <i class="fas fa-user-plus w-6 text-center"></i>
                        <span x-show="!sidebarCollapsed">Register</span>
                    </a>
                    
                    <a href="#" class="nav-item flex items-center space-x-3 py-3 px-4 text-white rounded-lg" 
                       :class="currentPage === 'forgot-password' ? 'active-nav' : ''"
                       @click="currentPage = 'forgot-password'">
                        <i class="fas fa-key w-6 text-center"></i>
                        <span x-show="!sidebarCollapsed">Forgot Password</span>
                    </a>
                    
                    <!-- Settings -->
                    <div class="mt-6" x-show="!sidebarCollapsed">
                        <p class="text-xs uppercase text-white text-opacity-60 px-4 mb-2">Settings</p>
                    </div>
                    
                    <a href="#" class="nav-item flex items-center space-x-3 py-3 px-4 text-white rounded-lg" 
                       :class="currentPage === 'profile' ? 'active-nav' : ''"
                       @click="currentPage = 'profile'">
                        <i class="fas fa-user-cog w-6 text-center"></i>
                        <span x-show="!sidebarCollapsed">Profile</span>
                    </a>
                    
                    <a href="#" class="nav-item flex items-center space-x-3 py-3 px-4 text-white rounded-lg" 
                       :class="currentPage === 'settings' ? 'active-nav' : ''"
                       @click="currentPage = 'settings'">
                        <i class="fas fa-cog w-6 text-center"></i>
                        <span x-show="!sidebarCollapsed">Settings</span>
                    </a>
                </div>
            </nav>
            
            <!-- User Profile & Logout -->
            <div class="p-4 border-t border-white border-opacity-20">
                <div class="flex items-center space-x-3">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" 
                         class="w-10 h-10 rounded-full border-2 border-white">
                    <div x-show="!sidebarCollapsed">
                        <p class="text-white font-medium">Sarah Johnson</p>
                        <p class="text-xs text-white text-opacity-70">Admin</p>
                    </div>
                </div>
                <a href="#" class="nav-item flex items-center space-x-3 py-3 px-4 text-white rounded-lg mt-4" 
                   @click="logout">
                    <i class="fas fa-sign-out-alt w-6 text-center"></i>
                    <span x-show="!sidebarCollapsed">Logout</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content min-h-screen" 
         :class="sidebarCollapsed ? 'content-collapsed' : 'content-expanded'">
        <!-- Top Navigation -->
        <nav class="glass p-4">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-white text-xl font-semibold" x-text="getPageTitle(currentPage)"></h2>
                    <p class="text-sm text-white text-opacity-80" x-text="getPageDescription(currentPage)"></p>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="glass px-4 py-2 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition-all">
                        <i class="fas fa-sync-alt mr-2"></i> Refresh
                    </button>
                    <div class="relative">
                        <button @click="notificationsOpen = !notificationsOpen" 
                                class="glass p-2 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition-all relative">
                            <i class="fas fa-bell"></i>
                            <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full text-xs flex items-center justify-center">3</span>
                        </button>
                        <div x-show="notificationsOpen" @click.away="notificationsOpen = false" 
                             class="absolute right-0 mt-2 w-72 bg-white rounded-lg shadow-xl z-20">
                            <div class="p-4 border-b">
                                <h3 class="font-medium text-gray-800">Notifications</h3>
                            </div>
                            <div class="divide-y divide-gray-100 max-h-60 overflow-y-auto">
                                <a href="#" class="flex items-center p-3 hover:bg-gray-50">
                                    <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user-plus text-indigo-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">New user registered</p>
                                        <p class="text-xs text-gray-500">2 minutes ago</p>
                                    </div>
                                </a>
                                <a href="#" class="flex items-center p-3 hover:bg-gray-50">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-chart-line text-green-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Traffic spike detected</p>
                                        <p class="text-xs text-gray-500">15 minutes ago</p>
                                    </div>
                                </a>
                                <a href="#" class="flex items-center p-3 hover:bg-gray-50">
                                    <div class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-exclamation-triangle text-amber-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">High bounce rate</p>
                                        <p class="text-xs text-gray-500">1 hour ago</p>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2 border-t text-center">
                                <a href="#" class="text-sm text-indigo-600 font-medium">View All</a>
                            </div>
                        </div>
                    </div>
                    <button @click="profileMenuOpen = !profileMenuOpen" 
                            class="flex items-center space-x-2 glass px-4 py-2 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition-all">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" class="w-6 h-6 rounded-full">
                        <span x-show="!sidebarCollapsed">Sarah</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <div x-show="profileMenuOpen" @click.away="profileMenuOpen = false" 
                         class="absolute right-4 mt-2 w-48 bg-white rounded-lg shadow-xl z-20">
                        <div class="p-4 border-b">
                            <p class="font-medium text-gray-800">Sarah Johnson</p>
                            <p class="text-xs text-gray-500">Admin</p>
                        </div>
                        <div class="p-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Notifications</a>
                        </div>
                        <div class="p-2 border-t">
                            <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100" @click="logout">Sign out</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="p-6">
            <!-- Dashboard Content (shown when currentPage is 'dashboard' or 'analytics') -->
            <template x-if="currentPage === 'dashboard' || currentPage === 'analytics'">
                <div class="max-w-7xl mx-auto px-4 pb-8">
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-white border-opacity-20 animate-slideIn hover:scale-105 transition-transform">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Total Page Views</p>
                                    <p class="text-3xl font-bold text-indigo-600" x-text="stats.totalPageViews">0</p>
                                    <p class="text-sm text-green-600 mt-1">
                                        <span class="inline-flex items-center">
                                            <i class="fas fa-arrow-up mr-1 text-xs"></i>
                                            +12.5%
                                        </span>
                                    </p>
                                </div>
                                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-eye text-indigo-600"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-white border-opacity-20 animate-slideIn hover:scale-105 transition-transform" style="animation-delay: 0.1s">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Total Clicks</p>
                                    <p class="text-3xl font-bold text-emerald-600" x-text="stats.totalClicks">0</p>
                                    <p class="text-sm text-green-600 mt-1">
                                        <span class="inline-flex items-center">
                                            <i class="fas fa-arrow-up mr-1 text-xs"></i>
                                            +8.2%
                                        </span>
                                    </p>
                                </div>
                                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-mouse-pointer text-emerald-600"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-white border-opacity-20 animate-slideIn hover:scale-105 transition-transform" style="animation-delay: 0.2s">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Avg Session Duration</p>
                                    <p class="text-3xl font-bold text-amber-600" x-text="stats.avgSessionDuration">0</p>
                                    <p class="text-sm text-gray-500 mt-1">minutes</p>
                                </div>
                                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-clock text-amber-600"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-white border-opacity-20 animate-slideIn hover:scale-105 transition-transform" style="animation-delay: 0.3s">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Unique Visitors</p>
                                    <p class="text-3xl font-bold text-purple-600" x-text="stats.uniqueVisitors">0</p>
                                    <p class="text-sm text-green-600 mt-1">
                                        <span class="inline-flex items-center">
                                            <i class="fas fa-arrow-up mr-1 text-xs"></i>
                                            +15.3%
                                        </span>
                                    </p>
                                </div>
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-users text-purple-600"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <!-- Page Views Chart -->
                        <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-white border-opacity-20">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-semibold text-gray-800">Page Views Trend</h3>
                                <div class="flex space-x-2">
                                    <button class="px-3 py-1 text-sm bg-indigo-100 text-indigo-600 rounded-lg hover:bg-indigo-200 transition-colors">7D</button>
                                    <button class="px-3 py-1 text-sm bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors">30D</button>
                                    <button class="px-3 py-1 text-sm bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors">90D</button>
                                </div>
                            </div>
                            <div class="h-64">
                                <canvas id="pageViewsChart"></canvas>
                            </div>
                        </div>

                        <!-- Geographic Distribution -->
                        <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-white border-opacity-20">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-semibold text-gray-800">Geographic Distribution</h3>
                                <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                            </div>
                            <div class="h-64">
                                <canvas id="geoChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Full Width Chart -->
                    <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-white border-opacity-20 mb-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Click Heatmap & Element Performance</h3>
                            <div class="flex items-center space-x-4">
                                <select class="px-3 py-2 border border-gray-300 rounded-lg bg-white text-sm">
                                    <option>All Pages</option>
                                    <option>Homepage</option>
                                    <option>Product Pages</option>
                                    <option>Blog Posts</option>
                                </select>
                                <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors text-sm">
                                    Generate Report
                                </button>
                            </div>
                        </div>
                        <div class="h-80">
                            <canvas id="clicksChart"></canvas>
                        </div>
                    </div>

                    <!-- Data Tables -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Top Pages -->
                        <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-white border-opacity-20">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Top Pages</h3>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-gray-200">
                                            <th class="text-left py-3 px-2 font-medium text-gray-600">Page</th>
                                            <th class="text-right py-3 px-2 font-medium text-gray-600">Views</th>
                                            <th class="text-right py-3 px-2 font-medium text-gray-600">Unique</th>
                                            <th class="text-right py-3 px-2 font-medium text-gray-600">Bounce Rate</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template x-for="page in topPages" :key="page.path">
                                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                                <td class="py-3 px-2">
                                                    <div class="flex items-center">
                                                        <div class="w-2 h-2 bg-indigo-400 rounded-full mr-3"></div>
                                                        <span class="font-medium text-gray-800 truncate" x-text="page.path"></span>
                                                    </div>
                                                </td>
                                                <td class="py-3 px-2 text-right font-medium text-gray-800" x-text="page.views"></td>
                                                <td class="py-3 px-2 text-right text-gray-600" x-text="page.unique"></td>
                                                <td class="py-3 px-2 text-right">
                                                    <span class="px-2 py-1 text-xs rounded-full" :class="page.bounce_rate > 70 ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600'" x-text="page.bounce_rate + '%'"></span>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-white border-opacity-20">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Activity</h3>
                            <div class="space-y-4">
                                <template x-for="activity in recentActivity" :key="activity.id">
                                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                        <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-eye text-indigo-600 text-sm"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-800" x-text="activity.action"></p>
                                            <p class="text-xs text-gray-500" x-text="activity.timestamp"></p>
                                        </div>
                                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Users Management Page -->
            <template x-if="currentPage === 'users'">
                <div class="max-w-7xl mx-auto px-4 pb-8">
                    <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-white border-opacity-20 mb-8">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-800">User Management</h2>
                            <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                <i class="fas fa-plus mr-2"></i> Add User
                            </button>
                        </div>
                        
                        <div class="mb-6 flex justify-between items-center">
                            <div class="relative w-64">
                                <input type="text" placeholder="Search users..." 
                                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                            <div class="flex space-x-2">
                                <button class="px-3 py-1 text-sm bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors">
                                    <i class="fas fa-filter mr-1"></i> Filter
                                </button>
                                <button class="px-3 py-1 text-sm bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors">
                                    <i class="fas fa-download mr-1"></i> Export
                                </button>
                            </div>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-gray-200">
                                        <th class="text-left py-3 px-2 font-medium text-gray-600">User</th>
                                        <th class="text-left py-3 px-2 font-medium text-gray-600">Email</th>
                                        <th class="text-left py-3 px-2 font-medium text-gray-600">Role</th>
                                        <th class="text-left py-3 px-2 font-medium text-gray-600">Status</th>
                                        <th class="text-right py-3 px-2 font-medium text-gray-600">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                        <td class="py-3 px-2">
                                            <div class="flex items-center">
                                                <img src="https://randomuser.me/api/portraits/men/32.jpg" class="w-8 h-8 rounded-full mr-3">
                                                <span class="font-medium text-gray-800">John Smith</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-2 text-gray-600">john.smith@example.com</td>
                                        <td class="py-3 px-2">
                                            <span class="px-2 py-1 bg-indigo-100 text-indigo-600 rounded-full text-xs">Admin</span>
                                        </td>
                                        <td class="py-3 px-2">
                                            <span class="px-2 py-1 bg-green-100 text-green-600 rounded-full text-xs">Active</span>
                                        </td>
                                        <td class="py-3 px-2 text-right">
                                            <div class="flex justify-end space-x-2">
                                                <button class="p-1 text-indigo-600 hover:bg-indigo-100 rounded-full">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="p-1 text-red-600 hover:bg-red-100 rounded-full">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                        <td class="py-3 px-2">
                                            <div class="flex items-center">
                                                <img src="https://randomuser.me/api/portraits/women/44.jpg" class="w-8 h-8 rounded-full mr-3">
                                                <span class="font-medium text-gray-800">Sarah Johnson</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-2 text-gray-600">sarah.j@example.com</td>
                                        <td class="py-3 px-2">
                                            <span class="px-2 py-1 bg-purple-100 text-purple-600 rounded-full text-xs">Editor</span>
                                        </td>
                                        <td class="py-3 px-2">
                                            <span class="px-2 py-1 bg-green-100 text-green-600 rounded-full text-xs">Active</span>
                                        </td>
                                        <td class="py-3 px-2 text-right">
                                            <div class="flex justify-end space-x-2">
                                                <button class="p-1 text-indigo-600 hover:bg-indigo-100 rounded-full">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="p-1 text-red-600 hover:bg-red-100 rounded-full">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                        <td class="py-3 px-2">
                                            <div class="flex items-center">
                                                <img src="https://randomuser.me/api/portraits/men/75.jpg" class="w-8 h-8 rounded-full mr-3">
                                                <span class="font-medium text-gray-800">Michael Brown</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-2 text-gray-600">michael.b@example.com</td>
                                        <td class="py-3 px-2">
                                            <span class="px-2 py-1 bg-blue-100 text-blue-600 rounded-full text-xs">Viewer</span>
                                        </td>
                                        <td class="py-3 px-2">
                                            <span class="px-2 py-1 bg-green-100 text-green-600 rounded-full text-xs">Active</span>
                                        </td>
                                        <td class="py-3 px-2 text-right">
                                            <div class="flex justify-end space-x-2">
                                                <button class="p-1 text-indigo-600 hover:bg-indigo-100 rounded-full">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="p-1 text-red-600 hover:bg-red-100 rounded-full">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                        <td class="py-3 px-2">
                                            <div class="flex items-center">
                                                <img src="https://randomuser.me/api/portraits/women/68.jpg" class="w-8 h-8 rounded-full mr-3">
                                                <span class="font-medium text-gray-800">Emily Davis</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-2 text-gray-600">emily.d@example.com</td>
                                        <td class="py-3 px-2">
                                            <span class="px-2 py-1 bg-blue-100 text-blue-600 rounded-full text-xs">Viewer</span>
                                        </td>
                                        <td class="py-3 px-2">
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs">Pending</span>
                                        </td>
                                        <td class="py-3 px-2 text-right">
                                            <div class="flex justify-end space-x-2">
                                                <button class="p-1 text-indigo-600 hover:bg-indigo-100 rounded-full">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="p-1 text-red-600 hover:bg-red-100 rounded-full">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                        <td class="py-3 px-2">
                                            <div class="flex items-center">
                                                <img src="https://randomuser.me/api/portraits/men/12.jpg" class="w-8 h-8 rounded-full mr-3">
                                                <span class="font-medium text-gray-800">Robert Wilson</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-2 text-gray-600">robert.w@example.com</td>
                                        <td class="py-3 px-2">
                                            <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">Inactive</span>
                                        </td>
                                        <td class="py-3 px-2">
                                            <span class="px-2 py-1 bg-red-100 text-red-600 rounded-full text-xs">Suspended</span>
                                        </td>
                                        <td class="py-3 px-2 text-right">
                                            <div class="flex justify-end space-x-2">
                                                <button class="p-1 text-indigo-600 hover:bg-indigo-100 rounded-full">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="p-1 text-red-600 hover:bg-red-100 rounded-full">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="flex justify-between items-center mt-6">
                            <div class="text-sm text-gray-600">
                                Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of <span class="font-medium">24</span> users
                            </div>
                            <div class="flex space-x-2">
                                <button class="px-3 py-1 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="px-3 py-1 bg-indigo-600 text-white rounded-lg">1</button>
                                <button class="px-3 py-1 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors">2</button>
                                <button class="px-3 py-1 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors">3</button>
                                <button class="px-3 py-1 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Roles & Permissions Page -->
            <template x-if="currentPage === 'roles'">
                <div class="max-w-7xl mx-auto px-4 pb-8">
                    <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-white border-opacity-20 mb-8">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-800">Roles & Permissions</h2>
                            <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                <i class="fas fa-plus mr-2"></i> Add Role
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Admin Role -->
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <div class="bg-indigo-600 p-4 text-white">
                                    <div class="flex justify-between items-center">
                                        <h3 class="font-bold">Admin</h3>
                                        <span class="text-xs bg-white text-indigo-600 px-2 py-1 rounded-full">5 users</span>
                                    </div>
                                    <p class="text-sm text-indigo-100 mt-1">Full access to all features</p>
                                </div>
                                <div class="p-4 bg-white">
                                    <h4 class="font-medium text-gray-800 mb-3">Permissions</h4>
                                    <ul class="space-y-2">
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            <span class="text-sm">Full dashboard access</span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            <span class="text-sm">User management</span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            <span class="text-sm">Role management</span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            <span class="text-sm">All permissions</span>
                                        </li>
                                    </ul>
                                    <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between">
                                        <button class="px-3 py-1 bg-indigo-100 text-indigo-600 rounded-lg text-sm hover:bg-indigo-200 transition-colors">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </button>
                                        <button class="px-3 py-1 bg-red-100 text-red-600 rounded-lg text-sm hover:bg-red-200 transition-colors">
                                            <i class="fas fa-trash mr-1"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Editor Role -->
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <div class="bg-purple-600 p-4 text-white">
                                    <div class="flex justify-between items-center">
                                        <h3 class="font-bold">Editor</h3>
                                        <span class="text-xs bg-white text-purple-600 px-2 py-1 rounded-full">12 users</span>
                                    </div>
                                    <p class="text-sm text-purple-100 mt-1">Can create and edit content</p>
                                </div>
                                <div class="p-4 bg-white">
                                    <h4 class="font-medium text-gray-800 mb-3">Permissions</h4>
                                    <ul class="space-y-2">
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            <span class="text-sm">Content management</span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            <span class="text-sm">Media library</span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            <span class="text-sm">Analytics view</span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="fas fa-times-circle text-gray-300 mr-2"></i>
                                            <span class="text-sm">User management</span>
                                        </li>
                                    </ul>
                                    <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between">
                                        <button class="px-3 py-1 bg-purple-100 text-purple-600 rounded-lg text-sm hover:bg-purple-200 transition-colors">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </button>
                                        <button class="px-3 py-1 bg-red-100 text-red-600 rounded-lg text-sm hover:bg-red-200 transition-colors">
                                            <i class="fas fa-trash mr-1"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Viewer Role -->
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <div class="bg-blue-600 p-4 text-white">
                                    <div class="flex justify-between items-center">
                                        <h3 class="font-bold">Viewer</h3>
                                        <span class="text-xs bg-white text-blue-600 px-2 py-1 rounded-full">7 users</span>
                                    </div>
                                    <p class="text-sm text-blue-100 mt-1">Read-only access</p>
                                </div>
                                <div class="p-4 bg-white">
                                    <h4 class="font-medium text-gray-800 mb-3">Permissions</h4>
                                    <ul class="space-y-2">
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            <span class="text-sm">View analytics</span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            <span class="text-sm">View content</span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="fas fa-times-circle text-gray-300 mr-2"></i>
                                            <span class="text-sm">Edit content</span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="fas fa-times-circle text-gray-300 mr-2"></i>
                                            <span class="text-sm">User management</span>
                                        </li>
                                    </ul>
                                    <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between">
                                        <button class="px-3 py-1 bg-blue-100 text-blue-600 rounded-lg text-sm hover:bg-blue-200 transition-colors">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </button>
                                        <button class="px-3 py-1 bg-red-100 text-red-600 rounded-lg text-sm hover:bg-red-200 transition-colors">
                                            <i class="fas fa-trash mr-1"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Profile Page -->
            <template x-if="currentPage === 'profile'">
                <div class="max-w-7xl mx-auto px-4 pb-8">
                    <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-white border-opacity-20 mb-8">
                        <div class="flex flex-col md:flex-row gap-8">
                            <!-- Profile Sidebar -->
                            <div class="md:w-1/3">
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <div class="flex flex-col items-center">
                                        <img src="https://randomuser.me/api/portraits/women/44.jpg" 
                                             class="w-24 h-24 rounded-full border-4 border-white shadow-lg mb-4">
                                        <h3 class="text-xl font-bold text-gray-800">Sarah Johnson</h3>
                                        <p class="text-sm text-gray-600 mb-4">Admin</p>
                                        <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                                            <div class="bg-indigo-600 h-2 rounded-full" style="width: 85%"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 mb-6">Profile completeness: 85%</p>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <p class="text-xs uppercase text-gray-500 mb-1">Email</p>
                                            <p class="text-sm font-medium text-gray-800">sarah.j@example.com</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase text-gray-500 mb-1">Joined</p>
                                            <p class="text-sm font-medium text-gray-800">May 12, 2021</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase text-gray-500 mb-1">Last Active</p>
                                            <p class="text-sm font-medium text-gray-800">2 hours ago</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase text-gray-500 mb-1">Timezone</p>
                                            <p class="text-sm font-medium text-gray-800">(GMT-05:00) Eastern Time</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Profile Content -->
                            <div class="md:w-2/3">
                                <h2 class="text-2xl font-bold text-gray-800 mb-6">Profile Settings</h2>
                                
                                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                                    <h3 class="font-medium text-gray-800 mb-4">Personal Information</h3>
                                    <form class="space-y-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                                <input type="text" value="Sarah" 
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                                <input type="text" value="Johnson" 
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                            <input type="email" value="sarah.j@example.com" 
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                                            <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" rows="3">Digital marketing specialist with 5+ years of experience in analytics and user behavior.</textarea>
                                        </div>
                                        <div class="flex justify-end">
                                            <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                                Save Changes
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                
                                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                                    <h3 class="font-medium text-gray-800 mb-4">Security</h3>
                                    <div class="space-y-4">
                                        <div class="flex justify-between items-center p-3 bg-white rounded-lg border border-gray-200">
                                            <div>
                                                <p class="font-medium text-gray-800">Password</p>
                                                <p class="text-sm text-gray-500">Last changed 3 months ago</p>
                                            </div>
                                            <button class="px-3 py-1 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors">
                                                Change
                                            </button>
                                        </div>
                                        <div class="flex justify-between items-center p-3 bg-white rounded-lg border border-gray-200">
                                            <div>
                                                <p class="font-medium text-gray-800">Two-Factor Authentication</p>
                                                <p class="text-sm text-gray-500">Add an extra layer of security</p>
                                            </div>
                                            <button class="px-3 py-1 bg-indigo-100 text-indigo-600 rounded-lg hover:bg-indigo-200 transition-colors">
                                                Enable
                                            </button>
                                        </div>
                                        <div class="flex justify-between items-center p-3 bg-white rounded-lg border border-gray-200">
                                            <div>
                                                <p class="font-medium text-gray-800">Active Sessions</p>
                                                <p class="text-sm text-gray-500">2 active sessions</p>
                                            </div>
                                            <button class="px-3 py-1 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors">
                                                View All
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h3 class="font-medium text-gray-800 mb-4">Preferences</h3>
                                    <div class="space-y-4">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="font-medium text-gray-800">Language</p>
                                                <p class="text-sm text-gray-500">Interface language</p>
                                            </div>
                                            <select class="px-3 py-2 border border-gray-300 rounded-lg bg-white text-sm">
                                                <option>English</option>
                                                <option>Spanish</option>
                                                <option>French</option>
                                                <option>German</option>
                                            </select>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="font-medium text-gray-800">Timezone</p>
                                                <p class="text-sm text-gray-500">(GMT-05:00) Eastern Time</p>
                                            </div>
                                            <select class="px-3 py-2 border border-gray-300 rounded-lg bg-white text-sm">
                                                <option>(GMT-05:00) Eastern Time</option>
                                                <option>(GMT-06:00) Central Time</option>
                                                <option>(GMT-07:00) Mountain Time</option>
                                                <option>(GMT-08:00) Pacific Time</option>
                                            </select>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="font-medium text-gray-800">Theme</p>
                                                <p class="text-sm text-gray-500">Light theme</p>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <button class="px-3 py-1 bg-indigo-600 text-white rounded-lg">Light</button>
                                                <button class="px-3 py-1 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors">Dark</button>
                                                <button class="px-3 py-1 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors">System</button>
                                            </div>
                                        </div>
                                        <div class="flex justify-end">
                                            <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                                Save Preferences
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Settings Page -->
            <template x-if="currentPage === 'settings'">
                <div class="max-w-7xl mx-auto px-4 pb-8">
                    <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-white border-opacity-20 mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">System Settings</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <!-- General Settings -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="font-medium text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-cog text-indigo-600 mr-2"></i> General
                                </h3>
                                <form class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Site Name</label>
                                        <input type="text" value="Analytics Dashboard" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Site URL</label>
                                        <input type="url" value="https://analytics.example.com" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Timezone</label>
                                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <option>(GMT-05:00) Eastern Time</option>
                                            <option>(GMT-06:00) Central Time</option>
                                            <option>(GMT-07:00) Mountain Time</option>
                                            <option>(GMT-08:00) Pacific Time</option>
                                        </select>
                                    </div>
                                    <div class="flex justify-end">
                                        <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                            Save
                                        </button>
                                    </div>
                                </form>
                            </div>
                            
                            <!-- Analytics Settings -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="font-medium text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-chart-line text-indigo-600 mr-2"></i> Analytics
                                </h3>
                                <form class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tracking Code</label>
                                        <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" rows="3"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Data Retention</label>
                                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <option>30 days</option>
                                            <option>60 days</option>
                                            <option>90 days</option>
                                            <option>1 year</option>
                                        </select>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" id="anonymize" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label for="anonymize" class="ml-2 block text-sm text-gray-700">Anonymize IP addresses</label>
                                    </div>
                                    <div class="flex justify-end">
                                        <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                            Save
                                        </button>
                                    </div>
                                </form>
                            </div>
                            
                            <!-- Email Settings -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="font-medium text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-envelope text-indigo-600 mr-2"></i> Email
                                </h3>
                                <form class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">SMTP Host</label>
                                        <input type="text" placeholder="smtp.example.com" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">SMTP Port</label>
                                        <input type="number" placeholder="587" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">SMTP Username</label>
                                        <input type="text" placeholder="your@email.com" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">SMTP Password</label>
                                        <input type="password" placeholder="••••••••" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                    <div class="flex justify-end">
                                        <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                            Save
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
                            <h3 class="font-medium text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-shield-alt text-indigo-600 mr-2"></i> Security
                            </h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                                    <div>
                                        <p class="font-medium text-gray-800">Two-Factor Authentication</p>
                                        <p class="text-sm text-gray-500">Require 2FA for all admin users</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" value="" class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                                    <div>
                                        <p class="font-medium text-gray-800">Password Policy</p>
                                        <p class="text-sm text-gray-500">Require strong passwords</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" value="" class="sr-only peer" checked>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                                    <div>
                                        <p class="font-medium text-gray-800">Session Timeout</p>
                                        <p class="text-sm text-gray-500">After 30 minutes of inactivity</p>
                                    </div>
                                    <select class="px-3 py-1 border border-gray-300 rounded-lg bg-white text-sm">
                                        <option>15 minutes</option>
                                        <option selected>30 minutes</option>
                                        <option>1 hour</option>
                                        <option>2 hours</option>
                                    </select>
                                </div>
                                <div class="flex justify-end">
                                    <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                        Save Security Settings
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="font-medium text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-plug text-indigo-600 mr-2"></i> Integrations
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div class="border border-gray-200 rounded-lg p-4 flex items-center">
                                    <img src="https://logo.clearbit.com/google.com" class="w-10 h-10 rounded-full mr-3">
                                    <div>
                                        <p class="font-medium text-gray-800">Google Analytics</p>
                                        <p class="text-xs text-gray-500">Not connected</p>
                                    </div>
                                    <button class="ml-auto px-3 py-1 bg-gray-100 text-gray-600 rounded-lg text-sm hover:bg-gray-200 transition-colors">
                                        Connect
                                    </button>
                                </div>
                                <div class="border border-gray-200 rounded-lg p-4 flex items-center">
                                    <img src="https://logo.clearbit.com/stripe.com" class="w-10 h-10 rounded-full mr-3">
                                    <div>
                                        <p class="font-medium text-gray-800">Stripe</p>
                                        <p class="text-xs text-gray-500">Connected</p>
                                    </div>
                                    <button class="ml-auto px-3 py-1 bg-indigo-100 text-indigo-600 rounded-lg text-sm hover:bg-indigo-200 transition-colors">
                                        Manage
                                    </button>
                                </div>
                                <div class="border border-gray-200 rounded-lg p-4 flex items-center">
                                    <img src="https://logo.clearbit.com/slack.com" class="w-10 h-10 rounded-full mr-3">
                                    <div>
                                        <p class="font-medium text-gray-800">Slack</p>
                                        <p class="text-xs text-gray-500">Not connected</p>
                                    </div>
                                    <button class="ml-auto px-3 py-1 bg-gray-100 text-gray-600 rounded-lg text-sm hover:bg-gray-200 transition-colors">
                                        Connect
                                    </button>
                                </div>
                                <div class="border border-gray-200 rounded-lg p-4 flex items-center">
                                    <img src="https://logo.clearbit.com/mailchimp.com" class="w-10 h-10 rounded-full mr-3">
                                    <div>
                                        <p class="font-medium text-gray-800">Mailchimp</p>
                                        <p class="text-xs text-gray-500">Connected</p>
                                    </div>
                                    <button class="ml-auto px-3 py-1 bg-indigo-100 text-indigo-600 rounded-lg text-sm hover:bg-indigo-200 transition-colors">
                                        Manage
                                    </button>
                                </div>
                                <div class="border border-gray-200 rounded-lg p-4 flex items-center">
                                    <img src="https://logo.clearbit.com/zapier.com" class="w-10 h-10 rounded-full mr-3">
                                    <div>
                                        <p class="font-medium text-gray-800">Zapier</p>
                                        <p class="text-xs text-gray-500">Not connected</p>
                                    </div>
                                    <button class="ml-auto px-3 py-1 bg-gray-100 text-gray-600 rounded-lg text-sm hover:bg-gray-200 transition-colors">
                                        Connect
                                    </button>
                                </div>
                                <div class="border border-gray-200 rounded-lg p-4 flex items-center">
                                    <img src="https://logo.clearbit.com/shopify.com" class="w-10 h-10 rounded-full mr-3">
                                    <div>
                                        <p class="font-medium text-gray-800">Shopify</p>
                                        <p class="text-xs text-gray-500">Not connected</p>
                                    </div>
                                    <button class="ml-auto px-3 py-1 bg-gray-100 text-gray-600 rounded-lg text-sm hover:bg-gray-200 transition-colors">
                                        Connect
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Authentication Pages -->
            <template x-if="currentPage === 'login' || currentPage === 'register' || currentPage === 'forgot-password'">
                <div class="max-w-md mx-auto py-12">
                    <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-2xl p-8 shadow-xl border border-white border-opacity-20">
                        <div class="text-center mb-8">
                            <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-lock text-indigo-600 text-2xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800" x-text="getPageTitle(currentPage)"></h2>
                            <p class="text-gray-600 mt-2" x-text="getPageDescription(currentPage)"></p>
                        </div>
                        
                        <!-- Login Form -->
                        <template x-if="currentPage === 'login'">
                            <form class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                    <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="your@email.com">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                    <input type="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="••••••••">
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label for="remember-me" class="ml-2 block text-sm text-gray-700">Remember me</label>
                                    </div>
                                    <a href="#" class="text-sm text-indigo-600 hover:text-indigo-500" @click="currentPage = 'forgot-password'">Forgot password?</a>
                                </div>
                                <button type="submit" class="w-full px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                                    Sign in
                                </button>
                                <div class="text-center text-sm text-gray-600">
                                    Don't have an account? <a href="#" class="text-indigo-600 hover:text-indigo-500" @click="currentPage = 'register'">Sign up</a>
                                </div>
                            </form>
                        </template>
                        
                        <!-- Register Form -->
                        <template x-if="currentPage === 'register'">
                            <form class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="John">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Doe">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                    <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="your@email.com">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                    <input type="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="••••••••">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                                    <input type="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="••••••••">
                                </div>
                                <div class="flex items-center">
                                    <input id="terms" name="terms" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="terms" class="ml-2 block text-sm text-gray-700">I agree to the <a href="#" class="text-indigo-600 hover:text-indigo-500">Terms</a> and <a href="#" class="text-indigo-600 hover:text-indigo-500">Privacy Policy</a></label>
                                </div>
                                <button type="submit" class="w-full px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                                    Create Account
                                </button>
                                <div class="text-center text-sm text-gray-600">
                                    Already have an account? <a href="#" class="text-indigo-600 hover:text-indigo-500" @click="currentPage = 'login'">Sign in</a>
                                </div>
                            </form>
                        </template>
                        
                        <!-- Forgot Password Form -->
                        <template x-if="currentPage === 'forgot-password'">
                            <form class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                    <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="your@email.com">
                                </div>
                                <button type="submit" class="w-full px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                                    Send Reset Link
                                </button>
                                <div class="text-center text-sm text-gray-600">
                                    Remember your password? <a href="#" class="text-indigo-600 hover:text-indigo-500" @click="currentPage = 'login'">Sign in</a>
                                </div>
                            </form>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <script>
        function analyticsApp() {
            return {
                sidebarCollapsed: false,
                currentPage: 'dashboard',
                notificationsOpen: false,
                profileMenuOpen: false,
                stats: {
                    totalPageViews: 0,
                    totalClicks: 0,
                    avgSessionDuration: 0,
                    uniqueVisitors: 0
                },
                topPages: [],
                recentActivity: [],
                charts: {},
                
                init() {
                    this.loadData();
                    this.initCharts();
                    this.animateStats();
                    
                    // Refresh data every 30 seconds
                    setInterval(() => {
                        this.loadData();
                    }, 30000);
                },
                
                getPageTitle(page) {
                    const titles = {
                        'dashboard': 'Dashboard Overview',
                        'analytics': 'Analytics',
                        'users': 'User Management',
                        'roles': 'Roles & Permissions',
                        'login': 'Sign in to your account',
                        'register': 'Create a new account',
                        'forgot-password': 'Reset your password',
                        'profile': 'User Profile',
                        'settings': 'System Settings'
                    };
                    return titles[page] || 'Dashboard';
                },
                
                getPageDescription(page) {
                    const descriptions = {
                        'dashboard': 'Overview of your analytics data',
                        'analytics': 'Detailed analytics and metrics',
                        'users': 'Manage system users and permissions',
                        'roles': 'Configure roles and access levels',
                        'login': 'Enter your credentials to access the dashboard',
                        'register': 'Fill in your details to create an account',
                        'forgot-password': 'Enter your email to receive a password reset link',
                        'profile': 'Manage your personal information and settings',
                        'settings': 'Configure system preferences and options'
                    };
                    return descriptions[page] || '';
                },
                
                async loadData() {
                    try {
                        // Simulate API calls to your Laravel endpoints
                        const [pageViews, clicks, sessionDuration, geolocation] = await Promise.all([
                            this.fetchData('/api/analytics/pageviews'),
                            this.fetchData('/api/analytics/clicks'),
                            this.fetchData('/api/analytics/session-duration'),
                            this.fetchData('/api/analytics/geolocation')
                        ]);
                        
                        this.updateStats(pageViews, clicks, sessionDuration);
                        this.updateTopPages();
                        this.updateRecentActivity();
                        this.updateCharts();
                        
                    } catch (error) {
                        console.error('Error loading data:', error);
                        this.loadMockData();
                    }
                },
                
                async fetchData(endpoint) {
                    // In a real Laravel app, you'd make actual API calls here
                    // For demo purposes, we'll return mock data
                    return new Promise(resolve => {
                        setTimeout(() => {
                            resolve(this.getMockData(endpoint));
                        }, 100);
                    });
                },
                
                getMockData(endpoint) {
                    const mockData = {
                        '/api/analytics/pageviews': { total: 12547, data: [120, 150, 180, 200, 250, 300, 320] },
                        '/api/analytics/clicks': { total: 3421, data: [45, 60, 75, 90, 105, 120, 135] },
                        '/api/analytics/session-duration': { average: 4.2 },
                        '/api/analytics/geolocation': { 
                            countries: [
                                { name: 'United States', value: 35 },
                                { name: 'United Kingdom', value: 20 },
                                { name: 'Canada', value: 15 },
                                { name: 'Germany', value: 12 },
                                { name: 'Others', value: 18 }
                            ]
                        }
                    };
                    return mockData[endpoint] || {};
                },
                
                loadMockData() {
                    this.stats = {
                        totalPageViews: 12547,
                        totalClicks: 3421,
                        avgSessionDuration: 4.2,
                        uniqueVisitors: 8934
                    };
                    
                    this.topPages = [
                        { path: '/dashboard', views: 2547, unique: 1234, bounce_rate: 45 },
                        { path: '/products', views: 1987, unique: 987, bounce_rate: 32 },
                        { path: '/about', views: 1456, unique: 756, bounce_rate: 28 },
                        { path: '/contact', views: 987, unique: 543, bounce_rate: 65 },
                        { path: '/blog', views: 765, unique: 432, bounce_rate: 52 }
                    ];
                    
                    this.recentActivity = [
                        { id: 1, action: 'New page view on /dashboard', timestamp: '2 minutes ago' },
                        { id: 2, action: 'Click event on "Subscribe" button', timestamp: '5 minutes ago' },
                        { id: 3, action: 'New visitor from United States', timestamp: '8 minutes ago' },
                        { id: 4, action: 'Page view on /products', timestamp: '12 minutes ago' },
                        { id: 5, action: 'Click event on "Learn More" link', timestamp: '15 minutes ago' }
                    ];
                },
                
                updateStats(pageViews, clicks, sessionDuration) {
                    this.stats.totalPageViews = pageViews.total || 12547;
                    this.stats.totalClicks = clicks.total || 3421;
                    this.stats.avgSessionDuration = sessionDuration.average || 4.2;
                    this.stats.uniqueVisitors = Math.floor(this.stats.totalPageViews * 0.71);
                },
                
                updateTopPages() {
                    this.topPages = [
                        { path: '/dashboard', views: 2547, unique: 1234, bounce_rate: 45 },
                        { path: '/products', views: 1987, unique: 987, bounce_rate: 32 },
                        { path: '/about', views: 1456, unique: 756, bounce_rate: 28 },
                        { path: '/contact', views: 987, unique: 543, bounce_rate: 65 },
                        { path: '/blog', views: 765, unique: 432, bounce_rate: 52 }
                    ];
                },
                
                updateRecentActivity() {
                    this.recentActivity = [
                        { id: 1, action: 'New page view on /dashboard', timestamp: '2 minutes ago' },
                        { id: 2, action: 'Click event on "Subscribe" button', timestamp: '5 minutes ago' },
                        { id: 3, action: 'New visitor from United States', timestamp: '8 minutes ago' },
                        { id: 4, action: 'Page view on /products', timestamp: '12 minutes ago' },
                        { id: 5, action: 'Click event on "Learn More" link', timestamp: '15 minutes ago' }
                    ];
                },
                
                animateStats() {
                    const targets = {
                        totalPageViews: 12547,
                        totalClicks: 3421,
                        avgSessionDuration: 4.2,
                        uniqueVisitors: 8934
                    };
                    
                    Object.keys(targets).forEach(key => {
                        let current = 0;
                        const target = targets[key];
                        const increment = target / 100;
                        
                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= target) {
                                current = target;
                                clearInterval(timer);
                            }
                            this.stats[key] = key === 'avgSessionDuration' ? current.toFixed(1) : Math.floor(current);
                        }, 20);
                    });
                },
                
                initCharts() {
                    this.$nextTick(() => {
                        this.createPageViewsChart();
                        this.createGeoChart();
                        this.createClicksChart();
                    });
                },
                
                createPageViewsChart() {
                    const ctx = document.getElementById('pageViewsChart');
                    if (!ctx) return;
                    
                    this.charts.pageViews = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                            datasets: [{
                                label: 'Page Views',
                                data: [120, 150, 180, 200, 250, 300, 320],
                                borderColor: 'rgb(99, 102, 241)',
                                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.1)'
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                },
                
                createGeoChart() {
                    const ctx = document.getElementById('geoChart');
                    if (!ctx) return;
                    
                    this.charts.geo = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['United States', 'United Kingdom', 'Canada', 'Germany', 'Others'],
                            datasets: [{
                                data: [35, 20, 15, 12, 18],
                                backgroundColor: [
                                    'rgba(99, 102, 241, 0.8)',
                                    'rgba(16, 185, 129, 0.8)',
                                    'rgba(245, 158, 11, 0.8)',
                                    'rgba(239, 68, 68, 0.8)',
                                    'rgba(107, 114, 128, 0.8)'
                                ],
                                borderWidth: 2,
                                borderColor: '#fff'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 20,
                                        usePointStyle: true
                                    }
                                }
                            }
                        }
                    });
                },
                
                createClicksChart() {
                    const ctx = document.getElementById('clicksChart');
                    if (!ctx) return;
                    
                    this.charts.clicks = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Header Nav', 'CTA Button', 'Footer Links', 'Product Cards', 'Social Icons', 'Search Bar'],
                            datasets: [{
                                label: 'Clicks',
                                data: [245, 189, 156, 134, 89, 67],
                                backgroundColor: [
                                    'rgba(99, 102, 241, 0.8)',
                                    'rgba(16, 185, 129, 0.8)',
                                    'rgba(245, 158, 11, 0.8)',
                                    'rgba(239, 68, 68, 0.8)',
                                    'rgba(168, 85, 247, 0.8)',
                                    'rgba(59, 130, 246, 0.8)'
                                ],
                                borderRadius: 8,
                                borderSkipped: false
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.1)'
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                },
                
                updateCharts() {
                    if (this.charts.pageViews) {
                        this.charts.pageViews.data.datasets[0].data = [120, 150, 180, 200, 250, 300, 320];
                        this.charts.pageViews.update();
                    }
                    
                    if (this.charts.geo) {
                        this.charts.geo.data.datasets[0].data = [35, 20, 15, 12, 18];
                        this.charts.geo.update();
                    }
                    
                    if (this.charts.clicks) {
                        this.charts.clicks.data.datasets[0].data = [245, 189, 156, 134, 89, 67];
                        this.charts.clicks.update();
                    }
                },
                
                logout() {
                    // In a real app, you would make an API call to logout
                    alert('Logging out...');
                    this.currentPage = 'login';
                }
            }
        }
    </script>
</body>
</html>