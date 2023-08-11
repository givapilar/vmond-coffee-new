
<!-- Main modal -->
<div id="vpay-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full overflow-x-hidden overflow-y-auto md:inset-0 h-full max-h-full">
    <div class="relative w-full h-full max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white shadow h-full dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    V-PAY
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="vpay-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->

            <div class="p-6 space-y-6 h-full max-h-[77%] overflow-y-scroll">
                <div class="grid mb-4 border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 md:grid-cols-2">
                    <figure class="flex flex-col items-start justify-start p-4 text-center bg-white sm:rounded-lg border-b border-gray-200 md:rounded-t-lg md:rounded-bl-lg dark:bg-gray-800 dark:border-gray-700">
                        <figcaption class="flex items-start justify-start space-x-3">
                            <svg class="w-9 h-9 text-gray-400" fill="currentColor"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                <path d="M64 32C28.7 32 0 60.7 0 96v32H576V96c0-35.3-28.7-64-64-64H64zM576 224H0V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V224zM112 352h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm112 16c0-8.8 7.2-16 16-16H368c8.8 0 16 7.2 16 16s-7.2 16-16 16H240c-8.8 0-16-7.2-16-16z"/>
                            </svg>
                            <div class="space-y-0.5 font-medium dark:text-white text-left">
                                <div>Saldo</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Rp. 500.000</div>
                            </div>
                        </figcaption>
                    </figure>
                    <figure class="flex flex-col items-start justify-start p-4 text-center sm:rounded-lg md:rounded-br-lg md:rounded-tr-lg bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 sm:mt-3">
                        <figcaption class="flex items-start justify-start space-x-3">
                            <svg class="w-9 h-9 text-gray-400" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                <path d="M64 64C28.7 64 0 92.7 0 128V384c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H64zM272 192H496c8.8 0 16 7.2 16 16s-7.2 16-16 16H272c-8.8 0-16-7.2-16-16s7.2-16 16-16zM256 304c0-8.8 7.2-16 16-16H496c8.8 0 16 7.2 16 16s-7.2 16-16 16H272c-8.8 0-16-7.2-16-16zM164 152v13.9c7.5 1.2 14.6 2.9 21.1 4.7c10.7 2.8 17 13.8 14.2 24.5s-13.8 17-24.5 14.2c-11-2.9-21.6-5-31.2-5.2c-7.9-.1-16 1.8-21.5 5c-4.8 2.8-6.2 5.6-6.2 9.3c0 1.8 .1 3.5 5.3 6.7c6.3 3.8 15.5 6.7 28.3 10.5l.7 .2c11.2 3.4 25.6 7.7 37.1 15c12.9 8.1 24.3 21.3 24.6 41.6c.3 20.9-10.5 36.1-24.8 45c-7.2 4.5-15.2 7.3-23.2 9V360c0 11-9 20-20 20s-20-9-20-20V345.4c-10.3-2.2-20-5.5-28.2-8.4l0 0 0 0c-2.1-.7-4.1-1.4-6.1-2.1c-10.5-3.5-16.1-14.8-12.6-25.3s14.8-16.1 25.3-12.6c2.5 .8 4.9 1.7 7.2 2.4c13.6 4.6 24 8.1 35.1 8.5c8.6 .3 16.5-1.6 21.4-4.7c4.1-2.5 6-5.5 5.9-10.5c0-2.9-.8-5-5.9-8.2c-6.3-4-15.4-6.9-28-10.7l-1.7-.5c-10.9-3.3-24.6-7.4-35.6-14c-12.7-7.7-24.6-20.5-24.7-40.7c-.1-21.1 11.8-35.7 25.8-43.9c6.9-4.1 14.5-6.8 22.2-8.5V152c0-11 9-20 20-20s20 9 20 20z"/>
                            </svg>
                            <div class="space-y-0.5 font-medium dark:text-white text-left">
                                <div>Total Transaksi</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">0</div>
                            </div>
                        </figcaption>
                    </figure>
                    {{-- <figure class="flex flex-col items-center justify-center p-8 text-center bg-white border-b border-gray-200 rounded-br-lg rounded-tr-lg md:border-b-0 md:border-r dark:bg-gray-800 dark:border-gray-700">
                        <figcaption class="flex items-center justify-center space-x-3">
                            <img class="rounded-full w-9 h-9" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/jese-leos.png" alt="profile picture">
                            <div class="space-y-0.5 font-medium dark:text-white text-left">
                                <div>Jese Leos</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Software Engineer at Facebook</div>
                            </div>
                        </figcaption>
                    </figure> --}}
                </div>

                <div class="border-2 border-gray-500 border-dashed rounded-lg p-4">
                    <h3 class="text-xl font-normal text-gray-900 text-center mb-3 dark:text-white">Informasi</h3>
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        Jangan lewatkan kesempatan ini untuk mencoba menu-menu baru kami atau kembali menikmati favorit Anda. Diskon 20% akan otomatis diberlakukan saat Anda menggunakan metode pembayaran V-PAY.
                    </p>
                </div>

                <div class="border-2 border-gray-500 border-dashed rounded-lg p-4">
                    <h3 class="text-xl font-normal text-gray-900 text-center mb-3 dark:text-white">Isi Saldo</h3>
                    <div class="transfer-bank">
                        <div class="flex justify-between items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" id="dropdownDefaultButton" data-dropdown-toggle="dropdown">
                            <button class="text-white w-full font-medium rounded-lg text-sm text-center inline-flex items-center" type="button">Transfer Bank</button>
                            <svg class="w-4 h-4 ml-2 text-white" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                        <div id="dropdown" class=" hidden bg-white divide-y divide-gray-100 rounded-lg w-full dark:bg-gray-700 dropdown-vpay">
                            <ul class="py-2 px-6 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                                <li class="p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    <input id="draft" class="peer/draft" type="radio" name="status" />
                                    <label for="draft" class="peer-checked/draft:text-sky-500"> Mandiri</label>
                                </li>
                                <li class="p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    <input id="draft" class="peer/draft" type="radio" name="status" />
                                    <label for="draft" class="peer-checked/draft:text-sky-500"> BCA</label>
                                </li>
                                <li class="p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    <input id="draft" class="peer/draft" type="radio" name="status" />
                                    <label for="draft" class="peer-checked/draft:text-sky-500"> Permata</label>
                                </li>
                            </ul>
                        </div>
                        <!-- Dropdown menu -->
                    </div>
                    <div class="transfer-bank">
                        <div class="flex justify-between items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" id="dropdownKartuDebit" data-dropdown-toggle="dropdown-kartudebit">
                            <button class="text-white w-full font-medium rounded-lg text-sm text-center inline-flex items-center" type="button">Kartu Debit</button>
                            <svg class="w-4 h-4 ml-2 text-white" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                        <div id="dropdown-kartudebit" class=" hidden bg-white divide-y divide-gray-100 rounded-lg w-full dark:bg-gray-700 dropdown-vpay">
                            <ul class="py-2 px-6 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownKartuDebit">
                                <li class="p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    <input id="draft" class="peer/draft" type="radio" name="status" />
                                    <label for="draft" class="peer-checked/draft:text-sky-500"> Mandiri</label>
                                </li>
                                <li class="p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    <input id="draft" class="peer/draft" type="radio" name="status" />
                                    <label for="draft" class="peer-checked/draft:text-sky-500"> BCA</label>
                                </li>
                                <li class="p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    <input id="draft" class="peer/draft" type="radio" name="status" />
                                    <label for="draft" class="peer-checked/draft:text-sky-500"> Permata</label>
                                </li>
                            </ul>
                        </div>
                        <!-- Dropdown menu -->
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="fixed bottom-0 w-full h-auto">
                <div class="flex items-center px-6 py-4 space-x-2 border-t border-gray-200 dark:border-gray-600">
                    <button data-modal-hide="defaultModal" type="button" class="text-white w-full bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Konfirmasi</button>
                </div>
            </div>
        </div>
    </div>
</div>
