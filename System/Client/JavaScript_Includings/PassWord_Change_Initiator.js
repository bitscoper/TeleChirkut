/* By Abdullah As-Sadeed */

var change_password_form = document.getElementById("change_password_form");
if (
  typeof change_password_form !== "undefined" &&
  change_password_form !== null
) {
  var password_change_submit = document.getElementById(
    "password_change_submit"
  );
  change_password_form.onsubmit = function (submission) {
    submission.preventDefault();

    var current_value = change_password_form.current_password.value;
    var new_value = change_password_form.new_password.value;
    var retyped_value = change_password_form.retyped_password.value;

    if (current_value !== "" && new_value !== "" && retyped_value !== "") {
      if (current_value !== new_value) {
        if (new_value == retyped_value) {
          if (new_value.length >= 11) {
            Get_Confirmation(
              "Confirmation",
              "Other sessions will be ended<br/>after changing password.",
              "Change",
              "Cancel"
            ).then(function (confirmation) {
              if (confirmation) {
                waiting(true);

                change_password_form.reset();

                password_change_submit.disabled = true;
                password_change_submit.value = "Changing ...";
                password_change_submit.title = "Changing Password";

                var data = new FormData();
                data.append("type", "PassWord_Change");
                data.append("current_password", current_value);
                data.append("new_password", new_value);
                data.append("retyped_password", retyped_value);

                fetch("/", {
                  method: "POST",
                  body: data,
                })
                  .then(function (response) {
                    return response.text();
                  })
                  .then(function (json) {
                    var json = JSON.parse(json);

                    waiting(false);

                    password_change_submit.value = "Change Password";
                    password_change_submit.title = "Change Password";
                    password_change_submit.disabled = false;

                    if (json.password_changed) {
                      Show_Alert("Password has been changed");
                    } else {
                      Show_Alert(json.error);
                    }
                  });
              } else {
                Show_Alert("Password has not been changed");
              }
            });
          } else {
            Show_Alert("New password does not meet minimum length!");
          }
        } else {
          Show_Alert(
            "New password and re-entered new password does not match!"
          );
        }
      } else {
        Show_Alert(
          "New password can not be as same as entered current password!"
        );
      }
    } else {
      Show_Alert("Provide all the above informations!");
    }
  };
}
