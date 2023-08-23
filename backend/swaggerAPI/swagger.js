const swaggerJSDoc = require('swagger-jsdoc');
const path = require('path'); // Import module path

const options = {
  definition: {
    openapi: '3.0.0',
    info: {
      title: 'Dokumentation API with Swagger',
      version: '1.0.1',
      description: 'A sample API with Swagger documentation',
    },
  },
  apis: [path.resolve(__dirname, '../routes/*.js')], // Menggunakan path.resolve untuk menyesuaikan path
};

const swaggerSpec = swaggerJSDoc(options);

module.exports = swaggerSpec;