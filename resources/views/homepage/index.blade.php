@extends('layouts.app')

@push('style-top')
<style>
    .billiard{
        margin-top: -143px;
        height: auto;
    }

    @media (max-width: 640px) {
        .billiard {
            margin-top: -40px; /* Adjust this value based on your preference */
        }
    }
</style>
@endpush

@push('style-bot')

@endpush

@section('content')
<section>
    <div class=" w-11/12 mt-5 p-4 bg-[#1d2943] border border-gray-200 rounded-lg shadow mx-auto dark:bg-[#1d2943] dark:border-[#16274b]">
        <div class="grid grid-cols-1">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 bg-white rounded-full p-2">
                    <svg class="w-6 h-6 text-[#1d2943]" fill="currentColor"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <path d="M64 32C28.7 32 0 60.7 0 96v32H576V96c0-35.3-28.7-64-64-64H64zM576 224H0V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V224zM112 352h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm112 16c0-8.8 7.2-16 16-16H368c8.8 0 16 7.2 16 16s-7.2 16-16 16H240c-8.8 0-16-7.2-16-16z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                        Total Transaksi 
                    </p>
                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                        Meja
                        {{ $kodeMeja }}
                    </p>
                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                        @if (Auth::check())
                            Rp. {{ number_format($orderFinishSubtotal, 0) ?? '' }}
                            ( {{ ucwords(Auth::user()->membership->level ?? '') }} Member )
                        @else
                            Daftarkan <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:underline dark:text-blue-500">akun anda</a>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="p-3 mt-1">
    <div class="flex items-center justify-between mb-1">
        <div class="">
            <span class="text-lg font-bold dark:text-white ml-1">MAIN MENU</span>
        </div>

        {{-- @if (session('message'))
            <div class="text-lg font-bold dark:text-white ml-1">{{ session('message') }}</div>
        @endif --}}

    </div>

    <div class="grid grid-cols-3 gap-3">
        <a href="{{ route('homepage-restaurant') }}">
            <div class="text-base sm:text-sm p-1">
                <div class="aspect-h-1 h-36 sm:h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75 border border-[#16274b] shadow-lg">
                    <img src="{{ asset('assetku/dataku/img/resto.jpg') }}" alt="" class="object-cover h-full w-full">
                    {{-- <span class="absolute top-0 left-0 inline-flex items-center justify-center w-6 h-6 bg-blue-600 rounded-full">
                        <svg aria-hidden="true" class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Message icon</span>
                    </span> --}}
                </div>

                <p aria-hidden="true" class="text-sm text-center mt-1 dark:text-gray-300" style="font-weight: 500;">RESTAURANT</p>
            </div>
        </a>
        <a href="{{ route('daftar-billiard') }}">
            <div class="text-base sm:text-sm p-1">
                <div class="aspect-h-1 h-36 sm:h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75 border border-[#16274b] shadow-lg">
                    <img src="{{ asset('assetku/dataku/img/billiard.jpg') }}" alt="" class="object-cover object-center h-full w-full billiard">
                </div>

                <p aria-hidden="true" class="text-sm text-center mt-1 dark:text-gray-300" style="font-weight: 500;">F w B</p>
            </div>
        </a>
        <a href="{{ route('daftar-meeting-room') }}">
            <div class="text-base sm:text-sm p-1">
                <div class="aspect-h-1 h-36 sm:h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75 border border-[#16274b] shadow-lg">
                    <img src="https://images.unsplash.com/photo-1431540015161-0bf868a2d407?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80" alt="." class="object-cover object-center h-full w-full">
                </div>

                <p aria-hidden="true" class="text-sm text-center mt-1 dark:text-gray-300" style="font-weight: 500;">EXCLUSIVE ROOM</p>
            </div>
        </a>
    </div>
</section>

