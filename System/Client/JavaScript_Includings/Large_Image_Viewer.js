/* By Abdullah As-Sadeed */

function View_Large_Image(source) {
  var overlap = document.createElement("div");
  overlap.classList.add("overlap");
  overlap.style.flexDirection = "column";

  var closer_container = document.createElement("div");
  closer_container.classList.add("closer_container");

  var overlap_closer = document.createElement("span");
  overlap_closer.classList.add("overlap_closer");
  overlap_closer.innerHTML = "&times;";
  overlap_closer.title = "Close";
  closer_container.append(overlap_closer);

  overlap_closer.onclick = function () {
    overlap.style.opacity = 0;

    setTimeout(function () {
      overlap.remove();
    }, 500);
  };

  overlap.append(closer_container);

  var large_image = document.createElement("img");
  large_image.loading = "lazy";
  large_image.src = source;
  large_image.alt = "";
  overlap.append(large_image);

  document.getElementById("container").append(overlap);

  window.getComputedStyle(overlap).opacity;
  overlap.style.opacity = 1;
}
