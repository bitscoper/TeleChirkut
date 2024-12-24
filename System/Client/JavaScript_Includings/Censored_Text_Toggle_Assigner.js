/* By Abdullah As-Sadeed */

function Assign_Censored_Text_Toggle() {
  Array.prototype.forEach.call(
    document.querySelectorAll(".censored_text"),
    function (censored_text) {
      censored_text.dataset.status = "censored";
      censored_text.title = "Toggle Censored Text";

      censored_text.onclick = function () {
        var original = censored_text.dataset.original;

        if (censored_text.dataset.status == "censored") {
          censored_text.innerHTML = original;
          censored_text.dataset.status = "visible";
        } else if (censored_text.dataset.status == "visible") {
          if (censored_text.dataset.type == "emoji") {
            censored_text.innerHTML = "*****";
          } else if (censored_text.dataset.type == "string") {
            censored_text.innerHTML = "*".repeat(original.length);
          }

          censored_text.dataset.status = "censored";
        }
      };
    }
  );
}
