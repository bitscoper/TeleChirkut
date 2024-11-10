/* By Abdullah As-Sadeed */

function Update_Total_Unseen_Counts() {
  var data = new FormData();
  data.append("type", "Total_Unseen_Counts");

  fetch("/", {
    method: "POST",
    body: data,
  })
    .then(function (response) {
      return response.text();
    })
    .then(function (json) {
      var json = JSON.parse(json);

      var total_unseen_messages_count = json.messages;
      var total_unseen_notifications_count = json.notifications;

      var header_unseen_messages_count = document.getElementById(
        "header_unseen_messages_count"
      );

      var header_unseen_notifications_count = document.getElementById(
        "header_unseen_notifications_count"
      );

      if (total_unseen_messages_count > 0) {
        header_unseen_messages_count.innerHTML = total_unseen_messages_count;
      } else {
        header_unseen_messages_count.innerHTML = "";
      }
      if (total_unseen_notifications_count > 0) {
        header_unseen_notifications_count.innerHTML =
          total_unseen_notifications_count;
      } else {
        header_unseen_notifications_count.innerHTML = "";
      }
    });
}
