<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Post Details') }}
            </h2>
            <a href="{{ route('posts.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                {{ __('Back to Posts') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-start justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $post->title }}</h3>
                        @if ($post->image && $post->image->url)
                            <img src="{{ $post->image->url }}" alt="{{ $post->title }}"
                                class="h-24 w-24 rounded-md object-cover">
                        @endif
                    </div>

                    <dl class="divide-y divide-gray-200">
                        <div class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">ID</dt>
                            <dd class="mt-1 text-sm text-gray-900 col-span-2">{{ $post->id }}</dd>
                        </div>
                        <div class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Content</dt>
                            <dd class="mt-1 text-sm text-gray-900 col-span-2 whitespace-pre-line">{{ $post->content }}
                            </dd>
                        </div>
                        <div class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Author</dt>
                            <dd class="mt-1 text-sm text-gray-900 col-span-2">{{ $post->user->name ?? '-' }}</dd>
                        </div>
                        <div class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Published</dt>
                            <dd class="mt-1 text-sm text-gray-900 col-span-2">
                                {{ $post->is_published ? 'Yes' : 'No' }}
                            </dd>
                        </div>
                        <div class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Created At</dt>
                            <dd class="mt-1 text-sm text-gray-900 col-span-2">{{ $post->created_at }}</dd>
                        </div>
                        <div class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Updated At</dt>
                            <dd class="mt-1 text-sm text-gray-900 col-span-2">{{ $post->updated_at }}</dd>
                        </div>
                    </dl>

                    <div class="mt-6 flex space-x-3">
                        <a href="{{ route('posts.edit', $post) }}"
                            class="inline-flex items-center px-4 py-2 bg-sky-500 border border-transparent rounded-md font-semibold text-xs text-white tracking-widest hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2">
                            {{ __('Edit Post') }}
                        </a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST"
                            onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white tracking-widest hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                {{ __('Delete Post') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Comments</h3>

                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($post->comments->isEmpty())
                        <p class="text-sm text-gray-500 mb-4">No comments yet.</p>
                    @else
                        <ul class="space-y-3 mb-6">
                            @foreach ($post->comments as $comment)
                                <li class="border border-gray-200 rounded-md p-3 text-sm text-gray-900">
                                    {{ $comment->comment }}
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <form action="{{ route('posts.comments.store', $post) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="comment" class="block text-sm font-medium text-gray-700">Add Comment</label>
                            <textarea name="comment" id="comment" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm">{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-sky-500 border border-transparent rounded-md font-semibold text-xs text-white tracking-widest hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2">
                            {{ __('Add Comment') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
