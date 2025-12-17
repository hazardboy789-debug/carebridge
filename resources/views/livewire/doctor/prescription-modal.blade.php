<div>
    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" wire:click="closeModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal panel -->
                <div class="inline-block w-full max-w-4xl my-8 text-left align-middle transition-all transform bg-white dark:bg-gray-800 rounded-lg shadow-xl">
                    <!-- Header -->
                    <div class="px-6 py-4 bg-green-50 dark:bg-green-900/20 border-b border-green-200 dark:border-green-800">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="modal-title">
                                    Create Prescription
                                </h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    For: {{ $patient->name ?? 'Patient' }}
                                </p>
                            </div>
                            <button wire:click="closeModal" 
                                    class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Form -->
                    <form wire:submit.prevent="generatePrescription">
                        <div class="px-6 py-4 max-h-[70vh] overflow-y-auto">
                            @if (session()->has('error'))
                                <div class="p-3 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900/20 dark:text-red-300" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <!-- Diagnosis -->
                            <div class="mb-6">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Diagnosis *
                                </label>
                                <textarea wire:model="diagnosis" 
                                          rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                          placeholder="Enter patient diagnosis..."
                                          required></textarea>
                                @error('diagnosis') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <!-- Symptoms -->
                            <div class="mb-6">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Symptoms *
                                </label>
                                <textarea wire:model="symptoms" 
                                          rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                          placeholder="Describe patient symptoms..."
                                          required></textarea>
                                @error('symptoms') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <!-- Medicines -->
                            <div class="mb-6">
                                <div class="flex items-center justify-between mb-2">
                                    <label class="block text-sm font-medium text-gray-900 dark:text-white">
                                        Medicines *
                                    </label>
                                    <button type="button" 
                                            wire:click="addMedicine"
                                            class="text-sm text-green-600 dark:text-green-400 hover:text-green-700">
                                        + Add Medicine
                                    </button>
                                </div>
                                
                                @foreach($medicines as $index => $medicine)
                                    <div class="flex gap-2 mb-2">
                                        <input type="text"
                                               wire:model="medicines.{{ $index }}"
                                               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                               placeholder="Medicine (e.g., Paracetamol|500mg|Twice daily|7 days)"
                                               required>
                                        @if(count($medicines) > 1)
                                            <button type="button"
                                                    wire:click="removeMedicine({{ $index }})"
                                                    class="px-3 text-red-500 hover:text-red-700">
                                                Remove
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Format: Name|Dosage|Frequency|Duration (use | as separator)
                                </p>
                            </div>

                            <!-- Instructions -->
                            <div class="mb-6">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Instructions *
                                </label>
                                <textarea wire:model="instructions" 
                                          rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                          placeholder="Enter medication instructions..."
                                          required></textarea>
                                @error('instructions') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <!-- Additional Information -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <!-- Follow-up Date -->
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Follow-up Date
                                    </label>
                                    <input type="date"
                                           wire:model="followUpDate"
                                           min="{{ date('Y-m-d') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                </div>

                                <!-- Notes -->
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Additional Notes
                                    </label>
                                    <textarea wire:model="notes" 
                                              rows="2"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                              placeholder="Any additional notes..."></textarea>
                                </div>
                            </div>

                            <!-- File Upload -->
                            <div class="mb-6">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Attach File (Optional)
                                </label>
                                <input type="file"
                                       wire:model="fileUpload"
                                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Upload prescription file (PDF, Word, or Image - max 2MB)
                                </p>
                                @if($fileUpload)
                                    <div class="mt-2">
                                        <p class="text-sm text-green-600">File selected: {{ $fileUpload->getClientOriginalName() }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex justify-end space-x-3">
                                <button type="button"
                                        wire:click="closeModal"
                                        wire:loading.attr="disabled"
                                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                                    Cancel
                                </button>
                                <button type="submit"
                                        wire:loading.attr="disabled"
                                        class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span wire:loading.remove wire:target="generatePrescription">
                                        Generate & Send Prescription
                                    </span>
                                    <span wire:loading wire:target="generatePrescription">
                                        <svg class="w-4 h-4 mr-2 -ml-1 animate-spin" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Generating...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @script
    <script>
        // Listen for prescription creation event
        Livewire.on('prescription-created', (data) => {
            // Refresh the parent chat component
            Livewire.dispatch('refresh-prescriptions');
            
            // Show success message
            const event = new CustomEvent('show-toast', {
                detail: {
                    message: 'Prescription created and sent successfully!',
                    type: 'success'
                }
            });
            window.dispatchEvent(event);
        });
    </script>
    @endscript
</div>