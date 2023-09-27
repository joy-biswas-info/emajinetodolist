<x-app-layout>

    <div>
        <h1 class="text-2xl dark:text-white text-center font-bold my-4">Create New Project</h1>
    </div>
    <form id="add-project-form"
        class="border-2 border-gray-400 sm:w-full md:w-1/3 lg:w-1/3 mx-auto p-4 rounded-lg shadow-lg bg-white dark:bg-gray-800 dark:border-gray-700 h-56"
        method="POST" action="{{ route('project.store') }}">
        @csrf
        <div class="mb-4">
            <input type="text"
                class="block w-full px-4 py-2 border-2 border-gray-300 rounded-md focus:border-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                name="project_title" placeholder="Project Title" required>
        </div>

        <div class="mb-4">
            <textarea
                class="block w-full px-4 py-2 border-2 border-gray-300 rounded-md focus:border-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                name="project_description" placeholder="Project Description"></textarea>
        </div>
        <div class="mb-4">
            <select name="user_id" id="user-id"
                class="block w-full px-4 py-2 border-2 border-gray-300 rounded-md focus:border-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                <option value="">Slect User</option>
                @if (!empty($users))
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                @endif
            </select>
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
                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 dark:bg-white dark:text-gray-700 dark:hover:text-gray-900">Create
                New
                Project</button>
        </div>
    </form>


    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            init: function() {
                this.on('addedfile', function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                });
            },
            url: "{{ route('temp-images.create') }}",
            maxFiles: 1,
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
