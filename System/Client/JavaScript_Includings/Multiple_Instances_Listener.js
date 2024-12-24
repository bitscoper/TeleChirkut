/* By Abdullah As-Sadeed */

function Detect_Multiple_Instances() {
  var channel = new BroadcastChannel("tab");

  channel.postMessage("AnOther_Tab");

  channel.onmessage = function (message) {
    if (message.data === "AnOther_Tab") {
      Get_Confirmation(
        "Multiple Instances",
        "There are multiple instances running.",
        "Got it",
        ""
      );
    }
  };
}
