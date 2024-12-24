/* By Abdullah As-Sadeed */

document.body.oncontextmenu = function (menu) {
  menu.preventDefault();

  var menu_target = menu.target;

  Array.prototype.forEach.call(
    document.querySelectorAll(".context_menu"),
    function (context_menu) {
      context_menu.style.opacity = 0;

      setTimeout(function () {
        context_menu.remove();
      }, 500);
    }
  );

  var show_reload_icon = true;

  var context_menu = document.createElement("span");
  context_menu.classList.add("context_menu");

  if (Number.isInteger(Number(my_profile_code))) {
    if (
      menu_target.classList.contains("message_body") ||
      menu_target.classList.contains("image_message")
    ) {
      var message_delete_icon = document.createElement("span");
      message_delete_icon.classList.add("context_menu_item");
      message_delete_icon.innerHTML = "Delete Message";
      context_menu.append(message_delete_icon);

      message_delete_icon.onclick = function () {
        Initiate_Delete_Message(menu_target.dataset.serial);
      };

      show_reload_icon = false;
    } else {
      var messages_icon = document.createElement("span");
      messages_icon.classList.add("context_menu_item");
      messages_icon.innerHTML = "Messages";
      context_menu.append(messages_icon);

      var notification_icon = document.createElement("span");
      notification_icon.classList.add("context_menu_item");
      notification_icon.innerHTML = "Notifications";
      context_menu.append(notification_icon);

      var log_out_icon = document.createElement("span");
      log_out_icon.classList.add("context_menu_item");
      log_out_icon.innerHTML = "Log Out";
      context_menu.append(log_out_icon);

      messages_icon.onclick = function () {
        window.location.assign("/#messages");
      };

      notification_icon.onclick = function () {
        window.location.assign("/#notifications");
      };

      log_out_icon.onclick = Log_Out;
    }
  }

  if (show_reload_icon) {
    var reload_icon = document.createElement("span");
    reload_icon.classList.add("context_menu_item");
    reload_icon.innerHTML = "Reload";
    context_menu.append(reload_icon);

    reload_icon.onclick = function () {
      window.location.reload();

      context_menu.style.opacity = 0;

      setTimeout(function () {
        context_menu.remove();
      }, 500);
    };
  }

  document.getElementById("container").append(context_menu);

  var { clientX: mouseX, clientY: mouseY } = event;

  var { normalizedX, normalizedY } = Normalize_Position(
    mouseX,
    mouseY,
    context_menu
  );

  context_menu.style.top = normalizedY + "px";
  context_menu.style.left = normalizedX + "px";

  window.getComputedStyle(context_menu).opacity;
  context_menu.style.opacity = 1;
};
