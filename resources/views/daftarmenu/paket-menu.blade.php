@extends('layouts.app')

@push('style-top')

@endpush

@push('style-bot')
<style>
    .swiper-button-next svg, .swiper-button-prev svg {
        width:20% !important;
    }

    .skeleton {
    /* width: 100%;
    height: 100%;
    background-size: 200% 100%; */
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

@section('content')

<section>
    <div id="myTabContent">
        {{-- <div class="hidden pt-0 px-4 pb-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="{{ strtolower(str_replace(' ','',$item->tag_name)) }}" role="tabpanel" aria-labelledby="{{ strtolower(str_replace(' ','',$item->tag_name)) }}-tab"> --}}
            <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
            <div class="grid grid-cols-2">
                @foreach ($paket_menus as $paket_menu)
                {{-- @foreach ($paket_menu->restaurantTag as $pivot) --}}
                @if ($paket_menu->category == 'paket_menu')
                <div class="text-base sm:text-sm px-1 py-3">
                    <div class="aspect-h-1 h-40 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75 skeleton">
                        
                        @if ($paket_menu->image != null)
                        <img src="{{ $global_url_image.$paket_menu->image ?? 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80' }}" alt="." class="object-cover object-center h-full w-full">
                        
                        @else
                        <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" alt="." class="object-cover object-center h-full w-full">
                        @endif

                           
                    </div>
                    <div class="px-1">
                        <p aria-hidden="true" class="text-xs mt-1 font-semibold dark:text-gray-300">{{ $paket_menu->nama_paket ?? 'Error' }}</p>
                        {{-- <span class="block text-[10px] dark:text-yellow-300">Stock {{ $paket_menu->current_stok }}</span> --}}
                        <span class="block text-[10px] dark:text-red-500">Rp.{{ number_format($paket_menu->harga_diskon,2) }} </span>
                        
                        <div class="flex gap-1 opacity-75 mt-auto">
                            {{-- <button class="w-4/12 bg-orange-500 text-xs rounded-lg mt-2 p-1 hover:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-300" data-modal-target="description-modal-paket_menu{{ $paket_menu->id }}" data-modal-toggle="description-modal-paket_menu{{ $paket_menu->id }}"><ion-icon name="eye" class="mt-[0.2rem] dark:text-white"></ion-icon></button> --}}
                            <button class="w-4/12 bg-orange-500 text-xs rounded-lg mt-2 p-1 hover:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-300 dark:text-white flex items-center justify-center" data-modal-target="description-modal-paket_menu{{ $paket_menu->id }}" data-modal-toggle="description-modal-paket_menu{{ $paket_menu->id }}">
                                <ion-icon name="eye" class="mt-[0.2rem] mb-1 dark:text-white" style="margin-right: 5px;"></ion-icon>
                                <p class="mt-1 mb-1">Detail</p>
                            </button>
                            {{-- {{ dd($paket_menu->status) }} --}}
                            <form action="{{ route('detail-paket-menu',$paket_menu->id) }}" method="get" class=" w-8/12">
                                <div class="flex gap-1 w-full">
                                    @if ($paket_menu->status == 'Tersedia')
                                    <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300 dark:text-white flex items-center justify-center">
                                        <ion-icon name="cart" class="mt-[0.2rem] mb-1 dark:text-white" style="font-size: 15px; margin-right: 5px;"></ion-icon>
                                        <p class="mt-1 mb-1">Add to Cart</p>
                                    </button>
                                    @else
                                    <button class="w-full text-gray-500 text-xs rounded-lg mt-2 p-1 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-sky-300 dark:text-white flex items-center justify-center" style="background-color: gray;" disabled>
                                        <ion-icon name="cart" class="mt-[0.2rem] mb-1 dark:text-white" style="font-size: 15px; margin-right: 5px;"></ion-icon>
                                        <p class="mt-1 mb-1">Sold Out</p>
                                    </button>
                                    @endif
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                @endif
                {{-- @include('modal.description') --}}
                @endforeach
                {{-- @endforeach  --}}
            </div>
        {{-- </div> --}}
    </div>
</section>

<div class="pb-[4rem]"></div>


@endsection

@push('script-top')

@endpush

@push('script-bot')

<script>
    $(document).ready(function() {
       
        
        // Menghitung panjang huruf untuk setiap tab
        var tabLengths = [];
        $('#myTab li').each(function(index) {
            var tabText = $(this).text();
            var textLength = tabText.length;
            tabLengths.push(textLength);
        });

        // Mengambil nilai maksimum dari panjang huruf
        var maxTabLength = Math.max.apply(null, tabLengths);

        // Menghitung jumlah slide yang akan ditampilkan berdasarkan panjang huruf
        var slidesToShow = Math.ceil(maxTabLength / 10); // Misalnya, setiap slide menampilkan 10 huruf

        // Menginisialisasi Slick slider dengan konfigurasi dinamis
        $('.myTab').slick({
            slidesToShow: slidesToShow,
            slidesToScroll: 1,
            autoplay: true, // Set this to true to enable auto sliding
            autoplaySpeed: 1000,
            speed: 1000,
            pauseOnHover: true,
            arrows: true,
            infinite: false,
            pauseOnFocus: true,
        });
    });

    // window.addEventListener("load", function(event) {
        // document.querySelector('[data-dropdown-toggle="dropdown"]').click();
    // });
 </script>
@endpush
