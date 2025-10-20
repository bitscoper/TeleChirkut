/* By Abdullah As-Sadeed */

function Retrieve_FeedLine() {
  var data = new FormData();
  data.append("type", "List_FeedLine_Posts");

  fetch("/", {
    method: "POST",
    body: data,
  })
    .then(function (response) {
      return response.text();
    })
    .then(function (json) {
      var serials = JSON.parse(json).serials;

      var feedline = document.createElement("div");
      feedline.id = "feedline";
      feedline_page.append(feedline);

      if (serials.length > 0) {
        serials.forEach(function (serial) {
          var post = document.createElement("span");
          post.dataset.serial = serial;
          post.dataset.loading = "not_requested";
          post.classList.add("post");
          feedline.append(post);
        });

        Try_Loading_Posts();
      } else {
        feedline_page.style.display = "flex";

        var empty_feedline = document.createElement("div");
        empty_feedline.classList.add("empty_flex");
        empty_feedline.innerHTML = "Follow users first";
        feedline_page.append(empty_feedline);
      }
    });
}
