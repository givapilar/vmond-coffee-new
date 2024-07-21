@extends('layouts.app')

@push('style-top')
<style>
    input[type="checkbox"][readonly] {
    cursor: not-allowed;
}
</style>
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
        <form action="{{ route('checkout-paket-menu',md5(strtotime("now"))) }}" method="POST" id="formCart">
            @csrf
            <div class="grid grid-cols-2 p-3">
                <input type="hidden" name="category" value="restaurant">
                <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
                    <li class="py-3 sm:py-4">
                        <div class="flex items-start space-x-4">
                            {{-- <div class="flex-shrink-0">
                                <img src="{{ 'https://managementvmond.controlindo.com/assets/images/restaurant/' ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=580&q=80'}} " alt="" class="w-12 h-12 rounded-full">
        
                            </div> --}}
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    {{ $paket_menu->nama_paket }}
                                </p>

                                <p class="text-xs text-gray-500 truncate dark:text-red-500">
                                    Rp. {{ number_format($paket_menu->harga_diskon) }}
                                </p>
                                <input type="hidden" name="total_paket" value="{{ $paket_menu->harga_diskon ?? 0 }}">
                                <input type="hidden" name="qty" value="1">
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            
            <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
                <div class="p-2 space-x-4">
                    <p class="text-lg font-semibold text-center dark:text-white">Detail Paket Menu</p>
                </div>
            
            <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">

            <div class="w-full">
                @php
                    $min = 0;
                @endphp

                <ul class="max-w-sm divide-y divide-gray-200 dark:divide-gray-700">
                    <li class="py-3 sm:py-2">
                        @foreach ($restaurants as $restaurant)
                            <div id="select-input-wrapper">
                                @foreach (old('restaurant_id') ?? $menu_package_pivots as $id)
                                    @if ($id == $restaurant->id)
                                        @php
                                            $groupIdentifier = 'menu_' . $restaurant->id; // Unique group identifier for radio buttons
                                        @endphp
                                        <div class="w-full" id="choice">
                                            <div class="w-full" id="choice">
                                                <div class="relative flex items-center px-3 py-2" id="detail">
                                                    <div class="flex items-center h-5">
                                                        <input id="choice-menu-{{ $restaurant->nama }}" onclick="getAddOn('{{ $restaurant->id }}')" type="hidden" value="{{ $restaurant->id }}" name="paket_restaurant_id[{{ $groupIdentifier }}]" class="restaurant-input w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 custom" checked/>
                                                    </div>
                                                    <label for="choice-menu-{{ $restaurant->nama }}" class="ml-3">
                                                        <span id="choice-menu-{{ $restaurant->nama }}-description" class="text-sm text-white dark:text-white">
                                                            {{ $restaurant->nama ?? '' }}
                                                        </span>
                                                        <br />
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="w-full">
                                                @php
                                                    $min = 0;
                                                @endphp
                                                {{-- <div id="add-ons-{{ $restaurant->id }}" class="add-ons-list divide-y divide-gray-200 dark:divide-gray-700">
                                                    @if ($restaurant->addOns->count() > 0)
                                                        <ul>
                                                            <li class="py-3 sm:py-2">
                                                                <div class="flex items-center space-x-4 px-3">
                                                                    <div class="flex-1 min-w-0">
                                                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                                            1. Add On
                                                                        </p>
                                                                    </div>
                                                                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                                        <input id="normal-radio" type="radio" onchange="getAddOnDetail('{{ $restaurant->id }}', 'normal')" value="Normal" name="addOnChange{{ $restaurant->id }}" class="typeAddOn w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                                    </div>
                                                                </div>
                                                            </li>
                                                
                                                        </ul>
                                                    @endif

                                                    <div class="grid grid-cols-3 detail-add-ons" id="detail-add-ons-{{ $restaurant->id }}" style="margin: 10px 30px; display:none;">
                                                        @foreach ($add_ons as $add_on)  
                                                            @foreach ($restaurant->addOns as $key => $resto)
                                                                @if ($resto->add_on_id == $add_on->id)
                                                                <div class="w-full" id="{{ str_replace(' ', '',strtolower($add_on->title)) }}">
                                                                    <input style="display: none;" type="hidden" class="custom add-ons-title" name="add_on_title[]" value="{{ $add_on->title }}" id="">
                                                                    <div class="flex justify-center align-center py-2 px-3">
                                                                        <p aria-hidden="true" class="text-sm font-semibold dark:text-white text-center break-words">{{ $add_on->title . '(Pilih '. $add_on->minimum_choice .')'?? 'Error' }} </p>
                                                                    </div>
                                                                    <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
                                                                    @foreach ($add_on->detailAddOn as $item)
                                                                        <div class="relative flex items-center px-3" id="detail-{{ $item->id }}">
                                                                            <div class="flex items-center h-5">
                                                                                <input id="{{ str_replace(' ', '',strtolower($item->nama)) }}-{{ $item->id }}" type="radio" value="{{ $item->id }}" name="harga_add{{ $groupIdentifier }}[{{ $groupIdentifier . '_' . $add_on->id }}]" class="normal-choice w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 custom {{ substr(strtolower($item->nama), 0, 6) }}">
                                                                            </div>
                                                                            <label for="{{ str_replace(' ', '',strtolower($item->nama)) }}-{{ $item->id }}" class="ml-3">
                                                                                <span id="{{ str_replace(' ', '',strtolower($item->nama)) }}-description" class="text-sm text-white dark:text-white">{{ $item->nama ?? '' }}</span> <br>
                                                                                <span id="{{ str_replace(' ', '',strtolower($item->nama)) }}-description" class="text-sm text-white dark:text-white">Rp. {{ $item->harga ?? '' }}</span>
                                                                            </label>
                                                                        </div>
                                                                        @if (!$loop->last)
                                                                            <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    </div>
                                                </div> --}}
                                            </div>
                                            <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    </li>
                </ul>
            </div>

            {{-- @endif --}}
            <div class="mt-2">
                {{-- <input type="hidden" name="id" value="{{ $restaurants->id }}" id="">
                <input type="hidden" name="nama" value="{{ $restaurants->nama }}" id="">
                <input type="hidden" name="harga" value="{{ $restaurants->harga_diskon }}" id="">
                <input type="hidden" name="category" value="{{ $category }}" id="">
                <input type="hidden" name="image" value="{{ $image.$restaurants->image }}" id=""> --}}

                <input type="hidden" name="quantity" value="1" id="">
                <button type="button" class="w-full h-full p-3 bg-blue-500 dark:text-white rounded-b-[30px] hover:bg-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-900" id="submitButton" onclick="submitDisabled()">Checkout</button>
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
    // Mengambil elemen radio button "Takeaway" dan "Dine In"
    const normalChecked = document.getElementById('normal-radio');
    const customeChecked = document.getElementById('custome-radio');

    // Mengambil elemen wrapper "Pilih Meja"
    const normal = document.getElementById('normal');
    const custom = document.getElementById('custom');

    // Menambahkan event listener saat radio button berubah
    normalChecked.addEventListener('change', toggleSections);
    customeChecked.addEventListener('change', toggleSections);

    // Fungsi untuk mengubah visibilitas "Pilih Meja" dan "Normal"
    function toggleSections() {
        if (normalChecked.checked) {
            $('.custom').prop('disabled', true);
            $('.normal').prop('disabled', false);
            custom.style.display = 'none';
            normal.style.display = 'block';
            console.log('normal change');
        } else if (customeChecked.checked) {
            console.log('custom change');
            $('.custom').prop('disabled', false);
            $('.normal').prop('disabled', true);
            custom.style.display = 'block';
            normal.style.display = 'none';
        }
    }
