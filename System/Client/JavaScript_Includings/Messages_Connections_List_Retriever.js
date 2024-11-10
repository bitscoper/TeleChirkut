/* By Abdullah As-Sadeed */

function Retrieve_Messages_Connections_List(callback) {
  var messages_connections = document.getElementById("messages_connections");

  var data = new FormData();
  data.append("type", "List_Messages_Connections");

  fetch("/", {
    method: "POST",
    body: data,
  })
    .then(function (response) {
      return response.text();
    })
    .then(function (json) {
      var connections = JSON.parse(json).connections;

      if (connections.length > 0) {
        connections.forEach(function (connection_data) {
          var profile_code = connection_data.profile_code;
          var full_name = connection_data.full_name;
          var unseen_count = connection_data.unseen_count;

          var connection = document.createElement("span");
          connection.classList.add("messages_connection");
          connection.title = full_name;
          connection.dataset.profile_code = profile_code;

          var connection_face = document.createElement("img");
          connection_face.classList.add("messages_connection_face");
          connection_face.loading = "lazy";
          connection_face.src = "/?face_logo=" + profile_code;
          connection_face.alt = "";
          connection.append(connection_face);

          var connection_full_name = document.createElement("span");
          connection_full_name.classList.add("messages_full_name");
          connection_full_name.innerHTML = full_name;
          connection.append(connection_full_name);

          if (unseen_count > 0) {
            var connection_unseen_count = document.createElement("span");
            connection_unseen_count.classList.add(
              "messages_connection_unseen_count"
            );
            connection_unseen_count.innerHTML = unseen_count;
            connection.append(connection_unseen_count);
          }

          messages_connections.append(connection);

          connection.onclick = function () {
            history.pushState(null, null, "#messages=" + profile_code);
            Assign_Messages_To_Profile_Code(profile_code);
          };
        });

        callback();
      }
    });
}
