/* By Abdullah As-Sadeed */

function Generate_Home_Page() {
  document.body.style.backgroundColor = "var(--back-dark)";

  var form = document.createElement("form");
  form.id = "log_in_form";

  var h1 = document.createElement("h1");
  h1.innerHTML = "TeleChirkut";
  form.append(h1);

  var fields = document.createElement("span");
  fields.id = "fields";

  var profile_code_container = document.createElement("span");
  profile_code_container.classList.add("field");

  var profile_code_field = document.createElement("input");
  profile_code_field.type = "text";
  profile_code_field.autocomplete = "off";
  profile_code_field.placeholder = "Profile Code";
  profile_code_field.title = "Wnter Profile Code";
  profile_code_container.append(profile_code_field);

  fields.append(profile_code_container);

  var password_container = document.createElement("span");
  password_container.classList.add("field");

  var password_field = document.createElement("input");
  password_field.type = "password";
  password_field.autocomplete = "off";
  password_field.placeholder = "Password";
  password_field.title = "Enter Password";
  password_container.append(password_field);

  fields.append(password_container);

  var password_recovery = document.createElement("span");
  password_recovery.id = "password_recovery";
  password_recovery.innerHTML = "Forgot Password?";
  fields.append(password_recovery);

  form.append(fields);

  var actions = document.createElement("span");
  actions.id = "actions";

  var registration_link = document.createElement("span");
  registration_link.innerHTML = "Registration";
  registration_link.title = "Register on TeleChirkut";
  actions.append(registration_link);

  var submit_button = document.createElement("input");
  submit_button.type = "submit";
  submit_button.value = "Log In";
  submit_button.title = "Log In";
  actions.append(submit_button);

  form.append(actions);

  document.getElementById("container").append(form);

  password_recovery.onclick = Initiate_PassWord_Recovery;

  registration_link.onclick = function () {
    waiting(true);

    window.location.assign("/registration");
  };

  form.onsubmit = function (submission) {
    submission.preventDefault();

    var profile_code = profile_code_field.value;
    var password = password_field.value;

    if (profile_code === "" && password === "") {
      Show_Alert("Enter your Profile Code and password!");
      return false;
    } else if (profile_code === "") {
      Show_Alert("Enter your Profile Code!");
      return false;
    } else if (password === "") {
      Show_Alert("Enter your password!");
      return false;
    } else if (profile_code == password) {
      Show_Alert("Profile Code and password can not be the same!");
      return false;
    } else if (password.length < 11) {
      Show_Alert("Password does not meet minimum length!");
      return false;
    } else if (!Number.isInteger(Number(profile_code))) {
      Show_Alert("Profile Code must be an integer!");
      return false;
    } else {
      form.blur();
      form.style.display = "none";

      Get_Confirmation(
        "Remembrance",
        'Do you agree to the <a target="new" title="Read the TeleChirkut Rules" href="rules">TeleChirkut Rules</a>?',
        "Agree",
        "No"
      ).then(function (confirmation) {
        if (confirmation) {
          waiting(true);
          var data = new FormData();
          data.append("profile_code", profile_code);
          data.append("password", password);

          fetch("/", {
            method: "POST",
            body: data,
          })
            .then(function (response) {
              return response.text();
            })
            .then(function (json) {
              var json = JSON.parse(json);

              if (json.logged_in) {
                window.location.reload();
              } else {
                waiting(false);

                form.style.display = "block";
                password_field.focus();

                Show_Alert(json.error);
              }
            });
        } else {
          form.style.display = "block";
          submit_button.focus();

          Show_Alert("You must agree to the TeleChirkut Rules");
        }
      });
    }
  };

  profile_code_field.focus();
}
