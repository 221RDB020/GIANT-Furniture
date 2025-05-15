const CACHE_STATIC = 'giant-app-static-v1';
const CACHE_DYNAMIC = 'giant-app-dynamic-v1';
const STATIC_FILES = [
    '/',
    '/build/assets/app-5BjpYBM6.js',
    '/build/assets/main-DaIUkcT8.css',
    '/manifest.json',
    '/status-pages/404.html',
];

const ROUTES_LIST = {
    '/categories/living-room': [
        '/categories/sofas',
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


self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_STATIC)
            .then(cache => {
                cache.addAll(STATIC_FILES);
            })
    )
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys()
            .then(keys => {
                return Promise.all(keys.map(key => {
                    if (key !== CACHE_STATIC && key !== CACHE_DYNAMIC) {
                        return caches.delete(key);
                    }
                }));
            })
    );
    return self.clients.claim();
});

self.addEventListener('fetch', event => {
    const requestUrl = new URL(event.request.url);

    event.respondWith(
        caches.match(event.request)
            .then(cached => {
                if (cached) return cached;

                return fetch(event.request)
                    .then(res => {
                        return caches.open(CACHE_DYNAMIC)
                            .then(cache => {
                                if (event.request.url.startsWith('http://') || event.request.url.startsWith('https://')) {
                                    cache.put(event.request.url, res.clone());

                                    if (ROUTES_LIST[requestUrl.pathname]) {
                                        cacheSubRoutes(ROUTES_LIST[requestUrl.pathname]);
                                    }
                                }
                                return res;
                            });
                    })
                    .catch(error => {
                        if (event.request.headers.get('accept').includes('text/html')) {
                            return caches.open(CACHE_STATIC)
                                .then(cache => {
                                    return cache.match('/status-pages/404.html')
                                });
                        }
                    });
            })
    );
});

async function cacheSubRoutes(routes) {
    const cache = await caches.open(CACHE_DYNAMIC);

    for (const route of routes) {
        try {
            const res = await fetch(route, {mode: 'no-cors'});
            if (res.ok || res.type === 'opaque') {
                await cache.put(route, res.clone());
            }
        } catch (err) {
            console.warn(`Failed to fetch route ${route}`, err);
        }
    }
}
