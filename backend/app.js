const express = require('express');
const app = express();
const userRoutes = require('./routes/integrasiApiRoutes');
const swaggerUi = require('swagger-ui-express');
const swaggerSpec = require('./swaggerAPI/swagger'); // Sesuaikan path jika berbeda
const axios = require('axios'); 
// Middleware untuk mengizinkan parsing JSON dari permintaan
app.use(express.json());
app.use('/v1/api-docs', swaggerUi.serve, swaggerUi.setup(swaggerSpec));
// Gunakan rute untuk pengguna
app.use('/v1/api', userRoutes);
const urlGlobal = "http://10.44.124.164:8080";
const msisdnDev = "080000000001";
const passwordDev = "51cbc137951976fa96deaa8899ce7dba641e0f309b8d50e02698436f8939150d";
// ====================================================================
// Get Token API BJB
// ====================================================================

// Request Token Fintech
// const sendGetRequest = async () => {
//   try {
//     const headers = {
//       "Content-Type": "application/json"
//     };
    
//     const metaData = {
//       "datetime": "2022-08-29T09:40:21.450Z",
//       "deviceId": "bjbdigi",
//       "devicePlatform": "Linux",
//       "deviceOSVersion": "bjbdigi-version",
//       "deviceType": "SM-M205G",
//       "latitude": -4.690455,
//       "longitude": 105.6308059,
//       "appId": "4",
//       "appVersion": "1.0",
//     };
    
//     const bodyData = {
//       "msisdn": msisdnDev,
//       "password": passwordDev,
//     };
    
//     const result = await axios.post(urlGlobal + "/mobile-webconsole/apps/pocket/requestTokenFintech/", 
//     {"metadata": metaData, "body": bodyData}, 
//     {"headers": headers});
    
//     console.log("AllResult :: ", result);
//     console.log("Result Data :: ", result.data);
    
//     // check console
    // if (result && result.data && result.data.body && result.data.body.CreateTokenFintechResponse) {
    //   const customer = result.data.body.CreateTokenFintechResponse.customer;
    //   const attr = result.data.body.CreateTokenFintechResponse._attr;
    //   const channel = result.data.body.CreateTokenFintechResponse.channel;
    //   const key = result.data.body.CreateTokenFintechResponse.key;
  
    //   console.log("Attr:", attr);
    //   console.log("Customer:", customer);
    //   console.log("Channel:", channel);
    //   console.log("Key:", key);
    // } else {
    //   console.log("Response structure is not as expected.");
    // }

//   } catch (err) {
//     // Handle Error Here
//     console.error(err);
//   }
// };

// sendGetRequest();

// ====================================================================
// Send OTP By phone number

// const sendOtpByPhoneNumber = async () => {
//   try {
//     const headers = {
//       "Content-Type": "application/json",
//       "X-AUTH-TOKEN": "eyJhbGciOiJIUzUxMiJ9.eyJqdGkiOiI1ZGRjOTI0NC01ZDdhLTRhNjItOTdmNi1mNTg0ZmY1ZDk1ZjMiLCJzdWIiOiJ0aGlyZHBhcnR5MDEiLCJleHAiOjE2OTM0MDMwNjcsImlhdCI6MTY5MzM3MzA2NywiaWRlbnRpZmllciI6ImtkZXpLSUpNR3JTdWlEbSIsInVzZXJuYW1lIjoidGhpcmRwYXJ0eTAxIn0.yzz5VkMJdkHfc66V4Svhhsngk7BtZrildMiPe1QQDlIl5CvajicDwMngqt5OdnOMTPW0ikRTiPIAoqKQEZRmcw" // Replace with actual X-AUTH-TOKEN value
//     };
    
//     const metaData = {
//       "datetime": "2023-08-30T09:40:21.450Z",
//       "deviceId": "bjbdigi",
//       "devicePlatform": "Linux",
//       "deviceOSVersion": "bjbdigi-version",
//       "deviceType": "",
//       "latitude": "",
//       "longitude": "",
//       "appId": 4,
//       "appVersion": "1.0",
//     };
    
//     const bodyData = {
//       "phoneNo": "081717181988" // Replace with actual appIdName value
//     };
    
//     const result = await axios.post(urlGlobal + "/mobile-webconsole/apps/4/pbNonFinancialAdapter/resendOTPByPhone", 
//       {"metadata": metaData, "body": bodyData}, 
//       {"headers": headers}
//     );
    
//     console.log("AllResult :: ", result);
//     console.log("Result Data :: ", result.data);
    

//     // Check Console detail qris
//     if (result && result.data && result.data.body && result.data.body.ResendOTPByPhoneResponse) {
//       const response = result.data.body.ResendOTPByPhoneResponse;
//       const attr = response._attr;
//       const status = response.Status;
//       const reference = response.reference;
    
//       console.log("Attr:", attr);
//       console.log("Status:", status);
//       console.log("Reference:", reference);
//     } else {
//       console.log("Response structure is not as expected.");
//     }
    
    
//   } catch (err) {
//     // Handle Error Here
//     console.error(err);
//   }
// };


