/* By Abdullah As-Sadeed */

function Change_Page(page, additional_value) {
  waiting(true);

  messages_to_profile_code = "";
  var sub_header = document.querySelector("#sub_header h4");
  Array.prototype.forEach.call(
    document.querySelectorAll(".page"),
    function (pages) {
      pages.style.display = "none";
    }
  );
  Array.prototype.forEach.call(
    document.querySelectorAll(".dynamic"),
    function (dynamics) {
      dynamics.innerHTML = "";
    }
  );

  if (page == "feedline") {
    var feedline_page = document.getElementById("feedline_page");

    document.title = "FeedLine - TeleChirkut";
    sub_header.innerHTML = "FeedLine";
    feedline_page.style.display = "block";

    Generate_Post_Form();

    Retrieve_FeedLine();
  } else if (page == "messages") {
    document.title = "Messages - TeleChirkut";
    sub_header.innerHTML = "Messages";
    document.getElementById("messages_page").style.display = "flex";

    Retrieve_Messages_Connections_List(function () {
      if (additional_value !== "") {
        Assign_Messages_To_Profile_Code(additional_value);
      }
    });

    Update_Total_Unseen_Counts();
  } else if (page == "notifications") {
    var notifications_page = document.getElementById("notifications_page");
    document.title = "Notifications - TeleChirkut";
    sub_header.innerHTML = "Notifications";
    notifications_page.style.display = "block";

    Retrieve_Notifications();
  } else if (page == "explore") {
    Generate_Users_Page();
  } else if (page == "profile") {
    var profile_page = document.getElementById("profile_page");

    var data = new FormData();
    data.append("type", "Profile_Card");
    data.append("profile_code", additional_value);

    fetch("/", {
      method: "POST",
      body: data,
    })
      .then(function (response) {
        return response.text();
      })
      .then(function (json) {
        var json = JSON.parse(json);

        document.title = json.full_name + " on TeleChirkut";
        sub_header.innerHTML = json.full_name;
      });
    profile_page.style.display = "block";

    var data = new FormData();
    data.append("type", "Profile");
    data.append("profile_code", additional_value);

    fetch("/", {
      method: "POST",
      body: data,
    })
      .then(function (response) {
        return response.text();
      })
      .then(function (profile) {
        profile_page.innerHTML = profile;

        if (additional_value == my_profile_code) {
          document.getElementById("edit_face_logo_icon").onclick = function () {
            window.location.assign("/#face_logo_editor");
          };

          document.getElementById("edit_timezone_icon").onclick =
            Initiate_TimeZone_Edit;

          document.getElementById("edit_introduction_icon").onclick =
            Initiate_Introduction_Edit;
        } else {
          document.getElementById("profile_message_icon").onclick =
            function () {
              var profile_code = profile_message_icon.dataset.profile_code;
              window.location.assign("/#messages=" + profile_code);
            };

          document.getElementById("profile_report_icon").onclick = function () {
            Initiate_Report_User(profile_report_icon.dataset.profile_code);
          };

          Array.prototype.forEach.call(
            document.querySelectorAll(".follow_icon"),
            function (follow_icon) {
              follow_icon.onclick = function () {
                Follow__Profile_Page(follow_icon.dataset.profile_code);
              };
            }
          );
        }
      });
  } else if (page == "face_logo_editor") {
    document.title = "Edit Face / Logo - TeleChirkut";
    sub_header.innerHTML = "Edit Face / Logo";
    document.getElementById("face_logo_editor_page").style.display = "block";
    face_logo_editor.bind({
      url: "/?face_logo=" + my_profile_code,
    });
  } else if (page == "password_changer") {
    document.title = "Change Password - TeleChirkut";

    sub_header.innerHTML = "Change Password";
    document.getElementById("password_changer_page").style.display = "flex";

    document.getElementById("change_password_form").current_password.focus();
  } else if (page == "reacted_posts") {
    var reacted_posts_page = document.getElementById("reactions_page");

    document.title = "Reacted Posts - TeleChirkut";
    sub_header.innerHTML = "Reacted Posts";
    reacted_posts_page.style.display = "block";

    List_Reacted_Posts();
  } else if (page == "log_in_sessions") {
    var log_in_sessions_page = document.getElementById("log_in_sessions_page");
    document.title = "Log Ins - TeleChirkut";
    sub_header.innerHTML = "Log Ins";
    log_in_sessions_page.style.display = "block";

    List_Log_In_Sessions();
  } else if (page == "rules") {
    var rules_page = document.getElementById("rules_page");
    document.title = "Rules - TeleChirkut";
    sub_header.innerHTML = "Rules";
    rules_page.style.display = "block";

    var data = new FormData();
    data.append("type", "Rules");

    fetch("/", {
      method: "POST",
      body: data,
    })
      .then(function (response) {
        return response.text();
      })
      .then(function (rules) {
        rules_page.innerHTML = rules;
      });
  } else if (page == "post") {
    var post_page = document.getElementById("post_page");
    document.title = "Post - TeleChirkut";
    sub_header.innerHTML = "Post";
    post_page.style.display = "block";

    Retrieve_Post_Details(additional_value);
  }

  waiting(false);
}
