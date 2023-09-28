<x-admin-layout>
    <div class="overflow-x-auto dark:text-white">
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="w-16">ID</th>
                    <th class="">Name</th>
                    <th class="w-24">Status</th>
                    <th class="w-24">Action</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($users))
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>
                                <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </td>
                            <td>

                                <form action="{{ route('delete.user', $user->id) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit">

                                        <svg wire:loading.remove.delay="" wire:target="" class="w-4 h-4 mr-1"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            aria-hidden="true">
                                            <path
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z">
                                            </path>
                                        </svg>
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center">No User Found</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="py-4">
        {{ $users->links() }}
    </div>
</x-admin-layout>
