// routes/userRoutes.js
const express = require('express');
const router = express.Router();
const integrasiApiController = require('../controllers/integrasiApiController');

// Definisikan rute untuk mendapatkan semua pengguna
router.get('/', integrasiApiController.getURL);

// Definisikan rute untuk mendapatkan pengguna berdasarkan ID
router.post('/callback', integrasiApiController.callbackFromBJB);

module.exports = router;
