const express = require('express');
const app = express();
const userRoutes = require('./routes/integrasiApiRoutes');

// Middleware untuk mengizinkan parsing JSON dari permintaan
app.use(express.json());

// Gunakan rute untuk pengguna
app.use('/v1/api', userRoutes);

// Jalankan server pada port tertentu
const port = 2222;
app.listen(port, () => {
  console.log('Backend Node.js server is running on port ' + port);
});
