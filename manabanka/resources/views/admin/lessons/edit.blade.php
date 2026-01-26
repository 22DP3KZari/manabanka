<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lesson: {{ $lesson->title }} - manaBanka Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold text-blue-600">manaBanka Admin</a>
                        </div>
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                            <a href="{{ route('admin.lessons.index') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                ← Back to Lessons
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="max-w-5xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900">Edit Latvian Translation</h1>
                    <p class="text-gray-600 mt-2">{{ $lesson->title }}</p>
                </div>

                <form action="{{ route('admin.lessons.update', $lesson) }}" method="POST" class="bg-white shadow rounded-lg p-6">
                    @csrf
                    @method('PUT')

                    <!-- English Reference (Read-only) -->
                    <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">English Reference (for comparison)</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                <div class="text-gray-900">{{ $lesson->title }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <div class="text-gray-700 whitespace-pre-wrap">{{ $lesson->description }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                                <div class="text-gray-700 whitespace-pre-wrap max-h-96 overflow-y-auto">{{ $lesson->content }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Latvian Translation Fields -->
                    <div class="space-y-6">
                        <div>
                            <label for="title_lv" class="block text-sm font-medium text-gray-700 mb-2">
                                Latvian Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="title_lv" 
                                   name="title_lv" 
                                   value="{{ old('title_lv', $lesson->title_lv) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   required>
                            @error('title_lv')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description_lv" class="block text-sm font-medium text-gray-700 mb-2">
                                Latvian Description
                            </label>
                            <textarea id="description_lv" 
                                      name="description_lv" 
                                      rows="3"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description_lv', $lesson->description_lv) }}</textarea>
                            @error('description_lv')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="content_lv" class="block text-sm font-medium text-gray-700 mb-2">
                                Latvian Content <span class="text-red-500">*</span>
                            </label>
                            <textarea id="content_lv" 
                                      name="content_lv" 
                                      rows="20"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-sm">{{ old('content_lv', $lesson->content_lv) }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">You can use line breaks. They will be preserved in the display.</p>
                            @error('content_lv')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end space-x-4">
                        <a href="{{ route('admin.lessons.index') }}" 
                           class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Save Translation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
