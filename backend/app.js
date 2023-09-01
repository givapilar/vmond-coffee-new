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
const msisdnDev = "081717181988";
const passwordDev = "51cbc137951976fa96deaa8899ce7dba641e0f309b8d50e02698436f8939150d";
// ====================================================================
// Get Token API BJB
// ====================================================================

// Request Token Fintech
const sendGetRequest = async () => {
  try {
    const headers = {
      "Content-Type": "application/json"
    };
    
    const metaData = {
      "datetime": "2023-09-01T09:40:21.450Z",
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
      "msisdn": msisdnDev,
      "password": "1c1bbf7b79bc9b97cafb7488946a6001f05980f62dbeb5bc093dd680b8241197",
    };
    
    const result = await axios.post(urlGlobal + "/mobile-webconsole/apps/pocket/requestTokenFintech/", 
    {"metadata": metaData, "body": bodyData}, 
    {"headers": headers});
    
    console.log("AllResult :: ", result);
    console.log("Result Data :: ", result.data);
    
    // check console
    if (result && result.data && result.data.body && result.data.body.CreateTokenFintechResponse) {
      const customer = result.data.body.CreateTokenFintechResponse.customer;
      const attr = result.data.body.CreateTokenFintechResponse._attr;
      const channel = result.data.body.CreateTokenFintechResponse.channel;
      const key = result.data.body.CreateTokenFintechResponse.key;
      const xAuthToken = result.headers['x-auth-token'];

      console.log("X-AUTH-TOKEN:", xAuthToken)
  
      console.log("Attr:", attr);
      console.log("Customer:", customer);
      console.log("Channel:", channel);
      console.log("Key:", key);
    } else {
      console.log("Response structure is not as expected.");
    }

  } catch (err) {
    // Handle Error Here
    console.error(err);
  }
};

sendGetRequest();

// ====================================================================
// Send OTP By phone number

// const sendOtpByPhoneNumber = async () => {
//   try {
//     const headers = {
//       "Content-Type": "application/json",
//       "X-AUTH-TOKEN": "eyJhbGciOiJIUzUxMiJ9.eyJqdGkiOiIxYWVhNjczNi1jNjU5LTQwNmEtOTRlNi00NTI2YzdlNjVhYTgiLCJzdWIiOiJWTU85MzcxOTI5ODgiLCJleHAiOjE2OTM0MjMwMTAsImlhdCI6MTY5MzM5MzAxMCwiaWRlbnRpZmllciI6IkVKSkJheTFEcVVYWHFCSyIsInVzZXJuYW1lIjoiVk1POTM3MTkyOTg4In0.7YzRn3AM7LV9YnLdHBi87nhSYvzkyL4V7M2ZAvZZ8h7hl-z4WAaCiAK1NpmFAkjCI5zfW1bmE_WAbXbJLkapUg" // Replace with actual X-AUTH-TOKEN value
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
//       const xAuthToken = result.headers['x-auth-token'];

//       console.log("X-AUTH-TOKEN:", xAuthToken)
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

// const aktivasi = async () => {
//   try {
//     const headers = {
//       "Content-Type": "application/json",
//       "X-AUTH-TOKEN": "eyJhbGciOiJIUzUxMiJ9.eyJqdGkiOiIxYWVhNjczNi1jNjU5LTQwNmEtOTRlNi00NTI2YzdlNjVhYTgiLCJzdWIiOiJWTU85MzcxOTI5ODgiLCJleHAiOjE2OTM0MjMwMTAsImlhdCI6MTY5MzM5MzAxMCwiaWRlbnRpZmllciI6IkVKSkJheTFEcVVYWHFCSyIsInVzZXJuYW1lIjoiVk1POTM3MTkyOTg4In0.7YzRn3AM7LV9YnLdHBi87nhSYvzkyL4V7M2ZAvZZ8h7hl-z4WAaCiAK1NpmFAkjCI5zfW1bmE_WAbXbJLkapUg" // Replace with actual X-AUTH-TOKEN value
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
//       "msisdn": "081717181988",
//       "pin": "123456",
//       "reference": "04832a86-313e-4a1c-9b92-ad8399ca3e3a",
//       "product": "MERCHANT",
//     };
    
//     const result = await axios.post(urlGlobal + "/mobile-webconsole/apps/4/pbNonFinancialAdapter//authorizationRegistration", 
//       {"metadata": metaData, "body": bodyData}, 
//       {"headers": headers}
//     );
    
//     console.log("AllResult :: ", result);
//     console.log("Result Data :: ", result.data);
    

