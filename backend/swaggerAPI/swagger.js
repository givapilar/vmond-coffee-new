const swaggerJSDoc = require('swagger-jsdoc');

const options = {
  definition: {
    openapi: '3.0.0',
    info: {
      title: 'Express API with Swagger',
      version: '1.0.0',
      description: 'A sample API with Swagger documentation',
    },
  },
  apis: ['./routes/*.js'], // Letakkan sesuai dengan path file-route Anda
};

const swaggerSpec = swaggerJSDoc(options);

module.exports = swaggerSpec;
