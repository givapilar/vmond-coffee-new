const jwt = require('jwt-simple');
const secretKey = 'yUyOSXBD8ZB96JKv5e5K4aETVLJcGkubL8d6UlrqERJSVtvDJr';

const getURL = (req, res) => {
    const resCallback = "Success Connect!";
    res.json(resCallback);
  };
  
  const callbackFromBJB = (req, res) => {
    try {
      // ===================================================================
      // JWT TOKEN
      // ===================================================================
      // const decodedToken = jwt.decode(req.body.token, secretKey);
      
      // // Lakukan verifikasi data, misalnya cek 'sub' dalam payload
      // if (!decodedToken || !decodedToken.sub) {
      //   throw new Error('Invalid your token!');
      // }

      // ===================================================================
      // JWT TOKEN
      // ===================================================================
        
      // Logika pengolahan data
  
      const responseData = {
        code: 200,
        method: req.method,
        url: req.url,
        headers: req.headers,
        message: 'Successfully!'
      };
      res.status(200).json(responseData);
    } catch (error) {
      const responseData = {
        code: 500,
        method: req.method,
        url: req.url,
        headers: req.headers,
        message: 'Failed! Error: ' + error
      };
      
      res.status(500).json(responseData);
    }
  };
  
  module.exports = {
    getURL,
    callbackFromBJB
  };