@extends('layouts.app')

@push('style-top')

@endpush

@push('style-bot')

@endpush

@section('content')
{{-- <section class="p-3">
    <div id="default-carousel" class="relative w-full" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative h-36 overflow-hidden rounded-2xl shadow-2xl md:h-96">
            <!-- Item 1 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://images.unsplash.com/photo-1563897539633-7374c276c212?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1046&q=80" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 2 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://images.unsplash.com/photo-1466814314367-45323ac74e2b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2085&q=80" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 3 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://images.unsplash.com/photo-1545062080-a71640ea75a1?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1469&q=80" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 4 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://images.unsplash.com/photo-1462826303086-329426d1aef5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
        </div>
        <!-- Slider indicators -->
        <div class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
            <button type="button" class="w-2 h-2 rounded-full" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
            <button type="button" class="w-2 h-2 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
            <button type="button" class="w-2 h-2 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
            <button type="button" class="w-2 h-2 rounded-full" aria-current="false" aria-label="Slide 4" data-carousel-slide-to="3"></button>
        </div>
    </div>
</section> --}}

<section class="p-3 mt-3">
    <div class="flex items-center justify-between border-b border-gray-400">
        <div class="">
            <span class="text-lg font-bold dark:text-white ml-1">MENU MAKANAN</span>
        </div>
    </div>

    <div class="grid grid-cols-1">
        @foreach ($restaurant as $item)
            @if ($item->category == 'Makanan')
            <div class="text-base flex gap-3 sm:text-sm px-1 py-3">
                <div class="relative max-w-sm h-24 w-24">
                    <a href="#">
                    <img class="rounded-lg" src="{{ $item->image ?? 'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=780&q=80'}} " alt="image description">
                    </a>
                    <span class="absolute bottom-0 inline-flex items-center justify-center w-full h-5 bg-red-800 border border-red-500 rounded-b-[.5rem] text-white text-xs">
                        Discount
                    </span>
                </div>
                <div class="grow px-1">
                    <p aria-hidden="true" class="text-xs mt-1 font-semibold dark:text-gray-300">{{ $item->nama ?? 'Error' }}</p>
                    <span class="block text-[8px] dark:text-yellow-300">Stock 100</span>
                    <div class="flex gap-2">
                        <span class="block text-[10px] text-white">Rp.{{ number_format($item->harga,2) }}</span>
                        <span class="block text-[8px] dark:text-red-500 line-through">Rp.{{ number_format($item->harga,2) }}</span>
                    </div>
                </div>
                <div class="shrink opacity-75 my-auto">
                    <button class="w-10 h-full block bg-orange-500 text-xs rounded-lg mb-2 p-1 hover:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-300" onclick="window.location='{{ route('detail-menu', ['type' => 'resto', 'slug' => $item->slug]) }}';"><ion-icon name="eye" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                    <form action="{{ route('restaurant-cart',$item->id) }}" method="get" class="w-10">
                        {{-- @csrf --}}
                        <div class="flex gap-1 opacity-75">
                            <input type="hidden" name="quantity" value="1" id="">
                            <input type="hidden" name="image" value="{{ $item->image }}" id="">
                            <input type="hidden" name="id" value="{{ $item->id }}" id="">
                            <button class="w-full h-full block bg-sky-500 text-xs rounded-lg p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300"><ion-icon name="bag-add" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="border-b border-gray-500"></div>
            @endif
        @endforeach
    </div>
</section>

