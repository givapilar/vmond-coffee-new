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

    .skeleton {
        animation: loading 1.5s infinite;
    }

    @keyframes loading {
        0% {
            background-position: 200% 0;
        }
        100% {
            background-position: -200% 0;
        }
}

</style>
@endpush

@push('style-bot')

@endpush

@section('content')

<section>
    <div class=" w-11/12 mt-5 p-4 bg-[#1d2943] border border-gray-200 rounded-lg shadow mx-auto dark:bg-[#1d2943] dark:border-[#16274b] ">
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
                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                        @if (Auth::check())
                            @if (Auth::user()->is_worker == true)
                            
                            @else
                            Rp. {{ number_format($orderFinishSubtotal, 0) ?? '' }}
                            @endif
                            ( {{ ucwords(Auth::user()->membership->level ?? '') }} Member )
                        @else
                            Daftarkan <a href="{{ route('register', ['meja' => Request::get('meja'),'jenis_meja' => Request::get('jenis_meja'), 'kode_meja' => Request::get('kode_meja')]) }}" class="font-medium text-blue-600 hover:underline dark:text-blue-500">akun anda</a>
                        @endif
                    </p>
                </div>
                <div class="flex-shrink-0 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                        @if($meja != null)
                        {{ $meja }}
                        @endif

                        @if($kodeMeja != null)
                        Meja
                        {{ $kodeMeja }}
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
    </div>

    <div class="grid grid-cols-3 gap-3">
        <a href="{{ route('homepage-restaurant', ['meja' => Request::get('meja'),'jenis_meja' => Request::get('jenis_meja'), 'kode_meja' => Request::get('kode_meja')]) }}">
            <div class="text-base sm:text-sm p-1">
                <div class="aspect-h-1 h-36 sm:h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75 border border-[#16274b] shadow-lg skeleton">
                    <img src="{{ asset('assetku/dataku/img/resto.jpg') }}" alt="" class="object-cover h-full w-full">
                </div>

                <p aria-hidden="true" class="text-sm text-center mt-1 dark:text-gray-300" style="font-weight: 500;">RESTAURANT</p>
            </div>
        </a>
        <a href="{{ route('daftar-billiard', ['meja' => Request::get('meja'),'jenis_meja' => Request::get('jenis_meja'), 'kode_meja' => Request::get('kode_meja')]) }}">
            <div class="text-base sm:text-sm p-1">
                <div class="aspect-h-1 h-36 sm:h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75 border border-[#16274b] shadow-lg skeleton">
                    <img src="{{ asset('assetku/dataku/img/billiard.jpg') }}" alt="" class="object-cover object-center h-full w-full billiard">
                </div>

                <p aria-hidden="true" class="text-sm text-center mt-1 dark:text-gray-300" style="font-weight: 500;">BILLIARD</p>
            </div>
        </a>
        <a href="{{ route('daftar-meeting-room', ['meja' => Request::get('meja'),'jenis_meja' => Request::get('jenis_meja'), 'kode_meja' => Request::get('kode_meja')]) }}">
            <div class="text-base sm:text-sm p-1">
                <div class="aspect-h-1 h-36 sm:h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75 border border-[#16274b] shadow-lg skeleton">
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
        <div class="relative h-48 sm:h-36 overflow-hidden rounded-2xl shadow-2xl border border-[#16274b] shadow-lg" style="background: #fff !important;">
            @foreach ($response_data_banner as $item)
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ $item->image ?? ''}} " alt=""class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<div class="pb-[5rem]"></div>
@endsection

@push('script-top')

@endpush

@push('script-bot')

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"> </script>

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
</script>
@endpush
