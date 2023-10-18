const express = require('express');
const router = express.Router();
const integrasiApiController = require('../controllers/integrasiApiController');
const integrasiBriApiController = require('../controllers/integrasiBriApiController');

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
 *               message: Failed!.
 */

router.post('/callback', integrasiApiController.callbackFromBJB);
router.post('/get-token-fintech', integrasiApiController.getTokenFintech);
router.post('/send-otp-fintech', integrasiApiController.sendOtpByPhoneNumber);
router.post('/aktivasi', integrasiApiController.aktivasi);
router.post('/create-qr', integrasiApiController.createQR);

// BRI
router.post('/snap/v1.0/qr-dynamic/token', integrasiBriApiController.callbackFromBRI);
router.post('/snap/v1.0/qr-dynamic/qr-mpm-notify', integrasiBriApiController.qrMpmNotify);

module.exports = router;