</script>

<script>
    $('.slick1').slick({
        infinite:false,
        arrows: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: false,
        speed:200,
    });

    function add(slug, $id) {
        let getVar = parseInt($('.counter').val());
        // let stok = parseInt('{{ $paket_menu->stok_perhari }}'); // Mendapatkan nilai stok dari PHP
        let stok = 100; // Mendapatkan nilai stok dari PHP

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
 </script>
 {{-- Level Pedas --}}
<script>

const addOns = @JSON($add_ons);
console.log(addOns);

addOns.forEach(addOn => {
    let formCheck = document.querySelectorAll('.' + addOn.title.replace(' ', '-').toLowerCase());
    let countCheck = 1;
    let maxCheck = addOn.minimum_choice;
    
    formCheck.forEach(detail => {
        detail.addEventListener('change', function() {
            if (this.checked) {
                countCheck++;
            } else {
                countCheck--;
            }

            if (countCheck > maxCheck) {
                // Uncheck the checkbox that exceeds the maximum allowed
                this.checked = false;
                countCheck--;
            }
        });
    });
});

</script>
{{-- Disable Button After Click --}}
<script>
    function submitDisabled()
    {
        $('#submitButton').prop('disabled', true);
        $('#submitButton').addClass('disabled');
        $('#formCart').submit();
    }

    function getAddOn(id, no) {
        console.log('masuk');
        $('.add-ons-list-' + no).css('display', 'none');
        $('#add-ons-' + id).css('display', 'block');
    }
    function getAddOnDetail(id, type)
    {
        if (type === 'normal') {
            $('#detail-add-ons-'+id).css('display', 'block');
        } 
        // else {
        //     $('#detail-add-ons-'+id).css('display', 'none');
        // }
    }
</script>
@endpush
