<div class="flex-1 p-8">
    <div class="flex flex-col gap-8">
        <!-- Page Heading -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-col gap-1">
                <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold tracking-tight">
                    Patients
                </p>
                <p class="text-text-light-secondary dark:text-text-dark-secondary text-base font-normal">
                    Access patient consultation history and medical records.
                </p>
            </div>
            <button class="flex min-w-[84px] items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-primary text-white text-sm font-bold gap-2">
                <span class="material-symbols-outlined">note_add</span>
                <span class="truncate">Add Note</span>
            </button>
        </div>

        <!-- Patients Content -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-3 flex flex-col gap-8">
                <!-- Patients Table -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                            My Patients
                        </h2>
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <input type="text" wire:model.debounce.300ms="search" placeholder="Search patients..." class="bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg pl-10 pr-4 py-2 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary w-64">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 transform -translate-y-1/2 text-text-light-secondary dark:text-text-dark-secondary">search</span>
                            </div>
                            <button class="flex items-center justify-center rounded-lg h-10 px-4 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-sm font-medium hover:bg-gray-50 dark:hover:bg-slate-700">
                                <span class="material-symbols-outlined">filter_list</span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-border-light dark:border-border-dark">
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Patient</th>
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Last Visit</th>
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Next Appointment</th>
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Status</th>
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border-light dark:divide-border-dark">
                                @forelse($patients as $patient)
                                <tr class="hover:bg-background-light dark:hover:bg-background-dark">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10" style='background-image: url("{{ $patient->avatar ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuBmoJ7zWljb-6oG8m3ruqHc_HJBrlj0SL-YJrRySRqzdiEOLUaC4dCutjq-IATLBJ9HMmYNf6wX0XVbROieBzLVfjzSdSqaXKckizUENhpVyCypmVQUW0n8qlyonn-6WFZ9tlfdZUcG8_apNL-YoCv5zsAIynHVuEwEdKaqpF_NkIePpngu2hMYNT7waE7Ws2B6J9kJxzmcYAicG_trQe760nCkKe6aJ8ZxBPc_6M_6D1J723zypAp2MjZW60fwqZoC_t-dxgyb0A' }}");'></div>
                                            <div>
                                                <p class="text-text-light-primary dark:text-text-dark-primary font-semibold text-sm">
                                                    {{ $patient->name }}
                                                </p>
                                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                                                    {{ $patient->email }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <p class="text-text-light-primary dark:text-text-dark-primary text-sm">
                                            {{ $patient->last_visit?->format('M d, Y') ?? 'Never' }}
                                        </p>
                                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                                            {{ $patient->last_visit?->format('h:i A') ?? '' }}
                                        </p>
                                    </td>
                                    <td class="py-3 px-4">
                                        <p class="text-text-light-primary dark:text-text-dark-primary text-sm">
                                            {{ $patient->next_appointment?->format('M d, Y') ?? 'No upcoming' }}
                                        </p>
                                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                                            {{ $patient->next_appointment?->format('h:i A') ?? '' }}
                                        </p>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="bg-{{ $patient->is_active ? 'green' : 'gray' }}-100 dark:bg-{{ $patient->is_active ? 'green' : 'gray' }}-900/20 text-{{ $patient->is_active ? 'green' : 'gray' }}-800 dark:text-{{ $patient->is_active ? 'green' : 'gray' }}-300 text-xs px-2 py-1 rounded-full">
                                            {{ $patient->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-2">
                                            <button wire:click="viewPatient({{ $patient->id }})" class="flex items-center justify-center rounded-full size-8 hover:bg-primary/10 dark:hover:bg-primary/20 text-text-light-secondary dark:text-text-dark-secondary">
                                                <span class="material-symbols-outlined text-lg">visibility</span>
                                            </button>
                                            <button wire:click="addNote({{ $patient->id }})" class="flex items-center justify-center rounded-full size-8 hover:bg-primary/10 dark:hover:bg-primary/20 text-text-light-secondary dark:text-text-dark-secondary">
                                                <span class="material-symbols-outlined text-lg">note_add</span>
                                            </button>
                                            <button wire:click="messagePatient({{ $patient->id }})" class="flex items-center justify-center rounded-full size-8 hover:bg-primary/10 dark:hover:bg-primary/20 text-text-light-secondary dark:text-text-dark-secondary">
                                                <span class="material-symbols-outlined text-lg">chat</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-text-light-secondary dark:text-text-dark-secondary">
                                        <span class="material-symbols-outlined text-4xl mb-2">personal_injury</span>
                                        <p>No patients found</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-6">
                        {{ $patients->links() }}
                    </div>
                </div>

                <!-- Patient Details Modal -->
                @if($viewingPatient)
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                            Patient History - {{ $viewingPatient->name }}
                        </h2>
                        <button wire:click="closeViewModal" class="flex items-center justify-center rounded-full size-8 hover:bg-red-50 dark:hover:bg-red-900/20 text-red-500">
                            <span class="material-symbols-outlined text-lg">close</span>
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Consultation History -->
                        <div class="bg-background-light dark:bg-background-dark p-4 rounded-lg">
                            <h3 class="text-text-light-primary dark:text-text-dark-primary font-semibold mb-3">Consultation History</h3>
                            <div class="space-y-3">
                                @forelse($patientAppointments as $consultation)
                                <div class="border-l-4 border-primary pl-3 py-1">
                                    <p class="text-text-light-primary dark:text-text-dark-primary text-sm font-medium">
                                        {{ $consultation->created_at->format('M d, Y') }}
                                    </p>
                                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                                        {{ $consultation->type }} - {{ $consultation->duration }} mins
                                    </p>
                                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs mt-1">
                                        Diagnosis: {{ $consultation->diagnosis ?? 'Not specified' }}
                                    </p>
                                </div>
                                @empty
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">No consultation history</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Medical Notes -->
                        <div class="bg-background-light dark:bg-background-dark p-4 rounded-lg">
                            <h3 class="text-text-light-primary dark:text-text-dark-primary font-semibold mb-3">Medical Notes</h3>
                            <div class="space-y-3">
                                @forelse($patientNotes ?? [] as $note)
                                <div class="border-l-4 border-green-500 pl-3 py-1">
                                    <p class="text-text-light-primary dark:text-text-dark-primary text-sm font-medium">
                                        {{ $note->created_at->format('M d, Y') }}
                                    </p>
                                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                                        {{ Str::limit($note->note, 100) }}
                                    </p>
                                </div>
                                @empty
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">No medical notes</p>
                                @endforelse
                            </div>
                            
                            <!-- Add Note Form -->
                            <div class="mt-4">
                                <textarea wire:model="newNote" placeholder="Add new note..." class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg px-3 py-2 text-text-light-primary dark:text-text-dark-primary text-sm focus:outline-none focus:ring-2 focus:ring-primary resize-none" rows="3"></textarea>
                                <button wire:click="saveNote" class="mt-2 flex items-center justify-center rounded-lg h-9 px-4 bg-primary text-white text-sm font-medium">
                                    Save Note
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column -->
            <div class="lg:col-span-1 flex flex-col gap-8">
                <!-- Patient Stats -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-4">
                        Patient Stats
                    </h2>
                    <div class="flex flex-col gap-4">
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Total Patients</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-bold">{{ $patientStats['total'] }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Active This Month</span>
                            <span class="text-green-600 dark:text-green-400 font-bold">{{ $patientStats['active_month'] }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">New This Week</span>
                            <span class="text-blue-600 dark:text-blue-400 font-bold">{{ $patientStats['new_week'] }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Follow-ups</span>
                            <span class="text-orange-600 dark:text-orange-400 font-bold">{{ $patientStats['follow_ups'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-4">
                        Quick Actions
                    </h2>
                    <div class="flex flex-col gap-3">
                        <button class="flex w-full items-center justify-center gap-2 rounded-lg h-11 px-4 bg-primary text-white text-sm font-bold">
                            <span class="material-symbols-outlined">note_add</span>
                            Add Patient Note
                        </button>
                        <button class="flex w-full items-center justify-center gap-2 rounded-lg h-11 px-4 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-sm font-bold hover:bg-gray-50 dark:hover:bg-slate-700">
                            <span class="material-symbols-outlined">schedule</span>
                            Schedule Follow-up
                        </button>
                        <button class="flex w-full items-center justify-center gap-2 rounded-lg h-11 px-4 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-sm font-bold hover:bg-gray-50 dark:hover:bg-slate-700">
                            <span class="material-symbols-outlined">description</span>
                            Generate Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>