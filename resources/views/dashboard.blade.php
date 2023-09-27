<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <ul role="list"
                class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                @if (!empty($projects))
                    @foreach ($projects as $project)
                        <li class="relative">
                            <div
                                class="group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1582053433976-25c00369fc93?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=512&q=80"
                                    alt="" class="object-cover pointer-events-none group-hover:opacity-75">

                            </div>
                            <h2 class="text-white font-bold text-2xl">{{ $project->project_title }}</h2>
                            <button class="btn dark:bg-white px-4 py-2 rounded my-2"><a
                                    href="{{ route('task.add', $project->id) }}">Add Task</a></button>

                        </li>
                    @endforeach
                @else
                    <h2>No project available</h2>
                @endif
        </div>
        <button class="btn py-2 px-4 dark:bg-white rounded-sm my-2"><a href="{{ route('project.create') }}">Create
                Project</a></button>
    </div>
    </div>
</x-app-layout>
