/* By Abdullah As-Sadeed */

function Log_Out() {
  Get_Confirmation(
    "Confirmation",
    "Are you sure to log out?",
    "Log Out",
    "No"
  ).then(function (confirmation) {
    if (confirmation) {
      waiting(true);

      var data = new FormData();
      data.append("type", "Log_Out");

      fetch("/", {
        method: "POST",
        body: data,
      })
        .then(function (response) {
          return response.text();
        })
        .then(function (json) {
          var json = JSON.parse(json);

          if (json.logged_out) {
            if ("serviceWorker" in navigator) {
              navigator.serviceWorker.ready.then(function (registration) {
                registration.pushManager
                  .getSubscription()
                  .then(function (subscription) {
                    subscription.unsubscribe();
                  });
              });
            }

            localStorage.clear();

            window.location.reload();
          } else {
            Show_Alert("Something Wrong");
            window.location.reload();
          }
        });
    } else {
      Show_Alert("Not Logged Out");
    }
  });
}
