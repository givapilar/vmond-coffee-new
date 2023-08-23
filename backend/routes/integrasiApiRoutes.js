const express = require('express');
const router = express.Router();
const integrasiApiController = require('../controllers/integrasiApiController');

// Definisikan rute untuk mendapatkan semua pengguna
router.get('/', integrasiApiController.getURL);

/**
 * @swagger
 * /v1/api/callback:
 *   post:
 *     responses:
 *       200:
 *          code:
 *              200
 *          method:
 *              POST
 *          url:
 *              /v1/api/callback
 *          headers:
 *              ....
 *          message:
 *              Successfully!
 *       500:
 *          code:
 *              500
 *          method:
 *              POST
 *          url:
 *              /v1/api/callback
 *          headers:
 *              ....
 *          message:
 *              Failed! Error: msg
 *
 */

// Definisikan rute untuk mendapatkan pengguna berdasarkan ID
router.post('/callback', integrasiApiController.callbackFromBJB);

module.exports = router;
