/* By Abdullah As-Sadeed */

function Convert_URL_Base64_To_Uint8_Array(base64_string) {
  var padding = "=".repeat((4 - (base64_string.length % 4)) % 4);
  var base64 = (base64_string + padding).replace(/\-/g, "+").replace(/_/g, "/");
  var raw_data = atob(base64);
  var out_array = new Uint8Array(raw_data.length);

  for (var i = 0; i < raw_data.length; ++i) {
    out_array[i] = raw_data.charCodeAt(i);
  }

  return out_array;
}

var client = document.getElementById("client");

if (typeof client !== "undefined" && client !== null) {
  if ("Notification" in window) {
    if (
      Notification.permission !== "granted" ||
      !localStorage.is_notification_permission_requested
    ) {
      Get_Confirmation(
        "Permission",
        "Do you permit for notifications?",
        "Grant",
        "No"
      ).then(function (confirmation) {
        if (confirmation) {
          Notification.requestPermission().then(function (permission) {
            if (permission == "granted") {
              Show_Alert("Granted");

              if ("PushManager" in window) {
                var application_server_Key =
                  "BJpxNQ1YHEDKx2keauZGjpL9IsmRPkXFzS1rKFZRDsjzCIzUih3RcVFt7zkopqWp-AbYni1F4yPwfRbBrZvq_Vg";

                service_worker_registration.pushManager
                  .subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: Convert_URL_Base64_To_Uint8_Array(
                      application_server_Key
                    ),
                  })
                  .then(function (subscription) {
                    var key = subscription.getKey("p256dh");
                    var token = subscription.getKey("auth");
                    var contentEncoding =
                      (PushManager.supportedContentEncodings || ["aesgcm"])[0];

                    var push_json = JSON.stringify({
                      endpoint: subscription.endpoint,
                      publicKey: key
                        ? btoa(
                            String.fromCharCode.apply(null, new Uint8Array(key))
                          )
                        : null,
                      authToken: token
                        ? btoa(
                            String.fromCharCode.apply(
                              null,
                              new Uint8Array(token)
                            )
                          )
                        : null,
                      contentEncoding,
                    });

                    var data = new FormData();
                    data.append("type", "Push_Subscribe");
                    data.append("push_json", push_json);

                    fetch("/", {
                      method: "POST",
                      body: data,
                    }).then(function () {
                      localStorage.is_notification_permission_requested = true;
                    });
                  });
              }
            }
          });
        }
      });
    }
  }
}
