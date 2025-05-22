const CACHE_STATIC = "giant-app-static-v1";
const CACHE_DYNAMIC = 'giant-app-dynamic-v1';
const ROUTES_LIST = {
    '/categories/living-room': [
        '/categories/sofas',
        '/categories/coffee-tables',
        '/categories/tv-stands',
        '/categories/bookshelves'
    ],
    '/categories/bedroom': [
        '/categories/beds',
        '/categories/wardrobes',
        '/categories/nightstands',
        '/categories/dressers'
    ],
    '/categories/child-room': [
        '/categories/bunk-beds',
        '/categories/toy-storage',
        '/categories/play-tables',
        '/categories/study-desks'
    ],
    '/categories/kitchen': [
        '/categories/kitchen-tables',
        '/categories/kitchen-cabinets',
        '/categories/seating',
        '/categories/pantry-storage'
    ],
    '/categories/bathroom': [
        '/categories/bathroom-mirrors',
        '/categories/shower-curtains',
        '/categories/bath-mats',
        '/categories/towel-racks'
    ],
    '/categories/hall': [
        '/categories/coat-racks',
        '/categories/shoe-cabinets',
        '/categories/console-tables',
        '/categories/umbrella-stands'
    ],
    '/categories/office': [
        '/categories/desks',
        '/categories/office-chairs',
        '/categories/filing-cabinets',
        '/categories/bookshelves'
    ]
};

function getAssets() {
    return fetch('./build/manifest.json')
        .then(res => res.json())
        .then(manifest => {
            return Object.values(manifest).map(entry => '/build/' + entry.file);
        });
}

self.addEventListener('install', event => {
    event.waitUntil(
        Promise.all([
            getAssets(),
            caches.open(CACHE_STATIC)
        ]).then(([assets, cache]) => {
            const STATIC_FILES = [
                '/',
                '/manifest.json',
                '/status-pages/404.html',
                ...assets
            ];
            return cache.addAll(STATIC_FILES);
        })
        .catch(error => {
            console.log(error);
        })
    );
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys()
            .then(keys => {
                Promise.all(
                    keys.map(key => {
                    if (key !== CACHE_STATIC && key !== CACHE_DYNAMIC) {
                        return caches.delete(key);
                    }
                }));
            })
    );
    self.clients.claim();
    cacheRoutes(Object.keys(ROUTES_LIST));
});

self.addEventListener('fetch', event => {
    const requestUrl = new URL(event.request.url);

    event.respondWith(
        caches.match(event.request)
            .then(cached => {
                if (ROUTES_LIST[requestUrl.pathname]) {
                    cacheRoutes(ROUTES_LIST[requestUrl.pathname])
                }

                if (cached) return cached;

                return fetch(event.request)
                    .then(res => {
                        return caches.open(CACHE_DYNAMIC)
                            .then(cache => {
                                if (event.request.url.startsWith('http://') || event.request.url.startsWith('https://')) {
                                    cache.put(event.request.url, res.clone());
                                }
                                return res;
                            });
                    })
                    .catch(error => {
                        if (event.request.headers.get('accept')?.includes('text/html')) {
                            return caches.match('/status-pages/404.html')
                        }
                    });
            })
    );
});

async function cacheRoutes(routes) {
    const cache = await caches.open(CACHE_DYNAMIC);

    for (const route of routes) {
        try {
            const cached = await cache.match(route);
            if (!cached) {
                const res = await fetch(route, {mode: 'no-cors'});
                if (res.ok || res.type === 'opaque') {
                    await cache.put(route, res.clone());
                }
            }
        } catch (err) {
            console.log(`Failed to fetch route ${route}`, err);
        }
    }
}

self.addEventListener('push', event => {
    const notification = event.data.json();

    event.waitUntil(
        self.registration.showNotification(notification.title, {
            body: notification.body,
            icon: "/assets/icon/icon-192.png",
            lang: 'en-US',
            vibrate: [200, 50, 200],
            badge: '/assets/icon/apple-icon-114.png',
            data: {
                url: notification.url
            }
        })
    )
});

self.addEventListener('notificationclick', event => {
    event.waitUntil(
        clients.matchAll()
            .then(clients => {
                let client = clients.find(c => {
                    return c.visibilityState === 'visible';
                });
                if (client !== undefined) {
                    client.navigate(event.notification.data.url);
                    client.focus();
                } else {
                    clients.openWindow(event.notification.data.url);
                }
                event.notification.close();
            })
    );
});
