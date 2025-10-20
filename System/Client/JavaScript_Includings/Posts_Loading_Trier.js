/* By Abdullah As-Sadeed */

function Try_Loading_Posts() {
  Array.prototype.forEach.call(
    document.querySelectorAll(".post"),
    function (post) {
      Try_Loading_Post(post);
    }
  );
}
