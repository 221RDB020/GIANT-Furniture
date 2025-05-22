const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const PUBLIC_VAPID_KEY = "BLL8fSWpc5_VYFzVWb_Usv1Oj_jy8QAfXZpB2vHvbIHQh5OKlWxcr-kUjz84o6eaOIjixYafPmotoI2mlRih9FU";
const options = {
    body: 'You Successfully Subscribed to our Newsletters!',
    icon: '/assets/icon/icon-192.png',
    lang: 'en-US',
    vibrate: [200, 50, 200],
    badge: '/assets/icon/apple-icon-114.png',
    tag: 'confirm-notification',
    renotify: false,
    data: {
        url: 'http://127.0.0.1:8000/',
    }
}

function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');

    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for (var i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

function confSubscription() {
    if (!('serviceWorker' in navigator)) return;

    let reg;
    navigator.serviceWorker.ready.then(swreg => {
        reg = swreg;
        return swreg.pushManager.getSubscription();
    })
        .then(subscription => {
            if (subscription === null) {
                return reg.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: urlBase64ToUint8Array(PUBLIC_VAPID_KEY)
                });
            }
        })
        .then(subscription => {
            if (subscription) {
                return fetch('/subscribe-to-notifications', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    body: JSON.stringify(subscription),
                })
            }
        })
        .then(response => {
            if (response?.ok) reg.showNotification('Subscription Successful!', options);
        })
        .catch(error => {
            console.log(error);
        });
}

if ('Notification' in window && 'serviceWorker' in navigator) {
    if (!(Notification.permission in ['denied', 'granted'])) {
        Notification.requestPermission().then(permission => {
            if (permission === 'granted') confSubscription();
        });
    }
}