/* By Abdullah As-Sadeed */

var registration_form = document.getElementById("registration_form");
var my_profile_code;

if (typeof registration_form !== "undefined" && registration_form !== null) {
  registration_form.timezone.value = "";

  var face_logo_heading = document.getElementById("face_logo_heading");
  var face_logo_editor_element = document.getElementById("face_logo_editor");

  var rotate_negative = document.getElementById("rotate_negative");
  var rotate_positive = document.getElementById("rotate_positive");

  var face_logo_selected = false;

  var face_logo_editor = new Croppie(face_logo_editor_element, {
    viewport: {
      width: 128,
      height: 128,
      type: "circle",
    },
    boundary: {
      width: 256,
      height: 256,
    },
    showZoomer: true,
    enableOrientation: true,
    enableResize: false,
    enableZoom: true,
    mouseWheelZoom: true,
  });

  registration_form.face_logo.onchange = function () {
    var file_reader = new FileReader();
    file_reader.onload = function (selection) {
      face_logo_editor.bind({
        url: selection.target.result,
      });
    };
    file_reader.readAsDataURL(this.files[0]);
    face_logo_selected = true;
  };

  rotate_negative.onclick = function () {
    face_logo_editor.rotate(-90);
  };

  rotate_positive.onclick = function () {
    face_logo_editor.rotate(90);
  };

  registration_form.onsubmit = function (submission) {
    submission.preventDefault();

    var password = registration_form.password.value;
    var retyped_password = registration_form.retyped_password.value;

    if (
      password === "" ||
      retyped_password === "" ||
      registration_form.full_name.value === "" ||
      registration_form.timezone.value === "" ||
      registration_form.introduction.value === "" ||
      registration_form.recovery_email_address.value === "" ||
      !face_logo_selected
    ) {
      Show_Alert("Provide all the above informations!");
    } else if (password !== retyped_password) {
      Show_Alert("Password and re-entered password does not match!");
    } else if (password.length < 11) {
      Show_Alert("Password's minimum length is 11!");
    } else {
      Get_Confirmation(
        "Agreement",
        'Do you agree to the <a target="new" title="Read the TeleChirkut Rules" href="rules">TeleChirkut Rules</a>?',
        "Agree",
        "No"
      ).then(function (confirmation) {
        if (confirmation) {
          waiting(true);
          var registration_submit_button = document.querySelector(
            'input[type="submit"]'
          );
          registration_submit_button.disabled = true;
          registration_submit_button.value = "Registering ...";
          face_logo_editor
            .result({
              type: "blob",
              size: "viewport",
              format: "webp",
              quality: 1,
              circle: true,
            })
            .then(function (blob) {
              var data = new FormData();
              data.append("full_name", registration_form.full_name.value);
              data.append("timezone", registration_form.timezone.value);
              data.append("introduction", registration_form.introduction.value);
              data.append("password", password);
              data.append("retyped_password", retyped_password);
              data.append(
                "recovery_email_address",
                registration_form.recovery_email_address.value
              );
              data.append("face_logo", blob);

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

                  if (json.registered) {
                    registration_form.remove();
                    my_profile_code = json.profile_code;

                    Introduce().then(function (continuation) {
                      if (continuation) {
                        waiting(true);

                        window.location.assign("/#explore");
                      }
                    });
                  } else if (!json.registered) {
                    Show_Alert("Something Wrong");
                  }
                });
            });
        } else {
          Show_Alert("You must agree to the TeleChirkut Rules");
        }
      });
    }
  };
}
