// ====================================================================
// Get Token API BJB
// ====================================================================

// Request Token Fintech
const sendGetRequest = async () => {
  try {
    const headers = {
      "Content-Type": "application/json"
    };
    
    const metaData = {
      "datetime": "2023-09-05T09:40:21.450Z",
      "deviceId": "9f9cb0504caa5059", 
      "devicePlatform": "Linux",
      "deviceOSVersion": "9",
      "deviceType": "",
      "latitude": "",
      "longitude": "",
      "appId": 4,
      "appVersion": "1.0",
    };
    
    const bodyData = {
      "msisdn": msisdnDev,
      "password": "1c1bbf7b79bc9b97cafb7488946a6001f05980f62dbeb5bc093dd680b8241197",
    };
    
    const result = await axios.post(urlGlobal + "/mobile-webconsole/apps/pocket/requestTokenFintech/", 
    {"metadata": metaData, "body": bodyData}, 
    {"headers": headers});
    
    console.log("AllResult :: ", result);
    console.log("Result Data :: ", result.data);
    
    // check console
    if (result && result.data && result.data.body && result.data.body.CreateTokenFintechResponse) {
      const customer = result.data.body.CreateTokenFintechResponse.customer;
      const attr = result.data.body.CreateTokenFintechResponse._attr;
      const channel = result.data.body.CreateTokenFintechResponse.channel;
      const key = result.data.body.CreateTokenFintechResponse.key;
      const xAuthToken = result.headers['x-auth-token'];

      console.log("X-AUTH-TOKEN:", xAuthToken)
  
      console.log("Attr:", attr);
      console.log("Customer:", customer);
      console.log("Channel:", channel);
      console.log("Key:", key);
    } else {
      console.log("Response structure is not as expected.");
    }

  } catch (err) {
    // Handle Error Here
    console.error(err);
  }
};