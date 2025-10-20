/* By Abdullah As-Sadeed */

window.onload = function () {
  if ("serviceWorker" in navigator) {
    navigator.serviceWorker
      .register("TeleChirkut.js")
      .then(function (registration) {
        service_worker_registration = registration;
      });
  }
};
