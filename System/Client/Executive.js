/* By Abdullah As-Sadeed */

var my_profile_code, service_worker_registration;

Watch_Console();

if (!document.getElementById("container").hasChildNodes()) {
  Generate_Home_Page();
}

var client = document.getElementById("client");

if (typeof client !== "undefined" && client !== null) {
  Retrieve_Profile_Code();

  Handle_Location_Hash();
  window.onhashchange = Handle_Location_Hash;

  Assign_OnClicks_Once();

  Observe_Mutations("image_message", function (image_message) {
    image_message.onclick = function () {
      View_Large_Image(image_message.src);
    };
  });

  Update_Total_Unseen_Counts();

  Initiate_Intervals();
}

Detect_Multiple_Instances();

Stop_Initialization_Animation();