// sendOtpByPhoneNumber();


// ====================================================================

// Aktivasi

const aktivasi = async () => {
  try {
    const headers = {
      "Content-Type": "application/json",
      "X-AUTH-TOKEN": "eyJhbGciOiJIUzUxMiJ9.eyJqdGkiOiI1ZGRjOTI0NC01ZDdhLTRhNjItOTdmNi1mNTg0ZmY1ZDk1ZjMiLCJzdWIiOiJ0aGlyZHBhcnR5MDEiLCJleHAiOjE2OTM0MDMwNjcsImlhdCI6MTY5MzM3MzA2NywiaWRlbnRpZmllciI6ImtkZXpLSUpNR3JTdWlEbSIsInVzZXJuYW1lIjoidGhpcmRwYXJ0eTAxIn0.yzz5VkMJdkHfc66V4Svhhsngk7BtZrildMiPe1QQDlIl5CvajicDwMngqt5OdnOMTPW0ikRTiPIAoqKQEZRmcw" // Replace with actual X-AUTH-TOKEN value
    };
    
    const metaData = {
      "datetime": "2023-08-30T09:40:21.450Z",
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
      "msisdn": "081717181988",
      "pin": "808080",
      "reference": "04832a86-313e-4a1c-9b92-ad8399ca3e3a",
      "product": "CUSTOMER",
    };
    
    const result = await axios.post(urlGlobal + "/mobile-webconsole/apps/4/pbNonFinancialAdapter//authorizationRegistration", 
      {"metadata": metaData, "body": bodyData}, 
      {"headers": headers}
    );
    
    console.log("AllResult :: ", result);
    console.log("Result Data :: ", result.data);
    

    if (result && result.data && result.data.body && result.data.body.Fault) {
      const fault = result.data.body.Fault;
      const faultcode = fault.faultcode;
      const faultstring = fault.faultstring;
    
      console.log("Fault Code:", faultcode);
      console.log("Fault String:", faultstring);
    } else {
      console.log("Response structure is not as expected.");
    }
    
    
    
  } catch (err) {
    // Handle Error Here
    console.error(err);
  }
};


aktivasi();

// ====================================================================
// Create Qris Dinamis BJB
// const createQrisFintech = async () => {
//   try {
//     const headers = {
//       "Content-Type": "application/json",
//       "X-AUTH-TOKEN": "eyJhbGciOiJIUzUxMiJ9.eyJqdGkiOiI1ZGRjOTI0NC01ZDdhLTRhNjItOTdmNi1mNTg0ZmY1ZDk1ZjMiLCJzdWIiOiJ0aGlyZHBhcnR5MDEiLCJleHAiOjE2OTM0MDMwNjcsImlhdCI6MTY5MzM3MzA2NywiaWRlbnRpZmllciI6ImtkZXpLSUpNR3JTdWlEbSIsInVzZXJuYW1lIjoidGhpcmRwYXJ0eTAxIn0.yzz5VkMJdkHfc66V4Svhhsngk7BtZrildMiPe1QQDlIl5CvajicDwMngqt5OdnOMTPW0ikRTiPIAoqKQEZRmcw" // Replace with actual X-AUTH-TOKEN value
//     };
    
//     const metaData = {
//       "datetime": "2023-08-30T09:40:21.450Z",
//       "deviceId": "bjbdigi",
//       "devicePlatform": "Linux",
//       "deviceOSVersion": "bjbdigi-version",
//       "deviceType": "",
//       "latitude": "",
//       "longitude": "",
//       "appId": "4",
//       "appVersion": "1.0",
//       "appIdName": "Third Party 01" // Replace with actual appIdName value
//     };
    
//     const bodyData = {
//       "merchantAccountNumber": msisdnDev, // Replace with actual merchant account number
//       "amount": "1000", // Replace with actual amount
//       "expInSecond": 3600 // Replace with actual expiry in seconds or remove if not needed
//     };
    
//     const result = await axios.post(urlGlobal + "/mobile-webconsole/apps/4/pbTransactionAdapter/createInvoiceQRISDinamisExt", 
//       {"metadata": metaData, "body": bodyData}, 
//       {"headers": headers}
//     );
    
//     console.log("AllResult :: ", result);
//     console.log("Result Data :: ", result.data);
    

//     // Check Console detail qris
//     if (result && result.data && result.data.body && result.data.body.CreateInvoiceQRISDinamisExtResponse) {
//       const response = result.data.body.CreateInvoiceQRISDinamisExtResponse;
//       const attr = response._attr;
//       const responseCode = response.responseCode;
//       const responseMessage = response.responseMessage;
    
//       console.log("Attr:", attr);
//       console.log("Response Code:", responseCode);
//       console.log("Response Message:", responseMessage);
//     } else {
//       console.log("Response structure is not as expected.");
//     }
    
//   } catch (err) {
//     // Handle Error Here
//     console.error(err);
//   }
// };


// createQrisFintech();

// Jalankan server pada port tertentu
const port = 2222;
app.listen(port, () => {
  console.log('Backend Node.js server is running on port ' + port);
});
