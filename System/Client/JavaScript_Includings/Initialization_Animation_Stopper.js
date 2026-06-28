/* By Abdullah As-Sadeed */

function Stop_Initialization_Animation() {
  var initialization_container = document.getElementById(
    "initialization_container"
  );

  if (
    typeof initialization_container !== "undefined" &&
    initialization_container !== null
  ) {
    initialization_container.style.opacity = 0;

    setTimeout(function () {
      initialization_container.style.display = "none";
    }, 500);
  }
}
