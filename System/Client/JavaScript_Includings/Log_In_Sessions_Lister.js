/* By Abdullah As-Sadeed */

function List_Log_In_Sessions() {
  var data = new FormData();
  data.append("type", "Log_In_Sessions");

  fetch("/", {
    method: "POST",
    body: data,
  })
    .then(function (response) {
      return response.text();
    })
    .then(function (json) {
      var log_in_sessions = JSON.parse(json).log_in_sessions;

      var table = document.createElement("table");
      table.classList.add("log_in_sessions");

      var table_body = document.createElement("tbody");

      var table_heading_row = document.createElement("tr");

      var table_heading_1 = document.createElement("th");
      table_heading_1.innerHTML = "Platform";
      table_heading_row.append(table_heading_1);

      var table_heading_2 = document.createElement("th");
      table_heading_2.innerHTML = "Agent";
      table_heading_row.append(table_heading_2);

      var table_heading_3 = document.createElement("th");
      table_heading_3.innerHTML = "Last IP Address";
      table_heading_row.append(table_heading_3);

      var table_heading_4 = document.createElement("th");
      table_heading_4.innerHTML = "Last Seen";
      table_heading_row.append(table_heading_4);

      var table_heading_5 = document.createElement("th");
      table_heading_5.innerHTML = "Status";
      table_heading_row.append(table_heading_5);

      table_body.append(table_heading_row);

      log_in_sessions.forEach(function (log_in_session) {
        var table_row = document.createElement("tr");

        var platform = document.createElement("td");
        platform.innerHTML = log_in_session.platform;
        platform.title = "Platform";
        table_row.append(platform);

        var agent = document.createElement("td");
        agent.innerHTML = log_in_session.agent;
        agent.title = "Agent";
        table_row.append(agent);

        var last_ip_address = document.createElement("td");
        last_ip_address.innerHTML = log_in_session.last_ip_address;
        last_ip_address.title = "IP Address";
        table_row.append(last_ip_address);

        var last_seen = document.createElement("td");
        last_seen.innerHTML = log_in_session.last_seen;
        last_seen.title = "Date Time";
        table_row.append(last_seen);

        var status = document.createElement("td");

        if (log_in_session.status == "Current") {
          status.innerHTML = "Current";
        } else if (log_in_session.status) {
          var end_icon = document.createElement("span");
          end_icon.classList.add("button");
          end_icon.innerHTML = "End";
          end_icon.title = "End The Session";
          status.append(end_icon);

          status.title = "Status";

          end_icon.onclick = function () {
            var data = new FormData();
            data.append("type", "End_Another_Session");
            data.append("serial", log_in_session.serial);

            fetch("/", {
              method: "POST",
              body: data,
            })
              .then(function (response) {
                return response.text();
              })
              .then(function (json) {
                var json = JSON.parse(json);

                if (json.ended) {
                  end_icon.remove();
                  status.innerHTML = "Ended";

                  Show_Alert("That session has been ended");
                } else if (!json.ended && json.error == "Already_Ended") {
                  end_icon.remove();
                  status.innerHTML = "Ended";

                  Show_Alert("That session was already ended");
                }
              });
          };
        } else if (!log_in_session.status) {
          status.innerHTML = "Ended";
        }

        table_row.append(status);

        table_body.append(table_row);
      });

      table.append(table_body);

      log_in_sessions_page.append(table);
    });
}
