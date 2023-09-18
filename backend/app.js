const express = require('express');
const app = express();
const userRoutes = require('./routes/integrasiApiRoutes');
const swaggerUi = require('swagger-ui-express');
const swaggerSpec = require('./swaggerAPI/swagger'); // Sesuaikan path jika berbeda
const axios = require('axios'); 
require('dotenv').config();
const schedule = require('node-schedule');

// =====================Function Import=======================
const { getTokenFintech } = require('./services/api-bjb/requestTokenFintech');
// ===================End Function Import=====================

app.use(express.json());
app.use('/v1/api-docs', swaggerUi.serve, swaggerUi.setup(swaggerSpec));
app.use('/v1/api', userRoutes);

// const appENV = process.env.APP_ENV;
// let urlGlobal, msisdn, passwordBJB, token;

// ====================================================
// Check APP ENV (Development or Production)
// ====================================================
// if (appENV == 'Development') {
//     urlGlobal = process.env.URL_GLOBAL_DEV;
//     msisdn = process.env.MSISDN_DEV;
//     passwordBJB = process.env.PASSWORD_DEV;
// }else if(appENV == 'Production'){
//     urlGlobal = process.env.URL_GLOBAL_PROD;
//     msisdn = process.env.MSISDN_PROD;
//     passwordBJB = process.env.PASSWORD_PROD;
// }
// ====================================================

// ====================================================
// Update token berdasarkan schedule per 30 menit sekali
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

// const updateToken = schedule.scheduleJob(' */30 * * * *', async function(){
//     token = await getTokenFintech(urlGlobal, msisdn, passwordBJB);
// });

// // ====================================================

// async function main() {
//     try {
//         // Cek ketersediaan token
//         if (!token) {
//             token = await getTokenFintech(urlGlobal, msisdn, passwordBJB);
//         }

        
//     } catch (err) {
//         // Handle Error
//         console.error(err);
//     }
// }

// main();
// const interval = 1000;
// setInterval(main, interval);

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
//       "merchantAccountNumber": msisdn, // Replace with actual merchant account number
//       "amount": "20000", // Replace with actual amount
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
// const port = 2222;
const port = 3000;
app.listen(port, () => {
  console.log('Backend Node.js server is running on port ' + port);
});