<x-admin-layout>
    <div class="mx-auto container mt-4">
        <div class="my-4 justify-start lg:w-[60%]">
            <h2 class="text-white text-xl md:text-2xl lg:text-3xl bg-blue-500 font-bold px-2 py-1 rounded mb-6">
                {{ $project->project_title }}</h2>
            <ul id="task-list" class="mx-2 min-h-[250px]">
                @if ($tasks->count() > 0)
                    @foreach ($tasks as $task)
                        <li data-task-id="{{ $task->id }}"
                            class="items-center space-x-2 light:bg-white dark:text-white border-b border-gray-600  dark:border-gray-600">
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

                                    <div
                                        class="list-group-item p-1 rounded-0 border-0 bg-transparent  col-start-6 col-end-9">
                                        <div class="flex justify-end items-center mb-1">
                                            <a href="#" class="text-info" data-mdb-toggle="tooltip"
                                                title="Edit todo">
                                                <i class="fas fa-pencil-alt me-3"></i>
                                            </a>
                                            <a href="{{ route('task.delete', $task->id) }}" class="text-red-500"
                                                data-mdb-toggle="tooltip" title="Delete todo">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                        <div class="text-end text-muted">

                                            <p class="text-sm mb-0"><i
                                                    class="fas fa-info-circle me-2"></i>{{ $task->created_at }}
                                            </p>

                                        </div>
                                    </div>
                                </ul>
                                @if ($task->description)
                                    <div id="hiddenDiv-{{ $task->id }}" style="display: non;">
                                        {!! $task->description !!}
                                    </div>
                                @endif
                            @else
                                <ul id="task-{{ $task->id }}"
                                    class="list-group list-group-horizontal rounded-0 bg-transparent dark:text-white grid grid-cols-8">
                                    <div class="flex items-center gap-1 col-start-1 col-end-7 row-start-1">
                                        <input class="form-checkbox me-0" type="checkbox"
                                            onclick="toggleTaskCompletion({{ $task->id }})">
                                        <h3 @if ($task->description) onclick="showDescription({{ $task->id }})" @endif
                                            class="text-lg font-normal mb-0 cursor-pointer">
                                            {{ $task->title }}</h3>
                                        <p id="loading-{{ $task->id }}"></p>
                                    </div>

                                    <div
                                        class="list-group-item p-1 rounded-0 border-0 bg-transparent col-start-6 col-end-9">
                                        <div class="flex justify-end items-center mb-1">
                                            <a href="#" class="text-info" data-mdb-toggle="tooltip"
                                                title="Edit todo">
                                                <i class="fas fa-pencil-alt me-3"></i>
                                            </a>
                                            <a href="{{ route('task.delete', $task->id) }}" class="text-red-500"
                                                data-mdb-toggle="tooltip" title="Delete todo">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                        <div class="text-end text-muted">

                                            <p class="text-sm mb-0"><i
                                                    class="fas fa-info-circle me-2"></i>{{ $task->created_at }}
                                            </p>

                                        </div>
                                    </div>
                                </ul>
                                @if ($task->description)
                                    <div id="hiddenDiv-{{ $task->id }}" style="display: non;">

                                        {!! $task->description !!}


                                    </div>
                                @endif
                            @endif

                        </li>
                    @endforeach
                @else
                    <div class="my-4 dark:text-white h-[250px]">There is no task. Please add task first .</div>
                @endif

            </ul>
        </div>

        {{-- <h2 class="dark:text-white text-xl font-bold mt-6 mb-2">Add Task</h2> --}}
        <form id="add-task-form" method="POST" action="{{ route('add.task') }}"
            class="lg:w-[60%] border-2 border-gray-400  p-4 rounded-lg shadow-lg bg-white dark:bg-gray-800 dark:border-gray-700">
            @csrf
            <div class="mb-4">
                <input type="text"
                    class="block w-full px-4 py-2 border-2 border-gray-300 rounded-md focus:border-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    name="title" placeholder="New Task" required>
            </div>
            <input type="hidden"
                class="block w-full px-4 py-2 border-2 border-gray-300 rounded-md focus:border-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                name="project_id" placeholder="Project Id" required value="{{ $project->id }}" />
            <input type="hidden"
                class="block w-full px-4 py-2 border-2 border-gray-300 rounded-md focus:border-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                name="user_id" placeholder="Project Id" required value="{{ $project->user_id }}" />

            <div class="mb-4">
                <textarea name="description" id="summernote" class="dark:bg-white"></textarea>
            </div>

            <span class="text-white btn bg-blue-500 py-1 px-2 rounded mb-1 cursor-pointer" onclick="showAddFile()">
                Image <i class="fa-regular fa-file"></i> </span>

            <div class="card mb-3 mt-1" style="display: none" id="add-file">
                <div class="card-body">
                    <div id="image" class="dropzone dz-clickable">
                        <div class="dz-message needsclick">
                            <br>Drop files here or click to upload.<br><br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex" id="image-gallery">

            </div>
            <div class="text-right">
                <button type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 dark:bg-white dark:text-gray-700 dark:hover:text-gray-900">Add
                    Task</button>
            </div>
        </form>
    </div>

    <script>
        function showAddFile() {
            const hiddenDiv = document.getElementById("add-file");
            if (hiddenDiv.style.display === 'none' || hiddenDiv.style.display === '') {
                hiddenDiv.style.display = 'block';
            } else {
                hiddenDiv.style.display = 'none';
            }
        }
    </script>
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
            loadingIndicator.innerHTML = `<button type="button" class="bg-indigo-500 ..." disabled>
                                            <svg class="animate-spin h-5 w-5 mr-3 ..." viewBox="0 0 24 24">
                                                <!-- ... -->
                                            </svg>
                                            Processing...
                                            </button>`;

            // Append the loading indicator to the 'loading' element
            document.getElementById(`loading-${taskId}`).appendChild(loadingIndicator);

            axios.post('/admin/tasks/toggle-completion/' + taskId)
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
                $html = `<div class="col-span-12 md:col-span-6 mx-1" id="image-row-${response.image_id }">
                        <input type="hidden" name="image_array[]" value="${response . image_id }">
                        <div class="bg-white rounded-lg shadow-md">
                            <img src="${ response . imagePath }" alt="Card image cap" width=300 height=300>
                            <a href="javascript:void(0)" onclick="deleteImage(${response . image_id })" class="block py-2 text-center bg-red-500 text-white font-bold hover:bg-red-600 transition duration-300 ease-in-out">Delete</a>
                        </div>
                    </div>`

                $('#image-gallery').append($html);

            },
            complete: function(file) {
                this.removeFile(file)
            }
        });

        function deleteImage(id) {
            $('#image-row-' + id).remove()
        };
    </script>
    <script>
        $('#summernote').summernote({
            tabsize: 2,
            height: 250,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color', '#fff']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                // ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],

        });
    </script>



</x-admin-layout>
