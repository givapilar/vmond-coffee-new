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
        <form action="{{ route('restaurant-cart',$restaurants->id) }}" method="get" id="formCart">
            @csrf
            <div class="grid grid-cols-2 p-3">
                <div class="text-base sm:text-sm px-1 py-3 w-8/12 items-center mx-auto">
                    <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                        
                        @if ($restaurants->image != null)
                            <img src="{{ $image.$restaurants->image ?? 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80' }}" alt="." class="object-cover object-center h-full w-full">
                        @else
                        <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" alt="." class="object-cover object-center h-full w-full">
                        @endif
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
                                            <input type="number" value="1" name="qty" id="count-items" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm text-center focus:ring-primary-600 focus:border-primary-600 block w-full py-0.5 h-full px-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 counter" placeholder="0" required="" readonly>
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
            
            <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
            @if (count($restaurant_add_on) != 0)
                <div class="p-2 space-x-4">
                    <p class="text-lg font-semibold text-center dark:text-white">Pilih Detail Pesanan</p>
                </div>
            
            <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">

            <div class="w-full">
                {{-- <div>
                    @if(session()->has('failed'))
                        <h1 class="text-red-500">{{ session()->get('failed') }}  </h1>
                    @endif
                </div> --}}

                @php
                    $min = 0;
                @endphp

                <ul class="max-w-sm divide-y divide-gray-200 dark:divide-gray-700">

                    <li class="py-3 sm:py-2">
                        <div class="flex items-center space-x-4 px-3">
                            {{-- <div class="flex-shrink-0">
                                <img class="w-8 h-8 rounded-full" src="{{ asset('assetku/dataku/img/takeaway.png') }}" alt="Neil image">
                            </div> --}}
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    1. Normal
                                </p>
                            </div>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                <input id="normal-radio" required type="radio" value="Normal" name="addOnChange" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            </div>
                        </div>
                    </li>

                    <li class="py-3 sm:py-2">
                        <div class="flex items-center space-x-4 px-3">
                            {{-- <div class="flex-shrink-0">
                                <img class="w-8 h-8 rounded-full" src="{{ asset('assetku/dataku/img/dinein.png') }}" alt="Neil image">
                            </div> --}}
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    2. Custom
                                </p>
                            </div>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                <input id="custome-radio" required type="radio" value="Custom" name="addOnChange" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            </div>
                        </div>
                    </li>
                    
                    <li class="" style="display: none;" id="custom">
                        @foreach ($add_ons as $add_on)
                            <div id="select-input-wrapper">
                                @foreach (old('add_on_id') ?? $restaurant_add_on as $id)
                                    @if ($id == $add_on->id)
                                        @php
                                            $min += $add_on->minimum_choice;
                                            $groupIdentifier = 'addon_' . $add_on->id; // Unique group identifier for radio buttons
                                        @endphp
                                        <input type="hidden" class="custom" name="minimum" value="{{ $min }}">
                                        <div class="w-full" id="{{ str_replace(' ', '',strtolower($add_on->title)) }}">
                                            <input type="hidden" class="custom" name="add_on_title[]" value="{{ $add_on->title }}" id="">
                                            <div class="flex justify-center align-center py-2 px-3">
                                                <p aria-hidden="true" class="text-sm font-semibold dark:text-white text-center">{{ $add_on->title ?? 'Error' }} </p>
                                                <p class="text-xs font-semibold dark:text-white text-center mt-1">&nbsp;(Pilih {{ $add_on->minimum_choice }} )</p>
                                            </div>
                                            <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
                                            @foreach ($add_on->detailAddOn as $item)
                                                <div class="relative flex items-center px-3" id="detail-{{ $item->id }}">
                                                    <div class="flex items-center h-5">
                                                        {{-- <input type="hidden" id="selectedRadioValue" name="add_nama" value=""> --}}
                                                        <input id="{{ str_replace(' ', '',strtolower($item->nama)) }}-{{ $item->id }}" type="radio" value="{{ $item->id }}" name="harga_add[{{ $groupIdentifier }}]" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 custom">
                                                    </div>
                                                    <label for="{{ str_replace(' ', '',strtolower($item->nama)) }}-{{ $item->id }}" class="ml-3">
                                                        <span id="{{ str_replace(' ', '',strtolower($item->nama)) }}-description" class="text-sm text-white dark:text-white">{{ $item->nama ?? '' }}</span> <br>
                                                        <span id="{{ str_replace(' ', '',strtolower($item->nama)) }}-description" class="text-sm text-white dark:text-white">Rp. {{ $item->harga ?? '' }}</span>
                                                    </label>
                                                </div>
                                                <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    </li>
                    
                    <li class="py-3 sm:py-2" style="display: none;" id="normal">
                        <div id="select-input-wrapper">
                            <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Normal</label>
                            @foreach ($add_ons as $add_on)
                                @foreach (old('add_on_id') ?? $restaurant_add_on as $id)
                                    @if ($id == $add_on->id)
                                        @php
                                            $min += $add_on->minimum_choice;
                                        @endphp 
                                        <input type="hidden" name="minimum" class="normal" value="{{ $min }}">
                                        <div class="flex gap-1 opacity-75 mt-auto w-full">
                                            <div class="grid space-y-3">
                                                <input type="hidden" name="add_on_title[]" class="normal" value="{{ $add_on->title }}" id="">
                                                
                                                <p aria-hidden="true" class="text-lg mt-1 font-semibold dark:text-gray-300">{{ $add_on->title ?? 'Error' }} (Pilih {{ $add_on->minimum_choice  }} )</p>
                                                @foreach ($add_on->detailAddOn as $item)
                                                    <div class="relative flex items-start">
                                                        <div class="flex items-center h-5 mt-1">
                                                            <input readonly id="{{ str_replace(' ', '',strtolower($item->nama)) }}" value="{{ $item->id }}" name="harga_add[]" type="checkbox" class="{{ str_replace(' ', '-', strtolower($add_on->title)) }} border-gray-200 rounded text-blue-600 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800 normal" aria-describedby="{{ str_replace(' ', '',strtolower($item->nama)) }}-description"
                                                            @if ($loop->index < $add_on->minimum_choice) 
                                                            checked @endif >
                                                            {{-- <input id="{{ str_replace(' ', '',strtolower($item->nama)) }}-{{ $item->id }}" type="radio" value="{{ $item->id }}" name="harga_add[{{ $groupIdentifier }}]" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 normal"
                                                            aria-describedby="{{ str_replace(' ', '',strtolower($item->nama)) }}-description"
                                                            @if ($loop->index < $add_on->minimum_choice) 
                                                            checked @endif> --}}

                                                        </div>
                                                        <label for="{{ str_replace(' ', '',strtolower($item->nama)) }}" class="ml-3">
                                                            <span id="{{ str_replace(' ', '',strtolower($item->nama)) }}-description" class="text-sm text-gray-600 dark:text-gray-300">{{ $item->nama ?? '' }}</span> <br>
                                                            <span id="{{ str_replace(' ', '',strtolower($item->nama)) }}-description" class="text-sm text-gray-600 dark:text-gray-300">Rp. {{ $item->harga ?? '' }}</span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endforeach
                        </div>
                    </li>
                    
                </ul>
            </div>
            @endif

            {{-- <div class="grid grid-cols-1">
            </div> --}}

            <div class="mt-2">
                <input type="hidden" name="id" value="{{ $restaurants->id }}" id="">
                <input type="hidden" name="nama" value="{{ $restaurants->nama }}" id="">
                <input type="hidden" name="harga" value="{{ $restaurants->harga_diskon }}" id="">
                <input type="hidden" name="category" value="{{ $category }}" id="">
                <input type="hidden" name="image" value="{{ $image.$restaurants->image }}" id="">

                {{-- <input type="hidden" name="quantity" value="1" id=""> --}}
                <button type="button" class="w-full h-full p-3 bg-blue-500 dark:text-white rounded-b-[30px] hover:bg-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-900" id="submitButton" onclick="submitDisabled()">Add Cart</button>
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
</script>
@endpush
