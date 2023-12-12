// const jwt = require('jwt-simple');
const secretKey = 'yUyOSXBD8ZB96JKv5e5K4aETVLJcGkubL8d6UlrqERJSVtvDJr';
const axios = require('axios');
require('dotenv').config();
const appENV = process.env.APP_ENV;
let urlGlobal, msisdn, passwordBJB;
// Import socket.io-client
const io = require("socket.io-client");
// Menghubungkan ke server Socket.IO
const socket = io('http://localhost:2222'); // Sesuaikan URL server Socket.IO
const crypto = require('crypto');
const jwt = require('jsonwebtoken');

const getURL = (req, res) => {
    const resCallback = "Success Connect BRI! \n";
    res.json(resCallback);
};

function generateShortToken(clientId, dateTime, expiresIn) {
    // Di sini Anda dapat mengimplementasikan logika untuk menghasilkan token yang lebih pendek
    // Berdasarkan clientId, datetime, dan algoritma tertentu.

    // Contoh sederhana: Menggabungkan clientId dan datetime
    const combinedData = clientId + dateTime;

    // Anda dapat menggunakan library atau algoritma tertentu untuk menghasilkan hash atau token yang lebih pendek
    // Sesuaikan dengan kebutuhan Anda.

    // Contoh sederhana: Menggunakan MD5 untuk menghasilkan token
    const md5 = require('crypto').createHash('md5');
    const shortToken = md5.update(combinedData).digest('hex');

    return shortToken;
}

const callbackFromBRI = async (req, res) => {
    try {
        const now = new Date();
        const offset = now.getTimezoneOffset();
        const expiresIn = 899;
        
        // Menghitung offset dalam format yang diinginkan (contoh: +07:00)
        const offsetHours = Math.floor(Math.abs(offset) / 60);
        const offsetMinutes = Math.abs(offset) % 60;
        const offsetSign = offset >= 0 ? '-' : '+';
        const offsetFormatted = `${offsetSign}${String(offsetHours).padStart(2, '0')}:${String(offsetMinutes).padStart(2, '0')}`;
        
        // Mengambil komponen tanggal dan waktu dalam format yang diinginkan
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        
        // Membentuk tanggal dan waktu dalam format yang diinginkan
        const formattedDateTime = `${year}-${month}-${day}T${hours}:${minutes}:${seconds}${offsetFormatted}`;
        // if (req.headers['x-client-key'] !== '1DhFVj7GA8bfll4tLJuD3KzHxPO3tzCb' ) {
        if (req.headers['x-client-key'] !== 'J1JrstpgKhhuC9Em16QOzZlLQBLjaG1F' ) {
            // return res.status(401).json({ message: 'Unauthorized Client' });
        }

        // const publicKey = `-----BEGIN PUBLIC KEY-----
        // MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvSDY2+DWghiw8cLpKN7T6pos3KSZFfyJNt0SXoCcNdmwW/n8t0YjNJuW0OEcXgs5mWqT0IVd8IjGQn+a5AnFNannZ8gtWB9InVxDQHclvYQmJ9KS419ej/1TULJLy0l6EhEVVNvuIs30gvpY5MvN7z3hmllxuLM6Tn7sx8XBhIF5MkbG4JVs8OzTDKWT5N1y9AB6KEulEqxQjLh6YAVn5ZAjg5Vh7LKjlfhwPi+67UwqEK5kbqP3Vj5NdnFd+vrGvbAf46CUM1XC4i+CuEnKfrG2hWk0MQHkarBdPJI+LBJOSmJk+NqAYMvuG1/zv/3MW48/oX0/kndRzV+tvW0/pQIDAQAB
        // -----END PUBLIC KEY-----`;

        // const client_ID = '1DhFVj7GA8bfll4tLJuD3KzHxPO3tzCb'; // Gantilah dengan client_ID Anda
        // const XTIMESTAMP = formattedDateTime; // Gantilah dengan XTIMESTAMP Anda
        // const stringToSign = client_ID + "|" + XTIMESTAMP;

        // // Membuat signature dengan menggunakan algoritma SHA256withRSA dan kunci publik
        // const sign = crypto.createSign('RSA-SHA256');
        // sign.update(stringToSign);
        // const signature = sign.sign(publicKey, 'base64');


        const shortToken = generateShortToken(req.headers['x-client-key'], formattedDateTime, expiresIn);

        if (shortToken) {
            const token = {
                accessToken: shortToken,
                tokenType: 'BearerToken',
                expiresIn: expiresIn
            };
            console.log("Success");
            console.log("Response" );
            res.status(200).json(token);
        } else {
            res.status(500).json({ error: 'Token creation failed' });
        }

        // const clientId = req.headers['client-id'];
        // const clientSecret = req.headers['client-secret'];

        // // Memeriksa apakah client-id dan client-secret sesuai dengan yang diharapkan
        // if (clientId !== '1DhFVj7GA8bfll4tLJuD3KzHxPO3tzCb' || clientSecret !== 'FaKm5s4fnTI35jyV') {
        //     return res.status(401).json({ message: 'Unauthorized Client' });
        // }

        // // Periksa body request
        // const { grantType } = req.body;

        // if (grantType !== 'client_credentials') {
        //     return res.status(400).json({ message: 'Invalid Field Format' });
        // }

        // // Fungsi generateAccessToken harus didefinisikan sebelum digunakan
        // const accessToken = generateAccessToken();

        // Buat respons sesuai format token yang diinginkan
        // const response = {
        //     accessToken: accessToken,
        //     tokenType: 'Bearer',
        //     expiresIn: '900'
        // };

        // res.status(200).json(response);
    } catch (error) {
        const errorResponse = {
            code: 500,
            message: 'An error occurred',
            error: error.message
        };
        res.status(500).json(errorResponse);
    }
}


