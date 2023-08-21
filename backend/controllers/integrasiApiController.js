const getURL = (req, res) => {
    const resCallback = "Success Connect!";
    res.json(resCallback);
  };
  
  const callbackFromBJB = (req, res) => {
    try {
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