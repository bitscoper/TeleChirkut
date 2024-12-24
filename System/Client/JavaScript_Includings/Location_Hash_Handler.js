/* By Abdullah As-Sadeed */

function Handle_Location_Hash() {
  var location_hash = window.location.hash.substring(1);

  if (location_hash !== "") {
    if (location_hash == "feedline") {
      Change_Page("feedline", "");
    } else if (location_hash == "messages") {
      Change_Page("messages", "");
    } else if (location_hash.startsWith("messages=")) {
      var profile_code = location_hash.split("=")[1];

      Change_Page("messages", profile_code);
    } else if (location_hash == "notifications") {
      Change_Page("notifications", "");
    } else if (location_hash == "explore") {
      Change_Page("explore", "");
    } else if (location_hash.startsWith("profile=")) {
      var profile_code = location_hash.split("=")[1];

      Change_Page("profile", profile_code);
    } else if (location_hash.startsWith("post=")) {
      var serial = location_hash.split("=")[1];

      Change_Page("post", serial);
    } else if (location_hash == "face_logo_editor") {
      Change_Page("face_logo_editor", "");
    } else if (location_hash == "reacted_posts") {
      Change_Page("reacted_posts", "");
    } else if (location_hash == "log_in_sessions") {
      Change_Page("log_in_sessions", "");
    } else if (location_hash == "password_changer") {
      Change_Page("password_changer", "");
    } else if (location_hash == "rules") {
      Change_Page("rules", "");
    } else if (location_hash == "owner") {
      Change_Page("profile", 1);
    } else {
      Show_Alert("Error 404: Your request was invalid!");

      history.replaceState(null, null, " ");
    }
  } else {
    window.location.assign("/#feedline");
  }
}
