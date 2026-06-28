/* By Abdullah As-Sadeed */

function List_Reacted_Posts() {
  var data = new FormData();
  data.append("type", "List_Reacted_Posts");

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
      document.getElementById("reactions_page").append(feedline);

      if (serials.length > 0) {
        serials.forEach(function (serial) {
          var post = document.createElement("span");
          post.dataset.serial = serial;
          post.dataset.loading = "not_requested";
          post.classList.add("post");
          feedline.append(post);

          var brake = document.createElement("br");
          feedline.append(brake);
        });

        Try_Loading_Posts();
      } else {
        var empty_reacted_posts = document.createElement("div");
        empty_reacted_posts.id = "empty_reacted_posts";
        empty_reacted_posts.innerHTML = "You have not reacted on any post yet.";
        feedline.append(empty_reacted_posts);
      }
    });
}
