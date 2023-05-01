@extends('layouts.app')

@push('style-top')

@endpush

@push('style-bot')

@endpush

@section('content')
<section class="p-3">
    <div class="max-w-sm bg-white border border-gray-200 rounded-[30px] shadow dark:bg-gray-800 dark:border-gray-700">
        <a href="#">
            <img class="rounded-t-[30px] brightness-75" src="https://images.unsplash.com/photo-1563379926898-05f4575a45d8?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80" alt="" />
        </a>
        <div class="p-5">
            <a href="#">
                <h5 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">DETAIL - MENU MAKANAN</h5>
                <h6 class="mb-3 text-xl font-semibold tracking-tight text-yellow-400">Seafood pasta with shrimps and tomatoes</h6>
            </a>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Seafood pasta with shrimps and tomatoes is a delicious and easy-to-make pasta dish that is perfect for seafood lovers. The dish typically consists of pasta noodles, cooked shrimp, and diced tomatoes, all tossed together in a flavorful sauce.</p>
            <a href="#" class="sm:mt-3 inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-full">
                Add to cart
            </a>
        </div>
    </div>
</section>

<div class="pb-[5rem]"></div>
@endsection

@push('script-top')

@endpush

@push('script-bot')
<script>
    $('.slick1').slick({
        infinite:false,
        arrows: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: false,
        speed:200,
    });
 </script>
@endpush