<section class="p-3 mt-3">
    <div class="flex items-center justify-between border-b border-gray-400">
        <div class="">
            <span class="text-lg font-bold dark:text-white ml-1">MENU MINUMAN</span>
        </div>
    </div>

    <div class="grid grid-cols-1">
        @foreach ($restaurant as $item)
            @if ($item->category == 'Minuman')
            <div class="text-base flex gap-3 sm:text-sm px-1 py-3">
                <div class="relative max-w-sm h-24 w-24">
                    <a href="#">
                    <img class="rounded-lg" src="{{ $item->image ?? 'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=780&q=80'}} " alt="image description">
                    </a>
                    {{-- <span class="absolute top-0 right-0 inline-flex items-center justify-center w-6 h-6 bg-blue-600 rounded-full">
                        <svg aria-hidden="true" class="w-4 h-4 text-white" fill="currentColor" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><path d="M374.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-320 320c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l320-320zM128 128A64 64 0 1 0 0 128a64 64 0 1 0 128 0zM384 384a64 64 0 1 0 -128 0 64 64 0 1 0 128 0z"/></svg>
                    </span> --}}
                    <span class="absolute bottom-0 inline-flex items-center justify-center w-full h-5 bg-red-800 border border-red-500 rounded-b-[.5rem] text-white text-xs">
                        Discount
                    </span>
                </div>
                <div class="grow px-1">
                    <p aria-hidden="true" class="text-xs mt-1 font-semibold dark:text-gray-300">{{ $item->nama ?? 'Error' }}</p>
                    <span class="block text-[8px] dark:text-yellow-300">Stock 100</span>
                    <div class="flex gap-2">
                        <span class="block text-[10px] text-white">Rp.{{ number_format($item->harga,2) }}</span>
                        <span class="block text-[8px] dark:text-red-500 line-through">Rp.{{ number_format($item->harga,2) }}</span>
                    </div>
                </div>
                <div class="shrink opacity-75 my-auto">
                    <button class="w-10 h-full block bg-orange-500 text-xs rounded-lg mb-2 p-1 hover:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-300"><ion-icon name="eye" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                    <form action="{{ route('restaurant-cart',$item->id) }}" method="get" class="w-10">
                        {{-- @csrf --}}
                        <div class="flex gap-1 opacity-75">
                            <input type="hidden" name="quantity" value="1" id="">
                            <input type="hidden" name="image" value="{{ $item->image }}" id="">
                            <input type="hidden" name="id" value="{{ $item->id }}" id="">
                            <button class="w-full h-full block bg-sky-500 text-xs rounded-lg p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300"><ion-icon name="bag-add" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="border-b border-gray-500"></div>
            @endif
        @endforeach
    </div>
</section>

{{-- <section class="p-3">
    <div class="flex items-center justify-between">
        <div class="">
            <span class="text-lg font-bold dark:text-white ml-1">MENU DESERT</span>
        </div>

    </div>

    <div class="grid grid-cols-3">
        <div class="text-base sm:text-sm px-1 py-3">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="https://images.unsplash.com/photo-1568051243851-f9b136146e97?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=435&q=80" alt="." class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-1 font-semibold dark:text-gray-300">Raspberry waffles</p>
                <span class="block text-[10px] dark:text-red-500">Rp.45.000,00</span>

                <div class="flex gap-1 opacity-75 mt-auto">
                    <button class="w-4/12 bg-orange-500 text-xs rounded-lg mt-2 p-1 hover:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-300"><ion-icon name="eye" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                    <button class="w-8/12 bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300"><ion-icon name="bag-add" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                </div>
            </div>
        </div>
        <div class=" text-base sm:text-sm px-1 py-3">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="https://images.unsplash.com/photo-1558234469-50fc184d1cc9?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=387&q=80" alt="." class="object-cover object-center h-full w-full">
            </div>

            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-1 font-semibold dark:text-gray-300">Starwberry Cake</p>
                <span class="block text-[10px] dark:text-red-500">Rp.35.000,00</span>

                <div class="flex gap-1 opacity-75 mt-auto">
                    <button class="w-4/12 bg-orange-500 text-xs rounded-lg mt-2 p-1 hover:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-300"><ion-icon name="eye" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                    <button class="w-8/12 bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300"><ion-icon name="bag-add" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                </div>
            </div>
        </div>
        <div class=" text-base sm:text-sm px-1 py-3">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="https://images.unsplash.com/photo-1540713434306-58505cf1b6fc?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=387&q=80" alt="." class="object-cover object-center h-full w-full">
            </div>

            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-1 font-semibold dark:text-gray-300">vegan sandwich</p>
                <span class="block text-[10px] dark:text-red-500">Rp.30.000,00</span>

                <div class="flex gap-1 opacity-75 mt-auto">
                    <button class="w-4/12 bg-orange-500 text-xs rounded-lg mt-2 p-1 hover:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-300"><ion-icon name="eye" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                    <button class="w-8/12 bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300"><ion-icon name="bag-add" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                </div>
            </div>
        </div>
    </div>
</section> --}}


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
