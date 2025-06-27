<div>
    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
        <h3 class="text-lg font-medium leading-6 text-gray-900">
            Edit Permissions for Role: {{ $role->name }}
        </h3>
        <p class="mt-1 text-sm text-gray-500">
            Select the permissions you want to assign to this role
        </p>
    </div>

    <div class="px-4 py-5 sm:p-6">
        @if (session()->has('message'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="save">
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Select
                            </th>
                            <th scope="col"
                                class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Permission
                            </th>
                            <th scope="col"
                                class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Description
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($permissions as $permission)
                            <tr>
                                <td class="px-3 py-4 whitespace-nowrap">
                                    <input type="checkbox" wire:model="selectedPermissions"
                                        value="{{ $permission->id }}"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $permission->name }}
                                    </div>
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">
                                        {{ $permission->description }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end mt-5">
                <a href="{{ route('roles.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </a>
                <button type="submit"
                    class="inline-flex justify-center px-4 py-2 ml-3 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save Permissions
                </button>
            </div>
        </form>
    </div>
</div>
