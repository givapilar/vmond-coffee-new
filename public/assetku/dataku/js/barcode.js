// ==========================================
// Function Generate QR By Request Server
// ==========================================
function createQris(dtamount, dturl) {
    let amount = dtamount;
    
    $.ajax({
        type: 'POST',
        url: dturl,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            "_token": "{{ csrf_token() }}",
            amount,
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
        content: '<img src="' + qrDataUrl + '" width="70%" height="70%" style="display:block; margin-right:auto; margin-left:auto;">',
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
// ==========================================
// Function Generate QR By Request Server
// ==========================================