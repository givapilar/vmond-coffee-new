const TelegramBot = require('node-telegram-bot-api');

// Ganti dengan token bot Telegram Anda
const botToken = process.env.BOT_TOKEN;

// Buat instance bot
const bot = new TelegramBot(botToken, { polling: false }); // polling: false menghindari mode polling

// Fungsi untuk mengirim pesan ke bot Telegram
function sendTelegramNotification(message) {
  // Ganti dengan chat_id bot Telegram Anda
  const chatId = '-902590975';

  bot.sendMessage(chatId, message)
    .then(() => {
      console.log('Notifikasi berhasil dikirim ke bot Telegram');
    })
    .catch((error) => {
      console.error('Gagal mengirim notifikasi ke bot Telegram:', error);
    });
}

module.exports = {
  sendTelegramNotification,
};
