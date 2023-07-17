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
<section class="p-3" style="text-align: -webkit-center;">
    <div class="text-left max-w-sm bg-white border border-gray-200 rounded-[30px] shadow dark:bg-gray-800 dark:border-gray-700">
        <div class="p-2 space-x-4">
            <p class="text-lg font-semibold text-center dark:text-white">Detail Restaurant</p>
        </div>
        <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
        <form action="{{ route('restaurant-cart',$restaurants->id) }}" method="get">
            @csrf
            <div class="grid grid-cols-2">
                <div class="text-base sm:text-sm px-1 py-3 w-8/12">
                    <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                        <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" alt="." class="object-cover object-center h-full w-full">
                    </div>
                </div>
        
                <input type="hidden" name="category" value="restaurant">
                <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
                    <li class="py-3 sm:py-4">
                        <div class="flex items-start space-x-4">
                            {{-- <div class="flex-shrink-0">
                                <img src="{{ 'https://managementvmond.controlindo.com/assets/images/restaurant/' ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=580&q=80'}} " alt="" class="w-12 h-12 rounded-full">
        
                            </div> --}}
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    {{ $restaurants->nama }}
                                </p>
        
                                <p>
                                    <span class="block text-[10px] dark:text-yellow-300">Stock {{ $restaurants->current_stok }}</span>
                                </p>
                                <p class="text-xs text-gray-500 truncate dark:text-red-500">
                                    Rp. {{ number_format($restaurants->harga_diskon) }}
                                </p>
        
        
                                <div class="rounded-full h-7 w-32 border border-gray-500 mt-2">
                                    <div class="grid h-full w-full grid-cols-3 mx-auto">
                                        <button type="button" class="inline-flex flex-col items-center justify-center px-5 rounded-l-full hover:bg-gray-50 dark:hover:bg-gray-800 group">
                                            <ion-icon name="remove" class="w-4 h-3 mb-0.5 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500" onclick="remove()"></ion-icon>
                                            <span class="sr-only">Remove</span>
                                        </button>
        
                                        <div>
                                            <input type="number" value="1" name="qty" id="count-items" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm text-center focus:ring-primary-600 focus:border-primary-600 block w-full py-0.5 h-full px-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 counter" placeholder="0" required="">
                                        </div>
        
                                        <button type="button" class="inline-flex flex-col items-center justify-center px-5 rounded-r-full hover:bg-gray-50 dark:hover:bg-gray-800 group" onclick="add()">
                                            <ion-icon name="add" class="w-4 h-3 mb-0.5 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500"></ion-icon>
                                            <span class="sr-only">Add</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
    
            <div class="grid grid-cols-1">
                <div class="px-1 w-full">
                    {{-- <p aria-hidden="true" class="text-xs mt-1 font-semibold dark:text-gray-300">{{ $restaurants->nama_paket ?? 'Error' }}</p> --}}
                    {{-- <span class="block text-[10px] dark:text-red-500">Rp.{{ number_format($restaurants->harga,2) }} </span> --}}
                    <div>
                        @if(session()->has('failed'))
                            <h1 class="text-red-500">{{ session()->get('failed') }}  </h1>
                        @endif
                    </div>
                    @php
                        $min = 0;
                    @endphp
                    {{-- {{dd($add_ons)}} --}}
                    @foreach ($add_ons as $add_on)
                        @foreach (old('add_on_id') ?? $restaurant_add_on as $id)
                            @if ($id == $add_on->id)
                                @php
                                    $min += $add_on->minimum_choice;
                                @endphp 
                                <input type="hidden" name="minimum" value="{{ $min }}">
                                <div class="flex gap-1 opacity-75 mt-auto w-full">
                                    <div class="grid space-y-3">
                                        <input type="hidden" name="add_on_title[]" value="{{ $add_on->id }}" id="">
                                        
                                        <p aria-hidden="true" class="text-lg mt-1 font-semibold dark:text-gray-300">{{ $add_on->title ?? 'Error' }} (Pilih {{ $add_on->minimum_choice  }} )</p>
                                        @foreach ($add_on->detailAddOn as $item)
                                            
                                        <div class="relative flex items-start">
                                            <div class="flex items-center h-5 mt-1">
                                                <input id="hs-checkbox-delete" value="{{ $item->id }}" name="harga_add[]" type="checkbox" class="{{ str_replace(' ', '-', strtolower($add_on->title)) }} border-gray-200 rounded text-blue-600 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" aria-describedby="hs-checkbox-delete-description">
                                                {{-- <input type="hidden" name="detail_id[]" value="{{ $item->id }}" id=""> --}}
        
                                            </div>
                                            <label for="hs-checkbox-delete" class="ml-3">
                                                {{-- <span class="block text-sm font-semibold text-gray-800 dark:text-gray-300">{{ $add_on->title }}</span> --}}
                                                <span id="hs-checkbox-delete-description" class="text-sm text-gray-600 dark:text-gray-300">{{ $item->nama ?? '' }}</span> <br>
                                                <span id="hs-checkbox-delete-description" class="text-sm text-gray-600 dark:text-gray-300">Rp. {{ $item->harga ?? '' }}</span>
                                            </label>
                                        </div>
                                        @endforeach
                                        
                                    </div>
                                </div>
                                    {{-- {{ dd($min) }} --}}
                                @endif
                            @endforeach
                    @endforeach
                </div>
            </div>

            <div class="mt-2">
                <input type="hidden" name="id" value="{{ $restaurants->id }}" id="">
                <input type="hidden" name="nama" value="{{ $restaurants->nama }}" id="">
                <input type="hidden" name="harga" value="{{ $restaurants->harga_diskon }}" id="">
                <input type="hidden" name="category" value="{{ $category }}" id="">
                <input type="hidden" name="image" value="{{ $image.$restaurants->image }}" id="">

                {{-- <input type="hidden" name="quantity" value="1" id=""> --}}
                <button type="submit" class="w-full h-full p-3 bg-blue-500 dark:text-white rounded-b-[30px] hover:bg-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-900">Add Cart</button>
            </div>
        </form>
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

    // function add(slug, $id){
    //     let getVar = parseInt($('.counter').val());
    //     if(!getVar || getVar == NaN){
    //         getVar = 1;
    //         $('.counter').val(getVar);
    //     }else{
    //         getVar = getVar + 1;
    //         $('.counter').val(getVar);
    //     }
    // }

    // function remove(slug, $id){
    //     let getVar = parseInt($('.counter').val());
    //     if(!getVar || getVar == NaN){
    //         getVar = 0;
    //         $('.counter').val(getVar);
    //     }else{
    //         getVar = getVar - 1;
    //         $('.counter').val(getVar);
    //     }

    // }

    function add(slug, $id) {
    let getVar = parseInt($('.counter').val());
    let stok = parseInt('{{ $restaurants->stok_perhari }}'); // Mendapatkan nilai stok dari PHP

    if (!getVar || isNaN(getVar)) {
        getVar = 1;
    } else {
        getVar = getVar + 1;
    }

    // Memeriksa apakah jumlah yang dimasukkan melebihi stok
    if (getVar <= stok) {
        $('.counter').val(getVar);
    }
}

