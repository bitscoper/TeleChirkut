/* By Abdullah As-Sadeed */

function Show_Alert(message) {
  if (typeof message !== "undefined") {
    if (message !== "") {
      var alert_box = document.createElement("div");

      alert_box.classList.add("alert_box");
      alert_box.innerHTML = message;

      document.getElementById("container").append(alert_box);

      setTimeout(function () {
        alert_box.style.opacity = 0;

        setTimeout(function () {
          alert_box.remove();
        }, 500);
      }, 3000);

      window.getComputedStyle(alert_box).opacity;
      alert_box.style.opacity = 1;
    } else {
      return false;
    }
  } else {
    return false;
  }
}
