<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aktivasi</title>
</head>
<body>
    <button onclick="test()">Test</button>
</body>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.1/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script>
    let token = '';
    function test() {
        axios.post("https://vmondcoffee.controlindo.com/v1/integration/get-token-fintech").then(function (response) {
            console.log('RESPONSE DATA:: '+response.data)
            console.log('RESPONSE DATA2:: '+response.data.data)
            console.log('RESPONSE DATA3:: '+response.data.data.token)
            console.log('RES:: ', response)
            // do whatever you want if console is [object object] then stringify the response
        })
    }
    
</script>
</html>