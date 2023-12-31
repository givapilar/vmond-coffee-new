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
            <span class="text-lg font-bold dark:text-white ml-1">RESERVATION RESTAURANT</span>
        </div>
        {{-- <div class="flex items-center">
            <span class="text-xs dark:text-white">Lihat Semua</span>
            <ion-icon name="chevron-forward-outline" class="dark:text-white"></ion-icon>
        </div> --}}
    </div>

    <div class="slick1 pt-2">
        <div class="text-base sm:text-sm p-1">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="https://images.unsplash.com/photo-1522336572468-97b06e8ef143?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=876&q=80" alt="" class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-2 font-semibold dark:text-gray-300 text-center">Meja 1(Indoor)</p>

                <div class="opacity-75">
                    <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300 dark:text-white">Reserve</button>
                </div>
            </div>
        </div>

        <div class="text-base sm:text-sm p-1">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="https://images.unsplash.com/photo-1522336572468-97b06e8ef143?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=876&q=80" alt="" class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-2 font-semibold dark:text-gray-300 text-center">Meja 2(Indoor)</p>

                <div class="opacity-75">
                    <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300 dark:text-white">Reserve</button>
                </div>
            </div>
        </div>

        <div class="text-base sm:text-sm p-1">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="https://images.unsplash.com/photo-1522336572468-97b06e8ef143?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=876&q=80" alt="" class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-2 font-semibold dark:text-gray-300 text-center">Meja 3(Indoor)</p>

                <div class="opacity-75">
                    <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300 dark:text-white">Reserve</button>
                </div>
            </div>
        </div>

        <div class="text-base sm:text-sm p-1">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="https://images.unsplash.com/photo-1522336572468-97b06e8ef143?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=876&q=80" alt="" class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-2 font-semibold dark:text-gray-300 text-center">Meja 4(Indoor)</p>

                <div class="opacity-75">
                    <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300 dark:text-white">Reserve</button>
                </div>
            </div>
        </div>

        <div class="text-base sm:text-sm p-1">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="https://images.unsplash.com/photo-1522336572468-97b06e8ef143?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=876&q=80" alt="" class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-2 font-semibold dark:text-gray-300 text-center">Meja 5(Indoor)</p>

                <div class="opacity-75">
                    <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300 dark:text-white">Reserve</button>
                </div>
            </div>
        </div>

        <div class="text-base sm:text-sm p-1">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="https://images.unsplash.com/photo-1522336572468-97b06e8ef143?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=876&q=80" alt="" class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-2 font-semibold dark:text-gray-300 text-center">Meja 6(Indoor)</p>

                <div class="opacity-75">
                    <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300 dark:text-white">Reserve</button>
                </div>
            </div>
        </div>
    </div>

    <div class="slick1 pt-2">
        <div class="text-base sm:text-sm p-1">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="https://images.unsplash.com/photo-1571515476930-f59475a66a58?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=869&q=80" alt="" class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-2 font-semibold dark:text-gray-300 text-center">Meja 1(Outdoor)</p>

                <div class="opacity-75">
                    <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300 dark:text-white">Reserve</button>
                </div>
            </div>
        </div>

        <div class="text-base sm:text-sm p-1">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="https://images.unsplash.com/photo-1571515476930-f59475a66a58?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=869&q=80" alt="" class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-2 font-semibold dark:text-gray-300 text-center">Meja 2(Outdoor)</p>

                <div class="opacity-75">
                    <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300 dark:text-white">Reserve</button>
                </div>
            </div>
        </div>

        <div class="text-base sm:text-sm p-1">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="https://images.unsplash.com/photo-1571515476930-f59475a66a58?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=869&q=80" alt="" class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-2 font-semibold dark:text-gray-300 text-center">Meja 3(Outdoor)</p>

                <div class="opacity-75">
                    <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300 dark:text-white">Reserve</button>
                </div>
            </div>
        </div>

        <div class="text-base sm:text-sm p-1">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="https://images.unsplash.com/photo-1571515476930-f59475a66a58?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=869&q=80" alt="" class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-2 font-semibold dark:text-gray-300 text-center">Meja 4(Outdoor)</p>

                <div class="opacity-75">
                    <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300 dark:text-white">Reserve</button>
                </div>
            </div>
        </div>

        <div class="text-base sm:text-sm p-1">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="https://images.unsplash.com/photo-1571515476930-f59475a66a58?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=869&q=80" alt="" class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-2 font-semibold dark:text-gray-300 text-center">Meja 5(Outdoor)</p>

                <div class="opacity-75">
                    <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300 dark:text-white">Reserve</button>
                </div>
            </div>
        </div>

        <div class="text-base sm:text-sm p-1">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="https://images.unsplash.com/photo-1571515476930-f59475a66a58?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=869&q=80" alt="" class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-2 font-semibold dark:text-gray-300 text-center">Meja 6(Outdoor)</p>

                <div class="opacity-75">
                    <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300 dark:text-white">Reserve</button>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="p-3">
    <div class="flex items-center justify-between">
        <div class="">
            <span class="text-lg font-bold dark:text-white ml-1">RESERVATION BILLIARD</span>
        </div>
        {{-- <div class="flex items-center">
            <span class="text-xs dark:text-white">Lihat Semua</span>
            <ion-icon name="chevron-forward-outline" class="dark:text-white"></ion-icon>
        </div> --}}
    </div>

    <div class="slick1 pt-2">
        <div class="text-base sm:text-sm p-1">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="https://images.unsplash.com/photo-1535066925810-38b22c6b8255?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1372&q=80" alt="" class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-2 font-semibold dark:text-gray-300 text-center">Meja 1</p>

                <div class="opacity-75">
                    <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300 dark:text-white text-center">Reserve</button>
                </div>
            </div>
        </div>
        <div class="text-base sm:text-sm p-1">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="https://images.unsplash.com/photo-1535066925810-38b22c6b8255?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1372&q=80" alt="" class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-2 font-semibold dark:text-gray-300 text-center">Meja 2</p>

                <div class="opacity-75">
                    <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300 dark:text-white text-center">Reserve</button>
                </div>
            </div>
        </div>
        <div class="text-base sm:text-sm p-1">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="https://images.unsplash.com/photo-1535066925810-38b22c6b8255?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1372&q=80" alt="" class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-2 font-semibold dark:text-gray-300 text-center">Meja 3</p>

                <div class="opacity-75">
                    <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300 dark:text-white text-center">Reserve</button>
                </div>
            </div>
        </div>
        <div class="text-base sm:text-sm p-1">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="https://images.unsplash.com/photo-1535066925810-38b22c6b8255?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1372&q=80" alt="" class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-2 font-semibold dark:text-gray-300 text-center">Meja 4</p>

                <div class="opacity-75">
                    <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300 dark:text-white text-center">Reserve</button>
                </div>
            </div>
        </div>
        <div class="text-base sm:text-sm p-1">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="https://images.unsplash.com/photo-1535066925810-38b22c6b8255?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1372&q=80" alt="" class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-2 font-semibold dark:text-gray-300 text-center">Meja 5</p>

                <div class="opacity-75">
                    <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300 dark:text-white text-center">Reserve</button>
                </div>
            </div>
        </div>
        <div class="text-base sm:text-sm p-1">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="https://images.unsplash.com/photo-1535066925810-38b22c6b8255?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1372&q=80" alt="" class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-2 font-semibold dark:text-gray-300 text-center">Meja 6</p>

                <div class="opacity-75">
                    <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300 dark:text-white text-center">Reserve</button>
                </div>
            </div>
        </div>
        <div class="text-base sm:text-sm p-1">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="https://images.unsplash.com/photo-1535066925810-38b22c6b8255?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1372&q=80" alt="" class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-2 font-semibold dark:text-gray-300 text-center">Meja 7</p>

                <div class="opacity-75">
                    <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300 dark:text-white text-center">Reserve</button>
                </div>
            </div>
        </div>
        <div class="text-base sm:text-sm p-1">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="https://images.unsplash.com/photo-1535066925810-38b22c6b8255?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1372&q=80" alt="" class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-2 font-semibold dark:text-gray-300 text-center">Meja 8</p>

                <div class="opacity-75">
                    <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300 dark:text-white text-center">Reserve</button>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="p-3">
    <div class="flex items-center justify-between">
        <div class="">
            <span class="text-lg font-bold dark:text-white ml-1"> RESERVATION MEETING ROOM</span>
        </div>
        {{-- <div class="flex items-center">
            <span class="text-xs dark:text-white">Lihat Semua</span>
            <ion-icon name="chevron-forward-outline" class="dark:text-white"></ion-icon>
        </div> --}}
    </div>

    <div class="slick1 pt-2">
        <div class="text-base sm:text-sm p-1">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="https://images.unsplash.com/photo-1462826303086-329426d1aef5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80" alt="" class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-1 font-semibold dark:text-gray-300">Room 1</p>

                <div class="opacity-75">
                    <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300 dark:text-white text-center">Reserve</button>
                </div>
            </div>
        </div>
        <div class="text-base sm:text-sm p-1">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="https://images.unsplash.com/photo-1462826303086-329426d1aef5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80" alt="" class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-1 font-semibold dark:text-gray-300">Room 2</p>

                <div class="opacity-75">
                    <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300 dark:text-white text-center">Reserve</button>
                </div>
            </div>
        </div>
        <div class="text-base sm:text-sm p-1">
            <div class="aspect-h-1 h-24 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="https://images.unsplash.com/photo-1462826303086-329426d1aef5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80" alt="" class="object-cover object-center h-full w-full">
            </div>
            <div class="px-1">
                <p aria-hidden="true" class="text-xs mt-1 font-semibold dark:text-gray-300">Room 3</p>

                <div class="opacity-75">
                    <button class="w-full bg-sky-500 text-xs rounded-lg mt-2 p-1 hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-300 dark:text-white text-center">Reserve</button>
                </div>
            </div>
        </div>
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
