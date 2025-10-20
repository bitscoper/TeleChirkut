/* By Abdullah As-Sadeed */

function Initiate_Delete_Message(serial) {
  Get_Confirmation(
    "Confirmation",
    "Are you sure to delete this message from both side?",
    "Delete",
    "No"
  ).then(function (confirmation) {
    if (confirmation) {
      var data = new FormData();
      data.append("type", "Message_Deletion");
      data.append("serial", serial);

      fetch("/", {
        method: "POST",
        body: data,
      })
        .then(function (response) {
          return response.text();
        })
        .then(function (json) {
          var json = JSON.parse(json);

          if (json.deleted) {
            Show_Alert("Message has been deleted");
          } else if (!json.deleted) {
            Show_Alert("Message deletion has been failed");
          }

          Renew_Messages_Retrieval();
        });
    } else {
      Show_Alert("Not Deleted");
    }
  });
}
