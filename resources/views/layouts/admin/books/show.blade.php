<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="md:w-1/3">
                            <img src="{{ asset('storage/'.$book->cover_image) }}" alt="{{ $book->title }}" class="w-full rounded-lg shadow-md">
                            
                            <div class="mt-4">
                                <h3 class="text-lg font-medium text-gray-900">Files</h3>
                                <div class="mt-2 space-y-2">
                                    @if($book->ebook_file)
                                    <div>
                                        <span class="text-sm font-medium text-gray-700">Ebook:</span>
                                        <a href="{{ asset('storage/'.$book->ebook_file) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm ml-2">Download</a>
                                    </div>
                                    @endif
                                    @if($book->audio_file)
                                    <div>
                                        <span class="text-sm font-medium text-gray-700">Audio:</span>
                                        <a href="{{ asset('storage/'.$book->audio_file) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm ml-2">Download</a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="md:w-2/3">
                            <h1 class="text-2xl font-bold text-gray-900">{{ $book->title }}</h1>
                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                <span>Published by: {{ $book->publishHouse->name }}</span>
                                <span class="mx-2">•</span>
                                <span>Category: {{ $book->category->name }}</span>
                            </div>

                            <div class="mt-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $book->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $book->is_published ? 'Published' : 'Draft' }}
                                </span>
                                @if($book->is_published)
                                <span class="ml-2 text-sm text-gray-500">
                                    Published on: {{ $book->published_date->format('M d, Y') }}
                                </span>
                                @endif
                            </div>

                            <div class="mt-6">
                                <h3 class="text-lg font-medium text-gray-900">Description</h3>
                                <p class="mt-2 text-gray-600 whitespace-pre-line">{{ $book->description }}</p>
                            </div>

                            <div class="mt-6">
                                <h3 class="text-lg font-medium text-gray-900">Publisher Details</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Publisher:</span> {{ $book->publisher->name }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Email:</span> {{ $book->publisher->email }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-6 flex space-x-4">
                                <a href="{{ route('admin.books.edit', $book) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Edit
                                </a>
                                <form action="{{ route('admin.books.destroy', $book) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('Are you sure you want to delete this book?')">
                                        Delete
                                    </button>
                                </form>
                                @if(!$book->is_published)
                                <form action="{{ route('admin.books.publish', $book) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        Publish
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>