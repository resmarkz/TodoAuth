<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('My Tasks') }}
            </h2>
            <x-primary-button class="ml-4" onclick="document.getElementById('create-task-modal').showModal()">
                {{ __('Add Task') }}
            </x-primary-button>
        </div>
    </x-slot>

    <div class="py-4 md:py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            <!-- Task Filters - Responsive -->
            <div class="bg-white dark:bg-gray-800 p-3 sm:p-4 shadow sm:rounded-lg">
                <div class="flex flex-wrap gap-2 sm:gap-4">
                    <form method="GET" action="{{ route('tasks.index') }}" class="inline">
                        <x-secondary-button 
                            type="submit" 
                            class="!px-3 !py-1.5 sm:!px-4 sm:!py-2 text-sm sm:text-base"
                            :active="request()->routeIs('tasks.index') && !request()->has('filter')"
                        >
                            All Tasks
                        </x-secondary-button>
                    </form>
                    
                    <form method="POST" action="{{ route('tasks.fetchNotCompleted') }}" class="inline">
                        @csrf
                        <x-secondary-button 
                            type="submit" 
                            class="!px-3 !py-1.5 sm:!px-4 sm:!py-2 text-sm sm:text-base"
                            :active="request()->routeIs('tasks.fetchNotCompleted')"
                        >
                            Active
                        </x-secondary-button>
                    </form>
                    
                    <form method="POST" action="{{ route('tasks.fetchCompleted') }}" class="inline">
                        @csrf
                        <x-secondary-button 
                            type="submit" 
                            class="!px-3 !py-1.5 sm:!px-4 sm:!py-2 text-sm sm:text-base"
                            :active="request()->routeIs('tasks.fetchCompleted')"
                        >
                            Completed
                        </x-secondary-button>
                    </form>
                </div>
            </div>

            <!-- Task List - Responsive -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900 dark:text-gray-100">
                    @foreach ($tasks as $task)
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 sm:py-4 border-b border-gray-200 dark:border-gray-700 gap-2 sm:gap-0">
                            <div class="flex-1 min-w-0">
                                <p class="text-gray-800 dark:text-gray-200 {{ $task->completed ? 'line-through text-gray-500' : '' }} truncate">
                                    {{ $task->title }}
                                </p>
                                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 {{ 
                                    $task->completed ? 'text-gray-500 dark:text-gray-400' : 
                                    ($task->isOverdue() ? 'text-red-600 dark:text-red-400' : 
                                    'text-gray-500 dark:text-gray-400')
                                }}">
                                    Due: {{ $task->due_date ? $task->due_date : 'No Due Date' }}
                                </p>
                            </div>
                            <div class="flex items-center justify-end sm:justify-normal space-x-2">
                                @if(!$task->completed)
                                    <form method="POST" action="{{ route('tasks.complete', $task->id) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <x-secondary-button type="submit" class="!px-2 !py-1 sm:!px-3 sm:!py-1 text-xs sm:text-sm bg-green-500 hover:bg-green-700 text-white">
                                            Complete
                                        </x-secondary-button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('tasks.uncomplete', $task->id) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <x-secondary-button type="submit" class="!px-2 !py-1 sm:!px-3 sm:!py-1 text-xs sm:text-sm bg-yellow-600 hover:bg-yellow-700 text-white">
                                            Undo
                                        </x-secondary-button>
                                    </form>
                                @endif
                                
                                <div class="flex space-x-1 sm:space-x-2">
                                    <button onclick="openEditModal({{ $task->id }}, '{{ $task->title }}', '{{ $task->description }}', '{{ $task->due_date }}')" 
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if(count($tasks) === 0)
                        <div class="text-center">
                            <p class="text-gray-500 dark:text-gray-400">No tasks found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Create Task Modal - Responsive -->
    <dialog id="create-task-modal" class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Add New Task</h3>
            <button onclick="document.getElementById('create-task-modal').close()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <form method="POST" action="{{ route('tasks.store') }}">
            @csrf
            <div class="mb-4">
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" required autofocus />
                @error('title')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <x-input-label for="description" :value="__('Description')" />
                <textarea id="description" name="description" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required></textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <x-input-label for="due_date" :value="__('Due Date')" />
                <x-text-input id="due_date" class="block mt-1 w-full" type="date" name="due_date" />
            </div>

            <div class="flex justify-end space-x-4 mt-6">
                <x-secondary-button onclick="document.getElementById('create-task-modal').close()">
                    Cancel
                </x-secondary-button>
                <x-primary-button>
                    Save Task
                </x-primary-button>
            </div>
        </form>
    </dialog>

    <!-- Edit Task Modal - Responsive -->
    <dialog id="edit-task-modal" class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Edit Task</h3>
            <button onclick="document.getElementById('edit-task-modal').close()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <form method="POST" id="edit-task-form">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <x-input-label for="edit_title" :value="__('Title')" />
                <x-text-input id="edit_title" class="block mt-1 w-full" type="text" name="title" required autofocus />
                @error('title')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <x-input-label for="edit_description" :value="__('Description')" />
                <textarea id="edit_description" name="description" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required></textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <x-input-label for="edit_due_date" :value="__('Due Date')" />
                <x-text-input id="edit_due_date" class="block mt-1 w-full" type="date" name="due_date" />
            </div>

            <div class="flex justify-end space-x-4 mt-6">
                <x-secondary-button onclick="document.getElementById('edit-task-modal').close()">
                    Cancel
                </x-secondary-button>
                <x-primary-button>
                    Update Task
                </x-primary-button>
            </div>
        </form>
    </dialog>

    <script>
        function openEditModal(id, title, description, dueDate) {
            const modal = document.getElementById('edit-task-modal');
            const form = document.getElementById('edit-task-form');
            
            form.action = `/tasks/${id}`;
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_description').value = description;
            document.getElementById('edit_due_date').value = dueDate;
            
            modal.showModal();
        }
    </script>
</x-app-layout>