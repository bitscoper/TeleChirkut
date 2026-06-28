/* By Abdullah As-Sadeed */

function Assign_OnClicks_Once() {
  document.getElementById("feedline_icon").onclick = function () {
    window.location.assign("/#feedline");
  };

  document.getElementById("messages_icon").onclick = function () {
    window.location.assign("/#messages");
  };

  document.getElementById("notifications_icon").onclick = function () {
    window.location.assign("/#notifications");
  };

  document.getElementById("explore_icon").onclick = function () {
    window.location.assign("/#explore");
  };

  document.getElementById("menu_icon").onclick = function () {
    menu.style.display = "inline-block";
  };

  document.getElementById("menu_profile_icon").onclick = function () {
    window.location.assign("/#profile=" + my_profile_code);
  };

  document.getElementById("change_password_icon").onclick = function () {
    window.location.assign("/#password_changer");
  };

  document.getElementById("reactions_icon").onclick = function () {
    window.location.assign("/#reacted_posts");
  };

  document.getElementById("log_ins_icon").onclick = function () {
    window.location.assign("/#log_in_sessions");
  };

  document.getElementById("log_out_icon").onclick = Log_Out;

  document.getElementById("rules_icon").onclick = function () {
    window.location.assign("/#rules");
  };
}