const qrMpmNotify = async (req, res) => {
    // try {
        try {
            // Di sini, Anda dapat melakukan operasi atau pemrosesan yang mungkin dapat memunculkan kesalahan
            
            const responseData = {
                code: 200,
                message: 'Successfully!',
            };
            console.log("Request", req);
            // console.log("Transaction Success", req.body.transactionStatusDesc);

            if (req.body.transactionStatusDesc === 'success') {
                try {
                    const bodyData = {
                        invoiceID: req.body.originalPartnerReferenceNo,
                        status: req.body.transactionStatusDesc,
                    };
                    const result = await axios.post('https://vmondcoffee.controlindo.com/api/data/success-order-bri', bodyData)
                        .then((response) => {
                            console.log(response);
                            // Mendengarkan pesan dari server
    
                        })
                        .catch((error) => {
                            console.error('Axios request error:', error);
                        });
                    socket.emit('notif-bri', req.body.originalPartnerReferenceNo);
                    console.log('RESULT JS:: ',result)
    
                } catch (error) {
                    console.log('ERROR!!!', error.message);
                }
            }

            res.status(200).json(responseData);
            
        } catch (error) {
            const errorResponse = {
                code: 500,
                message: 'An error occurred',
                error: error.message 
            };
            
            res.status(500).json(errorResponse);
        }
        // Memeriksa header Authorization
        // const authorizationHeader = req.headers['authorization'];

        // if (!authorizationHeader || !authorizationHeader.startsWith('Bearer ')) {
        //     return res.status(401).json({ message: 'Unauthorized' });
        // }

        // // Mengambil token dari header Authorization
        // const token = authorizationHeader.substring(7); // Menghapus "Bearer " dari header

        // console.log("Token",token);
        // // Melakukan verifikasi token (Anda perlu mengganti ini sesuai dengan implementasi Anda)
        // const isTokenValid = verifyToken(token);

        // if (!isTokenValid) {
        //     return res.status(401).json({ message: 'Invalid Token' });
        // }

        // // Jika token valid, lanjutkan dengan logika bisnis Anda di sini

        // // Contoh: Lakukan sesuatu dengan data yang diterima dalam req.body
        // const data = req.body;
        // ...

        // Jika semua berjalan dengan baik, kirim respons sukses
        // -----------------------------------------------------

    //     const bearerToken = req.headers['authorization'];

    //     if (bearerToken) {
    //         const bearer = bearerToken.split(' ');
    //         if (bearer.length === 2) {
    //             const bearerToken = bearer[1];
    //             req.token = bearerToken;
    //             // next();
    //             jwt.verify(req.token, 'secretkey', (err, authData) => {
    //                 if (err) {
    //                     res.sendStatus(403);
    //                 } else {
    //                     res.json({
    //                         message: "Success",
    //                         data: authData
    //                     });
    //                 }
    //             });
    //         } else {
    //             res.sendStatus(403);
    //         }
    //     } else {
    //         res.sendStatus(403);
    //     }
        
    // } catch (error) {
    //     const errorResponse = {
    //         code: 500,
    //         message: 'An error occurred',
    //         error: error.message
    //     };
    //     res.status(500).json(errorResponse);
    // }
}



  
  module.exports = {
    getURL,
    callbackFromBRI,
    qrMpmNotify,
  };