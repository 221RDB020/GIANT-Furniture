if ('serviceWorker' in navigator) {
    window.addEventListener('load', async () => {
        try {
            navigator.serviceWorker
                .register('/sw.js')
                .then(() => {
                    console.log('Service Worker registered');
                })
        } catch (err) {
            console.error('Service Worker registration failed:', err);
        }
    });
}

import './notifications.js';
import './bootstrap.js';
import './mobile-menu.js';
import './product-list.js';
import './product-show.js';
import './cart-index.js';
import './checkout.js';
import './warehouse-map.js';
