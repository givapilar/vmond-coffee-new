@extends('layouts.app')

@push('style-top')

@endpush

@push('style-bot')

@endpush

@section('content')

<section class="p-3">
    <div class="flex items-center justify-between">
        <div class="">
            <span class="text-lg font-bold dark:text-white ml-1">MENU UTAMA</span>
        </div>

        {{-- @if (session('message'))
            <div class="text-lg font-bold dark:text-white ml-1">{{ session('message') }}</div>
        @endif --}}
        
    </div>

    <div class="grid grid-cols-3 gap-3">
        <a href="{{ route('daftar-restaurant') }}">
            <div class="text-base sm:text-sm p-1">
                <div class="aspect-h-1 h-36 sm:h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                    <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1074&q=80" alt="" class="object-cover object-center h-full w-full">
                </div>

                <p aria-hidden="true" class="text-sm text-center mt-1 dark:text-gray-300">Restaurant</p>
            </div>
        </a>
        <a href="{{ route('daftar-billiard') }}">
            <div class=" text-base sm:text-sm p-1">
                <div class="aspect-h-1 h-36 sm:h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                    <img src="https://images.unsplash.com/photo-1544070928-135893793bdc?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=627&q=80" alt="." class="object-cover object-center h-full w-full">
                </div>

                <p aria-hidden="true" class="text-sm text-center mt-1 dark:text-gray-300">Billiard</p>
            </div>
        </a>
        <a href="{{ route('daftar-meeting-room') }}">
            <div class="text-base sm:text-sm p-1">
                <div class="aspect-h-1 h-36 sm:h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                    <img src="https://images.unsplash.com/photo-1431540015161-0bf868a2d407?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80" alt="." class="object-cover object-center h-full w-full">
                </div>

                <p aria-hidden="true" class="text-sm text-center mt-1 dark:text-gray-300">Meeting Room</p>
            </div>
        </a>
    </div>
</section>

@if (count($response_data_banner) != null || count($response_data_banner) != 0)
<section class="p-3">
    <div id="default-carousel" class="relative w-full" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative h-48 sm:h-36 overflow-hidden rounded-2xl shadow-2xl">
            <!-- Item 1 -->
            @foreach ($response_data_banner as $item)
            {{-- {{ dd($item->image) }} --}}
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                {{-- <img src="https://images.unsplash.com/photo-1563897539633-7374c276c212?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1046&q=80" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="..."> --}}
                <img src="{{ $item->image ?? 'https://images.unsplash.com/photo-1563897539633-7374c276c212?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1046&q=80'}} " alt=""class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">

            </div>

            @endforeach
        </div>
        <!-- Slider indicators -->
        <div class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
            <button type="button" class="w-2 h-2 rounded-full" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
            <button type="button" class="w-2 h-2 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
            <button type="button" class="w-2 h-2 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
            <button type="button" class="w-2 h-2 rounded-full" aria-current="false" aria-label="Slide 4" data-carousel-slide-to="3"></button>
        </div>
    </div>
</section>
@endif

@if (count($response_data) != null || count($response_data) != 0)
<section class="p-3">
    <div class="flex items-center justify-between">
        <div class="">
            <span class="text-lg font-bold dark:text-white ml-1">MENU RESTAURANT</span>
        </div>
        <div class="flex items-center">
            <span class="text-xs dark:text-white">Lihat Semua</span>
            <ion-icon name="chevron-forward-outline" class="dark:text-white"></ion-icon>
        </div>
    </div>

    <div class="slick1 pt-2">
        @foreach ($response_data as $item)
        <div class="text-base sm:text-sm p-1">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="{{ $item->image ?? 'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=780&q=80'}} " alt="" class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-1 font-semibold dark:text-gray-300">{{ $item->nama ?? 'Error' }}</p>
                <span class="block text-[10px] dark:text-red-500">Rp.{{ number_format($item->harga,2) }}</span>

                <div class="flex justify-center gap-1">
                    <button class="w-4/12 bg-orange-500 text-xs rounded-lg mt-2 p-1 hover:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-300" onclick="window.location='{{ route('detail-menu', ['type' => 'resto', 'slug' => $item->slug]) }}';"><ion-icon name="eye" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                    <form action="{{ route('restaurant-cart',$item->id) }}" method="get" class=" w-8/12">
                        {{-- @csrf --}}
                        <div class="flex gap-1 opacity-75">
                            <input type="hidden" name="quantity" value="1" id="">
                            <input type="hidden" name="image" value="{{ $item->image }}" id="">
                            <input type="hidden" name="id" value="{{ $item->id }}" id="">
                                <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300"><ion-icon name="bag-add" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                            </div>
                        </div>
                </form>
                </div>
        </div>
        @endforeach
    </div>
