/* By Abdullah As-Sadeed */

window.onclick = function (click) {
  var click_target = click.target;

  Array.prototype.forEach.call(
    document.querySelectorAll(".context_menu"),
    function (context_menu) {
      context_menu.style.opacity = 0;

      setTimeout(function () {
        context_menu.remove();
      }, 500);
    }
  );

  if (!click_target.classList.contains("post_more_icon")) {
    Array.prototype.forEach.call(
      document.querySelectorAll(".post_more_menu"),
      function (post_more_menu) {
        post_more_menu.style.opacity = 0;

        setTimeout(function () {
          post_more_menu.remove();
        }, 500);
      }
    );
  }

  if (!click_target.classList.contains("post_react_icon")) {
    Array.prototype.forEach.call(
      document.querySelectorAll(".post_reactions_container"),
      function (post_reactions_containers) {
        setTimeout(function () {
          post_reactions_containers.remove();
        }, 200);
      }
    );
  }

  if (click_target.id !== "menu_icon") {
    var menu = document.getElementById("menu");

    if (typeof menu !== "undefined" && menu !== null) {
      menu.style.display = "none";
    }
  }
};
