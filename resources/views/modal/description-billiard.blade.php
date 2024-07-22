
<!-- Main modal -->
<div id="description-modal-billiard" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full overflow-x-hidden overflow-y-auto md:inset-0 h-full max-h-full">
    <div class="relative w-full h-full max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white shadow h-full dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Description
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="description-modal{{ $item->id }}">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->

            <div class="p-6 space-y-6 h-full max-h-[77%] overflow-y-scroll">
                <div class="grid mb-4 border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 md:grid-cols-2">
                    <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" alt="">
                </div>

                <div class="border-2 border-gray-500 border-dashed rounded-lg p-4">
                    <h3 class="text-xl font-normal text-gray-900 text-center mb-3 dark:text-white">Informasi</h3>
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        {{ $item->description ?? ''}}
                    </p>
                </div>
            </div>
            <!-- Modal footer -->
            {{-- <div class="fixed bottom-0 w-full h-auto">
                <div class="flex items-center px-6 py-4 space-x-2 border-t border-gray-200 dark:border-gray-600">
                    <button data-modal-hide="defaultModal" type="button" class="text-white w-full bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Konfirmasi</button>
                </div>
            </div> --}}
        </div>
    </div>
</div>
