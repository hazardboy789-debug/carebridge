<div class="p-8">
    <div class="flex flex-col gap-8">
        <!-- Page Header -->
        <div class="flex flex-col gap-1">
            <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold tracking-tight">
                Reports & Analytics
            </p>
            <p class="text-text-light-secondary dark:text-text-dark-secondary text-base font-normal">
                Analyze platform performance and generate insights
            </p>
        </div>

        <!-- Filters Card -->
        <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
            <div class="flex flex-col lg:flex-row gap-4 items-end">
                <div class="flex-1">
                    <label class="text-text-light-primary dark:text-text-dark-primary text-sm font-semibold mb-2 block">
                        Report Type
                    </label>
                    <select wire:model.live="reportType" 
                            class="w-full border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark rounded-lg px-4 py-3 text-text-light-primary dark:text-text-dark-primary focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                        <option value="consultations">Consultation Analytics</option>
                        <option value="users">User Activity</option>
                        <option value="donations">Donation Reports</option>
                        <option value="revenue">Revenue Analysis</option>
                        <option value="engagement">User Engagement</option>
                    </select>
                </div>

                <div class="flex-1">
                    <label class="text-text-light-primary dark:text-text-dark-primary text-sm font-semibold mb-2 block">
                        Start Date
                    </label>
                    <input type="date" 
                           wire:model.live="startDate" 
                           class="w-full border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark rounded-lg px-4 py-3 text-text-light-primary dark:text-text-dark-primary focus:ring-2 focus:ring-primary focus:border-transparent" />
                </div>

                <div class="flex-1">
                    <label class="text-text-light-primary dark:text-text-dark-primary text-sm font-semibold mb-2 block">
                        End Date
                    </label>
                    <input type="date" 
                           wire:model.live="endDate" 
                           class="w-full border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark rounded-lg px-4 py-3 text-text-light-primary dark:text-text-dark-primary focus:ring-2 focus:ring-primary focus:border-transparent" />
                </div>

                <div class="flex gap-3">
                    <button wire:click="generateReport" 
                            class="flex items-center justify-center rounded-lg h-12 px-6 bg-primary hover:bg-primary/90 text-white text-sm font-bold gap-2 transition-all">
                        <span class="material-symbols-outlined text-lg">analytics</span>
                        Generate Report
                    </button>
                    
                    <button wire:click="exportCsv" 
                            class="flex items-center justify-center rounded-lg h-12 px-6 bg-green-500 hover:bg-green-600 text-white text-sm font-bold gap-2 transition-all">
                        <span class="material-symbols-outlined text-lg">download</span>
                        Export CSV
                    </button>
                    
                    <button wire:click="exportPdf" 
                            class="flex items-center justify-center rounded-lg h-12 px-6 bg-red-500 hover:bg-red-600 text-white text-sm font-bold gap-2 transition-all">
                        <span class="material-symbols-outlined text-lg">picture_as_pdf</span>
                        Export PDF
                    </button>
                </div>
            </div>
        </div>

        <!-- Summary Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Consultations -->
            <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-blue-100 dark:bg-blue-900">
                        <span class="material-symbols-outlined text-blue-500 dark:text-blue-300">video_call</span>
                    </div>
                    <div>
                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">Total Consultations</p>
                        <p class="text-text-light-primary dark:text-text-dark-primary text-2xl font-bold">{{ $stats['total'] ?? 0 }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm text-green-500">trending_up</span>
                    <span class="text-text-light-secondary dark:text-text-dark-secondary text-sm">+12% from last period</span>
                </div>
            </div>

            <!-- Active Users -->
            <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-green-100 dark:bg-green-900">
                        <span class="material-symbols-outlined text-green-500 dark:text-green-300">group</span>
                    </div>
                    <div>
                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">Active Users</p>
                        <p class="text-text-light-primary dark:text-text-dark-primary text-2xl font-bold">{{ $stats['active'] ?? 0 }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm text-green-500">trending_up</span>
                    <span class="text-text-light-secondary dark:text-text-dark-secondary text-sm">+8% from last week</span>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-purple-100 dark:bg-purple-900">
                        <span class="material-symbols-outlined text-purple-500 dark:text-purple-300">payments</span>
                    </div>
                    <div>
                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">Total Revenue</p>
                        <p class="text-text-light-primary dark:text-text-dark-primary text-2xl font-bold">LKR {{ number_format($stats['totalAmount'] ?? 0, 0) }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm text-green-500">trending_up</span>
                    <span class="text-text-light-secondary dark:text-text-dark-secondary text-sm">+15% from last month</span>
                </div>
            </div>

            <!-- Satisfaction Rate -->
            <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-orange-100 dark:bg-orange-900">
                        <span class="material-symbols-outlined text-orange-500 dark:text-orange-300">sentiment_satisfied</span>
                    </div>
                    <div>
                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">Satisfaction Rate</p>
                        <p class="text-text-light-primary dark:text-text-dark-primary text-2xl font-bold">{{ $stats['satisfaction'] ?? 96 }}%</p>
                    </div>
                </div>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm text-green-500">trending_up</span>
                    <span class="text-text-light-secondary dark:text-text-dark-secondary text-sm">+2% from last quarter</span>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Main Chart -->
            <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                            {{ $this->getChartTitle() }}
                        </h3>
                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                            {{ $this->getChartSubtitle() }}
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <button wire:click="setChartType('line')" 
                                class="px-3 py-2 rounded-lg text-sm font-medium {{ $chartType === 'line' ? 'bg-primary text-white' : 'bg-background-light dark:bg-background-dark text-text-light-secondary dark:text-text-dark-secondary' }}">
                            Line
                        </button>
                        <button wire:click="setChartType('bar')" 
                                class="px-3 py-2 rounded-lg text-sm font-medium {{ $chartType === 'bar' ? 'bg-primary text-white' : 'bg-background-light dark:bg-background-dark text-text-light-secondary dark:text-text-dark-secondary' }}">
                            Bar
                        </button>
                        <button wire:click="setChartType('area')" 
                                class="px-3 py-2 rounded-lg text-sm font-medium {{ $chartType === 'area' ? 'bg-primary text-white' : 'bg-background-light dark:bg-background-dark text-text-light-secondary dark:text-text-dark-secondary' }}">
                            Area
                        </button>
                    </div>
                </div>
                <div class="h-80">
                    <canvas id="reportsChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- Breakdown Chart -->
            <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                            {{ $this->getBreakdownTitle() }}
                        </h3>
                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                            Distribution breakdown
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <button wire:click="setBreakdownType('pie')" 
                                class="px-3 py-2 rounded-lg text-sm font-medium {{ $breakdownType === 'pie' ? 'bg-primary text-white' : 'bg-background-light dark:bg-background-dark text-text-light-secondary dark:text-text-dark-secondary' }}">
                            Pie
                        </button>
                        <button wire:click="setBreakdownType('doughnut')" 
                                class="px-3 py-2 rounded-lg text-sm font-medium {{ $breakdownType === 'doughnut' ? 'bg-primary text-white' : 'bg-background-light dark:bg-background-dark text-text-light-secondary dark:text-text-dark-secondary' }}">
                            Doughnut
                        </button>
                    </div>
                </div>
                <div class="h-80">
                    <canvas id="reportsChartBreakdown" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>

        <!-- Detailed Statistics -->
        <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                    Detailed Statistics
                </h3>
                <span class="text-xs px-3 py-1 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 font-semibold">
                    {{ $startDate ? date('M d, Y', strtotime($startDate)) : 'All time' }} 
                    - 
                    {{ $endDate ? date('M d, Y', strtotime($endDate)) : 'Present' }}
                </span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Status Breakdown -->
                <div class="space-y-4">
                    <h4 class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                        <span class="material-symbols-outlined align-middle mr-2 text-green-500">donut_large</span>
                        Status Distribution
                    </h4>
                    <div class="space-y-3">
                        @foreach($stats['byStatus'] ?? [] as $status => $count)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full {{ $this->getStatusColor($status) }}"></div>
                                <span class="text-text-light-secondary dark:text-text-dark-secondary capitalize">{{ $status }}</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="text-text-light-primary dark:text-text-dark-primary font-semibold">{{ $count }}</span>
                                <span class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                    {{ $stats['total'] > 0 ? number_format(($count / $stats['total']) * 100, 1) : 0 }}%
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Platform Metrics -->
                <div class="space-y-4">
                    <h4 class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                        <span class="material-symbols-outlined align-middle mr-2 text-blue-500">insights</span>
                        Platform Metrics
                    </h4>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-text-light-secondary dark:text-text-dark-secondary">Avg. Consultation Duration</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-semibold">{{ $stats['avgDuration'] ?? '15' }} min</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-text-light-secondary dark:text-text-dark-secondary">Peak Hours</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-semibold">{{ $stats['peakHours'] ?? '10:00 - 14:00' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-text-light-secondary dark:text-text-dark-secondary">Response Time (Avg)</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-semibold">{{ $stats['responseTime'] ?? '3.2' }} min</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-text-light-secondary dark:text-text-dark-secondary">Repeat Users</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-semibold">{{ $stats['repeatUsers'] ?? '42' }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                    Recent Activity
                </h3>
                <a href="#" class="text-primary text-sm font-bold hover:underline">View All</a>
            </div>
            
            <div class="space-y-4">
                @foreach($recentActivity as $activity)
                <div class="flex items-center gap-4 p-4 rounded-lg bg-background-light dark:bg-background-dark">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full {{ $activity['color'] }}">
                        <span class="material-symbols-outlined text-white">{{ $activity['icon'] }}</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-text-light-primary dark:text-text-dark-primary font-semibold">{{ $activity['title'] }}</p>
                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">{{ $activity['description'] }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">{{ $activity['time'] }}</p>
                        <span class="text-xs px-2 py-1 rounded-full {{ $activity['badgeColor'] }}">{{ $activity['badge'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let reportsChart = null;
    let breakdownChart = null;

    function renderChart(chartData, chartType = 'line') {
        const ctx = document.getElementById('reportsChart').getContext('2d');
        
        if (reportsChart) {
            reportsChart.destroy();
        }

        const colors = {
            line: {
                bg: 'rgba(59, 130, 246, 0.1)',
                border: 'rgba(59, 130, 246, 1)',
                point: 'rgba(59, 130, 246, 1)'
            },
            bar: {
                bg: 'rgba(34, 197, 94, 0.5)',
                border: 'rgba(34, 197, 94, 1)'
            },
            area: {
                bg: 'rgba(168, 85, 247, 0.2)',
                border: 'rgba(168, 85, 247, 1)',
                point: 'rgba(168, 85, 247, 1)'
            }
        };

        // Build datasets: prefer server-provided `datasets`, fallback to single `data` series
        const datasetsFromServer = (chartData.datasets && chartData.datasets.length)
            ? chartData.datasets.map((ds, idx) => ({
                label: ds.label || chartData.label || `Series ${idx + 1}`,
                data: ds.data || [],
                backgroundColor: ds.backgroundColor || colors[chartType]?.bg || colors.line.bg,
                borderColor: ds.borderColor || colors[chartType]?.border || colors.line.border,
                borderWidth: ds.borderWidth ?? 2,
                fill: typeof ds.fill !== 'undefined' ? ds.fill : (chartType === 'area'),
                tension: ds.tension ?? 0.4,
                pointBackgroundColor: ds.pointBackgroundColor || colors[chartType]?.point || colors.line.point,
                pointRadius: ds.pointRadius ?? 4,
                pointHoverRadius: ds.pointHoverRadius ?? 6
            }))
            : [{
                label: chartData.label || 'Data',
                data: chartData.data || [],
                backgroundColor: colors[chartType]?.bg || colors.line.bg,
                borderColor: colors[chartType]?.border || colors.line.border,
                borderWidth: 2,
                fill: chartType === 'area',
                tension: 0.4,
                pointBackgroundColor: colors[chartType]?.point || colors.line.point,
                pointRadius: 4,
                pointHoverRadius: 6
            }];

        const config = {
            type: chartType,
            data: {
                labels: chartData.labels || [],
                datasets: datasetsFromServer
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#e2e8f0' : '#475569'
                        }
                    },
                    tooltip: {
                        backgroundColor: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#1e293b' : '#ffffff',
                        titleColor: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#e2e8f0' : '#1e293b',
                        bodyColor: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#cbd5e1' : '#475569',
                        borderColor: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#475569' : '#e2e8f0',
                        borderWidth: 1
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#334155' : '#e2e8f0'
                        },
                        ticks: {
                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#cbd5e1' : '#64748b'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#334155' : '#e2e8f0'
                        },
                        ticks: {
                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#cbd5e1' : '#64748b'
                        }
                    }
                }
            }
        };

        reportsChart = new Chart(ctx, config);
    }

    function renderBreakdown(breakdownData, chartType = 'pie') {
        const ctx = document.getElementById('reportsChartBreakdown').getContext('2d');
        
        if (breakdownChart) {
            breakdownChart.destroy();
        }

        const colors = [
            'rgba(59, 130, 246, 0.8)',
            'rgba(34, 197, 94, 0.8)',
            'rgba(245, 158, 11, 0.8)',
            'rgba(239, 68, 68, 0.8)',
            'rgba(168, 85, 247, 0.8)',
            'rgba(236, 72, 153, 0.8)',
            'rgba(6, 182, 212, 0.8)'
        ];

        const config = {
            type: chartType,
            data: {
                labels: Object.keys(breakdownData),
                datasets: [{
                    data: Object.values(breakdownData),
                    backgroundColor: colors,
                    borderColor: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#1e293b' : '#ffffff',
                    borderWidth: 2,
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#e2e8f0' : '#475569',
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#1e293b' : '#ffffff',
                        titleColor: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#e2e8f0' : '#1e293b',
                        bodyColor: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#cbd5e1' : '#475569',
                        borderColor: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#475569' : '#e2e8f0',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        };

        breakdownChart = new Chart(ctx, config);
    }

    // Initialize charts (run now and also when Livewire initializes) so listeners are always registered
    function initCharts() {
        const initialChart = @json($chartData ?? []);
        const initialBreakdown = @json($breakdownData ?? []);
        const chartType = @json($chartType ?? 'line');
        const breakdownType = @json($breakdownType ?? 'pie');

        // Debug: log chart payload for investigation
        try { console.debug('initialChart', initialChart); } catch(e){}

        if (initialChart.labels && initialChart.labels.length > 0) {
            renderChart(initialChart, chartType);
        }

        if (Object.keys(initialBreakdown).length > 0) {
            renderBreakdown(initialBreakdown, breakdownType);
        }

        // Listen for Livewire updates (if Livewire is present)
        if (typeof Livewire !== 'undefined' && Livewire.on) {
            Livewire.on('chart-updated', (payload) => {
                try { console.debug('chart-updated payload', payload); } catch(e){}
                if (payload.chart) {
                    renderChart(payload.chart, payload.chartType || chartType);
                }
                if (payload.breakdown) {
                    renderBreakdown(payload.breakdown, payload.breakdownType || breakdownType);
                }
            });
        }

        // Update charts on theme change
        const darkModeMediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
        darkModeMediaQuery.addEventListener('change', () => {
            if (reportsChart) reportsChart.update();
            if (breakdownChart) breakdownChart.update();
        });
    }

    // Run immediately and also when Livewire initializes
    try { initCharts(); } catch (e) { /* ignore init errors */ }
    document.addEventListener('livewire:initialized', initCharts);

    // Handle window resize
    window.addEventListener('resize', () => {
        if (reportsChart) {
            reportsChart.resize();
        }
        if (breakdownChart) {
            breakdownChart.resize();
        }
    });
</script>
@endpush