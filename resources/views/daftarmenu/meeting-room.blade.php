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

<section class="p-3">
    <div id="default-carousel" class="relative w-full" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative h-36 overflow-hidden rounded-2xl shadow-2xl md:h-96" style="background: #fff !important;">
            @foreach ($banners as $item)
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ 'https://managementvmond.controlindo.com/assets/images/banner/'.$item->image ?? ''}} " alt=""class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="p-3">
    <div class="flex items-center justify-between">
        <div class="">
            <span class="text-lg font-bold dark:text-white ml-1">EXCLUSIVE ROOM</span>
        </div>
        {{-- <div class="flex items-center">
            <span class="text-xs dark:text-white">Lihat Semua</span>
            <ion-icon name="chevron-forward-outline" class="dark:text-white"></ion-icon>
        </div> --}}
    </div>

    <div class="grid grid-cols-1">
        @foreach ($paket_menus as $item)
        {{-- {{ dd($image) }} --}}
        @if ($item->category == 'meeting_room')
        <div class="text-base sm:text-sm px-1 py-3">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                {{-- {{ dd($item) }} --}}

                <img src="{{'https://managementvmond.controlindo.com/assets/images/paket-menu/'. ($item->image ?? '') }}" alt="." class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-1 font-semibold dark:text-gray-300">{{ $item->nama_paket ?? 'Error' }}</p>
                <span class="block text-[10px] dark:text-red-500">Rp.{{ number_format($item->harga,2) }} </span>
                
                <div class="flex gap-1 opacity-75 mt-auto">
                    @foreach ($others as $other)
                    <button class="w-4/12 bg-orange-500 text-xs rounded-lg mt-2 p-1 hover:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-300" data-modal-target="description-modal-meeting{{ $item->id }}" data-modal-toggle="description-modal-meeting{{ $item->id }}"><ion-icon name="eye" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                    @if ($item->status_konfirmasi == 'Aktif')
                    
                    <form action="{{ route('detail-meeting',$item->id) }}" method="get" class=" w-full">
                        <div class="flex gap-1 opacity-75">
                            <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300"><ion-icon name="bag-add" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                        </div>
                    </form>
                    @else
                        {{-- <p class="mb-3 font-xs text-gray-700 dark:text-gray-400">Please Contact My Operator</p> --}}
                        <a href={{ "https://wa.me/+62".$other->no_wa }} class="w-full d-block">
                            <div class="sm:mt-3 inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-center text-white bg-teal-700 rounded-lg hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-teal-600 dark:hover:bg-teal-700 dark:focus:ring-blue-800 w-full">
                                <svg class="w-5 h-5 text-emerald-400" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                    <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/>
                                </svg>
                                Hubungi Admin
                            </div>
                        </a>
                    @endif

                    @endforeach
                </div>
            </div>
        </div>
        @include('modal.description-meeting-room')

        @endif
        @endforeach
       
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
