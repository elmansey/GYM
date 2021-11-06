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
    authEndpoint: 'http://127.0.0.1:8000/api/broadcasting/auth',
    auth: {
        headers: {
            Accept: "application/json",
            Authorization: 'Bearer ' + localStorage.getItem('token'),
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

        }
    },

});


// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true,
//     host:window.location.hostname + ':8000',
//     authEndpoint: '/api/broadcasting/auth',
//     disableStats: true,
//     enabledTransports: ['ws', 'wss'],
//     auth: {
//         headers: {
//             'Content-Type': 'application/json',
//             Authorization: 'Bearer ' + localStorage.getItem('token'),
//             'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

//         }
//     },

// })
