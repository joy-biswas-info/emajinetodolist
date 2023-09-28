<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div role="list"
                class="grid grid-cols-2 gap-x-2 gap-y-4 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-4">
                @if (!empty($projects))
                    @foreach ($projects as $project)
                        <a href="{{ route('task.add', $project->id) }}">
                            <li class="relative list-none bg-gray-200 dark:bg-gray-500 rounded">
                                <div
                                    class="group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden">
                                    <img src='{{ asset($project->project_image) }}' alt=""
                                        class="object-cover pointer-events-none group-hover:opacity-75">

                                </div>

                                <div class="px-2 pb-2">
                                    @if ($project->completed_tasks_count > 0)
                                        @php
                                            
                                            $completedTaskPercentage = floor(($project->completed_tasks_count / $project->tasks_count) * 100);
                                        @endphp
                                        <div
                                            class="w-full bg-gray-200 rounded-full dark:bg-gray-700 my-2 border border-gray-800">
                                            <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                                                style="width: {{ $completedTaskPercentage }}%">
                                                {{ $completedTaskPercentage }} %
                                            </div>
                                        </div>
                                    @else
                                        <div
                                            class="w-full bg-gray-200 rounded-full dark:bg-gray-700 my-2 border border-gray-800">
                                            <div class="bg-blue-600 text-xs font-medium text-red-500 text-center p-0.5 leading-none rounded-full"
                                                style="width: 0%"> 0%
                                            </div>
                                        </div>
                                    @endif
                                    <h2 class="dark:text-white font-bold text-2xl">{{ $project->project_title }}</h2>
                                </div>



                            </li>
                        </a>
                    @endforeach
                @else
                    <h2>No project available</h2>
                @endif
            </div>
            <div>
                Totla Projects
            </div>
        </div>
    </div>
    </div>




</x-admin-layout>
