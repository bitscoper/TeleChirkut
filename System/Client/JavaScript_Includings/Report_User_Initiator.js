/* By Abdullah As-Sadeed */

function Initiate_Report_User(profile_code) {
  Get_Confirmation(
    "Report User",
    "Are you sure to report the user?<br/><br/><small>If their content violets <b>TeleChirkut Rules</b>,<br/>we will ban the user along with the contents.<br/>This process takes time because<br/>we have limited number of moderators.</small>",
    "Report",
    "No"
  ).then(function (confirmation) {
    if (confirmation) {
      var data = new FormData();
      data.append("type", "Report_User");
      data.append("profile_code", profile_code);

      fetch("/", {
        method: "POST",
        body: data,
      })
        .then(function (response) {
          return response.text();
        })
        .then(function (json) {
          var json = JSON.parse(json);

          Show_Alert(json.status);
        });
    } else {
      Show_Alert("Not Reported");
    }
  });
}
