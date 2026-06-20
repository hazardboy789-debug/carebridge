<div class="p-6 bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                Patient Vitals Tracker
            </h1>
            <p class="text-gray-500 mt-1">Monitor and record patient health metrics</p>
        </div>

        {{-- Flash Messages --}}
        @if(session()->has('success'))
            <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 px-4 py-3 rounded-r shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
            </div>
        @endif

        @error('vitals_empty')
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-r shadow-sm">{{ $message }}</div>
        @enderror

        {{-- Overall Health Status --}}
        @if($latest)
            <div class="mb-6 bg-white rounded-xl shadow-md p-5 flex items-center justify-between border-l-8 
                {{ $latest->overall_status['color'] === 'red' ? 'border-red-500' : ($latest->overall_status['color'] === 'orange' ? 'border-amber-500' : ($latest->overall_status['color'] === 'blue' ? 'border-blue-500' : 'border-green-500')) }}">
                <div>
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">Overall Health Status</div>
                    <div class="text-2xl font-bold {{ $latest->overall_status['color'] === 'red' ? 'text-red-600' : ($latest->overall_status['color'] === 'orange' ? 'text-amber-600' : ($latest->overall_status['color'] === 'blue' ? 'text-blue-600' : 'text-green-600')) }}">
                        {{ $latest->overall_status['status'] }}
                    </div>
                    <div class="text-xs text-gray-400 mt-1">Based on latest vitals recorded at {{ $latest->created_at->format('d M Y, h:i A') }}</div>
                </div>
                <div class="text-6xl opacity-20">
                    @if($latest->overall_status['color'] === 'red')
                        ⚠️
                    @elseif($latest->overall_status['color'] === 'orange')
                        ⚡
                    @elseif($latest->overall_status['color'] === 'blue')
                        ℹ️
                    @else
                        ✅
                    @endif
                </div>
            </div>
        @else
            <div class="mb-6 bg-white rounded-xl shadow-md p-5 border-l-8 border-gray-300 text-gray-500">
                <div class="text-sm font-medium uppercase tracking-wide">Overall Health Status</div>
                <div class="text-xl">No vitals recorded yet</div>
            </div>
        @endif

        {{-- Latest Vitals Cards with Status Badges --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            {{-- Blood Pressure --}}
            <div class="bg-white rounded-xl shadow-md p-5 border-l-4 
                @if($latest && $latest->blood_pressure_status['color'] === 'red') border-red-500
                @elseif($latest && $latest->blood_pressure_status['color'] === 'orange') border-amber-500
                @elseif($latest && $latest->blood_pressure_status['color'] === 'blue') border-blue-500
                @else border-green-500 @endif
                hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">Blood Pressure</div>
                    <span class="text-xs px-2 py-1 rounded-full {{ $latest ? $latest->blood_pressure_status['bg'] : 'bg-gray-100 text-gray-600' }}">
                        {{ $latest ? $latest->blood_pressure_status['status'] : '--' }}
                    </span>
                </div>
                <div class="text-2xl font-bold text-gray-800">
                    {{ $latest?->blood_pressure_systolic }}/{{ $latest?->blood_pressure_diastolic }}
                </div>
                <div class="text-xs text-gray-400 mt-1">mmHg</div>
            </div>

            {{-- Heart Rate --}}
            <div class="bg-white rounded-xl shadow-md p-5 border-l-4 
                @if($latest && $latest->heart_rate_status['color'] === 'red') border-red-500
                @elseif($latest && $latest->heart_rate_status['color'] === 'blue') border-blue-500
                @else border-green-500 @endif
                hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">Heart Rate</div>
                    <span class="text-xs px-2 py-1 rounded-full {{ $latest ? $latest->heart_rate_status['bg'] : 'bg-gray-100 text-gray-600' }}">
                        {{ $latest ? $latest->heart_rate_status['status'] : '--' }}
                    </span>
                </div>
                <div class="text-2xl font-bold text-gray-800">{{ $latest?->heart_rate ?? '--' }}</div>
                <div class="text-xs text-gray-400 mt-1">BPM</div>
            </div>

            {{-- Blood Sugar --}}
            <div class="bg-white rounded-xl shadow-md p-5 border-l-4 
                @if($latest && $latest->blood_sugar_status['color'] === 'red') border-red-500
                @elseif($latest && $latest->blood_sugar_status['color'] === 'orange') border-amber-500
                @elseif($latest && $latest->blood_sugar_status['color'] === 'blue') border-blue-500
                @else border-green-500 @endif
                hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">Blood Sugar</div>
                    <span class="text-xs px-2 py-1 rounded-full {{ $latest ? $latest->blood_sugar_status['bg'] : 'bg-gray-100 text-gray-600' }}">
                        {{ $latest ? $latest->blood_sugar_status['status'] : '--' }}
                    </span>
                </div>
                <div class="text-2xl font-bold text-gray-800">{{ $latest?->blood_sugar ?? '--' }}</div>
                <div class="text-xs text-gray-400 mt-1">mg/dL</div>
            </div>

            {{-- Temperature --}}
            <div class="bg-white rounded-xl shadow-md p-5 border-l-4 
                @if($latest && $latest->temperature_status['color'] === 'red') border-red-500
                @elseif($latest && $latest->temperature_status['color'] === 'blue') border-blue-500
                @else border-green-500 @endif
                hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">Temperature</div>
                    <span class="text-xs px-2 py-1 rounded-full {{ $latest ? $latest->temperature_status['bg'] : 'bg-gray-100 text-gray-600' }}">
                        {{ $latest ? $latest->temperature_status['status'] : '--' }}
                    </span>
                </div>
                <div class="text-2xl font-bold text-gray-800">{{ $latest?->temperature ?? '--' }}</div>
                <div class="text-xs text-gray-400 mt-1">°C / °F</div>
            </div>
        </div>

        {{-- Add Vitals Form --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                <h2 class="text-white font-semibold text-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Record New Vitals
                </h2>
                <p class="text-blue-100 text-sm mt-1">Enter patient's latest health measurements</p>
            </div>
            <div class="p-6">
                <form wire:submit.prevent="save">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div class="col-span-1 md:col-span-2">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Systolic (mmHg)</label>
                                    <input wire:model="blood_pressure_systolic" type="number" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm" placeholder="e.g., 120">
                                    @error('blood_pressure_systolic') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Diastolic (mmHg)</label>
                                    <input wire:model="blood_pressure_diastolic" type="number" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm" placeholder="e.g., 80">
                                    @error('blood_pressure_diastolic') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Heart Rate (BPM)</label>
                                    <input wire:model="heart_rate" type="number" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm" placeholder="e.g., 72">
                                    @error('heart_rate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Blood Sugar (mg/dL)</label>
                                    <input wire:model="blood_sugar" type="number" step="0.1" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm" placeholder="e.g., 95">
                                    @error('blood_sugar') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Temperature</label>
                                    <input wire:model="temperature" type="number" step="0.1" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm" placeholder="e.g., 98.6">
                                    @error('temperature') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Weight (kg)</label>
                                    <input wire:model="weight" type="number" step="0.1" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm" placeholder="e.g., 70.5">
                                    @error('weight') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Additional Notes</label>
                                <textarea wire:model="notes" rows="2" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm" placeholder="Any observations or comments..."></textarea>
                                @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-span-1 flex items-end">
                            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                Save Record
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- History Table with Status Column --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gray-50 border-b border-gray-200 px-6 py-4">
                <h3 class="font-semibold text-gray-700 text-lg flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Vitals History
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">BP (mmHg)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">HR (BPM)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sugar (mg/dL)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Temp</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Weight (kg)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($vitals as $vital)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $vital->created_at->format('d M Y, h:i A') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">{{ $vital->blood_pressure_systolic }}/{{ $vital->blood_pressure_diastolic }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $vital->heart_rate }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $vital->blood_sugar }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $vital->temperature }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $vital->weight ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ $vital->overall_status['bg'] }}">
                                        {{ $vital->overall_status['status'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="delete({{ $vital->id }})" onclick="return confirm('Are you sure you want to delete this record?')" class="text-red-600 hover:text-red-900 transition-colors inline-flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    No vitals records found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="bg-gray-50 border-t border-gray-200 px-6 py-4">
                {{ $vitals->links() }}
            </div>
        </div>
    </div>
</div>