/* By Abdullah As-Sadeed */

function Retrieve_Post_Details(serial) {
  var feedline = document.createElement("div");
  feedline.id = "feedline";

  var post = document.createElement("span");
  post.dataset.serial = serial;
  post.dataset.loading = "not_requested";
  post.classList.add("post");
  feedline.append(post);

  post_page.append(feedline);

  Try_Loading_Posts();

  var data = new FormData();
  data.append("type", "Post_Details");
  data.append("serial", serial);

  fetch("/", {
    method: "POST",
    body: data,
  })
    .then(function (response) {
      return response.text();
    })
    .then(function (json) {
      var reactions = JSON.parse(json).reactions;

      var post_reactions = document.createElement("div");

      reactions.forEach(function (reactions_data) {
        var reaction = reactions_data.reaction;

        var notification = document.createElement("span");
        notification.classList.add("notification");

        var face_logo = document.createElement("img");
        face_logo.loading = "lazy";
        face_logo.src = "/?face_logo=" + reactions_data.from_profile_code;
        face_logo.alt = "";
        notification.append(face_logo);

        var notification_text = document.createElement("span");
        notification_text.classList.add("notification_text");

        if (reaction == "love") {
          var reacted = "loved";
        } else if (reaction == "support") {
          var reacted = "supported";
        } else if (reaction == "celebrate") {
          var reacted = "celebrated";
        } else if (reaction == "amazing") {
          var reacted = "amazed";
        } else if (reaction == "curious") {
          var reacted = "felt curious";
        } else if (reaction == "funny") {
          var reacted = "felt funny";
        } else if (reaction == "sad") {
          var reacted = "felt sad";
        } else if (reaction == "angry") {
          var reacted = "showed anger";
        }

        notification_text.innerHTML =
          reactions_data.full_name + " " + reacted + ".";

        notification.onclick = function () {
          var profile_code = reactions_data.from_profile_code;
          window.location.assign("/#profile=" + profile_code);
        };

        notification.append(notification_text);

        var notification_date_time = document.createElement("span");
        notification_date_time.classList.add("notification_date_time");
        notification_date_time.innerHTML = reactions_data.date_time;
        notification.append(notification_date_time);

        post_reactions.append(notification);
      });

      post_page.append(post_reactions);
    });
}
