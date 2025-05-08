<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <x-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.index')">
                <x-primary-button>
                    {{ __('View Tasks') }}
                </x-primary-button>
            </x-nav-link>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-col items-center justify-center space-y-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-lg">{{ __("You're logged in!") }}</p>
                        <p class="text-gray-600 dark:text-gray-400 text-center">
                            Welcome to your dashboard. Click "View Tasks" to manage your todo list.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>