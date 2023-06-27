@extends('layouts.app')

@push('style-top')

@endpush

@push('style-bot')

@endpush

@section('content')
<section class="p-3">
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
</section>

<section class="p-3">
    <div class="flex items-center justify-between">
        <div class="">
            <span class="text-lg font-bold dark:text-white ml-1">Detail Restaurant</span>
        </div>
    </div>
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
                            <span class="block text-[10px] dark:text-yellow-300">Stock {{ $restaurants->stok_perhari }}</span>
                        </p>
                        <p class="text-xs text-gray-500 truncate dark:text-red-500">
                            Rp. {{ number_format($restaurants->harga) }}
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
                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                        <button class="flex justify-center items-center w-10 h-10 rounded-full p-2 bg-red-500 hover:bg-red-600 focus:ring-red-900 focus:ring-4"  data-modal-toggle="deleteModal">
                            <ion-icon name="trash" class=""></ion-icon>
                        </button>

                        <div id="deleteModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full sm:inset-0 h-full delay-200">
                            <div class="relative p-4 w-full max-w-md h-auto">
                                <!-- Modal content -->
                                <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                    <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="deleteModal">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    <p class="mb-4 text-gray-500 dark:text-gray-300">Are you sure you want to delete this item?</p>
                                    <div class="flex justify-center items-center space-x-4">
                                        <button data-modal-toggle="deleteModal" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                            No, cancel
                                        </button>
                                        <a href="" class="btn btn-danger py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                            Yes, I'm sure
                                        </a>
                                    </div>
                                </div>
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
            <span class="block text-[10px] dark:text-red-500">Rp.{{ number_format($restaurants->harga,2) }} </span>

            @foreach ($add_ons as $add_on)
                @foreach (old('add_on_id') ?? $restaurant_add_on as $id)
                    @if ($id == $add_on->id)
                        <div class="flex gap-1 opacity-75 mt-auto w-full">
                            <div class="grid space-y-3">
                                <input type="hidden" name="add_on_title[]" value="{{ $add_on->title }}" id="">
                                
                                <p aria-hidden="true" class="text-lg mt-1 font-semibold dark:text-gray-300">{{ $add_on->title ?? 'Error' }} (Pilih {{ $add_on->minimum_choice  }} )</p>
                                @foreach ($add_on->detailAddOn as $item)
                                    
                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5 mt-1">
                                        <input id="hs-checkbox-delete" value="{{ $item->harga }}" name="harga_add[]" type="checkbox" class="{{ str_replace(' ', '-', strtolower($add_on->title)) }} border-gray-200 rounded text-blue-600 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" aria-describedby="hs-checkbox-delete-description">
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
                    @endif
                @endforeach
            @endforeach
        </div>
    </div>
    
    
        <div class="mt-2">
            <input type="hidden" name="id" value="{{ $restaurants->id }}" id="">
            <input type="hidden" name="nama" value="{{ $restaurants->nama }}" id="">
            <input type="hidden" name="harga" value="{{ $restaurants->harga }}" id="">
            <input type="hidden" name="image" value="{{ $image.$restaurants->image }}" id="">
            {{-- <input type="hidden" name="quantity" value="1" id=""> --}}
            <button class="w-full h-full p-3 bg-blue-500 dark:text-white rounded-b-[30px] hover:bg-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-900">Checkout</button>
        </div>
    </form>
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

    function add(slug, $id){
        let getVar = parseInt($('.counter').val());
        if(!getVar || getVar == NaN){
            getVar = 1;
            $('.counter').val(getVar);
        }else{
            getVar = getVar + 1;
            $('.counter').val(getVar);
        }

        // $.ajax({
        //     type: 'POST',
        //     url: "{{ route('cart-update') }}",
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     },
        //     data: {
        //         "_token": "{{ csrf_token() }}",
        //         "qty": getVar,
        //         "id": $id
        //     },
        //     success: function (data) {
        //         // location.reload();
        //         // window.location.href(url)
        //     },
        //     error: function (data) {
        //         $.alert('Failed!');
        //         console.log(data);
        //     }
        // });
    }

    function remove(slug, $id){
        let getVar = parseInt($('.counter').val());
        if(!getVar || getVar == NaN){
            getVar = 0;
            $('.counter').val(getVar);
        }else{
            getVar = getVar - 1;
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
    const maxChecked2 = {{ $add_on->minimum_choice }}; // Jumlah maksimum nilai yang dapat dicentang

    const checkboxes2 = document.querySelectorAll('.{{ str_replace(' ', '-', strtolower($add_on->title)) }}');
    let checkedCount2 = 0;

    checkboxes2.forEach(checkbox2 => {
        checkbox2.addEventListener('change', function() {
            if (this.checked) {
                checkedCount2++;
            } else {
                checkedCount2--;
            }

            if (checkedCount2 > maxChecked2) {
                this.checked = false; // Mencegah centangan lebih dari jumlah maksimum
                checkedCount2--;
            }
        });
    });
 </script>
@endpush
