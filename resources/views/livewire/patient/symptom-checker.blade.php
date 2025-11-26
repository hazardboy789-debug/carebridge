<div> <!-- ADD THIS ROOT DIV -->
    <div class="flex-1 p-8">
        <div class="flex flex-col gap-8">
            <!-- Page Heading -->
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex flex-col gap-1">
                    <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold tracking-tight">
                        Symptom Checker
                    </p>
                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-base font-normal">
                        Describe your symptoms to get personalized health insights.
                    </p>
                </div>
                <button class="flex min-w-[84px] items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-primary text-white text-sm font-bold gap-2">
                    <span class="material-symbols-outlined">history</span>
                    <span class="truncate">Check History</span>
                </button>
            </div>

            <!-- Symptom Checker Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column -->
                <div class="lg:col-span-2 flex flex-col gap-8">
                    <!-- Symptom Input -->
                    <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                        <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-6">
                            Describe Your Symptoms
                        </h2>
                        
                        <form wire:submit.prevent="analyzeSymptoms" class="flex flex-col gap-6">
                            <!-- Flash Messages -->
                            @if (session()->has('success'))
                                <div class="p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                                    <p class="text-green-700 dark:text-green-300 text-sm">{{ session('success') }}</p>
                                </div>
                            @endif

                            @if (session()->has('error'))
                                <div class="p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                    <p class="text-red-700 dark:text-red-300 text-sm">{{ session('error') }}</p>
                                </div>
                            @endif

                            <!-- Loading State -->
                            @if($isAnalyzing)
                            <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-blue-600"></div>
                                    <p class="text-blue-700 dark:text-blue-300 text-sm">AI is analyzing your symptoms...</p>
                                </div>
                            </div>
                            @endif

                            <!-- Primary Symptom -->
                            <div>
                                <label class="block text-text-light-primary dark:text-text-dark-primary font-medium mb-2">
                                    Primary Symptom *
                                </label>
                                <input type="text" 
                                       wire:model="primarySymptom"
                                       placeholder="e.g., Headache, Fever, Cough..." 
                                       class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg px-4 py-3 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary">
                                @error('primarySymptom') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Symptom Description -->
                            <div>
                                <label class="block text-text-light-primary dark:text-text-dark-primary font-medium mb-2">
                                    Detailed Description *
                                </label>
                                <textarea rows="6" 
                                          wire:model="description"
                                          placeholder="Please describe your symptoms in detail, including when they started, severity, and any patterns you've noticed..."
                                          class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg px-4 py-3 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary resize-none"></textarea>
                                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Additional Symptoms -->
                            <div>
                                <label class="block text-text-light-primary dark:text-text-dark-primary font-medium mb-3">
                                    Additional Symptoms
                                </label>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    @foreach($availableSymptoms as $symptom)
                                    <label class="flex items-center gap-2 p-3 rounded-lg bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark cursor-pointer hover:bg-primary/5">
                                        <input type="checkbox" 
                                               wire:model="additionalSymptoms"
                                               value="{{ $symptom }}"
                                               class="rounded text-primary focus:ring-primary">
                                        <span class="text-text-light-primary dark:text-text-dark-primary text-sm">{{ $symptom }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Severity -->
                            <div>
                                <label class="block text-text-light-primary dark:text-text-dark-primary font-medium mb-3">
                                    Severity Level *
                                </label>
                                <div class="grid grid-cols-5 gap-2">
                                    @foreach($severityLevels as $key => $level)
                                    <label class="flex flex-col items-center gap-1 p-2 rounded-lg bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark cursor-pointer hover:bg-primary/5">
                                        <input type="radio" 
                                               wire:model="severity"
                                               value="{{ $key }}"
                                               class="text-primary focus:ring-primary">
                                        <span class="text-text-light-primary dark:text-text-dark-primary text-xs text-center">{{ $level }}</span>
                                    </label>
                                    @endforeach
                                </div>
                                @error('severity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                    wire:loading.attr="disabled"
                                    class="flex w-full items-center justify-center gap-2 rounded-lg h-12 px-4 bg-primary text-white text-sm font-bold disabled:opacity-50">
                                <span wire:loading.remove class="material-symbols-outlined">playlist_add_check</span>
                                <span wire:loading class="animate-spin material-symbols-outlined">refresh</span>
                                <span wire:loading.remove>Analyze Symptoms</span>
                                <span wire:loading>Analyzing...</span>
                            </button>
                        </form>
                    </div>

                    <!-- Results Section -->
                    @if($showResults)
                    <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                        <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-6">
                            Analysis Results
                        </h2>
                        
                        <div class="flex flex-col gap-6">
                            <!-- AI Analysis Section -->
                            @if($aiAnalysis)
                            <div class="p-4 rounded-lg bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800">
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="material-symbols-outlined text-purple-600 dark:text-purple-400">smart_toy</span>
                                    <div>
                                        <p class="text-purple-800 dark:text-purple-300 font-semibold">AI-Powered Analysis</p>
                                        <p class="text-purple-700 dark:text-purple-400 text-sm">Enhanced diagnosis using artificial intelligence</p>
                                    </div>
                                </div>
                                
                                @if(isset($aiAnalysis['urgency']))
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-sm font-medium text-purple-700 dark:text-purple-300">Urgency Level:</span>
                                    <span class="px-2 py-1 rounded-full text-xs font-medium 
                                        @if($aiAnalysis['urgency'] === 'emergency') bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300
                                        @elseif($aiAnalysis['urgency'] === 'high') bg-orange-100 text-orange-800 dark:bg-orange-900/20 dark:text-orange-300
                                        @elseif($aiAnalysis['urgency'] === 'medium') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300
                                        @else bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300
                                        @endif">
                                        {{ strtoupper($aiAnalysis['urgency']) }}
                                    </span>
                                </div>
                                @endif

                                @if(isset($aiAnalysis['possible_conditions']) && count($aiAnalysis['possible_conditions']) > 0)
                                <div class="mb-3">
                                    <p class="text-sm font-medium text-purple-700 dark:text-purple-300 mb-1">Possible Conditions:</p>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($aiAnalysis['possible_conditions'] as $condition)
                                        <span class="px-2 py-1 bg-white dark:bg-gray-800 rounded text-xs text-purple-600 dark:text-purple-400 border border-purple-200 dark:border-purple-700">
                                            {{ $condition }}
                                        </span>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                @if(isset($aiAnalysis['warning_signs']) && count($aiAnalysis['warning_signs']) > 0)
                                <div class="mb-3">
                                    <p class="text-sm font-medium text-red-600 dark:text-red-400 mb-1">⚠️ Warning Signs to Watch For:</p>
                                    <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-300 space-y-1">
                                        @foreach($aiAnalysis['warning_signs'] as $warning)
                                        <li>{{ $warning }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                @if(isset($aiAnalysis['immediate_actions']) && count($aiAnalysis['immediate_actions']) > 0)
                                <div>
                                    <p class="text-sm font-medium text-green-600 dark:text-green-400 mb-1">📋 Immediate Actions:</p>
                                    <ul class="list-disc list-inside text-sm text-green-700 dark:text-green-300 space-y-1">
                                        @foreach($aiAnalysis['immediate_actions'] as $action)
                                        <li>{{ $action }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>
                            @endif

                            <!-- Recommended Specialty -->
                            <div class="p-4 rounded-lg bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">medical_services</span>
                                    <div>
                                        <p class="text-blue-800 dark:text-blue-300 font-semibold">Recommended Specialty</p>
                                        <p class="text-blue-700 dark:text-blue-400 text-sm">{{ $specialtyNames[$recommendedSpecialty] ?? 'General Physician' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Recommendation -->
                            <div class="p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
                                <div class="flex items-start gap-3">
                                    <span class="material-symbols-outlined text-green-600 dark:text-green-400">recommend</span>
                                    <div>
                                        <p class="text-green-800 dark:text-green-300 font-semibold mb-2">Recommendation</p>
                                        <p class="text-green-700 dark:text-green-400 text-sm">{{ $recommendation }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Suggested Doctors -->
                            @if(count($suggestedDoctors) > 0)
                        @if(count($suggestedDoctors) > 0)
<div>
    <h3 class="text-text-light-primary dark:text-text-dark-primary font-semibold mb-4">
        Suggested Doctors ({{ count($suggestedDoctors) }} found)
    </h3>
    <div class="grid gap-3">
        @foreach($suggestedDoctors as $doctor)
        <div class="flex items-center justify-between p-4 rounded-lg bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-lg">person</span>
                </div>
                <div class="flex-1">
                    <p class="text-text-light-primary dark:text-text-dark-primary font-semibold">{{ $doctor['name'] }}</p>
                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                        {{ $doctor['specialty'] }} • {{ $doctor['experience'] }}
                    </p>
                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                        {{ $doctor['license'] }}
                    </p>
                    @if($doctor['description'])
                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs mt-1">
                        {{ Str::limit($doctor['description'], 60) }}
                    </p>
                    @endif
                </div>
            </div>
            <button wire:click="bookAppointment({{ $doctor['id'] }})"
                    class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary/90 whitespace-nowrap">
                <span class="material-symbols-outlined text-sm">calendar_today</span>
                Book Appointment
            </button>
        </div>
        @endforeach
    </div>
</div>
@else
<div class="p-4 rounded-lg bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800">
    <div class="flex items-center gap-3">
        <span class="material-symbols-outlined text-yellow-600 dark:text-yellow-400">info</span>
        <div>
            <p class="text-yellow-800 dark:text-yellow-300 font-semibold">No Doctors Available</p>
            <p class="text-yellow-700 dark:text-yellow-400 text-sm">
                We couldn't find any available {{ $specialtyNames[$recommendedSpecialty] ?? 'General Physician' }} in our system.
                Please try again later or contact our support for assistance.
            </p>
        </div>
    </div>
</div>
@endif
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex gap-3">
                                <button wire:click="resetForm"
                                        class="flex-1 flex items-center justify-center gap-2 rounded-lg h-12 px-4 bg-gray-500 text-white text-sm font-bold hover:bg-gray-600">
                                    <span class="material-symbols-outlined">replay</span>
                                    Check Another Symptom
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Right Column -->
                <div class="lg:col-span-1 flex flex-col gap-8">
                    <!-- Quick Tips -->
                    <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                        <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-4">
                            Quick Tips
                        </h2>
                        <div class="flex flex-col gap-3">
                            <div class="flex items-start gap-3 p-3 rounded-lg bg-background-light dark:bg-background-dark">
                                <span class="material-symbols-outlined text-primary text-lg">info</span>
                                <p class="text-text-light-primary dark:text-text-dark-primary text-sm">
                                    Be specific about when symptoms started and their frequency.
                                </p>
                            </div>
                            <div class="flex items-start gap-3 p-3 rounded-lg bg-background-light dark:bg-background-dark">
                                <span class="material-symbols-outlined text-primary text-lg">warning</span>
                                <p class="text-text-light-primary dark:text-text-dark-primary text-sm">
                                    For emergencies, call emergency services immediately.
                                </p>
                            </div>
                            <div class="flex items-start gap-3 p-3 rounded-lg bg-background-light dark:bg-background-dark">
                                <span class="material-symbols-outlined text-primary text-lg">medical_information</span>
                                <p class="text-text-light-primary dark:text-text-dark-primary text-sm">
                                    Include any medications you're currently taking.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Checks -->
                    <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                        <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-4">
                            Recent Checks
                        </h2>
                        <div class="flex flex-col gap-3">
                            @forelse($checkHistory as $check)
                            <div class="p-3 rounded-lg bg-background-light dark:bg-background-dark">
                                <div class="flex items-center justify-between mb-1">
                                    <p class="text-text-light-primary dark:text-text-dark-primary font-semibold text-sm">
                                        {{ $check['primary_symptom'] }}
                                    </p>
                                    <span class="bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-300 text-xs px-2 py-1 rounded-full capitalize">
                                        {{ str_replace('_', ' ', $check['severity']) }}
                                    </span>
                                </div>
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                                    Checked: {{ \Carbon\Carbon::parse($check['created_at'])->format('M d, Y') }}
                                </p>
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                                    Recommended: {{ $specialtyNames[$check['recommended_specialty']] ?? 'General Physician' }}
                                </p>
                            </div>
                            @empty
                            <div class="p-3 rounded-lg bg-background-light dark:bg-background-dark text-center">
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                    No recent symptom checks
                                </p>
                            </div>
                            @endforelse
                            
                            @if(count($checkHistory) > 0)
                            <button class="flex w-full items-center justify-center gap-2 rounded-lg h-9 px-4 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-sm font-medium hover:bg-gray-50 dark:hover:bg-slate-700">
                                View All History
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- CLOSE THE ROOT DIV -->