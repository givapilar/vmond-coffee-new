// app.js
const express = require('express');
const app = express();
const https = require('https');
const fs = require('fs');
const userRoutes = require('./routes/integrasiApiRoutes');

// Middleware untuk mengizinkan parsing JSON dari permintaan
app.use(express.json());

// Gunakan rute untuk pengguna
app.use('/v1/api', userRoutes);

// Konfigurasi SSL
const sslOptions = {
  key: fs.readFileSync('/etc/letsencrypt/live/vmondcoffee.controlindo.com/privkey.pem'),
  cert: fs.readFileSync('/etc/letsencrypt/live/vmondcoffee.controlindo.com/fullchain.pem')
};
// Jalankan server pada port tertentu
const port = 2222;
// Jalankan server HTTPS
https.createServer(sslOptions, app).listen(port, () => {
  console.log('Backend Node.js server is running on port 2222 (HTTPS)');
});
