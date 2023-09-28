<x-app-layout>
    <button class="btn py-2 px-4 dark:bg-white rounded-sm my-2"><a href="{{ route('project.create') }}">Create New
            Project</a></button>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div role="list" class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
            @if (!empty($projects))
                @foreach ($projects as $project)
                    <li class="relative">
                        <div
                            class="group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden">
                            <img src='{{ asset($project->project_image) }}' alt=""
                                class="object-cover pointer-events-none group-hover:opacity-75">

                        </div>
                        @if ($project->completed_tasks_count > 0)
                            @php
                                
                                $completedTaskPercentage = floor(($project->completed_tasks_count / $project->tasks_count) * 100);
                            @endphp
                            <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700 my-2">
                                <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                                    style="width: {{ $completedTaskPercentage }}%"> {{ $completedTaskPercentage }} %
                                </div>
                            </div>
                        @else
                            <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700 my-2">
                                <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                                    style="width: 0%"> 0%
                                </div>
                            </div>
                        @endif


                        <h2 class="text-white font-bold text-2xl">{{ $project->project_title }}</h2>
                        <button class="btn dark:bg-white px-4 py-2 rounded my-2"><a
                                href="{{ route('task.add', $project->id) }}">Add Task</a></button>

                    </li>
                @endforeach
            @else
                <h2>No project available</h2>
            @endif
        </div>
    </div>


    <div class="py-4 dark:text-white">
        {{ $projects->links() }}
    </div>
</x-app-layout>
