<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Roles for {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('message') }}
                    </div>
                @endif

                <form wire:submit.prevent="save">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Current Roles</label>

                        <div class="space-y-2">
                            @foreach ($availableRoles as $role)
                                <label class="inline-flex items-center">
                                    <input type="checkbox" wire:model="userRoles" value="{{ $role->id }}"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <span class="ml-2">{{ $role->name }} ({{ $role->description }})</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('users.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save Roles
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
