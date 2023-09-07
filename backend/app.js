const express = require('express');
const app = express();
const userRoutes = require('./routes/integrasiApiRoutes');
const swaggerUi = require('swagger-ui-express');
const swaggerSpec = require('./swaggerAPI/swagger'); // Sesuaikan path jika berbeda
const axios = require('axios'); 
require('dotenv').config();
const schedule = require('node-schedule');

// =====================Function Import=======================
// const  = require('./myModule');
const { getTokenFintech } = require('./services/api-bjb/requestTokenFintech');
// ===================End Function Import=====================

app.use(express.json());
app.use('/v1/api-docs', swaggerUi.serve, swaggerUi.setup(swaggerSpec));
app.use('/v1/api', userRoutes);

const urlGlobal = process.env.URL_GLOBAL;
const msisdnDev = process.env.MSISDN_DEV;
const passwordDev = process.env.PASSWORD_DEV;
let token = '';

// ====================================================
// Update token berdasarkan schedule per 1 jam sekali
// ====================================================

// *    *    *    *    *    *
// ┬    ┬    ┬    ┬    ┬    ┬
// │    │    │    │    │    │
// │    │    │    │    │    └ day of week (0 - 7) (0 or 7 is Sun)
// │    │    │    │    └───── month (1 - 12)
// │    │    │    └────────── day of month (1 - 31)
// │    │    └─────────────── hour (0 - 23)
// │    └──────────────────── minute (0 - 59)
// └───────────────────────── second (0 - 59, OPTIONAL)

const updateToken = schedule.scheduleJob(' */30 * * * *', async function(){
    token = await getTokenFintech(urlGlobal, msisdnDev, passwordDev);
});

// ====================================================

async function main() {
    try {
        // Cek ketersediaan token
        if (!token) {
            token = await getTokenFintech(urlGlobal, msisdnDev, passwordDev);
        }

        
    } catch (err) {
        // Handle Error
        console.error(err);
    }
}

main();
const interval = 1000;
setInterval(main, interval);

// ====================================================================
// Send OTP By phone number

// const sendOtpByPhoneNumber = async () => {
//   try {
//     const headers = {
//       "Content-Type": "application/json",
//       "X-AUTH-TOKEN": "eyJhbGciOiJIUzUxMiJ9.eyJqdGkiOiJjYWVlZmY1Yy1lOTI3LTQ4YTAtYjY5Ny1mYzFiNGRkZTk1ZWQiLCJzdWIiOiJWTU85MzcxOTI5ODgiLCJleHAiOjE2OTM5MjM0ODAsImlhdCI6MTY5Mzg5MzQ4MCwiaWRlbnRpZmllciI6Im5MUGpTdU5tNDA2SEZUUSIsInVzZXJuYW1lIjoiVk1POTM3MTkyOTg4In0.rBHoCLMYnoUITWOYvN0rdnR5y03F1vWjJ8QojkBzHVaQQfMdY31ujCMQdJjSGr52DBoL5gh__RmyUKSnKfeJFw" // Replace with actual X-AUTH-TOKEN value
//     };
    
//     const metaData = {
//       "datetime": "2023-09-04T09:40:21.450Z",
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
//       "X-AUTH-TOKEN": "eyJhbGciOiJIUzUxMiJ9.eyJqdGkiOiJjYWVlZmY1Yy1lOTI3LTQ4YTAtYjY5Ny1mYzFiNGRkZTk1ZWQiLCJzdWIiOiJWTU85MzcxOTI5ODgiLCJleHAiOjE2OTM5MjM0ODAsImlhdCI6MTY5Mzg5MzQ4MCwiaWRlbnRpZmllciI6Im5MUGpTdU5tNDA2SEZUUSIsInVzZXJuYW1lIjoiVk1POTM3MTkyOTg4In0.rBHoCLMYnoUITWOYvN0rdnR5y03F1vWjJ8QojkBzHVaQQfMdY31ujCMQdJjSGr52DBoL5gh__RmyUKSnKfeJFw" // Replace with actual X-AUTH-TOKEN value
//     };
    
//     const metaData = {
//       "datetime": "2023-09-04T09:40:21.450Z",
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
//       "pin": "111111",
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
//       "datetime": "2023-09-07T10:40:21.450Z",
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
//       "password": "1c1bbf7b79bc9b97cafb7488946a6001f05980f62dbeb5bc093dd680b8241197",
//       // "username": "VMO937192988",
//       // "pin": 111111,
//     };
    
//     const result = await axios.post(urlGlobal + "/mobile-webconsole/apps/pocket/requestTokenFintech", 
//       {"metadata": metaData, "body": bodyData}, 
//       {"headers": headers}
//     );
    
//     console.log("AllResult :: ", result);
//     console.log("Result Data :: ", result.data);
    

//     if (result && result.data && result.data.body && result.data.body.CreateTokenFintechResponse) {
//       const response = result.data.body.CreateTokenFintechResponse;
//       const attr = response._attr;
//       const customer = response.customer;
//       const channel = response.channel;
//       const key = response.key;
//       const xAuthToken = result.headers['x-auth-token'];

//       console.log("X-AUTH-TOKEN:", xAuthToken)
    
//       console.log("Attr:", attr);
//       console.log("Customer:", customer);
//       console.log("Channel:", channel);
//       console.log("key:", key);
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
// const createQrisFintech = async () => {
//   try {
//     const headers = {
//       "Content-Type": "application/json",
//       "X-AUTH-TOKEN": "eyJhbGciOiJIUzUxMiJ9.eyJqdGkiOiJhYzU5ZWRjMC1hNjU1LTQzNTQtYmM0Ni03ZDI3ZGE2OTgyMTgiLCJzdWIiOiJWTU85MzcxOTI5ODgiLCJleHAiOjE2OTQwNzMyNjIsImlhdCI6MTY5NDA0MzI2MiwiaWRlbnRpZmllciI6IkFDYk9Bbm5nU3ZHWUhraCIsInVzZXJuYW1lIjoiVk1POTM3MTkyOTg4In0.lur0e-k6ycIAyCQq6IgG5v7YYXYBRi9sNDoElYmXFqeMkFh70wN5Mo4xSq7BtknMkNw_gl7-t_ckOXdnLoFPjQ" // Replace with actual X-AUTH-TOKEN value
//     };
    
//     const metaData = {
//       "datetime": "2023-09-07T15:00:21.450Z",
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
//       "merchantAccountNumber": msisdnDev, // Replace with actual merchant account number
//       "amount": "15000", // Replace with actual amount
//       "expInSecond": 0 // Replace with actual expiry in seconds or remove if not needed
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
//       const amount = response.amount;
//       const exp = response.expiryParameter;
//       const invoiceId = response.invoiceId;
//       const stringQR = response.stringQR;
    
//       console.log("Attr:", attr);
//       console.log("Response Code:", responseCode);
//       console.log("Response Message:", responseMessage);
//       console.log("Amount:", amount);
//       console.log("String QR:", stringQR);
//       console.log("Exp:", exp);
//       console.log("Invoice Id :", invoiceId);
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
// const port = 3000;
app.listen(port, () => {
  console.log('Backend Node.js server is running on port ' + port);
});


// const port = process.env.PORT || 2222; // Gunakan PORT yang tersedia atau 2222 jika tidak ada yang tersedia
// app.listen(port, () => {
//   console.log(`Server berjalan di port ${port}`);
// });
