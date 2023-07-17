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

            @foreach ($tags->sortByDesc('created_at') as $item)
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
                                    <button class="inline-block px-5 py-4 border-b-2 rounded-t-lg mr-0 ml-3" style="text-align:center !important;" id="{{ strtolower(str_replace(' ','',$item->tag_name)) }}-tab" data-tabs-target="#{{ strtolower(str_replace(' ','',$item->tag_name)) }}" type="button" role="tab" aria-controls="{{ strtolower(str_replace(' ','',$item->tag_name)) }}" aria-selected="false">{{ strtolower(str_replace(' ','',$item->tag_name)) }}</button>
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
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="{{ strtolower(str_replace(' ','',$item->tag_name)) }}" role="tabpanel" aria-labelledby="{{ strtolower(str_replace(' ','',$item->tag_name)) }}-tab">
            <div class="grid grid-cols-2">
                @foreach ($restaurants as $resto)
                @foreach ($resto->restaurantTag as $pivot)
                {{-- {{ dd($resto->description) }} --}}
                @if ($pivot->tag_id == $item->id)
                @if ($resto->category == $category)
                <div class="text-base sm:text-sm px-1 py-3">
                    <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                        <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" alt="." class="object-cover object-center h-full w-full">
                    </div>
                    <div class="px-1">
                        <p aria-hidden="true" class="text-xs mt-1 font-semibold dark:text-gray-300">{{ $resto->nama ?? 'Error' }}</p>
                        <span class="block text-[10px] dark:text-red-500">Rp.{{ number_format($resto->harga_diskon,2) }} </span>

                        <div class="flex gap-1 opacity-75 mt-auto">
                            {{-- <button class="w-4/12 bg-orange-500 text-xs rounded-lg mt-2 p-1 hover:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-300" data-modal-target="description-modal-resto{{ $resto->id }}" data-modal-toggle="description-modal-resto{{ $resto->id }}"><ion-icon name="eye" class="mt-[0.2rem] dark:text-white"></ion-icon></button> --}}
                            <button class="w-4/12 bg-orange-500 text-xs rounded-lg mt-2 p-1 hover:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-300" data-modal-target="description-modal-resto{{ $resto->id }}" data-modal-toggle="description-modal-resto{{ $resto->id }}"><ion-icon name="eye" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                            {{-- <button class="w-8/12 bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300"><ion-icon name="bag-add" class="mt-[0.2rem] dark:text-white"></ion-icon></button> --}}
                            {{-- <form action="{{ route('add-cart-billiard',$resto->id) }}" method="get" class=" w-8/12">
                                <div class="flex gap-1 opacity-75">
                                    <input type="hidden" name="quantity" value="1" id="">
                                    <input type="hidden" name="image" value="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" id="">
                                    <input type="hidden" name="id" value="{{ $resto->id }}" id="">
                                    <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300"><ion-icon name="bag-add" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                                </div>
                            </form> --}}
                            <form action="{{ route('detail-resto',['id' => $resto->id,'category' => request()->category]) }}" method="get" class=" w-8/12">
                                <div class="flex gap-1 opacity-75 w-full">
                                    {{-- <input type="hidden" name="quantity" value="1" id="">
                                    <input type="hidden" name="image" value="{{ $global_url_image . $resto->image }}" id="">
                                    <input type="hidden" name="image" value="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" id="">
                                    <input type="hidden" name="id" value="{{ $resto->id }}" id=""> --}}
                                    {{-- <a href="{{ route('detail-resto',$resto->id) }}" class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300"><ion-icon name="bag-add" class="mt-[0.2rem] dark:text-white"></ion-icon></a> --}}
                                    <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300"><ion-icon name="bag-add" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
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

            {{-- <div class="grid grid-cols-1">
                @foreach ($restaurants as $resto)
                    @foreach ($resto->restaurantTag as $pivot)
                        @if ($pivot->tag_id == $item->id)
                        <div class="text-base flex gap-3 sm:text-sm px-1 py-3">
                            <div class="relative max-w-sm h-24 w-24">
                                <a href="#">
                                <img class="rounded-lg" src="{{ $global_url_image.$resto->image ?? 'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=780&q=80'}} " alt="image description">
                                </a>
                                <span class="absolute bottom-0 inline-flex items-center justify-center w-full h-5 bg-red-800 border border-red-500 rounded-b-[.5rem] text-white text-xs">
                                    Spesial Price
                                </span>
                            </div>
                            <div class="grow px-1">
                                <p aria-hidden="true" class="text-xs mt-1 font-semibold dark:text-gray-300">{{ $resto->nama ?? 'Error' }}</p>
                                <span class="block text-[8px] dark:text-yellow-300">Stock 100</span>
                                <span class="block text-[8px] dark:text-white text-ellipsis">{{$resto->description}}</span>
                                    <div class="flex gap-2">
                                    @if($resto->harga_diskon > 0)
                                        <span class="block text-[10px] text-white">Rp.{{ number_format($resto->harga_diskon,0) }}</span>
                                        <span class="block text-[8px] dark:text-red-500 line-through">Rp.{{ number_format($resto->harga,0) }}</span>
                                    @else
                                        <span class="block text-[10px] text-white">Rp.{{ number_format($resto->harga,0) }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="shrink opacity-75 my-auto">
                                <button class="w-10 h-full block bg-orange-500 text-xs rounded-lg mb-2 p-1 hover:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-300" onclick="window.location='{{ route('detail-menu', ['type' => 'resto', 'slug' => $resto->slug]) }}';"><ion-icon name="eye" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                                <form action="{{ route('restaurant-cart',$resto->id) }}" method="get" class="w-10">
                                    <div class="flex gap-1 opacity-75">
                                        <input type="hidden" name="quantity" value="1" id="">
                                        <input type="hidden" name="image" value="{{ $resto->image }}" id="">
                                        <input type="hidden" name="id" value="{{ $resto->id }}" id="">
                                        <button class="w-full h-full block bg-sky-500 text-xs rounded-lg p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300"><ion-icon name="bag-add" class="mt-[0.2rem] dark:text-white"></ion-icon></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="border-b border-gray-500"></div>
                        @endif
                    @endforeach
                @endforeach
            </div> --}}
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
            infinite: false,
            arrows: true,
            slidesToShow: slidesToShow,
            slidesToScroll: 1,
            autoplay: false,
            speed: 100
        });
    });

    // window.addEventListener("load", function(event) {
        // document.querySelector('[data-dropdown-toggle="dropdown"]').click();
    // });
 </script>
@endpush
