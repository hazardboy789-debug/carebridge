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
                    
                    <div class="flex flex-col gap-6">
                        <!-- Primary Symptom -->
                        <div>
                            <label class="block text-text-light-primary dark:text-text-dark-primary font-medium mb-2">
                                Primary Symptom
                            </label>
                            <input type="text" 
                                   placeholder="e.g., Headache, Fever, Cough..." 
                                   class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg px-4 py-3 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary">
                        </div>

                        <!-- Symptom Description -->
                        <div>
                            <label class="block text-text-light-primary dark:text-text-dark-primary font-medium mb-2">
                                Detailed Description
                            </label>
                            <textarea rows="6" 
                                      placeholder="Please describe your symptoms in detail, including when they started, severity, and any patterns you've noticed..."
                                      class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg px-4 py-3 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary resize-none"></textarea>
                        </div>

                        <!-- Additional Symptoms -->
                        <div>
                            <label class="block text-text-light-primary dark:text-text-dark-primary font-medium mb-3">
                                Additional Symptoms
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                @php
                                    $symptoms = ['Fever', 'Headache', 'Cough', 'Fatigue', 'Nausea', 'Dizziness', 'Pain', 'Rash', 'Swelling'];
                                @endphp
                                @foreach($symptoms as $symptom)
                                <label class="flex items-center gap-2 p-3 rounded-lg bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark cursor-pointer hover:bg-primary/5">
                                    <input type="checkbox" class="rounded text-primary focus:ring-primary">
                                    <span class="text-text-light-primary dark:text-text-dark-primary text-sm">{{ $symptom }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Severity -->
                        <div>
                            <label class="block text-text-light-primary dark:text-text-dark-primary font-medium mb-3">
                                Severity Level
                            </label>
                            <div class="grid grid-cols-5 gap-2">
                                @php
                                    $severityLevels = [
                                        'Very Mild' => 'text-green-600',
                                        'Mild' => 'text-lime-600',
                                        'Moderate' => 'text-yellow-600',
                                        'Severe' => 'text-orange-600',
                                        'Very Severe' => 'text-red-600'
                                    ];
                                @endphp
                                @foreach($severityLevels as $level => $color)
                                <label class="flex flex-col items-center gap-1 p-2 rounded-lg bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark cursor-pointer hover:bg-primary/5">
                                    <input type="radio" name="severity" class="text-primary focus:ring-primary">
                                    <span class="text-text-light-primary dark:text-text-dark-primary text-xs text-center">{{ $level }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button class="flex w-full items-center justify-center gap-2 rounded-lg h-12 px-4 bg-primary text-white text-sm font-bold">
                            <span class="material-symbols-outlined">playlist_add_check</span>
                            Analyze Symptoms
                        </button>
                    </div>
                </div>
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
                        @for($i = 0; $i < 3; $i++)
                        <div class="p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <div class="flex items-center justify-between mb-1">
                                <p class="text-text-light-primary dark:text-text-dark-primary font-semibold text-sm">
                                    Headache & Fatigue
                                </p>
                                <span class="bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-300 text-xs px-2 py-1 rounded-full">
                                    Mild
                                </span>
                            </div>
                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                                Checked: Oct 25, 2024
                            </p>
                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                                Recommended: Rest & Hydration
                            </p>
                        </div>
                        @endfor
                        
                        <button class="flex w-full items-center justify-center gap-2 rounded-lg h-9 px-4 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-sm font-medium hover:bg-gray-50 dark:hover:bg-slate-700">
                            View All History
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>