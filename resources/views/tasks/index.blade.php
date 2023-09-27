<x-app-layout>
    <div class="mx-auto container mt-4 lg:flex md:block">
        <div class="my-4 justify-start lg:w-[70%]">
            <h1 class="text-white text-2xl font-bold">{{ $project->project_title }}</h1>

            <ul id="task-list" class="mx-2">
                @foreach ($tasks as $task)
                    <li data-task-id="{{ $task->id }}"
                        class="items-center space-x-2 light:bg-white dark:text-white border-b dark:border-gray-600">
                        @if ($task->completed)
                            <ul id="task-{{ $task->id }}"
                                class="list-group list-group-horizontal rounded-0 bg-transparent grid grid-cols-8 bg-gray-400 my-1">
                                <div class="col-start-1 col-end-7">
                                    <div class="flex items-center gap-1 ">
                                        <input class="form-checkbox me-0" type="checkbox"
                                            onclick="toggleTaskCompletion({{ $task->id }})" checked>
                                        <h3 @if ($task->description) onclick="showDescription({{ $task->id }})" @endif
                                            class="text-lg font-normal mb-0 cursor-pointer">
                                            {{ $task->title }}</h3>
                                        <p id="loading-{{ $task->id }}"></p>
                                    </div>
                                </div>

                                <div class="list-group-item p-1 rounded-0 border-0 bg-transparent">
                                    <div class="flex justify-end items-center mb-1">
                                        <a href="#" class="text-info" data-mdb-toggle="tooltip" title="Edit todo">
                                            <i class="fas fa-pencil-alt me-3"></i>
                                        </a>
                                        <a href="#" class="text-danger" data-mdb-toggle="tooltip"
                                            title="Delete todo">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                    <div class="text-end text-muted">
                                        <a href="#" class="text-muted" data-mdb-toggle="tooltip"
                                            title="Created date">
                                            <p class="text-sm mb-0"><i
                                                    class="fas fa-info-circle me-2"></i>{{ $task->created_at }}
                                            </p>
                                        </a>
                                    </div>
                                </div>
                            </ul>
                            @if ($task->description)
                                <div id="hiddenDiv-{{ $task->id }}" style="display: non;">
                                    <p>{{ $task->description }}</p>
                                </div>
                            @endif
                        @else
                            <ul id="task-{{ $task->id }}"
                                class="list-group list-group-horizontal rounded-0 bg-transparent dark:text-white grid grid-cols-8">
                                <div class="flex items-center gap-1 col-start-1 col-end-7 row-start-1">
                                    <input class="form-checkbox me-0" type="checkbox"
                                        onclick="toggleTaskCompletion({{ $task->id }})">
                                    <h3 class="text-lg font-normal mb-0">{{ $task->title }}</h3>
                                    <p id="loading-{{ $task->id }}"></p>
                                </div>

                                <div class="list-group-item p-1 rounded-0 border-0 bg-transparent">
                                    <div class="flex justify-end items-center mb-1">
                                        <a href="#" class="text-info" data-mdb-toggle="tooltip" title="Edit todo">
                                            <i class="fas fa-pencil-alt me-3"></i>
                                        </a>
                                        <a href="#" class="text-danger" data-mdb-toggle="tooltip"
                                            title="Delete todo">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                    <div class="text-end text-muted">
                                        <a href="#" class="text-muted" data-mdb-toggle="tooltip"
                                            title="Created date">
                                            <p class="text-sm mb-0"><i
                                                    class="fas fa-info-circle me-2"></i>{{ $task->created_at }}
                                            </p>
                                        </a>
                                    </div>
                                </div>
                            </ul>
                            @if ($task->description)
                                <div id="hiddenDiv-{{ $task->id }}" style="display: non;">
                                    <p>{{ $task->description }}</p>
                                </div>
                            @endif
                        @endif

                    </li>
                @endforeach
            </ul>
        </div>

        <form id="add-task-form"
            class="border-2 border-gray-400 sm:w-full md:w-1/3 lg:w-1/3 mx-auto p-4 rounded-lg shadow-lg bg-white dark:bg-gray-800 dark:border-gray-700 h-56 lg:fixed right-1">
            @csrf
            <div class="mb-4">
                <input type="text"
                    class="block w-full px-4 py-2 border-2 border-gray-300 rounded-md focus:border-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    name="title" placeholder="New Task" required>
            </div>
            <input type="hidden"
                class="block w-full px-4 py-2 border-2 border-gray-300 rounded-md focus:border-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                name="project_id" placeholder="Project Id" required value="{{ $project->id }}">
            <div class="mb-4">
                <textarea
                    class="block w-full px-4 py-2 border-2 border-gray-300 rounded-md focus:border-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    name="description" placeholder="Task Description"></textarea>
            </div>
            <div class="col-md-6">
                <label for="image">Image</label>
                <div class="mb-3">
                    <div id="image" class="dropzone dz-clickable">
                        <div class="dz-message needsclick">
                            <br>Drop files here or click to upload.<br><br>
                        </div>
                    </div>
                </div>
                <input type="hidden" value="" name="image_id" id="image_id">

            </div>
            <div class="text-right">
                <button type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 dark:bg-white dark:text-gray-700 dark:hover:text-gray-900">Add
                    Task</button>
            </div>
        </form>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
        const addTaskForm = document.getElementById('add-task-form');
        const taskList = document.getElementById('task-list');

        // Function to add a new task to the list
        function addTaskToList(task) {
            const listItem = document.createElement('li');
            listItem.setAttribute('data-task-id', task.id);
            listItem.textContent = task.title;
            taskList.appendChild(listItem);
        }

        addTaskForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const title = addTaskForm.querySelector('input[name="title"]').value;
            const description = addTaskForm.querySelector('textarea[name="description"]').value;
            const projectId = addTaskForm.querySelector('input[name="project_id"]').value;

            axios.post('/tasks', {
                    title: title,
                    description: description,
                    project_id: projectId,
                    user_id: projectId
                })
                .then(response => {
                    console.log(response.data.message);
                    // Clear the form inputs
                    addTaskForm.reset();
                    location.reload()
                    // Add the new task to the list
                    addTaskToList(response.data.task); // Call the function to add the task
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
    <script>
        const taskList = document.getElementById('task-list');

        new Sortable(taskList, {
            animation: 150,
            onUpdate: function(event) {
                const taskOrder = [...taskList.children].map((task, index) => task.getAttribute(
                    'data-task-id'));
                updateTaskOrder(taskOrder);
            }
        });

        function updateTaskOrder(taskOrder) {
            axios.post('/tasks/update-order', {
                    taskOrder: taskOrder
                })
                .then(response => {
                    console.log(response.data.message);
                })
                .catch(error => {
                    console.error(error);
                });
        }
    </script>
    <script>
        function toggleTaskCompletion(taskId) {
            const taskUl = document.getElementById(`task-${taskId}`);
            // Create a loading indicator element
            var loadingIndicator = document.createElement('div');
            loadingIndicator.innerHTML = `<div role="status">
        <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
        </svg>
        <span class="sr-only">Loading...</span>
    </div>`;

            // Append the loading indicator to the 'loading' element
            document.getElementById(`loading-${taskId}`).appendChild(loadingIndicator);

            axios.post('/tasks/toggle-completion/' + taskId)
                .then(response => {
                    // Remove the loading indicator when the request is complete
                    loadingIndicator.remove();
                    // You can add more logic here to handle the response if needed
                })
                .catch(error => {
                    // Remove the loading indicator in case of an error
                    loadingIndicator.remove();

                    // Handle the error as needed
                    console.error(error);
                });
        }
    </script>

    <script>
        function showDescription(id) {
            const hiddenDiv = document.getElementById(`hiddenDiv-${id}`);
            if (hiddenDiv.style.display === 'none' || hiddenDiv.style.display === '') {
                hiddenDiv.style.display = 'block';
            } else {
                hiddenDiv.style.display = 'none';
            }
        }
    </script>

    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            init: function() {

            },
            url: "{{ route('temp-images.create') }}",
            maxFiles: 10,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(file, response) {
                $("#image_id").val(response.image_id);
                console.log(response)
            }
        });
    </script>

</x-app-layout>
