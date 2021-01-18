var CACHE_NAME = 'my-site-cache-v2';
var urlsToCache = [
  'https://www.doctorwhofans.be/css',
  'https://www.doctorwhofans.be/js',
  'https://www.doctorwhofans.be/images',
  'https://www.doctorwhofans.be/'
];
// @ts-ignore
let deferredPrompt;

self.addEventListener('beforeinstallprompt', function (event){
  event.preventDefault();
  deferredPrompt = event;
  showInstallPromotion();
});

self.addEventListener('install', function (event) {
  // Perform install steps
  'use strict';
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(function (cache) {
        //console.log('Opened cache');
        return cache.addAll(urlsToCache);
      })
  );
});
self.addEventListener('fetch', function (event) {
  event.respondWith(
    caches.match(event.request)
      .then(function (response) {
      // Cache hit - return response
        if (response) {
          return response;
        }
        // IMPORTANT: Clone the request. A request is a stream and
        // can only be consumed once. Since we are consuming this
        // once by cache and once by the browser for fetch, we need
        // to clone the response.
        var fetchRequest = event.request.clone();
        return fetch(fetchRequest).then(
          function (response) {
          // Check if we received a valid response
            if ((!response || response.status !== 200 || response.type !== 'basic') && response.url.indexOf('/php/') ==-1) {
              return response;
            }
            // IMPORTANT: Clone the response. A response is a stream
            // and because we want the browser to consume the response
            // as well as the cache consuming the response, we need
            // to clone it so we have two streams.
            var responseToCache = response.clone();

            caches.open(CACHE_NAME)
              .then(function (cache) {
                if(event.request=="GET"){
                  cache.put(event.request, responseToCache);
                }
              });

            return response;
          }
        );
      })
  );
});

self.addEventListener('activate', function (event) {
  var cacheWhitelist = ['my-site-cache-v2'];
  event.waitUntil(
    caches.keys().then(function (cacheNames) {
      return Promise.all(
        cacheNames.map(function (cacheName) {
          if (cacheWhitelist.indexOf(cacheName) === -1) {
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
  console.log('service worker activate');

});


function showInstallPromotion(){
  $('.installButton').show();
}
/* self.addEventListener('push', function(e) {
  var options = {
    body: event.data.body,
    icon: 'https://www.doctorwhofans.be/images/logo/logo.png',
    badge:'https://www.doctorwhofans.be/images/logo/logo.png',
    vibrate: [100, 50, 100],
    data: {
      dateOfArrival: Date.now(),
      primaryKey: '2'
    },
    actions: [
      {action: 'explore', title: 'Explore this new world',
        icon: 'images/checkmark.png'},
      {action: 'close', title: 'Close',
        icon: 'images/xmark.png'},
    ]
  };
  e.waitUntil(
    self.registration.showNotification('Hello world!', options)
  );
}); */


var version = "v2.0.2";
var swPath;
var urlObject = new URL(location);
var host;
if (urlObject.searchParams.get("swPath")) {
    swPath = urlObject.searchParams.get("swPath");
}
else {
    if (urlObject.searchParams.get("version")) {
        version = urlObject.searchParams.get("version");
    }
    if (urlObject.searchParams.get("swJSHost")) {
        host = "https://" + urlObject.searchParams.get("swJSHost");
    }




    else {
        host = "https://sdki.truepush.com/sdk/";
    }
    swPath = host + version + "/sw.js";
}
importScripts(swPath);