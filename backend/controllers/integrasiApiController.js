const jwt = require('jwt-simple');
const secretKey = 'yUyOSXBD8ZB96JKv5e5K4aETVLJcGkubL8d6UlrqERJSVtvDJr';
const axios = require('axios');
require('dotenv').config();
const appENV = process.env.APP_ENV;
let urlGlobal, msisdn, passwordBJB;
// Import socket.io-client
const io = require("socket.io-client");
// Menghubungkan ke server Socket.IO
const socket = io('http://localhost:2222'); // Sesuaikan URL server Socket.IO

// ====================================================
// Check APP ENV (Development or Production)
// ====================================================
// if (appENV == 'Development') {
    urlGlobal = process.env.URL_GLOBAL_DEV;
    msisdn = process.env.MSISDN_DEV;
    passwordBJB = process.env.PASSWORD_DEV;
// }else if(appENV == 'Production'){
    // urlGlobal = process.env.URL_GLOBAL_PROD;
    // msisdn = process.env.MSISDN_PROD;
    // passwordBJB = process.env.PASSWORD_PROD;
// }
// ====================================================

const getURL = (req, res) => {
    const resCallback = "Success Connect! \n";
    res.json(resCallback);
};

const callbackFromBRI = async(req, res) => {
    try {
        // Di sini, Anda dapat melakukan operasi atau pemrosesan yang mungkin dapat memunculkan kesalahan
        
        const responseData = {
            code: 200,
            message: 'Successfully!',
        };
        
        res.status(200).json(responseData);
    } catch (error) {
        const errorResponse = {
            code: 500,
            message: 'An error occurred',
            error: error.message 
        };
        
        res.status(500).json(errorResponse);
    }
}

const callbackFromBRIQrMpm = async(req, res) => {
    try {
        const responseData = {
            code: 200,
            message: 'Successfully!'
        };
        
        res.status(200).json(responseData);
    } catch (error) {
        
        const errorResponse = {
            code: 500,
            message: 'An error occurred',
            error: error.message 
        };
        
        res.status(500).json(errorResponse);
    }
}
const callbackFromBJB = async(req, res) => {
    try {
        // ===================================================================
        // JWT TOKEN
        // ===================================================================
        // const decodedToken = jwt.decode(req.body.token, secretKey);
        
        // // Lakukan verifikasi data, misalnya cek 'sub' dalam payload
        // if (!decodedToken || !decodedToken.sub) {
        //   throw new Error('Invalid your token!');
        // }

        // ===================================================================
        // JWT TOKEN
        // ===================================================================
            
        // Logika pengolahan data
        
        console.log('Response data : ',res);
        // console.log('====> Responn : ',res.body);
        const requestBody = req.body;
        
        // Lakukan sesuatu dengan data dari tubuh permintaan
        console.log('Request Body:', requestBody);
        console.log('Invoice Number :', requestBody.invoiceNumber);
        // console.log('Request : ',req);
        

        
        // JavaScript
        if (requestBody.transactionStatus === 'SUKSES') {
            try {
                const bodyData = {
                    invoiceID: requestBody.invoiceNumber,
                    status: requestBody.transactionStatus,
                };

                // const result = await axios.post(
                //     'https://vmondcoffee.controlindo.com/data/success-order-bjb',
                //     {body: bodyData }
                // );

                const result = await axios.post('https://vmondcoffee.controlindo.com/api/data/success-order-bjb', bodyData)
                    .then((response) => {
                        console.log(response);
                        // Mendengarkan pesan dari server

                    })
                    .catch((error) => {
                        console.error('Axios request error:', error);
                    });
                socket.emit('notif', requestBody.invoiceNumber);
                console.log('RESULT JS:: ',result)

            } catch (error) {
                console.log('ERROR!!!', error.message);
            }
        }

        const responseData = {
            code: 200,
            method: req.method,
            url: req.url,
            headers: req.headers,
            message: 'Successfully!'
        };
        res.status(200).json(responseData);
    } catch (error) {
        const responseData = {
            code: 500,
            method: req.method,
            url: req.url,
            headers: req.headers,
            message: 'Failed! Error: ' + error
        };
        
        res.status(500).json(responseData);
    }
};

