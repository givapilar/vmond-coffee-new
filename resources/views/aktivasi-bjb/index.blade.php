`<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aktivasi</title>
<link rel="stylesheet" href="{{ asset('assetku/dataku/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container my-3 gap-3">
        <button onclick="getToken()" class="btn btn-sm btn-primary">Get Token</button>
        <button onclick="sendOTP()" class="btn btn-sm btn-warning">Send OTP</button>
        <button onclick="aktivasi()" class="btn btn-sm btn-success">Aktivasi</button>
        <button onclick="createQris()" class="btn btn-sm btn-secondary">Create Qris</button>
        <button onclick="generateQris()" class="btn btn-sm btn-secondary">Generate Qris</button>
        {{-- <canvas id="barcode" style="width: 300px; height: 400px;"></canvas> --}}
        {{-- <input type="text" id="qrCodeData" placeholder="Masukkan data QR">
        <button id="generateQR">Generate QR</button> --}}

        <button id="hapusData">Generate Qr</button>

    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.1/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>

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
                                generateQris(res.data.stringQR)
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

<script>
   function generateQris(strQR) {
    // Create a QRious instance
    var qr = new QRious({
        value: strQR,
        size: 200, // Sesuaikan ukuran sesuai kebutuhan
    });

    // Convert the QR code to a data URL
    var qrDataUrl = qr.toDataURL();

    $.confirm({
        title: 'Generate QR Code',
        content: '<img src="' + qrDataUrl + '" width="100%" height="100%">',
        columnClass: 'medium',
        type: 'blue',
        typeAnimated: true,
        buttons: {
            viewQR: {
                text: 'View QR Code',
                btnClass: 'btn-blue',
                action: function () {
                    // Display the QR code image in a pop-up
                    var popup = window.open("", "QR Code", "width=300,height=300");
                    popup.document.body.innerHTML = '<img src="' + qrDataUrl + '" width="100%" height="100%">';
                }
            },
            downloadQR: {
                text: 'Download QR Code',
                btnClass: 'btn-green',
                action: function () {
                    // Trigger download of QR Code image
                    var a = document.createElement('a');
                    a.href = qrDataUrl;
                    a.download = 'qrcode.png'; // Nama file yang akan diunduh
                    a.style.display = 'none';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                }
            },
            close: {
                text: 'Close',
                action: function () {
                    // Close the dialog
                }
            }
        }
    });
}




</script>
    
</html>