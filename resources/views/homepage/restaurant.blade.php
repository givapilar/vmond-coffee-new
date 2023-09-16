@extends('layouts.app')

@push('style-top')
<style>
    .skeleton {
    width: 100%;
    height: 100%;
    background-size: 200% 100%;
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

@push('style-bot')

@endpush

@section('content')
<section class="p-3">
    {{-- <div class="flex items-center justify-between mb-1">
        <div class="mb-2">
            <span class="text-lg font-bold dark:text-white ml-1">Category</span>
        </div>
    </div>
    <hr> --}}

    <div class="grid grid-cols-1 gap-3 skeleton">
        <a href="{{ route('daftar-restaurant', ['category' => 'food', 'kode_meja' => Request::get('kode_meja')]) }}">
            <div class="text-base sm:text-sm p-1">
                <div class="aspect-h-1 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75 border border-[#16274b] shadow-lg" style="height: 15.5rem;">
                    <img src="{{ asset('assetku/dataku/img/cover.jpg') }}" alt="" class="object-cover object-center h-full w-full">
                </div>

                <p aria-hidden="true" class="text-sm text-center mt-1 dark:text-gray-300" style="font-weight: 700;">FOODS</p>
            </div>
        </a>
        <a href="{{ route('daftar-restaurant', ['category' => 'drink', 'kode_meja' => Request::get('kode_meja')]) }}">
            <div class="text-base sm:text-sm p-1">
                <div class="aspect-h-1 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75 border border-[#16274b] shadow-lg" style="height: 15.5rem;">
                    <img src="{{ asset('assetku/dataku/img/drink.jpg') }}" alt="." class="object-cover object-center h-full w-full">
                </div>

                <p aria-hidden="true" class="text-sm text-center mt-1 dark:text-gray-300" style="font-weight: 700;">DRINKS</p>
            </div>
        </a>
    </div>
</section>

<section class="p-3">
    <div id="default-carousel" class="relative w-full skeleton" data-carousel="slide">
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



<div class="pb-[5rem]"></div>
@endsection

@push('script-top')

@endpush

@push('script-bot')

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var lazyloadImages = document.querySelectorAll(".lazyload");

        var observer = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    var img = entry.target;
                    img.src = img.getAttribute("data-src");
                    img.classList.remove("lazyload");
                    observer.unobserve(img);
                }
            });
        });

        lazyloadImages.forEach(function(img) {
            observer.observe(img);
        });
    });
</script>


<script>
    $('.slick1').slick({
        infinite:false,
        arrows: false,
        slidesToShow: 5,
        slidesToScroll: 1,
        autoplay: false,
        speed:200,
        responsive: [
            {
            breakpoint: 1024,
                settings: {
                    slidesToShow: 4,
                }
            },
            {
            breakpoint: 800,
                settings: {
                    slidesToShow: 4,
                }
            },
            {
            breakpoint: 480,
                settings: {
                    slidesToShow: 3,
                }
            }
        ]
    });
    $('.meeting-rooms').slick({
        infinite:false,
        arrows: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: false,
        speed:200,
    });

//     Toastify({

// text: "This is a toast",

// duration: 3000

// }).showToast();

 </script>




@endpush
