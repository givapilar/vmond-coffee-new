const express = require('express');
const app = express();
const userRoutes = require('./routes/integrasiApiRoutes');
const swaggerUi = require('swagger-ui-express');
const swaggerSpec = require('./swaggerAPI/swagger');
const axios = require('axios'); 
require('dotenv').config();
const schedule = require('node-schedule');
const bodyParser = require('body-parser');
var server = require("http").Server(app);
var io = require("socket.io")(server, {
    origins: '*:*'
});
const cors = require('cors');

// =====================Function Import=======================
const { getTokenFintech } = require('./services/api-bjb/requestTokenFintech');
// ===================End Function Import=====================

app.use(express.json());
app.use(bodyParser.json());
app.use('/v1/api-docs', swaggerUi.serve, swaggerUi.setup(swaggerSpec));
app.use('/v1/api', userRoutes);

// Socket Handle
io.on('connection', (socket) => {
  console.log('a client connected');
  socket.on('notif', (msg) => {
    console.log('======================'+ msg);
    io.emit('notif-berhasil', msg);
  });

  socket.on('disconnect', () => {
    console.log('client disconnected');
  });
});

// Define Port Express
const port = 2222;
server.listen(port, () => {
  console.log('Backend Node.js server is running on port ' + port);
});