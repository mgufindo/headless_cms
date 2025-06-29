<div class="space-y-6">
    <form wire:submit.prevent="update" enctype="multipart/form-data">
        <div class="flex flex-wrap gap-2">
            <div class="w-full">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" wire:model="title" id="title"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @error('title')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="w-full">
                <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                <textarea wire:model="content" id="content" rows="10"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                @error('content')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="w-full">
                <label for="excerpt" class="block text-sm font-medium text-gray-700">Excerpt</label>
                <textarea wire:model="excerpt" id="excerpt" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                @error('excerpt')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="w-full">
                <label for="image" class="block text-sm font-medium text-gray-700">Featured Image</label>
                <input type="file" wire:model="image" id="image"
                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                @error('image')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
                @if ($image)
                    <div class="mt-2">
                        <img src="{{ is_string($image) ? asset('storage/' . $image) : $image->temporaryUrl() }}"
                            class="h-32">
                    </div>
                @elseif($existingImage)
                    <div class="mt-2">
                        <img src="{{ is_string($existingImage) ? asset('storage/' . $existingImage) : $existingImage->temporaryUrl() }}"
                            class="h-32">
                    </div>
                @endif
            </div>

            <div class="w-full">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select wire:model="status" id="status" wire:change="updatePublishedAt($event.target.value)"
                    class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
                @error('status')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="w-full">
                <label for="published_at" class="block text-sm font-medium text-gray-700">Publish Date</label>
                <input type="datetime-local" wire:model="published_at" id="published_at"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm disabled:bg-gray-100 disabled:cursor-not-allowed"
                    @disabled(!$publishedAtShow)>
                @error('published_at')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700">Categories</label>
                <div class="mt-2 space-y-2">
                    @foreach ($categories as $category)
                        <div class="flex items-center">
                            <input wire:model="selectedCategories" id="category-{{ $category->id }}" type="checkbox"
                                value="{{ $category->id }}"
                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <label for="category-{{ $category->id }}"
                                class="ml-2 text-sm text-gray-700">{{ $category->name }}</label>
                        </div>
                    @endforeach
                </div>
                @error('selectedCategories')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex justify-center w-full">
                <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 w-full">Simpan</button>
            </div>
        </div>
    </form>
</div>
