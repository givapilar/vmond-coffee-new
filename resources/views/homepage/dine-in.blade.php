@extends('Auth.layouts.app')

@section('content')
<section class="bg-gray-50 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center h-screen px-6 py-8 mx-auto md:h-screen lg:h-screen lg:py-0">
        <div class=" text-center" style="margin-top: 5rem" >
            <img class="mx-auto" src="{{ asset('assetku/dataku/img/logo/logo-vmond.png') }}" alt="logo">
        </div>
        
        <div class=" text-center" style="margin-top: 5rem">
            <img class="mx-auto" src="{{ asset('assetku/dataku/img/logo/logo-vmond.png') }}" alt="logo">
        </div>
        <div class="w-full bg-transparent md:mt-0 max-w-md xl:p-0">
            <div class="px-6 py-2 space-y-4 md:space-y-6 ">
                <button type="submit" style="margin-top: 5rem" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Dine In</button>
                <hr>
                <button type="button" onClick="window.location = '{{ route('register', ['jenis_meja' => Request::get('jenis_meja'), 'kode_meja' => Request::get('kode_meja')]) }}';" class="mt-4 w-full text-white bg-orange-600 hover:bg-orange-700 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800" style="width: 100% !important;">Takeaway</button>
            </div>
        </div>
    </div>
</section>
@endsection
