/* By Abdullah As-Sadeed */

function Initiate_TimeZone_Edit() {
  waiting(true);

  var overlap = document.createElement("div");
  overlap.classList.add("overlap");
  document.getElementById("container").append(overlap);

  var form = document.createElement("form");
  form.classList.add("confirmation_box");

  var title_container = document.createElement("div");
  title_container.classList.add("confirmation_box_title");
  title_container.innerHTML = "Edit Timezone";
  form.append(title_container);

  var timezone_field = document.createElement("input");
  timezone_field.type = "text";
  timezone_field.autocomplete = "off";
  timezone_field.placeholder = "Timezone";
  timezone_field.title = "Enter Timezone";
  form.append(timezone_field);

  var buttons_container = document.createElement("div");
  buttons_container.classList.add("confirmation_box_buttons");

  var confirm_button_container = document.createElement("div");
  confirm_button_container.classList.add(
    "confirmation_box_confirm_button_container"
  );

  var submit_icon = document.createElement("input");
  submit_icon.type = "submit";
  submit_icon.classList.add("button");
  submit_icon.value = "Edit";
  submit_icon.title = "Edit";
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

  var data = new FormData();
  data.append("type", "Profile_Card");
  data.append("profile_code", my_profile_code);

  fetch("/", {
    method: "POST",
    body: data,
  })
    .then(function (response) {
      return response.text();
    })
    .then(function (json) {
      var json = JSON.parse(json);

      timezone_field.value = json.timezone;

      waiting(false);
    });

  timezone_field.focus();

  form.onsubmit = function (submission) {
    submission.preventDefault();

    if (timezone_field.value === "") {
      Show_Alert("Select timezone!");
    } else {
      var data = new FormData();
      data.append("type", "Edit_Profile");
      data.append("timezone", timezone_field.value);

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

          if (json.edited) {
            document.getElementById("profile_timezone").innerHTML =
              timezone_field.value;

            Show_Alert("Timezone has been edited");
          } else {
            Show_Alert("Edit has been failed!");
          }

          overlap.style.opacity = 0;

          setTimeout(function () {
            overlap.remove();
          }, 500);
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
