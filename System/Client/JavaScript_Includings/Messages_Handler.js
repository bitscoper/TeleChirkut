/* By Abdullah As-Sadeed */

var messages_updates_container = document.getElementById("messages");

var messages_to_profile_code;

function Retrieve_Messages() {
  if (messages_to_profile_code !== "") {
    var data = new FormData();
    data.append("type", "Retrieve_Messages");
    data.append("to_profile_code", messages_to_profile_code);

    fetch("/", {
      method: "POST",
      body: data,
    })
      .then(function (response) {
        return response.text();
      })
      .then(function (updates) {
        Array.prototype.forEach.call(
          document.querySelectorAll(".messages_connection"),
          function (messages_connection) {
            messages_connection.classList.remove("messages_active_connection");
          }
        );

        document
          .querySelector(
            '.messages_connection[data-profile_code="' +
              messages_to_profile_code +
              '"]'
          )
          .classList.add("messages_active_connection");

        document.querySelector("#sub_header h4").innerHTML =
          "Messages - " +
          document.querySelector(
            '.messages_connection[data-profile_code="' +
              messages_to_profile_code +
              '"] .messages_full_name'
          ).innerHTML;

        messages_updates_container.innerHTML = Make_Clickable_Link(updates);
        Assign_Censored_Text_Toggle();

        if (updates == "No messages") {
          messages_updates_container.classList.add("empty_flex");
        } else if (updates !== "No messages") {
          messages_updates_container.classList.remove("empty_flex");
        }

        waiting(false);
      });
  }
}

function Assign_Messages_To_Profile_Code(assigned_profile_code) {
  waiting(true);

  messages_to_profile_code = assigned_profile_code;

  document
    .querySelector(
      '.messages_connection[data-profile_code="' +
        messages_to_profile_code +
        '"]'
    )
    .classList.add("messages_active_connection");

  Renew_Messages_Retrieval();
}

function Renew_Messages_Retrieval() {
  clearInterval(messages_update_timer);
  Retrieve_Messages();
  messages_update_timer = setInterval(Retrieve_Messages, 2000);
}

function After_Send(response) {
  Show_Alert(response);

  text_message.placeholder = "Write your message ...";
  send_button.disabled = false;

  Renew_Messages_Retrieval();
}

if (
  typeof messages_updates_container !== "undefined" &&
  messages_updates_container !== null
) {
  var messages_connections_container = document.getElementById(
    "messages_connections"
  );
  var text_message_form = document.getElementById("text_message_form");
  var send_button = document.querySelector(
    '#text_message_form input[type="image"]'
  );
  var text_message = text_message_form.text_message;
  var messages_update_timer;

  text_message_form.onsubmit = function (submission) {
    submission.preventDefault();

    if (text_message.value === "") {
      Show_Alert("Write your message!");
    } else {
      send_button.disabled = true;

      var data = new FormData();
      data.append("type", "Text_Message");
      data.append("to_profile_code", messages_to_profile_code);
      data.append("text_message", text_message.value);

      fetch("/", {
        method: "POST",
        body: data,
      })
        .then(function (response) {
          return response.text();
        })
        .then(function (response) {
          text_message_form.reset();
          After_Send(response);
        });
    }
  };

  document.getElementById("image_message_selector").onchange = function () {
    Get_Confirmation(
      "Confirmation",
      "Are you sure to send the image?",
      "Send",
      "No"
    ).then(function (confirmation) {
      if (confirmation) {
        send_button.disabled = true;
        text_message.placeholder = "Sending image ...";

        var data = new FormData();
        data.append("type", "Image_Message");
        data.append("to_profile_code", messages_to_profile_code);
        data.append(
          "image",
          document.getElementById("image_message_form").image.files[0]
        );

        fetch("/", {
          method: "POST",
          body: data,
        })
          .then(function (response) {
            return response.text();
          })
          .then(function (response) {
            After_Send(response);
            Show_Alert("Sent");
          });
      } else {
        Show_Alert("Not Sent");
      }
    });
  };
}
