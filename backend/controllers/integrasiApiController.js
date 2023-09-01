const jwt = require('jwt-simple');
const secretKey = 'yUyOSXBD8ZB96JKv5e5K4aETVLJcGkubL8d6UlrqERJSVtvDJr';
const axios = require('axios');

const getURL = (req, res) => {
    const resCallback = "Success Connect! \n";
    res.json(resCallback);

    // try {
    //   const headers = {
    //     "Content-Type": "application/json"
    //   };
  
    //   const metaData = {
    //     "datetime": "2023-09-01T09:40:21.450Z",
    //     "deviceId": "bjbdigi",
    //     "devicePlatform": "Linux",
    //     "deviceOSVersion": "bjbdigi-version",
    //     "deviceType": "",
    //     "latitude": "",
    //     "longitude": "",
    //     "appId": 4,
    //     "appVersion": "1.0",
    //   };
  
    //   const bodyData = {
    //     "msisdn": "your_msisdn_value",
    //     "password": "1c1bbf7b79bc9b97cafb7488946a6001f05980f62dbeb5bc093dd680b8241197",
    //   };
  
    //   const urlGlobal = "http://10.44.124.164:8080"; // Replace with your URL
    //   const endpoint = "/mobile-webconsole/apps/pocket/requestTokenFintech/";
  
    //   const result = await axios.post(`${urlGlobal}${endpoint}`, {
    //     "metadata": metaData,
    //     "body": bodyData
    //   }, {
    //     headers: headers
    //   });
  
    //   console.log("AllResult :: ", result);
    //   console.log("Result Data :: ", result.data);
  
    //   if (result && result.data && result.data.body && result.data.body.CreateTokenFintechResponse) {
    //     const customer = result.data.body.CreateTokenFintechResponse.customer;
    //     const attr = result.data.body.CreateTokenFintechResponse._attr;
    //     const channel = result.data.body.CreateTokenFintechResponse.channel;
    //     const key = result.data.body.CreateTokenFintechResponse.key;
    //     const xAuthToken = result.headers['x-auth-token'];
  
    //     console.log("X-AUTH-TOKEN:", xAuthToken)
    
    //     console.log("Attr:", attr);
    //     console.log("Customer:", customer);
    //     console.log("Channel:", channel);
    //     console.log("Key:", key);
    //   } else {
    //     console.log("Response structure is not as expected.");
    //   }
  
    // } catch (err) {
    //   console.error(err);
    // }
  };

  // const requestToken = (req, res) => {
  //   const curlCommand = `
  //     curl -X POST "http://172.31.32.85:2222/v1/api/" \
  //     -H "Content-Type: application/json" \
  //     -d '{
  //       "metadata": {
  //         "datetime": "2023-09-01T09:40:21.450Z",
  //         "deviceId": "bjbdigi",
  //         "devicePlatform": "Linux",
  //         "deviceOSVersion": "bjbdigi-version",
  //         "deviceType": "",
  //         "latitude": "",
  //         "longitude": "",
  //         "appId": 4,
  //         "appVersion": "1.0"
  //       },
  //       "body": {
  //         "msisdn": "your_msisdn_value",
  //         "password": "1c1bbf7b79bc9b97cafb7488946a6001f05980f62dbeb5bc093dd680b8241197"
  //       }
  //     }'
  //   `;
  
  //   res.json(curlCommand);
  // };
  
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
  
  module.exports = {
    getURL,
    callbackFromBJB,
  };