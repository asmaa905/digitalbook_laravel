<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Book') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="mb-4">
                                <x-label for="title" :value="__('Title')" />
                                <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                                @error('title')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <x-label for="category_id" :value="__('Category')" />
                                <select id="category_id" name="category_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <x-label for="publish_house_id" :value="__('Publish House')" />
                                <select id="publish_house_id" name="publish_house_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="">Select Publish House</option>
                                    @foreach($publishHouses as $house)
                                    <option value="{{ $house->id }}" {{ old('publish_house_id') == $house->id ? 'selected' : '' }}>{{ $house->name }}</option>
                                    @endforeach
                                </select>
                                @error('publish_house_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <x-label for="user_id" :value="__('Publisher')" />
                                <select id="user_id" name="user_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="">Select Publisher</option>
                                    @foreach($publishers as $publisher)
                                    <option value="{{ $publisher->id }}" {{ old('user_id') == $publisher->id ? 'selected' : '' }}>{{ $publisher->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <x-label for="cover_image" :value="__('Cover Image')" />
                                <x-input id="cover_image" class="block mt-1 w-full" type="file" name="cover_image" required />
                                @error('cover_image')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <x-label for="ebook_file" :value="__('Ebook File (PDF/EPUB)')" />
                                <x-input id="ebook_file" class="block mt-1 w-full" type="file" name="ebook_file" />
                                @error('ebook_file')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <x-label for="audio_file" :value="__('Audio File (MP3/WAV)')" />
                                <x-input id="audio_file" class="block mt-1 w-full" type="file" name="audio_file" />
                                @error('audio_file')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <x-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="5" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Create') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>