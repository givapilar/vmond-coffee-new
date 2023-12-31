// ====================================================================
// Send OTP By Phone NUmber
// ====================================================================
const axios = require('axios');
const { sendTelegramNotification } = require('../bot-telegram/sendTelegramNotification');

async function sendOtpByPhoneNumber(urlGlobal, msisdnDev, token) {
    try {
        const headers = {
            'Content-Type': 'application/json',
            'X-AUTH-TOKEN': token
        };

        const metaData = {
            "datetime": "2023-09-04T09:40:21.450Z",
            "deviceId": "bjbdigi",
            "devicePlatform": "Linux",
            "deviceOSVersion": "bjbdigi-version",
            "deviceType": "",
            "latitude": "",
            "longitude": "",
            "appId": 4,
            "appVersion": "1.0",
        };

        const bodyData = {
            phoneNo: msisdnDev
        };

        const result = await axios.post(
            urlGlobal + '/mobile-webconsole/apps/4/pbNonFinancialAdapter/resendOTPByPhone',
            { metadata: metaData, body: bodyData },
            { headers: headers }
        );

        const xAuthToken = result.headers['x-auth-token'];

        if (!xAuthToken) {
            // Jika xAuthToken kosong, jalankan kembali post data hingga 5 kali
            let retryCount = 0;
            const maxRetries = 2;
            const retryInterval = 3000; // Dalam milidetik (3 detik)

            while (!xAuthToken && retryCount < maxRetries) {
                await new Promise((resolve) => setTimeout(resolve, retryInterval));
                const retryResult = await axios.post(
                    `${urlGlobal}/mobile-webconsole/apps/pocket/requestTokenFintech/`,
                    { metadata: metaData, body: bodyData },
                    { headers: headers }
                );
                
                xAuthToken = retryResult.headers['x-auth-token'];
                retryCount++;
                console.log('process '+retryCount+'...');
            }

            if (!xAuthToken) {
                // Kirim notifikasi ke Telegram jika xAuthToken masih kosong setelah retry
                sendTelegramNotification('getTokenFintech : Gagal mendapatkan xAuthToken setelah mencoba kembali sebanyak 5 kali.');
                return 0;
            }
        }
        return xAuthToken;
    } catch (err) {
        sendTelegramNotification('getTokenFintech: Error post data...');
        return 0;
    }
}

module.exports = {
    sendOtpByPhoneNumber,
};