`<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aktivasi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container my-3 gap-3">
        <button onclick="getToken()" class="btn btn-sm btn-primary">Get Token</button>
        <button onclick="sendOTP()" class="btn btn-sm btn-warning">Send OTP</button>
        <button onclick="aktivasi()" class="btn btn-sm btn-success">Aktivasi</button>
        <button onclick="createQris()" class="btn btn-sm btn-secondary">Create Qris</button>
        {{-- <canvas id="barcode" style="width: 300px; height: 400px;"></canvas> --}}
        {{-- <input type="text" id="qrCodeData" placeholder="Masukkan data QR">
        <button id="generateQR">Generate QR</button> --}}

        <div id="deleteModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full sm:inset-0 h-full delay-200">
            <div class="relative p-4 w-full max-w-md h-auto">
                <!-- Modal content -->
                <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                    <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="deleteModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    <div id="qrcode"></div> <!-- Tambahkan elemen ini -->
                    <p class="mb-4 text-gray-500 dark:text-gray-300">Apakah anda yakin ingin menyelesaikan pesanan?</p>
                    <div class="flex justify-center items-center space-x-4">
                        <button data-modal-toggle="deleteModal" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            No, cancel
                        </button>
                        <form action="{{ route('checkout-waiters') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                Yes, I'm sure
                            </button>
                        </form>                            
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <button onclick="test()">Test</button> --}}
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.1/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<!-- bwip-js -->
<script src="https://unpkg.com/bwip-js"></script>
<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>

<script>
    let token = '';
    let reference = '';

    function getToken() {
        $.confirm({
            title: 'Get Token',
            content: "URL:{{ route('get-token') }}",
            columnClass: 'medium',
            type: 'blue',
            typeAnimated: true,
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function() {
                        let msisdn, password;
                        
                        msisdn = this.$content.find('#msisdn').val();
                        password = this.$content.find('#password').val();

                        $.ajax({
                            type: 'POST',
                            url: "{{ route('get-token-fintech') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_token": "{{ csrf_token() }}",
                                msisdn,
                                password,
                            },
                            async: false,
                            success: function(res) {
                                console.log(res);
                                token = res.data.token;
                                alert('Berhasil! Get Token.');
                            },
                            error: function(data) {
                                console.log(data);
                                $.alert(data.responseJSON.message);
                            }
                        });
                    }
                },
                cancel: function() {
                    //close
                },
            },
            onContentReady: function() {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function(e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    }

    function sendOTP() {
        console.log(token);
        $.confirm({
            title: 'Send OTP',
            content: "URL:{{ route('send-otp') }}",
            columnClass: 'medium',
            type: 'blue',
            typeAnimated: true,
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function() {
                        let dttoken, notelp;
                        
                        dttoken = token;
                        notelp = this.$content.find('#no_telp').val();
                        console.log('no tlp', notelp);

                        $.ajax({
                            type: 'POST',
                            url: "{{ route('send-otp-fintech') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_token": "{{ csrf_token() }}",
                                dttoken,
                                notelp,
                            },
                            async: false,
                            success: function(res) {
                                reference = res.data.reference;
                                // console.log("Response :" ,res);
                                alert('Berhasil! Send OTP.');
                            },
                            error: function(data) {
                                console.log(data);
                                $.alert(data.responseJSON.message);
                            }
                        });
                    }
                },
                cancel: function() {
                    //close
                },
            },
            onContentReady: function() {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function(e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    }

    function aktivasi() {
        $.confirm({
            title: 'Aktivasi',
            content: "URL:{{ route('aktivasi') }}",
            columnClass: 'medium',
            type: 'blue',
            typeAnimated: true,
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function() {
                        let dttoken, msisdn, pin, product, dtreference;
                        
                        dttoken = token;
                        msisdn = this.$content.find('#msisdn').val();
                        pin = this.$content.find('#pin').val();
                        product = this.$content.find('#product').val();
                        dtreference = reference;

                        $.ajax({
                            type: 'POST',
                            url: "{{ route('aktivasi-merchant') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_token": "{{ csrf_token() }}",
                                dttoken,
                                msisdn,
                                pin,
                                product,
                                dtreference,
                            },
                            async: false,
                            success: function(res) {
                                // console.log("Response :" res);
                                alert('Anda Berhasil Aktivasi!');
                            },
                            error: function(data) {
                                console.log(data);
                                $.alert(data.responseJSON.message);
                            }
                        });
                    }
                },
                cancel: function() {
                    //close
                },
            },
            onContentReady: function() {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function(e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    }

    function createQris() {
        $.confirm({
            title: 'Create Qris',
            content: "URL:{{ route('create-qris') }}",
            columnClass: 'medium',
            type: 'blue',
            typeAnimated: true,
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function() {
                        let amount, expired;
                        
                        amount = this.$content.find('#amount').val();
                        expired = this.$content.find('#expired').val();

                        $.ajax({
                            type: 'POST',
                            url: "{{ route('create-qris-merchant') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_token": "{{ csrf_token() }}",
                                amount,
                                expired,
                            },
                            async: false,
                            success: function(res) {
                                console.log(res);
                                console.log(res.data.stringQR);
                                if (res.data.code === 200) {
                                    // If the response status is 200, it's successful
                                    // Show the modal here
                                    var deleteModal = document.getElementById("deleteModal");
                                    deleteModal.classList.remove("hidden");
                                    generateQR(res.data.stringQR);
                                } else {
                                    // Handle other response statuses if needed
                                    console.error("Error:", response.status);
                                }
                                // alert('Anda Berhasil Create QR!');
                            },
                            error: function(data) {
                                console.log(data);
                                $.alert(data.responseJSON.message);
                            }
                        });
                    }
                },
                cancel: function() {
                    //close
                },
            },
            onContentReady: function() {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function(e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    }

    function generateQR(strQR) {
        // Create a QRious instance
        var qr = new QRious({
            element: document.getElementById("qrcode"),
            value: strQR,
            size: 200, // Adjust the size as needed
        });

        // Optionally, you can also display the QR code image in a pop-up
        var qrImage = new Image();
        qrImage.src = qr.toDataURL();

        var confirmation = window.confirm("Do you want to view the QR Code?\nClick OK to view it.");

        if (confirmation) {
            document.body.appendChild(qrImage);
        }
    }

</script>
</html>