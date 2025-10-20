/* By Abdullah As-Sadeed */

"use strict";

self.addEventListener("install", function () {
  self.skipWaiting();
});

self.addEventListener("activate", function (activation) {
  activation.waitUntil(
    caches.keys().then(function (cache_names) {
      for (var cache_name of cache_names) {
        caches.delete(cache_name);
      }

      var data = new FormData();
      data.append("client_caches", "");

      fetch("/", {
        method: "POST",
        body: data,
      })
        .then(function (response) {
          return response.text();
        })
        .then(function (json) {
          var caches_array = JSON.parse(json).caches;

          caches.open("client").then(function (cache) {
            return cache.addAll(caches_array);
          });
        });
    })
  );
});

self.addEventListener("fetch", function (fetching) {
  fetching.respondWith(
    caches
      .match(fetching.request)
      .then(function (cached_response) {
        return cached_response || fetch(fetching.request);
      })
      .catch(function (error) {
        if (fetching.request.mode === "navigate") {
          return caches.match("offline.php");
        }
        throw error;
      })
  );
});

self.addEventListener("notificationclick", function (notification_click) {
  if (notification_click.action === "close") {
    notification_click.notification.close();
  } else {
    clients.openWindow("/#notifications");

    notification_click.notification.close();
  }
});

function Notify(data) {
  var json = JSON.parse(data.text());

  var notification_settings = {
    badge: "Client_Includings/TeleChirkut_MonoChrome_96.png",
    body: json.body_text,
    icon: "Client_Includings/TeleChirkut_192.png",
  };

  if (json.image_url !== "") {
    notification_settings.image = json.image_url;
  }

  if (json.date_time !== "") {
    notification_settings.timestamp = Date.parse(json.date_time);
  }

  return self.registration.showNotification(json.title, notification_settings);
}

self.addEventListener("push", function (event) {
  if (self.Notification && self.Notification.permission === "granted") {
    if (event.data) {
      event.waitUntil(Notify(event.data));
    }
  }
});
