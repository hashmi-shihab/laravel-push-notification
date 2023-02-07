importScripts('https://www.gstatic.com/firebasejs/8.3.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.0/firebase-messaging.js');

firebase.initializeApp({
    apiKey: "AIzaSyAnc62y9fjoxgLi8729ldVBvzFo7X7vkpI",
    authDomain: "laravel-push-notificatio-6e34b.firebaseapp.com",
    projectId: "laravel-push-notificatio-6e34b",
    storageBucket: "laravel-push-notificatio-6e34b.appspot.com",
    messagingSenderId: "403689199447",
    appId: "1:403689199447:web:28b56876934b605baa5012",
    measurementId: "G-9W3P1XHQ5P"
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload,
    );

    const notificationTitle = "Background Message Title";
    const notificationOptions = {
        body: "Background Message body.",
        icon: "/itwonders-web-logo.png",
    };

    return self.registration.showNotification(
        notificationTitle,
        notificationOptions,
    );
});
