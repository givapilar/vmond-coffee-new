<!DOCTYPE html>
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
    <div class="container">
        <button onclick="getToken()" class="btn btn-sm btn-primary">Get Token</button>
    </div>
    {{-- <button onclick="test()">Test</button> --}}
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.1/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script>
    let token = '';
    function test() {
        axios.post("https://vmondcoffee.controlindo.com/v1/integration/get-token-fintech").then(function (response) {
            // console.log('RESPONSE DATA:: '+response.data)
            token = response.data.data.token;
            // console.log('RESPONSE DATA2:: '+response.data.data)
            console.log('RESPONSE DATA3:: '+response.data.data.token)
            // console.log('RES:: ', response)
            // do whatever you want if console is [object object] then stringify the response
        })
    }
    
    function getToken(id) {
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
                                    token = res.data.data.token;
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
</script>
</html>