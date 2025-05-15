// if ('serviceWorker' in navigator) {
//     navigator.serviceWorker
//         .register('/sw.js')
//         .then(function () {
//             console.log('Service Worker Registered');
//         });
// }

if ('serviceWorker' in navigator) {
    window.addEventListener('load', async () => {
        try {
            navigator.serviceWorker
                .register('/sw.js')
                .then(() => {
                    console.log('Service Worker registered');
                })

            await cacheRoutes();
        } catch (err) {
            console.error('Service Worker registration failed:', err);
        }
    });
}

const ROUTES_LIST = [
    '/categories/living-room',
    '/categories/bedroom',
    '/categories/child-room',
    '/categories/kitchen',
    '/categories/bathroom',
    '/categories/hall',
    '/categories/office'
];

async function cacheRoutes() {
    if (!('caches' in window)) return;

    const cache = await caches.open('giant-app-dynamic-v1');

    for (const url of ROUTES_LIST) {
        try {
            const res = await fetch(url, {mode: 'no-cors'});
            if (res.ok || res.type === 'opaque') {
                cache.put(url, res.clone());
            }
        } catch (err) {
            console.warn(`Failed to cache ${url}`, err);
        }
    }
}

window.addEventListener('beforeinstallprompt', (ev) => {
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
