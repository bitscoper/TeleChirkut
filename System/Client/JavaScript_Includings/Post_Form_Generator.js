/* By Abdullah As-Sadeed */

function Generate_Post_Form() {
  var post_form_text;

  async function Write_Post_Form_Text_PlaceHolder() {
    var placeholder_text = "Write what you feel exiciting to share ...";
    var placeholder_position = 0;
    var placeholder_length = placeholder_text.length;

    while (placeholder_position <= placeholder_length) {
      post_form_text.placeholder +=
        placeholder_text.charAt(placeholder_position);

      await Sleep(32);

      placeholder_position++;
    }
  }

  var post_form_image_added = false;

  var feedline_page = document.getElementById("feedline_page");

  var post_creation_button = document.createElement("span");
  post_creation_button.classList.add("post_creation_button");
  post_creation_button.innerHTML = "+";
  post_creation_button.title = "Fly A Post";
  feedline_page.append(post_creation_button);

  post_creation_button.onclick = function () {
    post_creation_button.style.display = "none";

    var overlap = document.createElement("div");
    overlap.classList.add("overlap");

    var post_form = document.createElement("form");
    post_form.classList.add("post_form");

    post_form_text = document.createElement("textarea");
    post_form_text.placeholder = "";
    post_form_text.title = "Write Post";
    post_form_text.autocomplete = "off";
    post_form.append(post_form_text);

    var post_form_image_input = document.createElement("input");
    post_form_image_input.type = "file";
    post_form_image_input.accept = "image/*";
    post_form.append(post_form_image_input);

    var post_form_image_input_label = document.createElement("label");
    post_form_image_input_label.title = "Upload A Snap";
    post_form_image_input_label.classList.add("post_image_selector");

    var post_form_image_input_previewer = document.createElement("img");
    post_form_image_input_previewer.src = "";
    post_form_image_input_previewer.alt = "Add a snap";
    post_form_image_input_label.append(post_form_image_input_previewer);

    post_form.append(post_form_image_input_label);

    post_form_image_input_label.onclick = function () {
      post_form_image_input.click();
    };

    post_form_image_input.onchange = function () {
      Preview_Image(this, post_form_image_input_previewer);

      post_form_image_added = true;
    };

    var post_form_footer = document.createElement("div");
    post_form_footer.classList.add("post_form_footer");

    var post_form_fly_button = document.createElement("span");
    post_form_fly_button.title = "Fly The Post";
    post_form_fly_button.innerHTML = "Fly";
    post_form_fly_button.classList.add("button");
    post_form_footer.append(post_form_fly_button);

    var post_form_closer = document.createElement("span");
    post_form_closer.classList.add("button_light");
    post_form_closer.title = "Close";
    post_form_closer.innerHTML = "Close";
    post_form_footer.append(post_form_closer);

    post_form_closer.onclick = function () {
      overlap.style.opacity = 0;

      setTimeout(function () {
        overlap.remove();
      }, 500);

      post_creation_button.style.display = "flex";
    };

    post_form.append(post_form_footer);

    overlap.append(post_form);

    feedline_page.append(overlap);

    window.getComputedStyle(overlap).opacity;
    overlap.style.opacity = 1;

    setTimeout(Write_Post_Form_Text_PlaceHolder, 200);

    post_form_text.focus();

    post_form.onsubmit = function (submission) {
      submission.preventDefault();

      post_form_fly_button.click();
    };

    post_form_fly_button.onclick = function () {
      if (post_form_text.value !== "" || post_form_image_added) {
        waiting(true);

        post_form_closer.style.display = "none";

        post_form_fly_button.disabled = true;
        post_form_fly_button.innerHTML = "Flying The Post ...";
        post_form_fly_button.title = "Flying The Post ...";

        var data = new FormData();
        data.append("type", "Post");
        data.append("text", post_form_text.value);
        data.append("image", post_form_image_input.files[0]);

        fetch("/", {
          method: "POST",
          body: data,
        })
          .then(function (response) {
            return response.text();
          })
          .then(function (json) {
            var json = JSON.parse(json);

            if (!json.success) {
              Show_Alert(json.error);

              post_form.reset();

              post_form_fly_button.value = "Fly";
              post_form_fly_button.title = "Fly The Post";
              post_form_fly_button.disabled = false;

              post_form_closer.style.display = "inline-block";

              waiting(false);
            } else if (json.success) {
              overlap.style.opacity = 0;

              setTimeout(function () {
                overlap.remove();
              }, 500);

              post_creation_button.style.display = "flex";

              var feedline = document.getElementById("feedline");

              var brake = document.createElement("br");
              feedline.prepend(brake);

              var post = document.createElement("span");
              post.dataset.serial = json.serial;
              post.dataset.loading = "not_requested";
              post.classList.add("post");
              feedline.prepend(post);

              Try_Loading_Posts();

              waiting(false);

              Show_Alert("Posted");
            }
          });
      } else {
        Show_Alert("Add a snap or write a post");
      }
    };
  };
}
