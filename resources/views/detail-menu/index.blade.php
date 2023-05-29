@extends('layouts.app')

@push('style-top')

@endpush

@push('style-bot')

@endpush

@section('content')
{{-- {{ dd($getJSON) }} --}}
<section class="p-3">
    <div class="max-w-full sm:max-w-full mx-auto bg-white border border-gray-200 rounded-[30px] shadow dark:bg-gray-800 dark:border-gray-700">
        <div class="flex justify-center align-center bg-gray-400 max-h-64 h-64 sm:h-56 rounded-t-[30px]">
            <img class="rounded-t-[30px] brightness-75 w-full bg-cover bg-center" src="{{ $getJSON->data[0]->image }}" alt="" />
        </div>
        <div class="p-5">
            <div>
                <h5 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">DETAIL - {{ $getJSON->data[0]->type ?? 'Not found' }} </h5>
                <h6 class="mb-0 text-xl font-semibold tracking-tight text-yellow-400">{{ $getJSON->data[0]->nama ?? 'Not found' }}</h6>
                <p class="mb-3 mt-0 font-normal text-red-600 dark:text-red-600">Rp.{{ $getJSON->data[0]->harga ?? '0-,' }}</p>
            </div>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{!! $getJSON->data[0]->description ?? 'Not found' !!}</p>
            <div class="sm:mt-3 inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-full">
                Add to cart
            </div>
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
