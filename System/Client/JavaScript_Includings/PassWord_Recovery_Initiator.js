/* By Abdullah As-Sadeed */

function Initiate_PassWord_Recovery() {
  var overlap = document.createElement("div");
  overlap.classList.add("overlap");
  document.getElementById("container").append(overlap);

  var form = document.createElement("form");
  form.id = "password_recovery_form";
  form.classList.add("confirmation_box");

  var title_container = document.createElement("div");
  title_container.classList.add("confirmation_box_title");
  title_container.innerHTML = "Recover Password";
  form.append(title_container);

  var profile_code_field = document.createElement("input");
  profile_code_field.type = "text";
  profile_code_field.autocomplete = "off";
  profile_code_field.placeholder = "Profile Code";
  profile_code_field.title = "Enter Profile Code";
  form.append(profile_code_field);

  var buttons_container = document.createElement("div");
  buttons_container.classList.add("confirmation_box_buttons");

  var confirm_button_container = document.createElement("div");
  confirm_button_container.classList.add(
    "confirmation_box_confirm_button_container"
  );

  var submit_icon = document.createElement("input");
  submit_icon.type = "submit";
  submit_icon.classList.add("button");
  submit_icon.value = "Continue";
  submit_icon.title = "Contine";
  confirm_button_container.append(submit_icon);

  buttons_container.append(confirm_button_container);

  var cancel_button_container = document.createElement("div");
  cancel_button_container.classList.add(
    "confirmation_box_cancel_button_container"
  );

  var cancel_button = document.createElement("span");
  cancel_button.classList.add("button_light");
  cancel_button.innerHTML = "Cancel";
  cancel_button_container.append(cancel_button);

  buttons_container.append(cancel_button_container);

  form.append(buttons_container);

  overlap.append(form);

  window.getComputedStyle(overlap).opacity;
  overlap.style.opacity = 1;

  profile_code_field.focus();

  form.onsubmit = function (submission) {
    submission.preventDefault();

    var profile_code = profile_code_field.value;

    if (profile_code === "") {
      Show_Alert("Enter your Profile Code!");

      return false;
    } else if (!Number.isInteger(Number(profile_code))) {
      Show_Alert("Profile Code must be an integer!");

      return false;
    } else {
      waiting(true);

      var data = new FormData();
      data.append("type", "PassWord_Recovery_1");
      data.append("profile_code", profile_code);

      fetch("/", {
        method: "POST",
        body: data,
      })
        .then(function (response) {
          return response.text();
        })
        .then(function (json) {
          var json_1 = JSON.parse(json);

          document.getElementById("password_recovery_form").remove();

          waiting(false);

          if (json_1.valid_profile_code) {
            var form = document.createElement("form");
            form.id = "password_recovery_form";
            form.classList.add("confirmation_box");

            var title_container = document.createElement("div");
            title_container.classList.add("confirmation_box_title");
            title_container.innerHTML = "Recover Password";
            form.append(title_container);

            var message_container = document.createElement("div");
            message_container.classList.add("confirmation_box_message");
            message_container.innerHTML =
              "Check the inbox of your<br/>recovery email address<br/>for the authentication code.";
            form.append(message_container);

            var authentication_code_field = document.createElement("input");
            authentication_code_field.type = "password";
            authentication_code_field.autocomplete = "off";
            authentication_code_field.placeholder = "Authentication Code";
            authentication_code_field.title = "Enter Authentication Code";
            form.append(authentication_code_field);

            var brake = document.createElement("br");
            form.append(brake);

            var new_password_field = document.createElement("input");
            new_password_field.type = "password";
            new_password_field.autocomplete = "off";
            new_password_field.placeholder = "New Password";
            new_password_field.title = "Enter New Password";
            form.append(new_password_field);

            var brake = document.createElement("br");
            form.append(brake);

            var retyped_password_field = document.createElement("input");
            retyped_password_field.type = "password";
            retyped_password_field.autocomplete = "off";
            retyped_password_field.placeholder = "Re-enter New Password";
            retyped_password_field.title = "Re-enter New Password";
            form.append(retyped_password_field);

            var buttons_container = document.createElement("div");
            buttons_container.classList.add("confirmation_box_buttons");

            var confirm_button_container = document.createElement("div");
            confirm_button_container.classList.add(
              "confirmation_box_confirm_button_container"
            );

            var submit_icon = document.createElement("input");
            submit_icon.type = "submit";
            submit_icon.classList.add("button");
            submit_icon.value = "Continue";
            submit_icon.title = "Contine";
            confirm_button_container.append(submit_icon);

            buttons_container.append(confirm_button_container);

            var cancel_button_container = document.createElement("div");
            cancel_button_container.classList.add(
              "confirmation_box_cancel_button_container"
            );

            var cancel_button = document.createElement("span");
            cancel_button.classList.add("button_light");
            cancel_button.innerHTML = "Cancel";
            cancel_button_container.append(cancel_button);

            buttons_container.append(cancel_button_container);

            form.append(buttons_container);

            overlap.append(form);

            window.getComputedStyle(overlap).opacity;
            overlap.style.opacity = 1;

            authentication_code_field.focus();

            form.onsubmit = function (submission) {
              submission.preventDefault();

              var authentication_code = authentication_code_field.value;
              var new_password = new_password_field.value;
              var retyped_password = retyped_password_field.value;

              if (
                authentication_code === "" ||
                new_password === "" ||
                retyped_password === ""
              ) {
                Show_Alert("Provide all the above informations!");

                return false;
              } else if (!Number.isInteger(Number(profile_code))) {
                Show_Alert("Authentication Code must be an integer!");

                return false;
              } else if (new_password !== retyped_password) {
                Show_Alert(
                  "New password and re-entered new password does not match!"
                );

                return false;
              } else if (new_password.length < 11) {
                Show_Alert("New password does not meet minimum length!");

                return false;
              } else if (authentication_code.length < 8) {
                Show_Alert("Authentication Code does not meet minimum length!");

                return false;
              } else {
                waiting(true);

                var data = new FormData();
                data.append("type", "PassWord_Recovery_2");
                data.append("profile_code", profile_code);
                data.append("verification_code", json_1.verification_code);
                data.append("authentication_code", authentication_code);
                data.append("new_password", new_password);
                data.append("retyped_password", retyped_password);

                fetch("/", {
                  method: "POST",
                  body: data,
                })
                  .then(function (response) {
                    return response.text();
                  })
                  .then(function (json) {
                    var json_2 = JSON.parse(json);

                    document.getElementById("password_recovery_form").remove();

                    if (json_2.password_recovered) {
                      Show_Alert("Password Recovered");

                      window.location.reload();
                    } else {
                      overlap.style.opacity = 0;

                      setTimeout(function () {
                        overlap.remove();
                      }, 500);

                      Show_Alert(json_2.error);

                      waiting(false);
                    }
                  });
              }
            };

            cancel_button.onclick = function () {
              overlap.style.opacity = 0;

              setTimeout(function () {
                overlap.remove();
              }, 500);
            };
          } else if (!json_1.valid_profile_code) {
            overlap.style.opacity = 0;

            setTimeout(function () {
              overlap.remove();
            }, 500);

            Show_Alert("Profile Code is invalid!");
          }
        });
    }
  };

  cancel_button.onclick = function () {
    overlap.style.opacity = 0;

    setTimeout(function () {
      overlap.remove();
    }, 500);
  };
}
