<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Details') }}
            </h2>

            <a href="{{ route('users.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                {{ __('Back to Users') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $user->name }}</h3>

                    <dl class="divide-y divide-gray-200">
                        <div class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">ID</dt>
                            <dd class="mt-1 text-sm text-gray-900 col-span-2">{{ $user->id }}</dd>
                        </div>
                        <div class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 col-span-2">{{ $user->name }}</dd>
                        </div>
                        <div class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900 col-span-2">{{ $user->email }}</dd>
                        </div>
                        <div class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="mt-1 text-sm text-gray-900 col-span-2">{{ $user->phone->phone ?? '-' }}</dd>
                        </div>
                        <div class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Roles</dt>
                            <dd class="mt-1 text-sm text-gray-900 col-span-2">
                                @if ($user->roles->isEmpty())
                                    -
                                @else
                                    {{ $user->roles->pluck('name')->join(', ') }}
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">{{ __('Car Owner Detail') }}</h3>
                    </div>

                    @if (!$user->carOwnerDetail)
                        <p class="text-sm text-gray-500">No car owner detail available for this user.</p>
                    @else
                        <dl class="divide-y divide-gray-200">
                            <div class="py-3 grid grid-cols-3 gap-4">
                                <dt class="text-sm font-medium text-gray-500">Car Model</dt>
                                <dd class="mt-1 text-sm text-gray-900 col-span-2">
                                    {{ $user->car->model ?? '-' }}
                                </dd>
                            </div>
                            <div class="py-3 grid grid-cols-3 gap-4">
                                <dt class="text-sm font-medium text-gray-500">Owner Name</dt>
                                <dd class="mt-1 text-sm text-gray-900 col-span-2">
                                    {{ $user->carOwnerDetail->owner_name ?? '-' }}
                                </dd>
                            </div>
                            <div class="py-3 grid grid-cols-3 gap-4">
                                <dt class="text-sm font-medium text-gray-500">Registration Number</dt>
                                <dd class="mt-1 text-sm text-gray-900 col-span-2">
                                    {{ $user->carOwnerDetail->registration_number ?? '-' }}
                                </dd>
                            </div>
                            <div class="py-3 grid grid-cols-3 gap-4">
                                <dt class="text-sm font-medium text-gray-500">Registration Date</dt>
                                <dd class="mt-1 text-sm text-gray-900 col-span-2">
                                    {{ $user->carOwnerDetail->registration_date ?? '-' }}
                                </dd>
                            </div>
                        </dl>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">{{ __('All Posts') }}</h3>
                    </div>

                    @if ($user->posts->isEmpty())
                        <p class="text-sm text-gray-500">This user has no posts yet.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Title
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Published
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Created At
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($user->posts as $post)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $post->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $post->title }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $post->is_published ? 'Yes' : 'No' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $post->created_at?->format('Y-m-d H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">{{ __('Published Posts') }}</h3>
                    </div>

                    @if ($user->publishedPosts->isEmpty())
                        <p class="text-sm text-gray-500">This user has no posts yet.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Title
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Published
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Created At
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($user->publishedPosts as $post)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $post->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $post->title }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $post->is_published ? 'Yes' : 'No' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $post->created_at?->format('Y-m-d H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">{{ __('Comments on User\'s Posts') }}</h3>
                    </div>

                    @if ($user->comments->isEmpty())
                        <p class="text-sm text-gray-500">There are no comments on this user's posts yet.</p>
                    @else
                        <div class="space-y-3">
                            @foreach ($user->comments as $comment)
                                <div class="border border-gray-200 rounded-md p-3 text-sm text-gray-900">
                                    <div class="text-xs text-gray-500 mb-1">
                                        Post: #{{ $comment->post_id }}
                                    </div>
                                    <div>{{ $comment->comment }}</div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
