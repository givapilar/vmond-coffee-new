@extends('Auth.layouts.app')

@section('content')
<section class="bg-gray-50 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center h-screen px-6 py-8 mx-auto md:h-screen lg:h-screen lg:py-0">
        <div class=" text-center">
            <img class="mx-auto" src="{{ asset('assetku/dataku/img/logo/logo-vmond.png') }}" alt="logo">
            {{-- <h1 class="text-[40px] mt-2 font-bold leading-tight tracking-[0.7rem] text-center text-gray-900 dark:text-white">
                VMOND
            </h1>
            <span class="text-[40px] font-light leading-tight tracking-[0.7rem] text-center text-gray-900 dark:text-white">
                CAFE
            </span> --}}
        </div>
        <div class="w-full bg-transparent md:mt-0 max-w-md xl:p-0">
            <div class="px-6 py-2 space-y-4 md:space-y-6 ">

                <form class="space-y-4 md:space-y-6" action="{{ route('login', ['jenis_meja' => Request::get('jenis_meja'), 'kode_meja' => Request::get('kode_meja')]) }}" method="POST">
                    @csrf
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username / Phone Number</label>
                        <input type="text" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('email') is-invalid @enderror" placeholder="member" required="">

                        @error('email')
                            <span class="text-xs text-red-700">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div x-data="{ show: true }">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        {{-- <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required=""> --}}
                        <div class="relative">
                            <input placeholder="*******"  name="password" id="password" :type="show ? 'password' : 'text'" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('password') is-invalid @enderror">
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
                    <div class="flex items-center justify-between">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                              <input id="remember" aria-describedby="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800">
                            </div>
                            <div class="ml-3 text-sm">
                              <label for="remember" class="text-gray-500 dark:text-gray-300">Remember me</label>
                            </div>
                        </div>
                        <a href="#" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">Forgot password?</a>
                    </div>
                    <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Sign in</button>
                    <hr>
                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        Don’t have an account yet? 
                    </p>
                    {{-- <button type="button" onClick="window.location = '{{ route('register') }}';" class="w-full text-white bg-orange-600 hover:bg-orange-700 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800" style="width: 100% !important;">Sign up</button> --}}
                    <button type="button" onClick="window.location = '{{ route('register', ['jenis_meja' => Request::get('jenis_meja'), 'kode_meja' => Request::get('kode_meja')]) }}';" class="w-full text-white bg-orange-600 hover:bg-orange-700 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800" style="width: 100% !important;">Sign up</button>
                    
                    <br>
                    <br>
                    <span class="text-sm font-light text-gray-500 dark:text-gray-400">
                        log in as a non member? <a href="{{ route('homepage', ['jenis_meja' => Request::get('jenis_meja'), 'kode_meja' => Request::get('kode_meja')]) }}" class="font-medium text-blue-600 hover:underline dark:text-blue-500">Click here</a>
                    </span>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