function remove(slug, $id) {
    let getVar = parseInt($('.counter').val());
    
    if (!getVar || isNaN(getVar)) {
        getVar = 0;
    } else {
        getVar = getVar - 1;
    }
    
    if (getVar >= 0) {
        $('.counter').val(getVar);
    }
}
 </script>
 {{-- GUla --}}
 <script>
    // const maxChecked = 1; // Jumlah maksimum nilai yang dapat dicentang

    // const checkboxes = document.querySelectorAll('.pilih-gula');
    // let checkedCount = 0;

    // checkboxes.forEach(checkbox => {
    // checkbox.addEventListener('change', function() {
    //     if (this.checked) {
    //     checkedCount++;
    //     } else {
    //     checkedCount--;
    //     }

    //     if (checkedCount > maxChecked) {
    //     this.checked = false; // Mencegah centangan lebih dari jumlah maksimum
    //     checkedCount--;
    //     }
    // });
    // });
 </script>
 {{-- Level Pedas --}}
 <script>

    const addOns = @JSON($add_ons);
    console.log(addOns);

    addOns.forEach(addOns => {
        let formCheck = document.querySelectorAll('.' + addOns.title.replace(' ', '-').toLowerCase());
        let countCheck = 0;
        let maxCheck = addOns.minimum_choice;
        // console.log(formCheck);
        formCheck.forEach(detail => {
            detail.addEventListener('change', function(){
                if (this.checked) {
                    countCheck++;
                } else {
                    countCheck--;
                }

                if (countCheck > maxCheck) {
                    this.checked = false; // Mencegah centangan lebih dari jumlah maksimum
                    countCheck--;
                }
            });
        });
    });
 </script>
@endpush
