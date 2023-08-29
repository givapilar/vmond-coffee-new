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
const passwordDev = "111111";
// ====================================================================
// Get Token API BJB
// ====================================================================
const sendGetRequest = async () => {
  try {
    const headers = {
      "Content-Type": "application/json"
    };
    
    const metaData = {
      "datetime": "2022-08-29T09:40:21.450Z",
      "deviceId": "bjbdigi",
      "devicePlatform": "Linux",
      "deviceOSVersion": "bjbdigi-version",
      "deviceType": "SM-M205G",
      "latitude": -4.690455,
      "longitude": 105.6308059,
      "appId": "4",
      "appVersion": "1.0",
    };
    
    const bodyData = {
      "msisdn": msisdnDev,
      "password": passwordDev,
    };
    
    const result = await axios.post(urlGlobal + "/mobile-webconsole/apps/pocket/requestTokenFintech/", 
    {"metadata": metaData, "body": bodyData}, 
    {"headers": headers});
    
    console.log("AllResult :: ", result);
    console.log("Result Data :: ", result.data);
  } catch (err) {
    // Handle Error Here
    console.error(err);
  }
};


sendGetRequest();


// ====================================================================



// Jalankan server pada port tertentu
const port = 2222;
app.listen(port, () => {
  console.log('Backend Node.js server is running on port ' + port);
});
