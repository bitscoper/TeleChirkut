/* By Abdullah As-Sadeed */

function Follow__Profile_Page(to_profile_code) {
  var follow = document.getElementById("follow_" + to_profile_code);

  var full_name = follow.dataset.fullname;

  var data = new FormData();
  data.append("type", "Follow");
  data.append("profile_code", to_profile_code);

  fetch("/", {
    method: "POST",
    body: data,
  })
    .then(function (response) {
      return response.text();
    })
    .then(function (json) {
      var json = JSON.parse(json);
      var action = json.action;
      var followers_count = document.getElementById("followers_count");

      if (typeof followers_count !== "undefined" && followers_count !== null) {
        followers_count.innerHTML = json.followers_count;
      }

      if (action == "followed") {
        follow.innerHTML = "Followed";
        follow.classList.remove("button");
        follow.classList.add("button_light");
        follow.title = "Unfollow " + full_name;
      } else if (action == "unfollowed") {
        follow.innerHTML = "Follow";
        follow.classList.remove("button_light");
        follow.classList.add("button");
        follow.title = "Follow " + full_name;
      }
    });
}
