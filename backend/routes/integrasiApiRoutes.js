const express = require('express');
const router = express.Router();
const integrasiApiController = require('../controllers/integrasiApiController');

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

module.exports = router;