const getTokenFintech = async (req, res) => {
    // try {
    //     const dtmsisdn = req.body.msisdnDev;
    //     const dtpassword = req.body.passwordDev;
        
    //     const headers = {
    //         'Content-Type': 'application/json',
    //     };

    //     const metaData = {
    //         "datetime": "2023-09-18T00:25:21.450Z",
    //         "deviceId": "9f9cb0504caa5059", 
    //         "devicePlatform": "Linux",
    //         "deviceOSVersion": "9",
    //         "deviceType": "",
    //         "latitude": "",
    //         "longitude": "",
    //         "appId": 58,
    //         "appVersion": "1.0",
    //     };

    //     const bodyData = {
    //         msisdn: dtmsisdn,
    //         password: dtpassword
    //     };

    //     const result = await axios.post(
    //         urlGlobal + '/mobile-webconsole/apps/pocket/requestTokenFintech/',
    //         { metadata: metaData, body: bodyData },
    //         { headers: headers }
    //     );

    //     const xAuthToken = result.headers['x-auth-token'];
        
    //     const responseData = {
    //         code: 200,
    //         method: req.method,
    //         token: xAuthToken,
    //         message: 'Successfully!'
    //     };
        
    //     console.log("Result Get Token : " , result);
    //     res.status(200).json(responseData);
    // } catch (error) {
    //     const responseData = {
    //         code: 500,
    //         method: req.method,
    //         url: req.url,
    //         headers: req.headers,
    //         message: 'Failed! Error: ' + error
    //     };
        
    //     res.status(500).json(responseData);
    // }
    const responseData = {
        code: 200,
        message: 'Successfully!'
    };
    
    // console.log("Result Get Token : " , result);
    res.status(200).json(responseData);

};

const sendOtpByPhoneNumber = async (req, res) => {
    try {
        const token = req.body.dttoken;
        const notelp = req.body.notelp;

        const headers = {
            'Content-Type': 'application/json',
            'X-AUTH-TOKEN': token
        };

        const metaData = {
            "datetime": "2023-09-04T09:40:21.450Z",
            "deviceId": "bjbdigi",
            "devicePlatform": "Linux",
            "deviceOSVersion": "bjbdigi-version",
            "deviceType": "",
            "latitude": "",
            "longitude": "",
            "appId": 58,
            "appVersion": "1.0",
        };

        const bodyData = {
            phoneNo: notelp
        };

        const result = await axios.post(
            urlGlobal + '/mobile-webconsole/apps/4/pbNonFinancialAdapter/resendOTPByPhone',
            { metadata: metaData, body: bodyData },
            { headers: headers }
        );
        const response = result.data.body.ResendOTPByPhoneResponse;
        const reference = response.reference;

        const responseData = {
            code: 200,
            method: req.method,
            reference: reference,
            message: 'Successfully!'
        };

        console.log("Result Senf OTP :" ,result.data.body);
        res.status(200).json(responseData);
    } catch (error) {
        const responseData = {
            code: 500,
            method: req.method,
            url: req.url,
            headers: req.headers,
            message: 'Failed! Error: ' + error
        };
        
        res.status(500).json(responseData);
    }
};

const aktivasi = async (req, res) => {
    try {
        const token = req.body.dttoken;
        const dtmsisdn = req.body.msisdn;
        const dtpin = req.body.pin;
        const dtproduct = req.body.product;
        const dtreference = req.body.dtreference;

        const headers = {
            'Content-Type': 'application/json',
            'X-AUTH-TOKEN': token
        };

        const metaData = {
            "datetime": "2023-09-04T09:40:21.450Z",
            "deviceId": "bjbdigi",
            "devicePlatform": "Linux",
            "deviceOSVersion": "bjbdigi-version",
            "deviceType": "",
            "latitude": "",
            "longitude": "",
            "appId": 58,
            "appVersion": "1.0",
        };

        const bodyData = {
            msisdn: dtmsisdn,
            pin: dtpin,
            reference: dtreference,
            product: dtproduct,
        };

        const result = await axios.post(
            urlGlobal + '/mobile-webconsole/apps/4/pbNonFinancialAdapter/authorizationRegistration',
            { metadata: metaData, body: bodyData },
            { headers: headers }
        );
        const response = result.data.body;
        console.log(response);

        const responseData = {
            code: 200,
            method: req.method,
            message: 'Successfully!'
        };

        console.log("Result  Aktivasi :" ,response);
        res.status(200).json(responseData);
    } catch (error) {
        const responseData = {
            code: 500,
            method: req.method,
            url: req.url,
            headers: req.headers,
            message: 'Failed! Error: ' + error
        };
        
        res.status(500).json(responseData);
    }
};

