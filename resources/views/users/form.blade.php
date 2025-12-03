@csrf

<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name</label>
    <input id="name" type="text" name="name" value="{{ old('name', $user->name ?? '') }}"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    @error('name')
        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    @error('email')
        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
    <input id="password" type="password" name="password"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    @error('password')
        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
    @enderror
    @if (isset($user))
        <p class="text-xs text-gray-500 mt-1">Leave blank to keep current password.</p>
    @endif
</div>

<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">Phone</label>
    <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone->phone ?? '') }}"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    @error('phone')
        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="image_url">Image URL</label>
    <input id="image_url" type="url" name="image_url" value="{{ old('image_url', $user->image->url ?? '') }}"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    @error('image_url')
        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="roles">Roles</label>
    <select id="roles" name="roles[]" multiple
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline h-32">
        @foreach ($roles as $role)
            <option value="{{ $role->id }}" @selected(collect(old('roles', isset($user) ? $user->roles->pluck('id')->toArray() : []))->contains($role->id))>
                {{ $role->name }}
            </option>
        @endforeach
    </select>
    @error('roles')
        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
    @enderror
    @error('roles.*')
        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
    @enderror
</div>

<div class="flex items-center justify-end">
    <a href="{{ route('users.index') }}"
        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 mr-2">
        Cancel
    </a>
    <button type="submit"
        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        {{ $buttonText ?? 'Save' }}
    </button>
</div>
