/* By Abdullah As-Sadeed */

function Retrieve_Notifications() {
  var data = new FormData();
  data.append("type", "Notifications");

  fetch("/", {
    method: "POST",
    body: data,
  })
    .then(function (response) {
      return response.text();
    })
    .then(function (json) {
      var notifications = JSON.parse(json).notifications;

      if (notifications.length > 0) {
        notifications.forEach(function (notification_data) {
          var type = notification_data.type;

          var notification = document.createElement("span");
          notification.classList.add("notification");

          var face_logo = document.createElement("img");
          face_logo.loading = "lazy";
          face_logo.src = "/?face_logo=" + notification_data.from_profile_code;
          face_logo.alt = "";
          notification.append(face_logo);

          var notification_text = document.createElement("span");
          notification_text.classList.add("notification_text");

          if (type == "followed") {
            notification_text.innerHTML =
              notification_data.full_name + " followed you.";

            notification.onclick = function () {
              var profile_code = notification_data.from_profile_code;
              window.location.assign("/#profile=" + profile_code);
            };
          } else if (
            type == "love" ||
            type == "support" ||
            type == "celebrate" ||
            type == "amazing" ||
            type == "curious" ||
            type == "funny" ||
            type == "sad" ||
            type == "angry"
          ) {
            if (type == "love") {
              var reacted = "loved";
            } else if (type == "support") {
              var reacted = "supported";
            } else if (type == "celebrate") {
              var reacted = "celebrated";
            } else if (type == "amazing") {
              var reacted = "amazed at";
            } else if (type == "curious") {
              var reacted = "felt curious to";
            } else if (type == "funny") {
              var reacted = "felt funny to";
            } else if (type == "sad") {
              var reacted = "felt sad to";
            } else if (type == "angry") {
              var reacted = "showed anger to";
            }

            notification_text.innerHTML =
              notification_data.full_name + " " + reacted + " your post.";

            notification.onclick = function () {
              var serial = notification_data.feedline_serial;
              window.location.assign("/#post=" + serial);
            };
          }

          notification.append(notification_text);

          var notification_date_time = document.createElement("span");
          notification_date_time.classList.add("notification_date_time");
          notification_date_time.innerHTML = notification_data.date_time;
          notification.append(notification_date_time);

          notifications_page.append(notification);
        });
      } else {
        notifications_page.style.display = "flex";

        var empty_notificatiion = document.createElement("div");
        empty_notificatiion.classList.add("empty_flex");
        empty_notificatiion.innerHTML = "No Notification";
        notifications_page.append(empty_notificatiion);
      }

      Update_Total_Unseen_Counts();
    });
}
