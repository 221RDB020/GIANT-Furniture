if ('serviceWorker' in navigator) {
    navigator.serviceWorker
        .register('/sw.js')
        .then(function () {
            console.log('Service Worker Registered');
        });
}

window.addEventListener('beforeinstallprompt', (ev) => {
    console.log('beforeinstallprompt fired');
    ev.preventDefault()
    window.deferredPrompt = ev;
    return false;
});


import './bootstrap.js';
import './mobile-menu.js';
import './product-list.js';
import './product-show.js';
import './cart-index.js';
import './checkout.js';