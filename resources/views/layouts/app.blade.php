<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.partials.head')
</head>
<body class="dark:bg-gray-900 max-w-3xl mx-auto">

@include('layouts.partials.header')

{{-- <hr class="mx-auto" style="width: 95%"> --}}
<div class="z-40 absolute top-24 left-1/2 transform -translate-x-1/2 w-11/12 p-4 bg-[#1d2943] border border-gray-200 rounded-lg shadow mx-auto dark:bg-[#1d2943] dark:border-[#16274b]">
    <div class="grid grid-cols-2">
        <div class="flex items-center space-x-4">
            <div class="flex-shrink-0 bg-white rounded-full p-2">
                <svg class="w-6 h-6 text-[#1d2943]" fill="currentColor"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                    <path d="M64 32C28.7 32 0 60.7 0 96v32H576V96c0-35.3-28.7-64-64-64H64zM576 224H0V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V224zM112 352h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm112 16c0-8.8 7.2-16 16-16H368c8.8 0 16 7.2 16 16s-7.2 16-16 16H240c-8.8 0-16-7.2-16-16z"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                    Saldo
                </p>
                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                    Rp. 500.000
                </p>
            </div>
        </div>
        <div class="flex items-center space-x-4">
            <div class="flex-shrink-0 bg-white rounded-full p-2">
                <svg class="w-6 h-6 text-[#1d2943]" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                    <path d="M64 64C28.7 64 0 92.7 0 128V384c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H64zM272 192H496c8.8 0 16 7.2 16 16s-7.2 16-16 16H272c-8.8 0-16-7.2-16-16s7.2-16 16-16zM256 304c0-8.8 7.2-16 16-16H496c8.8 0 16 7.2 16 16s-7.2 16-16 16H272c-8.8 0-16-7.2-16-16zM164 152v13.9c7.5 1.2 14.6 2.9 21.1 4.7c10.7 2.8 17 13.8 14.2 24.5s-13.8 17-24.5 14.2c-11-2.9-21.6-5-31.2-5.2c-7.9-.1-16 1.8-21.5 5c-4.8 2.8-6.2 5.6-6.2 9.3c0 1.8 .1 3.5 5.3 6.7c6.3 3.8 15.5 6.7 28.3 10.5l.7 .2c11.2 3.4 25.6 7.7 37.1 15c12.9 8.1 24.3 21.3 24.6 41.6c.3 20.9-10.5 36.1-24.8 45c-7.2 4.5-15.2 7.3-23.2 9V360c0 11-9 20-20 20s-20-9-20-20V345.4c-10.3-2.2-20-5.5-28.2-8.4l0 0 0 0c-2.1-.7-4.1-1.4-6.1-2.1c-10.5-3.5-16.1-14.8-12.6-25.3s14.8-16.1 25.3-12.6c2.5 .8 4.9 1.7 7.2 2.4c13.6 4.6 24 8.1 35.1 8.5c8.6 .3 16.5-1.6 21.4-4.7c4.1-2.5 6-5.5 5.9-10.5c0-2.9-.8-5-5.9-8.2c-6.3-4-15.4-6.9-28-10.7l-1.7-.5c-10.9-3.3-24.6-7.4-35.6-14c-12.7-7.7-24.6-20.5-24.7-40.7c-.1-21.1 11.8-35.7 25.8-43.9c6.9-4.1 14.5-6.8 22.2-8.5V152c0-11 9-20 20-20s20 9 20 20z"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                    Total Transaksi
                </p>
                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                    0
                </p>
            </div>
        </div>
    </div>
</div>
<div class="mt-14"></div>
@yield('content')

@include('layouts.partials.footer')
<div id="signoutModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto p-3 overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full sm:inset-0 h-full delay-200">
    <div class="relative flex flex-col bg-white shadow-lg rounded-xl dark:bg-gray-800">
        <div class="absolute top-2 right-2">
          <button type="button" class="inline-flex flex-shrink-0 justify-center items-center h-8 w-8 rounded-md text-gray-500 hover:text-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 focus:ring-offset-white transition-all text-sm dark:focus:ring-gray-700 dark:focus:ring-offset-gray-800" data-modal-toggle="signoutModal">
            <span class="sr-only">Close</span>
            <svg class="w-3.5 h-3.5" width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M0.258206 1.00652C0.351976 0.912791 0.479126 0.860131 0.611706 0.860131C0.744296 0.860131 0.871447 0.912791 0.965207 1.00652L3.61171 3.65302L6.25822 1.00652C6.30432 0.958771 6.35952 0.920671 6.42052 0.894471C6.48152 0.868271 6.54712 0.854471 6.61352 0.853901C6.67992 0.853321 6.74572 0.865971 6.80722 0.891111C6.86862 0.916251 6.92442 0.953381 6.97142 1.00032C7.01832 1.04727 7.05552 1.1031 7.08062 1.16454C7.10572 1.22599 7.11842 1.29183 7.11782 1.35822C7.11722 1.42461 7.10342 1.49022 7.07722 1.55122C7.05102 1.61222 7.01292 1.6674 6.96522 1.71352L4.31871 4.36002L6.96522 7.00648C7.05632 7.10078 7.10672 7.22708 7.10552 7.35818C7.10442 7.48928 7.05182 7.61468 6.95912 7.70738C6.86642 7.80018 6.74102 7.85268 6.60992 7.85388C6.47882 7.85498 6.35252 7.80458 6.25822 7.71348L3.61171 5.06702L0.965207 7.71348C0.870907 7.80458 0.744606 7.85498 0.613506 7.85388C0.482406 7.85268 0.357007 7.80018 0.264297 7.70738C0.171597 7.61468 0.119017 7.48928 0.117877 7.35818C0.116737 7.22708 0.167126 7.10078 0.258206 7.00648L2.90471 4.36002L0.258206 1.71352C0.164476 1.61976 0.111816 1.4926 0.111816 1.36002C0.111816 1.22744 0.164476 1.10028 0.258206 1.00652Z" fill="currentColor"></path>
            </svg>
          </button>
        </div>

        <div class="p-4 sm:p-10 text-center overflow-y-auto">
          <!-- Icon -->
          <span class="mb-4 inline-flex justify-center items-center w-[62px] h-[62px] rounded-full border-4 border-yellow-50 bg-yellow-100 text-yellow-500">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
            </svg>
          </span>
          <!-- End Icon -->

          <h3 class="mb-2 text-2xl font-bold text-gray-800 dark:text-gray-200">
            Sign out
          </h3>
          <p class="text-gray-500">
            Are you sure you would like to sign out?
          </p>

          <div class="mt-6 grid gap-y-2">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="py-2.5 px-4 w-full inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-gray-800 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800" type="submit">
                  Sign out
                </button>
            </form>
            <button type="button" class="py-2.5 px-4 w-full inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800" data-modal-toggle="signoutModal">
              Cancel
            </button>
          </div>
        </div>
    </div>
</div>

@include('modal.vpay')
</body>

@include('layouts.partials.foot')
</html>