</section>
@endif

@if (count($response_data_biliard) != null || count($response_data_biliard) != 0)
<section class="p-3">
    <div class="flex items-center justify-between">
        <div class="">
            <span class="text-lg font-bold dark:text-white ml-1">BILLIARD</span>
        </div>
        <div class="flex items-center">
            <span class="text-xs dark:text-white">Lihat Semua</span>
            <ion-icon name="chevron-forward-outline" class="dark:text-white"></ion-icon>
        </div>
    </div>

    <div class="slick1 pt-2">
        @foreach ($response_data_biliard as $biliard)
        <div class="text-base sm:text-sm p-1">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                {{-- <img src="https://images.unsplash.com/photo-1535066925810-38b22c6b8255?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1372&q=80" alt="" class="object-cover object-center h-full w-full"> --}}
                <img src="{{ $biliard->image ?? 'https://images.unsplash.com/photo-1535066925810-38b22c6b8255?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1372&q=80'}} " alt="" class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-1 font-semibold dark:text-gray-300">{{ $biliard->nama }} #{{ $biliard->no_meja }}</p>
                <span class="block text-[10px] dark:text-red-500">Rp.{{ number_format($biliard->harga,2) }} / Jam</span>

                <div class="flex gap-1 opacity-75">
                    <button class="w-4/12 bg-orange-500 text-xs rounded-lg mt-2 p-1 hover:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-300" onclick="window.location='{{ route('detail-menu', ['type' => 'billiard', 'slug' => $biliard->slug]) }}';"><ion-icon name="eye" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                    <button class="w-8/12 bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300" onclick="location.href='{{ route('cart-biliard-edit',$biliard->id) }}';"><ion-icon name="book" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

@if (count($response_data_meeting_room) != null || count($response_data_meeting_room) != 0)
<section class="p-3">
    <div class="flex items-center justify-between">
        <div class="">
            <span class="text-lg font-bold dark:text-white ml-1">MEETING ROOM</span>
        </div>
        <div class="flex items-center">
            <span class="text-xs dark:text-white">Lihat Semua</span>
            <ion-icon name="chevron-forward-outline" class="dark:text-white"></ion-icon>
        </div>
    </div>

    <div class="meeting-rooms pt-2">
        @foreach ($response_data_meeting_room as $meeting_room)
        <div class="text-base sm:text-sm p-1">
            <div class="aspect-h-1 h-36 sm:h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="{{ $meeting_room->image ?? 'https://images.unsplash.com/photo-1462826303086-329426d1aef5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80'}} " alt="" class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-1 font-semibold dark:text-gray-300">{{ $meeting_room->nama }}</p>
                <span class="block text-[10px] dark:text-red-500">Rp.{{ number_format($meeting_room->harga,2) }} / Jam</span>

                    <div class="flex gap-1 opacity-75">
                        <input type="hidden" name="quantity" value="1" id="">
                        <input type="hidden" name="id" value="{{ $meeting_room->id }}" id="">
                        <button class="w-4/12 bg-orange-500 text-xs rounded-lg mt-2 p-1 hover:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-300" onclick="window.location='{{ route('detail-menu', ['type' => 'meetingroom', 'slug' => $meeting_room->slug]) }}';"><ion-icon name="eye" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                        <button class="w-8/12 bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300" onclick="location.href='{{ route('cart-meeting-edit',$meeting_room->id) }}';"><ion-icon name="book" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                    </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

<div class="pb-[5rem]"></div>
@endsection

@push('script-top')

@endpush

@push('script-bot')
<script>
    $('.slick1').slick({
        infinite:false,
        arrows: false,
        slidesToShow: 5,
        slidesToScroll: 1,
        autoplay: false,
        speed:200,
        responsive: [
            {
            breakpoint: 1024,
                settings: {
                    slidesToShow: 4,
                }
            },
            {
            breakpoint: 800,
                settings: {
                    slidesToShow: 4,
                }
            },
            {
            breakpoint: 480,
                settings: {
                    slidesToShow: 3,
                }
            }
        ]
    });
    $('.meeting-rooms').slick({
        infinite:false,
        arrows: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: false,
        speed:200,
    });

//     Toastify({

// text: "This is a toast",

// duration: 3000

// }).showToast();

 </script>

 


@endpush
