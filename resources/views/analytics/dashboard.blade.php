<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .loading-spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3b82f6;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Analytics Dashboard</h1>

        <!-- Loading Indicator -->
        <div id="loading" class="loading-spinner hidden"></div>

        <!-- Error Message -->
        <div id="error-message" class="hidden text-red-600 text-center mb-4"></div>

        <!-- Controls -->
        <form method="GET" action="{{ route('analytics.dashboard') }}" class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div>
                    <label for="site_id" class="mr-2 text-lg font-medium text-gray-700">Select Website:</label>
                    <select name="site_id" id="site_id" class="border p-2 rounded-lg bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                        <option value="all" {{ request('site_id') === 'all' || !request('site_id') ? 'selected' : '' }}>All Sites</option>
                        @foreach ($analytics as $domain => $siteData)
                            @if ($domain !== 'combined')
                                <option value="{{ $siteData['site_id'] }}" {{ request('site_id') == $siteData['site_id'] ? 'selected' : '' }}>
                                    {{ $siteData['name'] }} ({{ $domain }})
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="period" class="mr-2 text-lg font-medium text-gray-700">Select Period:</label>
                    <select name="period" id="period" class="border p-2 rounded-lg bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                        @foreach ($periods as $period)
                            <option value="{{ $period }}" {{ request('period', 'this_month') === $period ? 'selected' : '' }}>
                                {{ ucwords(str_replace('_', ' ', $period)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            @if (request('site_id') && request('site_id') !== 'all')
                <div class="flex items-center gap-2">
                    <input type="text" id="share-link" value="{{ url('/analytics', ['site_id' => request('site_id'), 'period' => request('period', 'this_month')]) }}" readonly class="border p-2 rounded-lg bg-gray-100 text-gray-600 w-full sm:w-auto">
                    <button type="button" onclick="copyShareLink()" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">Copy Link</button>
                </div>
            @endif
        </form>

        <!-- All Sites View -->
        @if (!request('site_id') || request('site_id') === 'all')
            <div class="site-data bg-white p-6 rounded-lg shadow-md mb-8">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800">Combined Analytics</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <h3 class="text-lg font-medium mb-2 text-gray-700">Summary (All Time)</h3>
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="border p-2 text-left">Metric</th>
                                    <th class="border p-2 text-left">Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>Total Views</td><td>{{ collect($analytics['combined']['all_time']['views'])->sum('count') }}</td></tr>
                                <tr><td>Total Clicks</td><td>{{ collect($analytics['combined']['all_time']['clicks'])->sum('count') }}</td></tr>
                                <tr><td>Unique Visitors</td><td>{{ $analytics['combined']['all_time']['unique_visitors'] }}</td></tr>
                                <tr><td>Top Page</td><td><a href="{{ $analytics['combined']['all_time']['top_pages'][0]['page_url'] ?? '#' }}" class="text-blue-500 hover:underline" target="_blank">{{ $analytics['combined']['all_time']['top_pages'][0]['page_url'] ?? 'N/A' }}</a></td></tr>
                                <tr><td>New Visitors</td><td>{{ $analytics['combined']['all_time']['new_visitors'] ?? 0 }}</td></tr>
                                <tr><td>Returning Visitors</td><td>{{ $analytics['combined']['all_time']['returning_visitors'] ?? 0 }}</td></tr>
                                <tr><td>Online Visitors</td><td>{{ $analytics['combined']['all_time']['online_visitors'] ?? 0 }}</td></tr>
                                <tr><td>Avg Session Duration</td><td>{{ $analytics['combined']['all_time']['avg_session_duration'] ?? 0 }} seconds</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <h3 class="text-lg font-medium mb-2 text-gray-700">Top Pages ({{ ucwords(str_replace('_', ' ', request('period', 'this_month'))) }})</h3>
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="border p-2 text-left">Page URL</th>
                                    <th class="border p-2 text-left">Views</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($analytics['combined']['periods'][request('period', 'this_month')]['top_pages'] as $page)
                                    <tr>
                                        <td class="border p-2"><a href="{{ $page['page_url'] }}" class="text-blue-500 hover:underline" target="_blank">{{ $page['page_url'] }}</a></td>
                                        <td class="border p-2">{{ $page['views'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="chart-container bg-white p-4 rounded-lg shadow-sm">
                        <h3 class="text-lg font-medium mb-2 text-gray-700">Page Views Over Time</h3>
                        <canvas id="combinedViewsChart"></canvas>
                    </div>
                    <div class="chart-container bg-white p-4 rounded-lg shadow-sm">
                        <h3 class="text-lg font-medium mb-2 text-gray-700">Clicks Over Time</h3>
                        <canvas id="combinedClicksChart"></canvas>
                    </div>
                    <div class="chart-container bg-white p-4 rounded-lg shadow-sm">
                        <h3 class="text-lg font-medium mb-2 text-gray-700">Visitor Statistics</h3>
                        <canvas id="combinedVisitorsChart"></canvas>
                    </div>
                    <div class="chart-container bg-white p-4 rounded-lg shadow-sm">
                        <h3 class="text-lg font-medium mb-2 text-gray-700">Visitors by Country</h3>
                        <canvas id="combinedCountryChart"></canvas>
                    </div>
                </div>
            </div>
        @endif

        <!-- Individual Site View -->
        @if (request('site_id') && request('site_id') !== 'all')
            @foreach ($analytics as $domain => $siteData)
                @if ($siteData['site_id'] == request('site_id'))
                    <div class="site-data bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-2xl font-semibold mb-4 text-gray-800">{{ $siteData['name'] }} ({{ $domain }})</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                                <h3 class="text-lg font-medium mb-2 text-gray-700">Summary (All Time)</h3>
                                <table class="w-full border-collapse">
                                    <thead>
                                        <tr class="bg-gray-200">
                                            <th class="border p-2 text-left">Metric</th>
                                            <th class="border p-2 text-left">Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>Total Views</td><td>{{ collect($siteData['all_time']['views'])->sum('count') }}</td></tr>
                                        <tr><td>Total Clicks</td><td>{{ collect($siteData['all_time']['clicks'])->sum('count') }}</td></tr>
                                        <tr><td>Unique Visitors</td><td>{{ $siteData['all_time']['unique_visitors'] }}</td></tr>
                                        <tr><td>Top Page</td><td><a href="{{ $siteData['all_time']['top_pages'][0]['page_url'] ?? '#' }}" class="text-blue-500 hover:underline" target="_blank">{{ $siteData['all_time']['top_pages'][0]['page_url'] ?? 'N/A' }}</a></td></tr>
                                        <tr><td>New Visitors</td><td>{{ $siteData['all_time']['new_visitors'] ?? 0 }}</td></tr>
                                        <tr><td>Returning Visitors</td><td>{{ $siteData['all_time']['returning_visitors'] ?? 0 }}</td></tr>
                                        <tr><td>Online Visitors</td><td>{{ $siteData['all_time']['online_visitors'] ?? 0 }}</td></tr>
                                        <tr><td>Avg Session Duration</td><td>{{ $siteData['all_time']['avg_session_duration'] ?? 0 }} seconds</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                                <h3 class="text-lg font-medium mb-2 text-gray-700">Top Pages ({{ ucwords(str_replace('_', ' ', request('period', 'this_month'))) }})</h3>
                                <table class="w-full border-collapse">
                                    <thead>
                                        <tr class="bg-gray-200">
                                            <th class="border p-2 text-left">Page URL</th>
                                            <th class="border p-2 text-left">Views</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($siteData['periods'][request('period', 'this_month')]['top_pages'] as $page)
                                            <tr>
                                                <td class="border p-2"><a href="{{ $page['page_url'] }}" class="text-blue-500 hover:underline" target="_blank">{{ $page['page_url'] }}</a></td>
                                                <td class="border p-2">{{ $page['views'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="chart-container bg-white p-4 rounded-lg shadow-sm">
                                <h3 class="text-lg font-medium mb-2 text-gray-700">Page Views Over Time</h3>
                                <canvas id="viewsChart-{{ $siteData['site_id'] }}"></canvas>
                            </div>
                            <div class="chart-container bg-white p-4 rounded-lg shadow-sm">
                                <h3 class="text-lg font-medium mb-2 text-gray-700">Clicks Over Time</h3>
                                <canvas id="clicksChart-{{ $siteData['site_id'] }}"></canvas>
                            </div>
                            <div class="chart-container bg-white p-4 rounded-lg shadow-sm">
                                <h3 class="text-lg font-medium mb-2 text-gray-700">Custom Events Over Time</h3>
                                <canvas id="customEventsChart-{{ $siteData['site_id'] }}"></canvas>
                            </div>
                            <div class="chart-container bg-white p-4 rounded-lg shadow-sm">
                                <h3 class="text-lg font-medium mb-2 text-gray-700">Visitor Statistics</h3>
                                <canvas id="visitorsChart-{{ $siteData['site_id'] }}"></canvas>
                            </div>
                            <div class="chart-container bg-white p-4 rounded-lg shadow-sm">
                                <h3 class="text-lg font-medium mb-2 text-gray-700">Visitors by Country</h3>
                                <canvas id="countryChart-{{ $siteData['site_id'] }}"></canvas>
                            </div>
                            <div class="chart-container bg-white p-4 rounded-lg shadow-sm">
                                <h3 class="text-lg font-medium mb-2 text-gray-700">Average Session Duration</h3>
                                <canvas id="sessionDurationChart-{{ $siteData['site_id'] }}"></canvas>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>

    <script>
        // Show loading indicator
        document.getElementById('loading').classList.remove('hidden');

        // Error handling
        function showError(message) {
            const errorDiv = document.getElementById('error-message');
            errorDiv.textContent = message;
            errorDiv.classList.remove('hidden');
            document.getElementById('loading').classList.add('hidden');
        }

        // Copy share link
        function copyShareLink() {
            const shareLink = document.getElementById('share-link');
            shareLink.select();
            document.execCommand('copy');
            alert('Share link copied to clipboard!');
        }

        try {
            const analyticsData = @json($analytics);
            const periods = @json($periods);
            const selectedSite = "{{ request('site_id', 'all') }}";
            const selectedPeriod = "{{ request('period', 'this_month') }}";

            // Color palette for charts
            const colors = {
                blue: { bg: 'rgba(59, 130, 246, 0.6)', border: 'rgba(59, 130, 246, 1)' },
                red: { bg: 'rgba(239, 68, 68, 0.6)', border: 'rgba(239, 68, 68, 1)' },
                green: { bg: 'rgba(16, 185, 129, 0.6)', border: 'rgba(16, 185, 129, 1)' },
                yellow: { bg: 'rgba(245, 158, 11, 0.6)', border: 'rgba(245, 158, 11, 1)' },
                purple: { bg: 'rgba(139, 92, 246, 0.6)', border: 'rgba(139, 92, 246, 1)' },
            };

            // Initialize charts for combined view
            if (selectedSite === 'all') {
                const combinedData = analyticsData.combined.periods[selectedPeriod];

                // Combined Views Chart
                const combinedViewsCtx = document.getElementById('combinedViewsChart')?.getContext('2d');
                if (combinedViewsCtx) {
                    new Chart(combinedViewsCtx, {
                        type: 'line',
                        data: {
                            labels: combinedData.views.map(item => item.period),
                            datasets: [{
                                label: 'Page Views',
                                data: combinedData.views.map(item => item.count),
                                borderColor: colors.blue.border,
                                backgroundColor: colors.blue.bg,
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: { beginAtZero: true, title: { display: true, text: 'Views' } },
                                x: { title: { display: true, text: 'Date' } }
                            },
                            plugins: {
                                legend: { display: true },
                                title: { display: true, text: 'Page Views Over Time', font: { size: 16 } }
                            }
                        }
                    });
                }

                // Combined Clicks Chart
                const combinedClicksCtx = document.getElementById('combinedClicksChart')?.getContext('2d');
                if (combinedClicksCtx) {
                    new Chart(combinedClicksCtx, {
                        type: 'line',
                        data: {
                            labels: combinedData.clicks.map(item => item.period),
                            datasets: [{
                                label: 'Clicks',
                                data: combinedData.clicks.map(item => item.count),
                                borderColor: colors.red.border,
                                backgroundColor: colors.red.bg,
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: { beginAtZero: true, title: { display: true, text: 'Clicks' } },
                                x: { title: { display: true, text: 'Date' } }
                            },
                            plugins: {
                                legend: { display: true },
                                title: { display: true, text: 'Clicks Over Time', font: { size: 16 } }
                            }
                        }
                    });
                }

                // Combined Visitors Chart
                const combinedVisitorsCtx = document.getElementById('combinedVisitorsChart')?.getContext('2d');
                if (combinedVisitorsCtx) {
                    new Chart(combinedVisitorsCtx, {
                        type: 'bar',
                        data: {
                            labels: ['Unique Visitors', 'New Visitors', 'Returning Visitors', 'Online Visitors'],
                            datasets: [{
                                label: 'Visitors',
                                data: [
                                    combinedData.unique_visitors,
                                    combinedData.new_visitors || 0,
                                    combinedData.returning_visitors || 0,
                                    combinedData.online_visitors || 0
                                ],
                                backgroundColor: [colors.blue.bg, colors.green.bg, colors.yellow.bg, colors.purple.bg],
                                borderColor: [colors.blue.border, colors.green.border, colors.yellow.border, colors.purple.border],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: { beginAtZero: true, title: { display: true, text: 'Count' } },
                                x: { title: { display: true, text: 'Visitor Type' } }
                            },
                            plugins: {
                                legend: { display: true },
                                title: { display: true, text: 'Visitor Statistics', font: { size: 16 } }
                            }
                        }
                    });
                }

                // Combined Country Chart
                const combinedCountryCtx = document.getElementById('combinedCountryChart')?.getContext('2d');
                if (combinedCountryCtx) {
                    new Chart(combinedCountryCtx, {
                        type: 'pie',
                        data: {
                            labels: combinedData.by_country?.map(item => item.country || 'Unknown') || [],
                            datasets: [{
                                label: 'Visitors by Country',
                                data: combinedData.by_country?.map(item => item.count) || [],
                                backgroundColor: [colors.blue.bg, colors.red.bg, colors.green.bg, colors.yellow.bg, colors.purple.bg],
                                borderColor: [colors.blue.border, colors.red.border, colors.green.border, colors.yellow.border, colors.purple.border],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { position: 'right' },
                                title: { display: true, text: 'Visitors by Country', font: { size: 16 } }
                            }
                        }
                    });
                }
            } else {
                const siteData = Object.values(analyticsData).find(site => site.site_id == selectedSite);
                const periodData = siteData.periods[selectedPeriod];

                // Views Chart
                const viewsCtx = document.getElementById(`viewsChart-${siteData.site_id}`)?.getContext('2d');
                if (viewsCtx) {
                    new Chart(viewsCtx, {
                        type: 'line',
                        data: {
                            labels: periodData.views.map(item => item.period),
                            datasets: [{
                                label: 'Page Views',
                                data: periodData.views.map(item => item.count),
                                borderColor: colors.blue.border,
                                backgroundColor: colors.blue.bg,
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: { beginAtZero: true, title: { display: true, text: 'Views' } },
                                x: { title: { display: true, text: 'Date' } }
                            },
                            plugins: {
                                legend: { display: true },
                                title: { display: true, text: 'Page Views Over Time', font: { size: 16 } }
                            }
                        }
                    });
                }

                // Clicks Chart
                const clicksCtx = document.getElementById(`clicksChart-${siteData.site_id}`)?.getContext('2d');
                if (clicksCtx) {
                    new Chart(clicksCtx, {
                        type: 'line',
                        data: {
                            labels: periodData.clicks.map(item => item.period),
                            datasets: [{
                                label: 'Clicks',
                                data: periodData.clicks.map(item => item.count),
                                borderColor: colors.red.border,
                                backgroundColor: colors.red.bg,
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: { beginAtZero: true, title: { display: true, text: 'Clicks' } },
                                x: { title: { display: true, text: 'Date' } }
                            },
                            plugins: {
                                legend: { display: true },
                                title: { display: true, text: 'Clicks Over Time', font: { size: 16 } }
                            }
                        }
                    });
                }

                // Custom Events Chart
                const customEventTypes = [...new Set(periodData.custom_events.map(item => item.event_type))];
                const customEventsCtx = document.getElementById(`customEventsChart-${siteData.site_id}`)?.getContext('2d');
                if (customEventsCtx) {
                    new Chart(customEventsCtx, {
                        type: 'line',
                        data: {
                            labels: [...new Set(periodData.custom_events.map(item => item.period))],
                            datasets: customEventTypes.map(type => ({
                                label: type,
                                data: periodData.custom_events.filter(item => item.event_type === type).map(item => item.count),
                                borderColor: `rgba(${Math.random() * 255}, ${Math.random() * 255}, ${Math.random() * 255}, 1)`,
                                backgroundColor: `rgba(${Math.random() * 255}, ${Math.random() * 255}, ${Math.random() * 255}, 0.2)`,
                                fill: true,
                                tension: 0.4
                            }))
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: { beginAtZero: true, title: { display: true, text: 'Events' } },
                                x: { title: { display: true, text: 'Date' } }
                            },
                            plugins: {
                                legend: { display: true },
                                title: { display: true, text: 'Custom Events Over Time', font: { size: 16 } }
                            }
                        }
                    });
                }

                // Visitors Chart
                const visitorsCtx = document.getElementById(`visitorsChart-${siteData.site_id}`)?.getContext('2d');
                if (visitorsCtx) {
                    new Chart(visitorsCtx, {
                        type: 'bar',
                        data: {
                            labels: ['Unique Visitors', 'New Visitors', 'Returning Visitors', 'Online Visitors'],
                            datasets: [{
                                label: 'Visitors',
                                data: [
                                    periodData.unique_visitors,
                                    periodData.new_visitors || 0,
                                    periodData.returning_visitors || 0,
                                    periodData.online_visitors || 0
                                ],
                                backgroundColor: [colors.blue.bg, colors.green.bg, colors.yellow.bg, colors.purple.bg],
                                borderColor: [colors.blue.border, colors.green.border, colors.yellow.border, colors.purple.border],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: { beginAtZero: true, title: { display: true, text: 'Count' } },
                                x: { title: { display: true, text: 'Visitor Type' } }
                            },
                            plugins: {
                                legend: { display: true },
                                title: { display: true, text: 'Visitor Statistics', font: { size: 16 } }
                            }
                        }
                    });
                }

                // Country Chart
                const countryCtx = document.getElementById(`countryChart-${siteData.site_id}`)?.getContext('2d');
                if (countryCtx) {
                    new Chart(countryCtx, {
                        type: 'pie',
                        data: {
                            labels: periodData.by_country?.map(item => item.country || 'Unknown') || [],
                            datasets: [{
                                label: 'Visitors by Country',
                                data: periodData.by_country?.map(item => item.count) || [],
                                backgroundColor: [colors.blue.bg, colors.red.bg, colors.green.bg, colors.yellow.bg, colors.purple.bg],
                                borderColor: [colors.blue.border, colors.red.border, colors.green.border, colors.yellow.border, colors.purple.border],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { position: 'right' },
                                title: { display: true, text: 'Visitors by Country', font: { size: 16 } }
                            }
                        }
                    });
                }

                // Session Duration Chart
                const sessionDurationCtx = document.getElementById(`sessionDurationChart-${siteData.site_id}`)?.getContext('2d');
                if (sessionDurationCtx) {
                    new Chart(sessionDurationCtx, {
                        type: 'bar',
                        data: {
                            labels: ['Avg Session Duration'],
                            datasets: [{
                                label: 'Session Duration (seconds)',
                                data: [periodData.avg_session_duration || 0],
                                backgroundColor: colors.green.bg,
                                borderColor: colors.green.border,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: { beginAtZero: true, title: { display: true, text: 'Seconds' } },
                                x: { title: { display: true, text: 'Metric' } }
                            },
                            plugins: {
                                legend: { display: true },
                                title: { display: true, text: 'Average Session Duration', font: { size: 16 } }
                            }
                        }
                    });
                }
            }

            // Hide loading indicator
            document.getElementById('loading').classList.add('hidden');
        } catch (e) {
            console.error('Error initializing dashboard:', e);
            showError('Failed to load dashboard: ' + e.message);
        }
    </script>
</body>
</html>