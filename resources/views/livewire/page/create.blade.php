<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Add new pages</h2>

                <form wire:submit.prevent="save">
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" id="title" wire:model="title"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Add title">
                        @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                        <input type="text" id="slug" wire:model="slug"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Add slug">
                        @error('slug')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="body" class="block text-sm font-medium text-gray-700 mb-1">Body</label>
                        <div wire:ignore x-data="{
                            initEditor() {
                                ClassicEditor.create(this.$refs.editor)
                                    .then(editor => {
                                        editor.model.document.on('change:data', () => {
                                            $wire.set('body', editor.getData(), false);
                                        });
                        
                                        // Set nilai awal jika ada
                                        if (this.$refs.editor.value) {
                                            editor.setData(this.$refs.editor.value);
                                        }
                                    })
                                    .catch(error => {
                                        console.error('CKEditor error:', error);
                                    });
                            }
                        }" x-init="initEditor()">
                            <textarea x-ref="editor" wire:model="body"></textarea>
                        </div>
                        @error('body')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <label class="inline-flex items-center mb-5 cursor-pointer">
                            <input type="checkbox" wire:model="status" class="sr-only peer"
                                @if ($status) checked @endif>
                            <div
                                class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600">
                            </div>
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                {{ $status ? 'Active' : 'Inactive' }}
                            </span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('categories.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
