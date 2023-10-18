const jwt = require('jwt-simple');
const secretKey = 'yUyOSXBD8ZB96JKv5e5K4aETVLJcGkubL8d6UlrqERJSVtvDJr';
const axios = require('axios');
require('dotenv').config();
const appENV = process.env.APP_ENV;
let urlGlobal, msisdn, passwordBJB;
// Import socket.io-client
const io = require("socket.io-client");
// Menghubungkan ke server Socket.IO
const socket = io('http://localhost:2222'); // Sesuaikan URL server Socket.IO

const getURL = (req, res) => {
    const resCallback = "Success Connect BRI! \n";
    res.json(resCallback);
};

const callbackFromBRI = async(req, res) => {
    try {
        // Di sini, Anda dapat melakukan operasi atau pemrosesan yang mungkin dapat memunculkan kesalahan

        // console.log('Response Data',res);
        
        console.log('Body =============',req.body);
        const responseData = {
            code: 200,
            message: 'Successfully!',
        };
        
        res.status(200).json(responseData);
    } catch (error) {
        const errorResponse = {
            code: 500,
            message: 'An error occurred',
            error: error.message 
        };
        
        res.status(500).json(errorResponse);
    }
}

const qrMpmNotify = async(req, res) => {
    try {
        const responseData = {
            code: 200,
            message: 'Successfully!'
        };
        
        res.status(200).json(responseData);
    } catch (error) {
        
        const errorResponse = {
            code: 500,
            message: 'An error occurred',
            error: error.message 
        };
        
        res.status(500).json(errorResponse);
    }
}
  
  module.exports = {
    getURL,
    callbackFromBRI,
    qrMpmNotify,
  };