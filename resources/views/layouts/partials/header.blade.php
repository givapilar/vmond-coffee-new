<header>
    {{-- {{ dd(substr($_SERVER['REQUEST_URI'],0,strrpos($_SERVER['REQUEST_URI'],'/'))) }} --}}
    <nav class="h-28 p-0" style="background: url('https://images.unsplash.com/photo-1606787366850-de6330128bfc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80') !important;">
        <div class="max-w-screen-xl h-full flex flex-wrap items-start justify-between mx-auto p-4 backdrop-brightness-50">
            <a href="https://flowbite.com/" class="">
                <span class="block self-center text-2xl font-semibold whitespace-nowrap dark:text-white">VMOND</span>
                <span class="block self-center text-xs font-normal whitespace-nowrap dark:text-white">Hi, {{ Auth::user()->name ?? 'Guest' }}</span>
            </a>

            @php
                $cart_array = cartArray();
            @endphp
            <div class="flex items-center sm:order-2">

                <a href="{{ route('reservation') }}" class="flex mr-5">
                    <ion-icon name="grid" class="text-2xl dark:text-white"></ion-icon>
                </a>

                <a href="{{ route('cart') }}" class="flex mr-5">
                    <ion-icon name="cart" class="text-2xl dark:text-white"></ion-icon>
                    {{-- <p class="text-white">
                        (<?=count($cart_array)?>)
                    </p> --}}
                    @if (Auth::check())
                        <p class="text-white">({{count(\Cart::session(Auth::user()->id)->getContent())}})</p>
                    @else
                        <p class="text-white">(0)</p>
                    @endif
                </a>

                <button type="button" class="flex mr-3 text-sm bg-gray-800 rounded-full sm:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-8 h-8 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1374&q=80" alt="user photo">
                </button>
                <!-- Dropdown menu -->
                <div class="z-40 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600 w-[10rem]" id="user-dropdown">
                    <div class="px-4 py-3">
                        <span class="block text-sm text-gray-900 dark:text-white">{{ Auth::user()->username ?? 'Guest' }}</span>
                        @if (Auth::user() != null)
                            <span class="block text-sm  text-gray-500 truncate dark:text-gray-400">{{ 'Rp. ' . Auth::user()->balance. ',-' ?? '' }}</span>
                        @endif
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                            <a href="{{ route('homepage') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Home</a>
                        </li>

                        @if (Auth::user() != null)
                        <li>
                            <a href="{{url('users/'.Auth::user()->id.'/edit')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Profile</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white" data-modal-toggle="signoutModal">Sign out</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
