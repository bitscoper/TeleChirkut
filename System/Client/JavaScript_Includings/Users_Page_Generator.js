/* By Abdullah As-Sadeed */

var users_type_explore,
  users_type_followings,
  users_type_followers,
  users_type_connections,
  user_search_field;

function Retrieve_Users(type) {
  var sub_header = document.querySelector("#sub_header h4");

  Array.prototype.forEach.call(
    document.querySelectorAll(".users_type"),
    function (users_type) {
      users_type.classList.remove("users_type_active");
    }
  );

  document.getElementById("users").innerHTML = "";

  if (type == "explore") {
    document.title = "Explore - TeleChirkut";

    sub_header.innerHTML = "Explore Users";
    users_type_explore.classList.add("users_type_active");
  } else if (type == "followings") {
    document.title = "Followings - TeleChirkut";

    sub_header.innerHTML = "Users You Follow";
    users_type_followings.classList.add("users_type_active");
  } else if (type == "followers") {
    document.title = "Followers - TeleChirkut";

    sub_header.innerHTML = "Users Who Follow You";
    users_type_followers.classList.add("users_type_active");
  } else if (type == "connections") {
    document.title = "Connections - TeleChirkut";

    sub_header.innerHTML = "Users You Follow Each Other";
    users_type_connections.classList.add("users_type_active");
  }

  var data = new FormData();
  data.append("type", "Users");
  data.append("users", type);

  fetch("/", {
    method: "POST",
    body: data,
  })
    .then(function (response) {
      return response.text();
    })
    .then(function (json) {
      var profile_codes = JSON.parse(json).profile_codes;

      profile_codes.forEach(function (profile_code) {
        Retrieve_Profile_Card(profile_code, "users");
      });
    });

  user_search_field.focus();
}

function Generate_Users_Page() {
  var users_page = document.getElementById("users_page");
  users_page.style.display = "block";

  var users_type_container = document.createElement("div");
  users_type_container.classList.add("users_type_container");

  users_type_explore = document.createElement("span");
  users_type_explore.classList.add("users_type");
  users_type_explore.innerHTML = "Explore";
  users_type_explore.title = "Explore";
  users_type_explore.onclick = function () {
    Retrieve_Users("explore");
  };
  users_type_container.append(users_type_explore);

  users_type_followings = document.createElement("span");
  users_type_followings.classList.add("users_type");
  users_type_followings.innerHTML = "Followings";
  users_type_followings.title = "Followings";
  users_type_followings.onclick = function () {
    Retrieve_Users("followings");
  };
  users_type_container.append(users_type_followings);

  users_type_followers = document.createElement("span");
  users_type_followers.classList.add("users_type");
  users_type_followers.innerHTML = "Followers";
  users_type_followers.title = "Followers";
  users_type_followers.onclick = function () {
    Retrieve_Users("followers");
  };
  users_type_container.append(users_type_followers);

  users_type_connections = document.createElement("span");
  users_type_connections.classList.add("users_type");
  users_type_connections.innerHTML = "Connections";
  users_type_connections.title = "Connections";
  users_type_connections.onclick = function () {
    Retrieve_Users("connections");
  };
  users_type_container.append(users_type_connections);

  users_page.append(users_type_container);

  var user_search_form = document.createElement("form");
  user_search_form.id = "user_search_form";

  user_search_field = document.createElement("input");
  user_search_field.type = "text";
  user_search_field.autocomplete = "off";
  user_search_field.placeholder = "Search users by name";
  user_search_field.title = "Search Users By Name";
  user_search_form.append(user_search_field);

  users_page.append(user_search_form);

  user_search_form.onsubmit = function (submission) {
    submission.preventDefault();

    return false;
  };

  user_search_field.onkeydown = function () {
    Array.prototype.forEach.call(
      document.querySelectorAll(".card"),
      function (card) {
        if (
          card.dataset.fullname
            .toUpperCase()
            .search(user_search_field.value.toUpperCase()) > -1
        ) {
          card.style.display = "inline-block";
        } else {
          card.style.display = "none";
        }
      }
    );
  };

  var users_container = document.createElement("div");
  users_container.id = "users";
  users_page.append(users_container);

  Retrieve_Users("explore");
}
