
<!-- Main modal -->
<div id="notification-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full overflow-x-hidden overflow-y-auto md:inset-0 h-full max-h-full">
    <div class="relative w-full h-full max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white shadow h-full dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white flex gap-2 items-center mt-1">
                    <svg class="w-6 h-6 mb-[5px] text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" aria-hidden="true">
                        <path d="M224 0c-17.7 0-32 14.3-32 32V51.2C119 66 64 130.6 64 208v18.8c0 47-17.3 92.4-48.5 127.6l-7.4 8.3c-8.4 9.4-10.4 22.9-5.3 34.4S19.4 416 32 416H416c12.6 0 24-7.4 29.2-18.9s3.1-25-5.3-34.4l-7.4-8.3C401.3 319.2 384 273.9 384 226.8V208c0-77.4-55-142-128-156.8V32c0-17.7-14.3-32-32-32zm45.3 493.3c12-12 18.7-28.3 18.7-45.3H224 160c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7z"/>
                    </svg>
                    Notification
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="notification-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->

            <div class="p-3 space-y-4 h-full max-h-[77%] overflow-y-scroll">
                <div class="flex items-center bg-gray-600 rounded-lg p-2 border border-gray-500 hover:brightness-75">
                    <div class="relative inline-block shrink-0">
                        <img class="w-14 h-14 rounded-full" src="{{ asset('assetku/dataku/img/history-notification.jpg') }}" alt="History Notif"/>
                    </div>
                    <div class="grow ml-3 text-sm font-normal">
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">#23123 Transaction</div>
                        <span class="text-xs font-medium text-blue-600 dark:text-blue-500">a few seconds ago</span>
                    </div>
                    <div class="shrink-0">
                        <img class="w-10 h-10 rounded-full p-2" src="{{ asset('assetku/dataku/img/right-arrow.png') }}" alt="History Notif"/>
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
