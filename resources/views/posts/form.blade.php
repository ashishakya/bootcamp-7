@csrf

<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Title</label>
    <input id="title" type="text" name="title" value="{{ old('title', $post->title ?? '') }}"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    @error('title')
        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="content">Content</label>
    <textarea id="content" name="content" rows="5"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('content', $post->content ?? '') }}</textarea>
    @error('content')
        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="image_url">Image URL</label>
    <input id="image_url" type="url" name="image_url" value="{{ old('image_url', $post->image->url ?? '') }}"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    @error('image_url')
        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4 flex items-center">
    <input id="is_published" type="checkbox" name="is_published" value="1"
        {{ old('is_published', $post->is_published ?? false) ? 'checked' : '' }} class="mr-2 leading-tight">
    <label class="text-gray-700 text-sm font-bold" for="is_published">Published</label>
    @error('is_published')
        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
    @enderror
</div>

<div class="flex items-center justify-end">
    <a href="{{ route('posts.index') }}"
        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 mr-2">
        Cancel
    </a>
    <button type="submit"
        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        {{ $buttonText ?? 'Save' }}
    </button>
</div>
