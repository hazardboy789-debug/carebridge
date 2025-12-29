<div>
    <div class="p-6">
    <h1 class="text-2xl font-semibold mb-4">Admin Dashboard</h1>

    <!-- Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="p-4 bg-white rounded-lg shadow-sm">
            <div class="text-sm text-gray-500">Doctors</div>
            <div class="text-2xl font-bold">{{ $totalDoctors }}</div>
        </div>

        <div class="p-4 bg-white rounded-lg shadow-sm">
            <div class="text-sm text-gray-500">Patients</div>
            <div class="text-2xl font-bold">{{ $totalPatients }}</div>
        </div>

        <div class="p-4 bg-white rounded-lg shadow-sm">
            <div class="text-sm text-gray-500">Appointments</div>
            <div class="text-2xl font-bold">{{ $totalAppointments }}</div>
            <div class="text-xs text-gray-400">Today: {{ $appointmentsToday }}</div>
        </div>

        <div class="p-4 bg-white rounded-lg shadow-sm">
            <div class="text-sm text-gray-500">Revenue (This Month)</div>
            <div class="text-2xl font-bold">${{ number_format($revenueMonth, 2) }}</div>
            <div class="text-xs text-gray-400">Last 7 days: ${{ number_format($revenueWeek, 2) }}</div>
        </div>
    </div>

    <!-- Chart + Recent lists -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="col-span-2 bg-white p-4 rounded-lg shadow-sm">
            <h3 class="font-semibold mb-2">Revenue (last 7 days)</h3>
            <canvas id="revenueChart" height="120"></canvas>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm">
            <h3 class="font-semibold mb-3">Pending Orders</h3>
            <div class="text-3xl font-bold mb-4">{{ $pendingOrders }}</div>

            <h4 class="font-semibold mt-4">Recent Transactions</h4>
            <ul class="divide-y mt-2">
                @foreach($recentTransactions as $t)
                    <li class="py-2">
                        <div class="text-sm">
                            <strong>{{ $t->user->name ?? 'User #' . $t->user_id }}</strong>
                            <span class="text-gray-500 text-xs"> — {{ $t->type }} • {{ $t->status }}</span>
                        </div>
                        <div class="text-xs text-gray-600">${{ number_format($t->amount, 2) }} • {{ $t->created_at->diffForHumans() }}</div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Recent Appointments table -->
    <div class="mt-6 bg-white p-4 rounded-lg shadow-sm">
        <h3 class="font-semibold mb-3">Recent Appointments</h3>

        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="text-left text-xs text-gray-500">
                        <th class="px-3 py-2">When</th>
                        <th class="px-3 py-2">Doctor</th>
                        <th class="px-3 py-2">Patient</th>
                        <th class="px-3 py-2">Status</th>
                        <th class="px-3 py-2">Fee</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentAppointments as $a)
                        <tr class="border-t">
                          <td class="px-3 py-2 text-sm">{{ $a->appointment_date->format('M d, Y H:i') }}</td>
                            <td class="px-3 py-2 text-sm">{{ optional($a->doctor)->name ?? 'Doctor #' . $a->doctor_id }}</td>
                            <td class="px-3 py-2 text-sm">{{ optional($a->patient)->name ?? 'Patient #' . $a->patient_id }}</td>
                            <td class="px-3 py-2 text-sm">{{ ucfirst($a->status) }}</td>
                            <td class="px-3 py-2 text-sm">${{ number_format($a->fee, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<!-- Chart.js CDN - remove if you already include it globally -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('livewire:load', function () {
        const data = @json($revenueSeries);

        const labels = data.map(d => d.label);
        const amounts = data.map(d => d.amount);

        const ctx = document.getElementById('revenueChart').getContext('2d');

        // destroy previous chart instance to avoid duplicates when Livewire updates
        if (window._adminRevenueChart) {
            window._adminRevenueChart.destroy();
        }

        window._adminRevenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Revenue',
                    data: amounts,
                    fill: true,
                    tension: 0.3,
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    });

    // Listen for server-side events to refresh JS (optional)
    Livewire.on('refreshChart', () => {
        // re-run the livewire refresh triggers
    });
</script>
@endpush
    </div>
