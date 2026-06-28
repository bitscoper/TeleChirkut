/* By Abdullah As-Sadeed */

function Get_Confirmation(
  title,
  message,
  confirm_button_value,
  cancel_button_value
) {
  return new Promise((resolve, reject) => {
    if (
      typeof title !== "undefined" ||
      typeof message !== "undefined" ||
      typeof confirm_button_value !== "undefined"
    ) {
      if (title !== "" || message !== "" || confirm_button_value !== "") {
        var overlap = document.createElement("div");
        overlap.classList.add("overlap");

        var confirmation_box = document.createElement("div");
        confirmation_box.classList.add("confirmation_box");

        var title_container = document.createElement("div");
        title_container.classList.add("confirmation_box_title");
        title_container.innerHTML = title;
        confirmation_box.append(title_container);

        var message_container = document.createElement("div");
        message_container.classList.add("confirmation_box_message");
        message_container.innerHTML = message;
        confirmation_box.append(message_container);

        var buttons_container = document.createElement("div");
        buttons_container.classList.add("confirmation_box_buttons");

        var confirm_button_container = document.createElement("div");
        confirm_button_container.classList.add(
          "confirmation_box_confirm_button_container"
        );

        var confirm_button = document.createElement("span");
        confirm_button.classList.add("button");
        confirm_button.innerHTML = confirm_button_value;
        confirm_button_container.append(confirm_button);

        buttons_container.append(confirm_button_container);

        if (cancel_button_value !== "") {
          var cancel_button_container = document.createElement("div");
          cancel_button_container.classList.add(
            "confirmation_box_cancel_button_container"
          );

          var cancel_button = document.createElement("span");
          cancel_button.classList.add("button_light");
          cancel_button.innerHTML = cancel_button_value;
          cancel_button_container.append(cancel_button);

          buttons_container.append(cancel_button_container);
        }

        confirmation_box.append(buttons_container);

        overlap.append(confirmation_box);

        document.getElementById("container").append(overlap);

        window.getComputedStyle(overlap).opacity;
        overlap.style.opacity = 1;

        confirm_button.focus();

        confirm_button.onclick = function () {
          overlap.style.opacity = 0;

          setTimeout(function () {
            overlap.remove();
            resolve(true);
          }, 500);
        };

        if (cancel_button_value !== "") {
          cancel_button.onclick = function () {
            overlap.style.opacity = 0;

            setTimeout(function () {
              overlap.remove();
              resolve(false);
            }, 500);
          };

          document.body.onkeydown = function (event) {
            if (event.key === "Enter") {
              confirm_button.click();
            } else if (event.key === "Escape") {
              cancel_button.click();
            }
          };
        }

        return;
      } else {
        reject("Bad Arguments");
      }
    } else {
      reject("Bad Arguments");
    }
  });
}