const createQR = async (req, res) => {
    try {
        
        const headers1 = {
            'Content-Type': 'application/json',
        };

        // const metaData1 = {
        //     "datetime": "2023-09-18T00:25:21.450Z",
        //     "deviceId": "9f9cb0504caa5059", 
        //     "devicePlatform": "Linux",
        //     "deviceOSVersion": "9",
        //     "deviceType": "",
        //     "latitude": "",
        //     "longitude": "",
        //     "appId": 58,
        //     "appVersion": "1.0",
        // };
        const metaData1 = {
            "datetime": "2023-09-18T00:25:21.450Z",
            "deviceId": "bjbdigi", 
            "devicePlatform": "Linux",
            "deviceOSVersion": "9",
            "deviceType": "",
            "latitude": "",
            "longitude": "",
            "appId": 4,
            "appVersion": "1.0",
        };

        const bodyData1 = {
            msisdn: msisdn,
            // msisdn: "081717181988",
            password: passwordBJB
        };

        const result1 = await axios.post(
            urlGlobal + '/mobile-webconsole/apps/pocket/requestTokenFintech/',
            { metadata: metaData1, body: bodyData1 },
            { headers: headers1 }
        );

        const xAuthToken = result1.headers['x-auth-token'];
        const dtamount = req.body.amount;
        const dtexpired = req.body.expired;

        console.log("Token :",xAuthToken);
        console.log("URL :",urlGlobal);
        console.log("MSIDN :",msisdn);
        console.log("PW :",passwordBJB);
        // console.log("Token :",xAuthToken);
        // Create QR
        const headers = {
            'Content-Type': 'application/json',
            'X-AUTH-TOKEN': xAuthToken
        };

        const metaData = {
            "datetime": "2023-09-04T09:40:21.450Z",
            "deviceId": "bjbdigi",
            "devicePlatform": "Linux",
            "deviceOSVersion": "bjbdigi-version",
            "deviceType": "",
            "latitude": "",
            "longitude": "",
            "appId": 4,
            "appVersion": "1.0",
        };
        // const metaData = {
        //     "datetime": "2023-09-04T09:40:21.450Z",
        //     "deviceId": "bjbdigi",
        //     "devicePlatform": "Linux",
        //     "deviceOSVersion": "bjbdigi-version",
        //     "deviceType": "",
        //     "latitude": "",
        //     "longitude": "",
        //     "appId": 58,
        //     "appVersion": "1.0",
        // };

        const bodyData = {
            merchantAccountNumber: "081717181988",
            // amount: dtamount,
            amount: '1',
            expInSecond: dtexpired,
        };

        const result = await axios.post(
            urlGlobal + '/mobile-webconsole/apps/4/pbTransactionAdapter/createInvoiceQRISDinamisExt',
            { metadata: metaData, body: bodyData },
            { headers: headers }
        );
        const response = result.data.body.CreateInvoiceQRISDinamisExtResponse;
        console.log('RESULT CREATE QR::',result.data.body);
        console.log('RESULT CREATE QR::',response);
        // console.log('MSIDN::',msisdn);

        const responseData = {
            code: 200,
            method: req.method,
            stringQR: response.stringQR._text,
            invoiceID: response.invoiceId._text,
            message: 'Successfully!'
        };

        res.status(200).json(responseData);
    } catch (error) {
        const responseData = {
            code: 500,
            method: req.method,
            url: req.url,
            headers: req.headers,
            message: 'Failed! Error: ' + error
        };
        
        res.status(500).json(responseData);
    }
};

const checkStatusPay = async (req, res) => {
    try {
        // const qrid = req.body.qrid;
        // const qrid = 'QRIS20230905165542007067'; //Paid True
        // const qrid = 'QRIS20230907095615007140'; //Paid False
        const qrid = 'QRIS20230904151749007047'; //bill id yg baru di created dan blm terbayarkan
        const phone_no = '081717181988';
        console.log('=============QRID=============== ',qrid);
        
        // ===
        // Check Status Payment BY QRID
        const headers = {
            'Content-Type': 'application/json',
            'Authorization': 'Basic YmpiQXV0aERldjpQQFNTVzBSRCE='
        };

        // axios.get(urlGlobal + `/bjb/api/getQRISstatus`, { headers: headers },{body: bodyData})
        const result = await axios.get(`http://10.44.124.164:80/bjb/api/getQRISstatus?qris_id=${qrid}&phone_no=${phone_no}`, { headers: headers })
        .then((response) => {
            // Permintaan berhasil
            const responseData = response.data;
            
            console.log('Berhasil:', responseData);
        })
        .catch((error) => {
            // Permintaan gagal, tangani kesalahan di sini
            console.error('Gagal:', error);
        });

        const responseData = {
            code: 200,
            method: req.method,
            message: 'Successfully!'
        };

        res.status(200).json(responseData);
    } catch (error) {
        const responseData = {
            code: 500,
            method: req.method,
            url: req.url,
            headers: req.headers,
            message: 'Failed! Error: ' + error
        };
        
        res.status(500).json(responseData);
    }
};
  
module.exports = {
    getURL,
    callbackFromBJB,
    callbackFromBRI,
    callbackFromBRIQrMpm,
    getTokenFintech,
    sendOtpByPhoneNumber,
    aktivasi,
    createQR,
    checkStatusPay,
};