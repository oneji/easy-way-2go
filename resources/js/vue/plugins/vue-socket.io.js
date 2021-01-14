import VueSocketIO from 'vue-socket.io'
import io from 'socket.io-client'

const chatURL = process.env.MIX_CHAT_URL;

export default new VueSocketIO({
    debug: true,
    connection: io(chatURL),
});