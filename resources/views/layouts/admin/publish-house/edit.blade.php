<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Publish House') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.publish-houses.update', $publishHouse) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name Field -->
                            <div class="mb-4">
                                <x-label for="name" :value="__('Name')" />
                                <x-input id="name" class="block mt-1 w-full" type="text" name="name" 
                                    :value="old('name', $publishHouse->name)" required autofocus />
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Website Field -->
                            <div class="mb-4">
                                <x-label for="website" :value="__('Website')" />
                                <x-input id="website" class="block mt-1 w-full" type="url" name="website" 
                                    :value="old('website', $publishHouse->website)" />
                                @error('website')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Description Field -->
                        <div class="mb-4">
                            <x-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="4" 
                                class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            >{{ old('description', $publishHouse->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Logo Field -->
                        <div class="mb-4">
                            <x-label for="logo" :value="__('Logo')" />
                            
                            <!-- Current Logo Preview -->
                            @if($publishHouse->logo)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Current Logo:</p>
                                <img src="{{ asset('storage/'.$publishHouse->logo) }}" 
                                    alt="{{ $publishHouse->name }} logo" 
                                    class="h-20 w-20 object-contain rounded border border-gray-200">
                            </div>
                            @endif
                            
                            <!-- Logo Upload -->
                            <div class="flex items-center">
                                <x-input id="logo" class="block w-full" type="file" name="logo" />
                            </div>
                            @error('logo')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Recommended size: 200x200 pixels</p>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end mt-6 space-x-4">
                            <!-- Cancel Button -->
                            <a href="{{ route('admin.publish-houses.index') }}" 
                                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                {{ __('Cancel') }}
                            </a>
                            
                            <!-- Update Button -->
                            <x-button class="ml-4">
                                {{ __('Update') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>