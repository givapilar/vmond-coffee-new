const express = require('express');
const app = express();
const userRoutes = require('./routes/integrasiApiRoutes');
const swaggerUi = require('swagger-ui-express');
const swaggerSpec = require('./swaggerAPI/swagger'); // Sesuaikan path jika berbeda
const axios = require('axios'); 
require('dotenv').config();
const isReachable = require('is-reachable');

// =====================Function Import=======================
// const  = require('./myModule');
const { getTokenFintech } = require('./services/api-bjb/requestTokenFintech');
// ===================End Function Import=====================

// Middleware untuk mengizinkan parsing JSON dari permintaan
app.use(express.json());
app.use('/v1/api-docs', swaggerUi.serve, swaggerUi.setup(swaggerSpec));
// Gunakan rute untuk pengguna
app.use('/v1/api', userRoutes);
const urlGlobal = process.env.URL_GLOBAL;
const msisdnDev = process.env.MSISDN_DEV;
const passwordDev = process.env.PASSWORD_DEV;
let token = '';

async function main() {
    try {
        // Cek apakah token belum ada atau sudah lebih dari 1 jam
        if (!token || isTokenExpired()) {
            token = await getTokenFintech(urlGlobal, msisdnDev, passwordDev);
            console.log('Token telah diperbarui:', token);
        }

        // Lanjutkan dengan pemrosesan hasil sesuai kebutuhan Anda
    } catch (err) {
        // Tangani error di sini
        console.error(err);
    }
}

// Fungsi untuk memeriksa apakah token sudah lebih dari 1 jam
function isTokenExpired() {
    if (!token || !token.timestamp) {
        return true;
    }

    const currentTime = new Date().getTime();
    const tokenTime = token.timestamp.getTime();
    const oneHourInMilliseconds = 5 * 1000; // 1 jam dalam milidetik

    return currentTime - tokenTime >= oneHourInMilliseconds;
}

// Jalankan main() untuk pertama kali
main();
const interval = 1000;
setInterval(main, interval);

// sendGetRequest();

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
// const createQrisFintech = async () => {
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
//       "merchantAccountNumber": msisdnDev, // Replace with actual merchant account number
//       "amount": "2000", // Replace with actual amount
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
app.listen(port, () => {
  console.log('Backend Node.js server is running on port ' + port);
});
