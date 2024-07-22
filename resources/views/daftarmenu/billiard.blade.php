@extends('layouts.app')

@push('style-top')

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
                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                        @if (Auth::check())
                            @if (Auth::user()->is_worker == true)

                            @else
                            Rp. {{ number_format($orderFinishSubtotal, 0) ?? '' }}
                            @endif
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

<section class="p-3">
    <div id="default-carousel" class="relative w-full" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative h-36 overflow-hidden rounded-2xl shadow-2xl md:h-96" style="background: #fff !important;">
            @foreach ($banners as $item)
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ 'https://managementvmond.controlindo.com/assets/images/banner/'.$item->image ?? ''}} " alt=""class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
            </div>
            @endforeach
            {{-- <!-- Item 1 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
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
<section class="p-3">
    <div class="flex items-center justify-between">
        <div class="">
            <span class="text-lg font-bold dark:text-white ml-1">Food with Billiard</span>
        </div>
    </div>

    <div class="grid grid-cols-1">

        @foreach ($paket_menus as $item)
            @if ($item->category == 'billiard')
                {{-- {{ dd($rest_api_url) }} --}}
            <div class="text-base sm:text-sm px-1 py-3">
                <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                    <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" alt="." class="object-cover object-center h-full w-full">
                </div>
                <div class="px-1">
                    <p aria-hidden="true" class="text-xs mt-1 font-semibold dark:text-gray-300">{{ $item->nama_paket ?? 'Error' }}</p>
                    <span class="block text-[10px] dark:text-red-500">Rp.{{ number_format($item->harga,2) }} </span>

                    <div class="flex gap-1 opacity-75 mt-auto">
                        {{-- <button class="w-4/12 bg-orange-500 text-xs rounded-lg mt-2 p-1 hover:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-300"><ion-icon name="eye" class="mt-[0.2rem] dark:text-white"></ion-icon></button> --}}
                        <button class="w-4/12 bg-orange-500 text-xs rounded-lg mt-2 p-1 hover:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-300" data-modal-target="description-modal{{ $item->id }}" data-modal-toggle="description-modal{{ $item->id }}"><ion-icon name="eye" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                        {{-- <button class="w-8/12 bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300"><ion-icon name="bag-add" class="mt-[0.2rem] dark:text-white"></ion-icon></button> --}}
                        @if (Auth::check())
                        <form action="{{ route('detail-billiard',$item->id) }}" method="get" class=" w-8/12">
                            <div class="flex gap-1 opacity-75">
                                @if ($item->status == "Tersedia")
                                <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300"><ion-icon name="bag-add" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                                @else
                                <button class="w-full text-gray-500 text-xs rounded-lg mt-2 p-1 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-sky-300 dark:text-white flex items-center justify-center" style="background-color: gray;" disabled>
                                    <ion-icon name="bag-add" class="mt-[0.2rem] mb-1 dark:text-white" style="font-size: 15px; margin-right: 5px;"></ion-icon>
                                </button>
                                @endif
                            </div>
                        </form>
                        @else
                        <form action="{{ route('detail-billiard-guest',$item->id) }}" method="get" class=" w-8/12">
                            <div class="flex gap-1 opacity-75">
                                @if ($item->status == "Tersedia")
                                <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300"><ion-icon name="bag-add" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                                @else
                                <button class="w-full text-gray-500 text-xs rounded-lg mt-2 p-1 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-sky-300 dark:text-white flex items-center justify-center" style="background-color: gray;" disabled>
                                    <ion-icon name="bag-add" class="mt-[0.2rem] mb-1 dark:text-white" style="font-size: 15px; margin-right: 5px;"></ion-icon>
                                </button>
                                @endif
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
                @include('modal.description-billiard')
            </div>
            @endif
        @endforeach

        @if(Auth::user())
        @if(Auth::user()->telephone == '081818181847')
            <div class="text-base sm:text-sm px-1 py-3">
                <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                    <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" alt="." class="object-cover object-center h-full w-full">
                </div>
                <div class="px-1">
                    <p aria-hidden="true" class="text-xs mt-1 font-semibold dark:text-gray-300">Open Bill Package</p>
                    <span class="block text-[10px] dark:text-red-500">Rp.- </span>

                    <div class="flex gap-1 opacity-75 mt-auto">
                        <form action="{{ route('detail-billiard-openbill') }}" method="get" class=" w-8/12">
                            <div class="flex gap-1 opacity-75">
                                <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300"><ion-icon name="bag-add" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        @endif
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
        arrows: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        speed:200,
    });
 </script>


@endpush