//     if (result && result.data && result.data.body && result.data.body.AuthorizationRegisterResponse) {
//       const response = result.data.body.AuthorizationRegisterResponse;
//       const attr = response._attr;
//       const customer = response.customer;
//       const xAuthToken = result.headers['x-auth-token'];

//       console.log("X-AUTH-TOKEN:", xAuthToken)
//       console.log("Attr:", attr);
//       console.log("Customer:", customer);
//     } else {
//       console.log("Response structure is not as expected.");
//     }
    
    
//   } catch (err) {
//     // Handle Error Here
//     console.error(err);
//   }
// };


// aktivasi();

// Request Token for Transaction Authentication as Merchant
// const requestTokenAuthMerchant = async () => {
//   try {
//     const headers = {
//       "Content-Type": "application/json"
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
//       "msisdn": "081717181988",
//       "username": "VMO937192988",
//       "pin": 111111,
//     };
    
//     const result = await axios.post(urlGlobal + "/mobile-webconsole/apps/pocket/requestTokenFintech", 
//       {"metadata": metaData, "body": bodyData}, 
//       {"headers": headers}
//     );
    
//     console.log("AllResult :: ", result);
//     console.log("Result Data :: ", result.data);
    

//     if (result && result.data && result.data.body && result.data.body.AuthorizationRegisterResponse) {
//       const response = result.data.body.AuthorizationRegisterResponse;
//       const attr = response._attr;
//       const customer = response.customer;
//       const xAuthToken = result.headers['x-auth-token'];

//       console.log("X-AUTH-TOKEN:", xAuthToken)
    
//       console.log("Attr:", attr);
//       console.log("Customer:", customer);
//     } else {
//       console.log("Response structure is not as expected.");
//     }
    
    
//   } catch (err) {
//     // Handle Error Here
//     console.error(err);
//   }
// };


// requestTokenAuthMerchant();

// ====================================================================
// Create Qris Dinamis BJB
const createQrisFintech = async () => {
  try {
    const headers = {
      "Content-Type": "application/json",
      "X-AUTH-TOKEN": "eyJhbGciOiJIUzUxMiJ9.eyJqdGkiOiI1YmU0ZDQ2NS0yODgwLTQ0NTEtYTg4Yi0zNmNiYmZiZjM1OWUiLCJzdWIiOiJWTU85MzcxOTI5ODgiLCJleHAiOjE2OTM1NTMyOTIsImlhdCI6MTY5MzUyMzI5MiwiaWRlbnRpZmllciI6IkthdkE3RVlUOExxbmZ2OSIsInVzZXJuYW1lIjoiVk1POTM3MTkyOTg4In0.EPJe7By9kXRVUz9GACNgXhZGxF2eZ6qFJQRS_HPhGNE6qeRqsrZbJoNEqF5qapu9FtZn2vN9tmnKmSloLAxbVg" // Replace with actual X-AUTH-TOKEN value
    };
    
    const metaData = {
      "datetime": "2023-08-31T09:40:21.450Z",
      "deviceId": "bjbdigi",
      "devicePlatform": "Linux",
      "deviceOSVersion": "bjbdigi-version",
      "deviceType": "",
      "latitude": "",
      "longitude": "",
      "appId": 4,
      "appVersion": "1.0",
      "appIdName": "vmondcoffee" // Replace with actual appIdName value
    };
    
    const bodyData = {
      "merchantAccountNumber": msisdnDev, // Replace with actual merchant account number
      "amount": 1000, // Replace with actual amount
      "expInSecond": 3600 // Replace with actual expiry in seconds or remove if not needed
    };
    
    const result = await axios.post(urlGlobal + "/mobile-webconsole/apps/4/pbTransactionAdapter/createInvoiceQRISDinamisExt", 
      {"metadata": metaData, "body": bodyData}, 
      {"headers": headers}
    );
    
    console.log("AllResult :: ", result);
    console.log("Result Data :: ", result.data);
    

    // Check Console detail qris
    if (result && result.data && result.data.body && result.data.body.CreateInvoiceQRISDinamisExtResponse) {
      const response = result.data.body.CreateInvoiceQRISDinamisExtResponse;
      const attr = response._attr;
      const responseCode = response.responseCode;
      const responseMessage = response.responseMessage;
    
      console.log("Attr:", attr);
      console.log("Response Code:", responseCode);
      console.log("Response Message:", responseMessage);
    } else {
      console.log("Response structure is not as expected.");
    }
    
  } catch (err) {
    // Handle Error Here
    console.error(err);
  }
};


createQrisFintech();

// Jalankan server pada port tertentu
const port = 2222;
app.listen(port, () => {
  console.log('Backend Node.js server is running on port ' + port);
});
