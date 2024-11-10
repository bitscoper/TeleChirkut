/* By Abdullah As-Sadeed */

function waiting(condition) {
  Array.prototype.forEach.call(
    document.querySelectorAll(".waiting_container"),
    function (waiting_container) {
      waiting_container.remove();
    }
  );

  if (condition) {
    var waiting_container = document.createElement("div");
    waiting_container.classList.add("waiting_container");

    var waiting_indicator = document.createElement("div");
    waiting_indicator.classList.add("waiting");
    waiting_container.append(waiting_indicator);

    document.getElementById("container").append(waiting_container);
  }
}
