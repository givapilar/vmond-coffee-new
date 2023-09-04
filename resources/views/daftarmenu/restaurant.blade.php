@extends('layouts.app')

@push('style-top')

@endpush

@push('style-bot')

@endpush

@section('content')
<section>
    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
        @php
            $processedTags = []; // Array untuk menyimpan tag yang telah diproses
            @endphp

            @foreach ($tags as $item)
                @php
                $isTagProcessed = false; // Flag untuk menandai apakah tag telah diproses sebelumnya
                @endphp

                @foreach ($restaurants as $resto)
                    @foreach ($resto->restaurantTag as $pivot)
                        @if ($resto->category == $category)
                            @if ($pivot->tag_id == $item->id && !in_array($item->id, $processedTags))
                                @php
                                $processedTags[] = $item->id; // Menyimpan tag yang telah diproses
                                $isTagProcessed = true; // Menandai bahwa tag telah diproses
                                @endphp

                                <li class="mr-2" role="presentation">
                                    {{-- <a href="{{ route('daftar-restaurant', ['category' => request()->category, 'menu' => $item->tag_name]) }}" id="category-link" class="inline-block px-5 py-4 border-b-2 rounded-t-lg mr-0 ml-3" style="text-align:center !important; font-weight: 700 !important;" data-tabs-target="#{{ strtolower(str_replace(' ','',$item->tag_name)) }}" type="button" role="tab" aria-controls="{{ strtolower(str_replace(' ','',$item->tag_name)) }}" aria-selected="false">{{ strtoupper($item->tag_name) }}</a> --}}
                                    {{-- <a href="#" class="inline-block px-5 py-4 border-b-2 rounded-t-lg mr-0 ml-3" style="text-align:center !important; font-weight: 700 !important;" id="{{ strtolower(str_replace(' ','',$item->tag_name)) }}-tab" data-tabs-target="#{{ strtolower(str_replace(' ','',$item->tag_name)) }}" type="button" role="tab" aria-controls="{{ strtolower(str_replace(' ','',$item->tag_name)) }}" aria-selected="false">{{ strtoupper($item->tag_name) }}</a> --}}
                                    <a href="#" class="inline-block px-5 py-4 border-b-2 rounded-t-lg mr-0 ml-3" style="text-align:center !important; font-weight: 700 !important;" id="{{ strtolower(str_replace(' ','',$item->tag_name)) }}-tab" data-tabs-target="#{{ strtolower(str_replace(' ','',$item->tag_name)) }}" type="button" role="tab" >{{ strtoupper($item->tag_name) }}</a>
                                    {{-- <a href="#" class="get-parameter inline-block px-5 py-4 border-b-2 rounded-t-lg mr-0 ml-3"
                                        style="text-align: center !important; font-weight: 700 !important;"
                                        data-tag-name="{{ strtolower(str_replace(' ', '', $item->tag_name)) }}">
                                        {{ strtoupper($item->tag_name) }}
                                    </a> --}}
                                    {{-- {{ dd($menu == request()->menu) }} --}}
                                </li>

                            @endif
                        @endif
                    @endforeach
                @endforeach
            @endforeach
        </ul>
    </div>
</section>

<section>
    <div id="myTabContent">
        @foreach ($tags as $item)
        {{-- {{ dd((request()->menu == $item->tag_name), request()->menu, $menu, $item->tag_name) }} --}}
        <div class="hidden pt-0 px-4 pb-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="{{ strtolower(str_replace(' ','',$item->tag_name)) }}" role="tabpanel" aria-labelledby="{{ strtolower(str_replace(' ','',$item->tag_name)) }}-tab">
            <div class="p-3 space-x-4">
                <p class="text-lg font-semibold text-center dark:text-white">{{ strtoupper($item->tag_name) }}</p>
            </div>
            <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
            <div class="grid grid-cols-2">
                @foreach ($restaurants as $resto)
                @foreach ($resto->restaurantTag as $pivot)
                {{-- {{ dd($resto->description) }} --}}
                @if ($pivot->tag_id == $item->id)
                @if ($resto->category == $category)
                <div class="text-base sm:text-sm px-1 py-3">
                    <div class="aspect-h-1 h-40 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                        
                        @if ($resto->image != null)
                        <img src="{{ $global_url_image.$resto->image ?? 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80' }}" alt="." class="object-cover object-center h-full w-full">
                        
                        @else
                        <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" alt="." class="object-cover object-center h-full w-full">
                        @endif

                           
                    </div>
                    <div class="px-1">
                        <p aria-hidden="true" class="text-xs mt-1 font-semibold dark:text-gray-300">{{ $resto->nama ?? 'Error' }}</p>
                        <span class="block text-[10px] dark:text-yellow-300">Stock {{ $resto->current_stok }}</span>
                        <span class="block text-[10px] dark:text-red-500">Rp.{{ number_format($resto->harga_diskon,2) }} </span>
                        
                        <div class="flex gap-1 opacity-75 mt-auto">
                            {{-- <button class="w-4/12 bg-orange-500 text-xs rounded-lg mt-2 p-1 hover:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-300" data-modal-target="description-modal-resto{{ $resto->id }}" data-modal-toggle="description-modal-resto{{ $resto->id }}"><ion-icon name="eye" class="mt-[0.2rem] dark:text-white"></ion-icon></button> --}}
                            <button class="w-4/12 bg-orange-500 text-xs rounded-lg mt-2 p-1 hover:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-300 dark:text-white flex items-center justify-center" data-modal-target="description-modal-resto{{ $resto->id }}" data-modal-toggle="description-modal-resto{{ $resto->id }}">
                                <ion-icon name="eye" class="mt-[0.2rem] mb-1 dark:text-white" style="margin-right: 5px;"></ion-icon>
                                <p class="mt-1 mb-1">Detail</p>
                            </button>
                            <form action="{{ route('detail-resto',['id' => $resto->id,'category' => request()->category]) }}" method="get" class=" w-8/12">
                                <div class="flex gap-1 w-full">
                                    @if ($resto->status == 'Tersedia')
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
                @include('modal.description')
                @endif
                @endif
                @endforeach
                @endforeach 
            </div>
        </div>
        @endforeach
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
        $('#myTab').slick({
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
