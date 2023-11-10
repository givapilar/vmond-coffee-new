@extends('Auth.layouts.app')

@section('content')
<section class="bg-gray-50 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center h-screen px-6 py-8 mx-auto md:h-screen lg:h-screen lg:py-0">
        <div class=" text-center">
            <img class="mx-auto" src="{{ asset('assetku/dataku/img/logo/logo-vmond.png') }}" alt="logo">
        </div>
        <div class=" text-center">
            <img class="mx-auto" src="{{ asset('assetku/dataku/img/logo/logo-vmond.png') }}" alt="logo">
        </div>
        <div class="w-full bg-transparent md:mt-0 max-w-md xl:p-0">
            <div class="px-6 py-2 space-y-4 md:space-y-6 ">
                
                <form class="space-y-4 md:space-y-6" action="{{ route('homepage', ['jenis_meja' => Request::get('jenis_meja'), 'kode_meja' => Request::get('kode_meja')]) }}" method="GET">
                    @csrf
                    <button name="meja" value="dine-in" type="submit" style="margin-top: 10rem;" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Dine in</button>
                    <input type="hidden" name="jenis_meja" value="{{ request('jenis_meja') }}">
                    <input type="hidden" name="kode_meja" value="{{ request('kode_meja') }}">
                    <hr>
                </form>
                <form class="space-y-4 md:space-y-6" action="{{ route('homepage', ['jenis_meja' => Request::get('jenis_meja'), 'kode_meja' => Request::get('kode_meja')]) }}" method="GET">
                    @csrf
                    <input type="hidden" name="jenis_meja" value="{{ request('jenis_meja') }}">
                    <input type="hidden" name="kode_meja" value="{{ request('kode_meja') }}">
                    <button name="meja" value="takeaway" type="submit" class="w-full text-white bg-orange-600 hover:bg-orange-700 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800" style="width: 100% !important;">Takeaway/Pickup</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
