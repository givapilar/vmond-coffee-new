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
        <canvas id="barcode" style="width: 300px; height: 400px;"></canvas>
        <div id="qrcode"></div> <!-- Tambahkan elemen ini -->
        <input type="text" id="qrCodeData" placeholder="Masukkan data QR">
        <button id="generateQR">Generate QR</button>
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

<script>
     document.addEventListener("DOMContentLoaded", function () {
            // Ambil referensi ke elemen HTML yang diperlukan
            var qrCodeDataInput = document.getElementById("qrCodeData");
            var generateQRButton = document.getElementById("generateQR");

            // Tambahkan event listener ke tombol "Generate QR"
            generateQRButton.addEventListener("click", function () {
                // Ambil data QR dari input
                var qrCodeData = qrCodeDataInput.value;

                // Buat objek kode QR
                var qrcode = new QRCode(document.getElementById("qrcode"), {
                    text: qrCodeData,
                    width: 128,
                    height: 128,
                });

                // Tampilkan kode QR dalam pop-up konfirmasi
                var imageUrl = document.getElementById("qrcode").querySelector("img").src;
                var confirmation = window.confirm("Apakah Anda ingin melihat Kode QR?\nKlik OK untuk melihatnya.");
                
                if (confirmation) {
                    var qrImage = new Image();
                    qrImage.src = imageUrl;
                    var popupWindow;
                    popupWindow.document.write("<img src='" + imageUrl + "' alt='QR Code'>");
                    popupWindow.document.close();
                }
            });
        });
</script>

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
                                alert('Anda Berhasil Create QR!');
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

</script>
</html>