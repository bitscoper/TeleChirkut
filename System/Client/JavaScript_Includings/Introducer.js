/* By Abdullah As-Sadeed */

function Introduce() {
  return new Promise((resolve, reject) => {
    if (typeof my_profile_code !== "undefined") {
      if (my_profile_code !== "" && Number.isInteger(Number(my_profile_code))) {
        var total_steps = 5;
        var current_step = 1;

        Get_Confirmation(
          "Welcome",
          "Thanks for starting a new journey.<br/>Your Profile Code is <b>" +
            my_profile_code +
            "</b>",
          "Continue",
          ""
        ).then(function (continuation) {
          if (continuation) {
            Get_Confirmation(
              "Getting Started (" + current_step + "/" + total_steps + ")",
              "You will see the posts of people you follow.<br/>Posts appear on the FeedLine.",
              "Got it",
              "Remind Later"
            ).then(function (continuation) {
              if (continuation) {
                current_step++;

                Get_Confirmation(
                  "Getting Started (" + current_step + "/" + total_steps + ")",
                  "People who follow each other can message each other.",
                  "Got it",
                  "Remind Later"
                ).then(function (continuation) {
                  if (continuation) {
                    current_step++;

                    Get_Confirmation(
                      "Getting Started (" +
                        current_step +
                        "/" +
                        total_steps +
                        ")",
                      "People who follow each other can message each other.",
                      "Got it",
                      "Remind Later"
                    ).then(function (continuation) {
                      if (continuation) {
                        resolve(true);
                      }
                    });
                  }
                });
              }
            });
          }
        });

        return;
      } else {
        reject("Bad Arguments");
      }
    } else {
      reject("Bad Arguments");
    }
  });
}
