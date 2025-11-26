<div>
    <!-- Main modal -->
    @if($isOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                Create Prescription for {{ $patient->name ?? '' }}
                            </h3>
                            
                            <form wire:submit.prevent="generatePrescription" class="mt-4 space-y-4">
                                <!-- Flash Messages -->
                                @if(session()->has('medicine_added'))
                                    <div class="p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded">
                                        <p class="text-sm text-green-700 dark:text-green-300">{{ session('medicine_added') }}</p>
                                    </div>
                                @endif

                                <!-- Diagnosis -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Diagnosis *</label>
                                    <textarea wire:model="diagnosis" rows="2" 
                                              class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"></textarea>
                                    @error('diagnosis') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <!-- Symptoms -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Symptoms *</label>
                                    <textarea wire:model="symptoms" rows="2"
                                              class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"></textarea>
                                    @error('symptoms') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <!-- Add Medicine Section -->
                                <div class="border-t pt-4">
                                    <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Add Medicines</h4>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
                                        <div>
                                            <input type="text" wire:model="medicineName" placeholder="Medicine Name" 
                                                   class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 dark:bg-gray-700 dark:text-white">
                                            @error('medicineName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <input type="text" wire:model="medicineDosage" placeholder="Dosage" 
                                                   class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 dark:bg-gray-700 dark:text-white">
                                            @error('medicineDosage') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <input type="text" wire:model="medicineFrequency" placeholder="Frequency" 
                                                   class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 dark:bg-gray-700 dark:text-white">
                                            @error('medicineFrequency') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <input type="text" wire:model="medicineDuration" placeholder="Duration" 
                                                   class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 dark:bg-gray-700 dark:text-white">
                                            @error('medicineDuration') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    
                                    <button type="button" wire:click="addMedicine" 
                                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                                        Add Medicine
                                    </button>
                                </div>

                                <!-- Medicine List -->
                                @if(count($medicines) > 0)
                                <div class="border rounded-lg p-3 bg-gray-50 dark:bg-gray-700">
                                    <h5 class="font-medium mb-2 text-gray-900 dark:text-white">Prescribed Medicines:</h5>
                                    @foreach($medicines as $index => $medicine)
                                    <div class="flex justify-between items-center p-2 bg-white dark:bg-gray-600 rounded mb-1">
                                        <span class="text-sm text-gray-700 dark:text-gray-300">
                                            {{ $medicine['name'] }} - {{ $medicine['dosage'] }} - {{ $medicine['frequency'] }} - {{ $medicine['duration'] }}
                                        </span>
                                        <button type="button" wire:click="removeMedicine({{ $index }})" 
                                                class="text-red-500 hover:text-red-700 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <div class="border rounded-lg p-3 bg-yellow-50 dark:bg-yellow-900/20">
                                    <p class="text-sm text-yellow-700 dark:text-yellow-300">No medicines added yet. Please add at least one medicine.</p>
                                </div>
                                @endif

                                <!-- Instructions -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Special Instructions</label>
                                    <textarea wire:model="instructions" rows="2" placeholder="e.g., Take after meals, Avoid alcohol, etc."
                                              class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"></textarea>
                                </div>

                                <!-- Notes -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Additional Notes</label>
                                    <textarea wire:model="notes" rows="2" placeholder="Any additional information for the patient"
                                              class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"></textarea>
                                </div>

                                <!-- Follow-up Date -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Follow-up Date</label>
                                    <input type="date" wire:model="followUpDate" 
                                           class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="generatePrescription" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        Generate & Send Prescription
                    </button>
                    <button type="button" wire:click="closeModal" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-600 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Script to handle modal events -->
    @script
    <script>
        // Listen for open modal event from parent component
        $wire.on('openPrescriptionModal', (data) => {
            $wire.openModal(data.patientId);
        });

        // Listen for prescription creation success
        $wire.on('prescriptionCreated', () => {
            // Modal will close automatically via the component
        });

        // Close modal when clicking outside
        document.addEventListener('click', (e) => {
            if ($wire.isOpen && e.target.classList.contains('fixed')) {
                $wire.closeModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', (e) => {
            if ($wire.isOpen && e.key === 'Escape') {
                $wire.closeModal();
            }
        });
    </script>
    @endscript
</div>