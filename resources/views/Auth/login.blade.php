@extends('Auth.layouts.app')

@section('content')
<section class="bg-gray-50 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center h-screen px-6 py-8 mx-auto md:h-screen lg:h-screen lg:py-0">
        <div class=" text-center">
            <img class="w-44 h-44 rounded-full mx-auto" src="https://lh3.googleusercontent.com/p/AF1QipPaC8tMUrKh3aVYC6PgdUTDcZj49xkMxqAXswqb=s680-w680-h510" alt="logo">
            <h1 class="text-[40px] mt-2 font-bold leading-tight tracking-[0.7rem] text-center text-gray-900 md:text-2xl lg:text-2xl dark:text-white">
                VMOND
            </h1>
            <span class="text-[40px] font-light leading-tight tracking-[0.7rem] text-center text-gray-900 dark:text-white">
                CAFE
            </span>
        </div>
        <div class="w-full bg-transparent md:mt-0 max-w-md xl:p-0">
            <div class="px-6 py-2 space-y-4 md:space-y-6 ">

                <form class="space-y-4 md:space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                              <input id="remember" aria-describedby="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800" required="">
                            </div>
                            <div class="ml-3 text-sm">
                              <label for="remember" class="text-gray-500 dark:text-gray-300">Remember me</label>
                            </div>
                        </div>
                        <a href="#" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">Forgot password?</a>
                    </div>
                    <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Sign in</button>
                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        Don’t have an account yet? <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:underline dark:text-blue-500">Sign up</a>
                    </p>
                    <span class="text-sm font-light text-gray-500 dark:text-gray-400">
                        log in as a guest? <a href="{{ route('homepage') }}" class="font-medium text-blue-600 hover:underline dark:text-blue-500">Click here</a>
                    </span>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
