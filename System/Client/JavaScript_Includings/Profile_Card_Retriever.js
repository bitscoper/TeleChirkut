/* By Abdullah As-Sadeed */

function Retrieve_Profile_Card(profile_code, parent_id) {
  var data = new FormData();
  data.append("type", "Profile_Card");
  data.append("profile_code", profile_code);

  fetch("/", {
    method: "POST",
    body: data,
  })
    .then(function (response) {
      return response.text();
    })
    .then(function (json) {
      var json = JSON.parse(json);

      var card = document.createElement("span");
      card.classList.add("card");
      card.dataset.fullname = json.full_name;

      var face_logo = document.createElement("img");
      face_logo.classList.add("card_face_logo");
      face_logo.loading = "lazy";
      face_logo.alt = "";
      face_logo.src = "/?face_logo=" + profile_code;
      card.append(face_logo);

      var full_name = document.createElement("span");
      full_name.classList.add("card_full_name");
      full_name.innerHTML = json.full_name;
      card.append(full_name);

      var card_profile_code_verification_container =
        document.createElement("span");
      card_profile_code_verification_container.classList.add(
        "card_profile_code_verification_container"
      );
      card_profile_code_verification_container.innerHTML = profile_code;

      if (json.verified) {
        card_profile_code_verification_container.innerHTML += " | Verified";
      }

      card.append(card_profile_code_verification_container);

      var card_timezone = document.createElement("span");
      card_timezone.classList.add("card_timezone");
      card_timezone.innerHTML = json.timezone;
      card.append(card_timezone);

      var follow_button = document.createElement("span");

      if (json.followed) {
        follow_button.classList.add("button_light");
        follow_button.title = "Unfollow " + json.full_name;
        follow_button.innerHTML = "Followed";
      } else if (!json.followed) {
        follow_button.classList.add("button");
        follow_button.title = "Follow " + json.full_name;
        follow_button.innerHTML = "Follow";
      }

      card.append(follow_button);

      follow_button.onclick = function () {
        var data = new FormData();
        data.append("type", "Follow");
        data.append("profile_code", profile_code);

        fetch("/", {
          method: "POST",
          body: data,
        })
          .then(function (response) {
            return response.text();
          })
          .then(function (json) {
            var json_2 = JSON.parse(json);

            var action = json_2.action;

            if (action == "followed") {
              follow_button.innerHTML = "Followed";

              follow_button.classList.remove("button");
              follow_button.classList.add("button_light");

              follow_button.title = "Unfollow " + json.full_name;
            } else if (action == "unfollowed") {
              follow_button.innerHTML = "Follow";

              follow_button.classList.remove("button_light");
              follow_button.classList.add("button");

              follow_button.title = "Follow " + json.full_name;
            }
          });
      };

      document.getElementById(parent_id).append(card);

      card.onclick = function (click) {
        if (click.target !== follow_button) {
          window.location.assign("/#profile=" + profile_code);
        }
      };
    });
}
