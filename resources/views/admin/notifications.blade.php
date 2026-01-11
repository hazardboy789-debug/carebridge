<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Notifications</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="mb-4 text-green-600">{{ session('message') }}</div>
            @endif

            <!-- Test notification button removed for production -->

            @livewire('admin.notifications-list')
        </div>
    </div>
</x-app-layout>
