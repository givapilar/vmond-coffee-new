const jwt = require('jwt-simple');
const secretKey = 'yUyOSXBD8ZB96JKv5e5K4aETVLJcGkubL8d6UlrqERJSVtvDJr';
const axios = require('axios');

const getURL = (req, res) => {
    const resCallback = "Success Connect! \n";
    res.json(resCallback);
};
  
const callbackFromBJB = (req, res) => {
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

        console.log('Result data : ',res);
        console.log('Request : ',req);

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

const getTokenFintech = (req, res) => {
    try {
        // const headers = {
        //     'Content-Type': 'application/json',
        // };

        // const metaData = {
        //     "datetime": "2023-09-05T09:40:21.450Z",
        //     "deviceId": "9f9cb0504caa5059", 
        //     "devicePlatform": "Linux",
        //     "deviceOSVersion": "9",
        //     "deviceType": "",
        //     "latitude": "",
        //     "longitude": "",
        //     "appId": 4,
        //     "appVersion": "1.0",
        // };

        // const bodyData = {
        //     msisdn: req.msisdnDev,
        //     password: req.passwordDev
        // };

        // const result = await axios.post(
        //     urlGlobal + '/mobile-webconsole/apps/pocket/requestTokenFintech/',
        //     { metadata: metaData, body: bodyData },
        //     { headers: headers }
        // );

        // const xAuthToken = result.headers['x-auth-token'];

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

const sendOtpByPhoneNumber = async (req, res) => {
    try {
        const headers = {
            'Content-Type': 'application/json',
            'X-AUTH-TOKEN': req.token
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

        const bodyData = {
            phoneNo: msisdnDev
        };

        const result = await axios.post(
            urlGlobal + '/mobile-webconsole/apps/4/pbNonFinancialAdapter/resendOTPByPhone',
            { metadata: metaData, body: bodyData },
            { headers: headers }
        );

        const responseData = {
            code: 200,
            method: req.method,
            res: result,
            res: req,
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
    getTokenFintech,
    sendOtpByPhoneNumber,
  };