@if (count($response_data_banner) != null || count($response_data_banner) != 0)
<section class="p-3">
    <div id="default-carousel" class="relative w-full" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative h-48 sm:h-36 overflow-hidden rounded-2xl shadow-2xl border border-[#16274b] shadow-lg" style="background: #fff !important;">
            <!-- Item 1 -->
            @foreach ($response_data_banner as $item)
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ $item->image ?? ''}} " alt=""class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
            </div>
            @endforeach
            {{-- {{ dd($response_data_banner) }} --}}
            {{-- <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ asset('assetku/dataku/img/logo/logo-vmond.png') }}" class="absolute block w-25 -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 2 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ asset('assetku/dataku/img/logo/logo-vmond.png') }}" class="absolute block w-25 -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 3 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ asset('assetku/dataku/img/logo/logo-vmond.png') }}" class="absolute block w-25 -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 4 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ asset('assetku/dataku/img/logo/logo-vmond.png') }}" class="absolute block w-25 -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div> --}}
        </div>

        <!-- Slider indicators -->
        {{-- <div class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
            <button type="button" class="w-2 h-2 rounded-full" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
            <button type="button" class="w-2 h-2 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
            <button type="button" class="w-2 h-2 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
            <button type="button" class="w-2 h-2 rounded-full" aria-current="false" aria-label="Slide 4" data-carousel-slide-to="3"></button>
        </div> --}}
    </div>
</section>
@endif

{{-- @if (count($response_data) != null || count($response_data) != 0)
<section class="p-3">
    <div class="flex items-center justify-between">
        <div class="">
            <span class="text-lg font-bold dark:text-white ml-1">MENU RESTAURANT</span>
        </div>
        <a class="flex items-center" href="{{ route('daftar-restaurant') }}">
            <span class="text-xs dark:text-white">Lihat Semua</span>
            <ion-icon name="chevron-forward-outline" class="dark:text-white"></ion-icon>
        </a>
    </div>

    <div class="slick1 pt-2">
        @foreach ($response_data as $item)
        <div class="text-base sm:text-sm p-1">
            <div class="relative max-w-sm">
                <a href="#">
                  <img class="rounded-lg" src="{{ $item->image ?? 'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=780&q=80'}} " alt="image description">
                </a>

                <span class="absolute bottom-0 inline-flex items-center justify-center w-full h-5 bg-red-800 border border-red-500 rounded-b-[.5rem] text-white text-xs">
                    Discount
                </span>
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-1 font-semibold dark:text-gray-300">{{ $item->nama ?? 'Error' }}</p>
                <span class="block text-[8px] dark:text-yellow-300">Stock 100</span>
                <div class="flex gap-2">
                    <div class="flex-1">
                        <span class="block text-[10px] text-white">Rp.{{ number_format($item->harga,2) }}</span>
                    </div>
                    <div class="flex-1">
                        <span class="block text-[8px] dark:text-red-500 line-through">Rp.{{ number_format($item->harga,2) }}</span>
                    </div>
                </div>

                <div class="flex justify-center gap-1">
                    <button class="w-4/12 bg-orange-500 text-xs rounded-lg mt-2 p-1 hover:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-300" onclick="window.location='{{ route('detail-menu', ['type' => 'resto', 'slug' => $item->slug]) }}';"><ion-icon name="eye" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                    <form action="{{ route('restaurant-cart',$item->id) }}" method="get" class=" w-8/12">
                        <div class="flex gap-1 opacity-75">
                            <input type="hidden" name="quantity" value="1" id="">
                            <input type="hidden" name="image" value="{{ $item->image }}" id="">
                            <input type="hidden" name="id" value="{{ $item->id }}" id="">
                            <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300"><ion-icon name="bag-add" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                        </div>
                    </form>
                </div>
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
                        <button class="w-8/12 bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300" onclick="location.href='{{ route('cart-meeting-edit',$meeting_room->id) }}';"><ion-icon name="call-outline" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                    </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif --}}

{{-- <div class="grid grid-cols-3 gap-3">
    <div class="text-base sm:text-sm p-1">
        <div id="reader" class="text-sm text-center mt-1 dark:text-gray-300" width="600px"></div>
    </div>
</div> --}}

{{-- <div id="reader" class="" style="color: white;" width="600px"></div> --}}
<div class="pb-[5rem]"></div>
@endsection

@push('script-top')

@endpush

@push('script-bot')

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"> </script>

<script>
    function onScanSuccess(decodedText, decodedResult) {
    // handle the scanned code as you like, for example:
    console.log(`Code matched = ${decodedText}`, decodedResult);
    }

    function onScanFailure(error) {
    // handle scan failure, usually better to ignore and keep scanning.
    // for example:
    // console.warn(`Code scan error = ${error}`);
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    { fps: 10, qrbox: {width: 250, height: 250} },
    /* verbose= */ false);
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>


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
