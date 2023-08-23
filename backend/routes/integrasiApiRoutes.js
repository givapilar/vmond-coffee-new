const express = require('express');
const router = express.Router();
const integrasiApiController = require('../controllers/integrasiApiController');

// Definisikan rute untuk mendapatkan semua pengguna
router.get('/', integrasiApiController.getURL);

/**
 * @swagger
 * /v1/api/callback:
 *   post:
 *     summary: Handle callback
 *     description: Endpoint to handle callback from external service.
 *     responses:
 *       200:
 *         description: Successfully callback.
 *         content:
 *           application/json:
 *             example:
 *               status: 200
 *               message: Successfully!
 *       500:
 *         description: Failed callback.
 *         content:
 *           application/json:
 *             example:
 *               status: 500
 *               message: Failed! Error: An error occurred.
 */


// Definisikan rute untuk mendapatkan pengguna berdasarkan ID
router.post('/callback', integrasiApiController.callbackFromBJB);

module.exports = router;
