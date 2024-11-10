/* By Abdullah As-Sadeed */

function Retrieve_Profile_Code() {
  var data = new FormData();
  data.append("type", "My_Profile_Code");

  fetch("/", {
    method: "POST",
    body: data,
  })
    .then(function (response) {
      return response.text();
    })
    .then(function (received_my_profile_code) {
      my_profile_code = received_my_profile_code;

      Update_Profile_Icon();
    });
}
