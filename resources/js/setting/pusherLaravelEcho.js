import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');
window.Pusher.logToConsole = true;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true,
    encrypted: false,
    wsPort: 6001,
    wssPort: 6001,
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
    disabledTransports: ['xhr_streaming'],
    authEndpoint: '/api/broadcasting/auth',


    auth: {
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token'),
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')

        }
    }
});



