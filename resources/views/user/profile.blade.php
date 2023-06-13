@extends('layouts.app')

@push('style-top')

@endpush

@push('style-bot')

@endpush

@section('content')

<script src="https://cdn.tailwindcss.com/3.1.4"></script>

<div class="">
    <div class="mx-auto py-8 px-6">
        <div class="grid grid-cols-4 px-0 gap-2 sm:grid-cols-12 lg:px-4 lg:gap-2">
            <div class="col-span-4 sm:col-span-4">
                <div class="bg-white shadow rounded-lg p-6 dark:bg-gray-800">
                    <div class="flex flex-col items-center">
                        <img src="{{ asset('assetku/dataku/img/user/'.($user->avatar ?? 'default.png')) }}" class="w-32 h-32 bg-gray-300 rounded-full mb-4 shrink-0">
                        <h1 class="text-xl font-bold dark:text-white">{{ $user->username ?? 'Guest' }}</h1>
                        <p class="text-gray-600 dark:text-gray-400">{{ $user->membership ?? '-' }}</p>
                        <div class="mt-6 flex flex-wrap gap-4 justify-center">
                            {{-- <a href="javascript:void(0)" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">Contact</a>
                            <a href="javascript:void(0)" class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded">Resume</a> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-4 sm:col-span-8">
                <form action="{{route('update-account', Crypt::encryptString('update-'.$user->id.'-encrypt')) }}" method="POST" enctype="multipart/form-data">
                    @method('patch')
                    @csrf
                    <div class="bg-white shadow rounded-lg p-6 dark:bg-gray-800">
                        <h2 class="text-xl font-bold mb-4 dark:text-white text-center">Change Data</h2>
                        <div class="mb-4">
                            <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                            <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') ?? $user->username }}"  placeholder="Enter Username">
                            @error('username')
                                <span class="text-xs text-red-700">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="telephone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone Number</label>
                            <input id="telephone" type="tel" value="{{ $user->telephone }}" name="telephone" aria-label="Please enter your phone number" placeholder="08xx-xxxx-xxxx" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('telephone') is-invalid @enderror">
                            @error('telephone')
                                <span class="text-xs text-red-700">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4 text-center">
                            <img src="{{ asset('assetku/dataku/img/user/'.($user->avatar ?? 'default.png')) }}" width="110px" class="image img block mx-auto" />
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="avatar">Upload file</label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="avatar" name="avatar" type="file">
                        </div>

                        @if (Auth::user()->id == $user->id)
                            <div class="mb-4" x-data="{ show: true }">
                                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Old Password</label>
                                <div class="relative">
                                    <input placeholder="*******" name="password" id="password" :type="show ? 'password' : 'text'" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('password') is-invalid @enderror">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">

                                    <svg class="h-4 text-gray-300" fill="none" @click="show = !show" :class="{'hidden': !show, 'block':show }" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 576 512">
                                        <path fill="currentColor" d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                                        </path>
                                    </svg>

                                    <svg class="h-4 text-gray-300" fill="none" @click="show = !show" :class="{'block': !show, 'hidden':show }" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 640 512">
                                        <path fill="currentColor" d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z">
                                        </path>
                                    </svg>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="text-xs text-red-700">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4" x-data="{ show: true }">
                                <label for="new_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">New Password</label>
                                <div class="relative">
                                    <input placeholder="*******" name="new_password" id="new_password" :type="show ? 'password' : 'text'" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('new_password') is-invalid @enderror">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                                        <svg class="h-4 text-gray-300" fill="none" @click="show = !show" :class="{'hidden': !show, 'block':show }" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 576 512">
                                            <path fill="currentColor" d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                                            </path>
                                        </svg>

                                        <svg class="h-4 text-gray-300" fill="none" @click="show = !show" :class="{'block': !show, 'hidden':show }" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 640 512">
                                            <path fill="currentColor" d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                @error('new_password')
                                    <span class="text-xs text-red-700">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        @endif
                        <div class="mb-4">
                            <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                            {{-- <input type="text" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nathan Alexander" required> --}}
                            <textarea name="address" id="address" rows="5" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $user->address }}</textarea>
                        </div>

                        <div class="flex gap-3 mt-3">
                            <a href="{{ route('homepage') }}" class="w-full text-white bg-zinc-600 hover:bg-zinc-700 focus:ring-4 focus:outline-none focus:ring-zinc-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-zinc-600 dark:hover:bg-zinc-700 dark:focus:ring-zinc-800">Kembali</a>
                            <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="pb-[5rem]"></div>

@endsection
