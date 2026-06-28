/* By Abdullah As-Sadeed */

function Try_Loading_Post(post) {
  if (post.dataset.loading == "not_requested") {
    if (Is_Partially_Inside_Viewport(post)) {
      var xhr_feedline = new XMLHttpRequest();

      post.dataset.loading = "loading";

      var serial = post.dataset.serial;

      xhr_feedline.open("POST", "/");

      var data = new FormData();
      data.append("type", "Retrieve_Post");
      data.append("serial", serial);

      xhr_feedline.send(data);

      xhr_feedline.onload = function () {
        var json = JSON.parse(xhr_feedline.response);

        var post_profile_link_more_container = document.createElement("span");
        post_profile_link_more_container.classList.add(
          "post_profile_link_more_container"
        );

        var post_profile_link = document.createElement("span");
        post_profile_link.classList.add("post_profile_link");

        var post_face_logo = document.createElement("img");
        post_face_logo.classList.add("post_face_logo");
        post_face_logo.loading = "lazy";
        post_face_logo.src = "/?face_logo=" + json.profile_code;
        post_face_logo.alt = "";
        post_profile_link.append(post_face_logo);

        var post_full_name_profile_code_verification_container =
          document.createElement("span");
        post_full_name_profile_code_verification_container.classList.add(
          "post_full_name_profile_code_verification_container"
        );

        var post_full_name = document.createElement("span");
        post_full_name.classList.add("post_full_name");
        post_full_name.innerHTML = json.full_name;
        post_full_name_profile_code_verification_container.append(
          post_full_name
        );

        var brake = document.createElement("br");
        post_full_name_profile_code_verification_container.append(brake);

        var post_profile_code_verification = document.createElement("span");
        post_profile_code_verification.classList.add(
          "post_profile_code_verification"
        );
        post_profile_code_verification.innerHTML = json.profile_code;

        if (json.is_profile_verified) {
          post_profile_code_verification.innerHTML += " | Verified";
        }

        post_full_name_profile_code_verification_container.append(
          post_profile_code_verification
        );

        post_profile_link.append(
          post_full_name_profile_code_verification_container
        );

        post_profile_link_more_container.append(post_profile_link);

        post_profile_link.onclick = function () {
          window.location.assign("/#profile=" + json.profile_code);
        };

        if (json.owner == "Me" || json.owner == "Other") {
          var post_more_container = document.createElement("span");
          post_more_container.classList.add("post_more_container");

          var post_more_icon = document.createElement("img");
          post_more_icon.classList.add("post_more_icon");
          post_more_icon.src = "Client_Includings/More.svg";
          post_more_icon.alt = "";
          post_more_icon.title = "More Options";
          post_more_container.append(post_more_icon);

          post_more_icon.onclick = function () {
            var post_more_menu = document.createElement("span");
            post_more_menu.classList.add("post_more_menu");

            if (json.owner == "Me") {
              var post_delete_icon = document.createElement("span");
              post_delete_icon.classList.add("post_more_menu_item");
              post_delete_icon.innerHTML = "Delete";
              post_more_menu.append(post_delete_icon);

              post_delete_icon.onclick = function () {
                Get_Confirmation(
                  "Confirmation",
                  "Are you sure to delete the post?",
                  "Delete",
                  "No"
                ).then(function (confirmation) {
                  if (confirmation) {
                    waiting(true);

                    var data = new FormData();
                    data.append("type", "Post_Deletion");
                    data.append("serial", serial);

                    fetch("/", {
                      method: "POST",
                      body: data,
                    })
                      .then(function (response) {
                        return response.text();
                      })

                      .then(function (json) {
                        var json = JSON.parse(json);

                        if (json.deleted) {
                          post.style.opacity = 0;

                          setTimeout(function () {
                            post.remove();
                          }, 200);

                          waiting(false);

                          Show_Alert("Post has been deleted");
                        } else if (!json.deleted) {
                          Show_Alert("Something Wrong");
                        }
                      });
                  } else {
                    Show_Alert("Not Deleted");
                  }
                });
              };
            } else if (json.owner == "Other") {
              var menu_report = document.createElement("span");
              menu_report.classList.add("post_more_menu_item");
              menu_report.innerHTML = "Report Post";
              post_more_menu.append(menu_report);

              menu_report.onclick = function () {
                post_more_menu.remove();

                Get_Confirmation(
                  "Report Post",
                  "Are you sure to report the post?<br/><br/><small>If the content violets <b>TeleChirkut Rules</b>,<br/>we will ban the user along with the content.<br/>This process takes time because<br/>we have limited number of moderators.</small>",
                  "Report",
                  "No"
                ).then(function (confirmation) {
                  if (confirmation) {
                    var data = new FormData();
                    data.append("type", "Report_Post");
                    data.append("serial", serial);

                    fetch("/", {
                      method: "POST",
                      body: data,
                    })
                      .then(function (response) {
                        return response.text();
                      })
                      .then(function (json) {
                        var json = JSON.parse(json);

                        Show_Alert(json.status);
                      });
                  } else {
                    Show_Alert("Not Reported");
                  }
                });
              };
            }

            post_more_icon.parentElement.append(post_more_menu);

            window.getComputedStyle(post_more_menu).opacity;
            post_more_menu.style.opacity = 1;
          };

          post_profile_link_more_container.append(post_more_container);
        }

        post.append(post_profile_link_more_container);

        var post_text = document.createElement("span");
        post_text.classList.add("post_text");
        post_text.innerHTML = Make_Clickable_Link(json.text);
        post.append(post_text);

        Assign_Censored_Text_Toggle();

        if (json.image_available) {
          var post_image = document.createElement("img");
          post_image.classList.add("post_image");
          post_image.dataset.loading = "not_loaded";
          post_image.src =
            "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=";
          post_image.alt = "";
          post.append(post_image);

          var loading_post_image = new Image();
          loading_post_image.onload = function () {
            post_image.dataset.loading = "loaded";
            var loading_post_image_src = this.src;
            setTimeout(function () {
              post_image.src = loading_post_image_src;
              post_image.style.opacity = 1;
            }, 200);

            post_image.onclick = function () {
              View_Large_Image(post_image.src);
            };

            post_image.title = "View Large";

            loading_post_image = null;
          };
          loading_post_image.src = "/?post_image=" + serial;
        }

        var post_counts_date_time_container = document.createElement("span");
        post_counts_date_time_container.classList.add(
          "post_counts_date_time_container"
        );

        var post_reactions_count = document.createElement("span");
        post_reactions_count.classList.add("post_reactions_count");
        post_reactions_count.innerHTML = json.reactions_count;
        post_counts_date_time_container.append(post_reactions_count);

        var post_date_time = document.createElement("span");
        post_date_time.classList.add("post_date_time");
        post_date_time.innerHTML = json.date_time;
        post_counts_date_time_container.append(post_date_time);

        post.append(post_counts_date_time_container);

        if (json.owner == "Me" || json.owner == "Other") {
          var post_footer = document.createElement("post_footer");
          post_footer.classList.add("post_footer");

          if (json.owner == "Me") {
            var details_icon_container = document.createElement("span");
            details_icon_container.classList.add("post_footer_items");
            details_icon_container.classList.add(
              "post_details_icon_container"
            );

            var post_details_icon = document.createElement("img");
            post_details_icon.src = "Client_Includings/Details.svg";
            post_details_icon.alt = "";
            post_details_icon.title = "Details";
            details_icon_container.append(post_details_icon);

            var post_details_text = document.createElement("span");
            post_details_text.innerHTML = "Private Details";
            details_icon_container.append(post_details_text);

            details_icon_container.onclick = function () {
              window.location.assign("/#post=" + serial);
            };

            post_footer.append(details_icon_container);
          } else if (json.owner == "Other") {
            var react_icon_container = document.createElement("span");
            react_icon_container.classList.add("post_footer_items");

            var react_icon = document.createElement("img");
            react_icon.classList.add("post_react_icon");

            var reacted = json.reacted;

            if (reacted == "love") {
              react_icon.src = "Client_Includings/Reaction_Love.gif";
              react_icon.title = "Loved";
            } else if (reacted == "support") {
              react_icon.src = "Client_Includings/Reaction_Support.gif";
              react_icon.title = "Supported";
            } else if (reacted == "celebrate") {
              react_icon.src = "Client_Includings/Reaction_Celebrate.gif";
              react_icon.title = "Celebrated";
            } else if (reacted == "amazing") {
              react_icon.src = "Client_Includings/Reaction_Amazing.gif";
              react_icon.title = "Amazed";
            } else if (reacted == "curious") {
              react_icon.src = "Client_Includings/Reaction_Curious.gif";
              react_icon.title = "Felt Curious";
            } else if (reacted == "funny") {
              react_icon.src = "Client_Includings/Reaction_Funny.gif";
              react_icon.title = "Felt Funny";
            } else if (reacted == "sad") {
              react_icon.src = "Client_Includings/Reaction_Sad.gif";
              react_icon.title = "Felt Sad";
            } else if (reacted == "angry") {
              react_icon.src = "Client_Includings/Reaction_Angry.gif";
              react_icon.title = "Showed Anger";
            } else {
              react_icon.src = "Client_Includings/React.svg";
              react_icon.title = "React";
            }

            react_icon.alt = "";

            react_icon_container.append(react_icon);

            react_icon.onclick = function () {
              var post_reactions_container = document.createElement("span");
              post_reactions_container.classList.add(
                "post_reactions_container"
              );

              function React_Post(reaction) {
                react_icon.src = "Client_Includings/Algorithming.svg";
                react_icon.title = "Processing";

                var data = new FormData();
                data.append("type", "Post_Reaction");
                data.append("serial", serial);
                data.append("reaction", reaction);

                fetch("/", {
                  method: "POST",
                  body: data,
                })
                  .then(function (response) {
                    return response.text();
                  })
                  .then(function (json) {
                    var json = JSON.parse(json);

                    var action = json.action;

                    if (action == "love") {
                      react_icon.src = "Client_Includings/Reaction_Love.gif";
                      react_icon.title = "Loved";
                    } else if (action == "support") {
                      react_icon.src = "Client_Includings/Reaction_Support.gif";
                      react_icon.title = "Supported";
                    } else if (action == "celebrate") {
                      react_icon.src =
                        "Client_Includings/Reaction_Celebrate.gif";
                      react_icon.title = "Celebrated";
                    } else if (action == "amazing") {
                      react_icon.src = "Client_Includings/Reaction_Amazing.gif";
                      react_icon.title = "Amazed";
                    } else if (action == "curious") {
                      react_icon.src = "Client_Includings/Reaction_Curious.gif";
                      react_icon.title = "Felt Curious";
                    } else if (action == "funny") {
                      react_icon.src = "Client_Includings/Reaction_Funny.gif";
                      react_icon.title = "Felt Funny";
                    } else if (action == "sad") {
                      react_icon.src = "Client_Includings/Reaction_Sad.gif";
                      react_icon.title = "Felt Sad";
                    } else if (action == "angry") {
                      react_icon.src = "Client_Includings/Reaction_Angry.gif";
                      react_icon.title = "Showed Anger";
                    } else if (action == "REMOVED") {
                      react_icon.src = "Client_Includings/React.svg";
                      react_icon.title = "React";
                      Show_Alert("Reaction has been removed");
                    }

                    var love_count = json.love_count;
                    var support_count = json.support_count;
                    var celebrate_count = json.celebrate_count;
                    var amazing_count = json.amazing_count;
                    var curious_count = json.curious_count;
                    var funny_count = json.funny_count;
                    var sad_count = json.sad_count;
                    var angry_count = json.angry_count;

                    var reactions_count =
                      love_count +
                      support_count +
                      celebrate_count +
                      amazing_count +
                      curious_count +
                      funny_count +
                      sad_count +
                      angry_count;

                    if (reactions_count == 0) {
                      post_reactions_count.innerHTML = "";
                    } else if (reactions_count == 1) {
                      post_reactions_count.innerHTML = "1 reaction";
                    } else if (reactions_count > 1) {
                      post_reactions_count.innerHTML =
                        reactions_count + " reactions";
                    }
                  });
              }

              var love = document.createElement("img");
              love.classList.add("post_reaction");
              love.src = "Client_Includings/Reaction_Love.gif";
              love.title = "Love";
              love.alt = "";
              post_reactions_container.append(love);

              love.onclick = function () {
                React_Post("love");
              };

              var support = document.createElement("img");
              support.classList.add("post_reaction");
              support.src = "Client_Includings/Reaction_Support.gif";
              support.title = "Support";
              support.alt = "";
              post_reactions_container.append(support);

              support.onclick = function () {
                React_Post("support");
              };

              var celebrate = document.createElement("img");
              celebrate.classList.add("post_reaction");
              celebrate.src = "Client_Includings/Reaction_Celebrate.gif";
              celebrate.title = "Celebrate";
              celebrate.alt = "";
              post_reactions_container.append(celebrate);

              celebrate.onclick = function () {
                React_Post("celebrate");
              };

              var amazing = document.createElement("img");
              amazing.classList.add("post_reaction");
              amazing.src = "Client_Includings/Reaction_Amazing.gif";
              amazing.title = "Amazing";
              amazing.alt = "";
              post_reactions_container.append(amazing);

              amazing.onclick = function () {
                React_Post("amazing");
              };

              var curious = document.createElement("img");
              curious.classList.add("post_reaction");
              curious.src = "Client_Includings/Reaction_Curious.gif";
              curious.title = "Curious";
              curious.alt = "";
              post_reactions_container.append(curious);

              curious.onclick = function () {
                React_Post("curious");
              };

              var funny = document.createElement("img");
              funny.classList.add("post_reaction");
              funny.src = "Client_Includings/Reaction_Funny.gif";
              funny.title = "Funny";
              funny.alt = "";
              post_reactions_container.append(funny);

              funny.onclick = function () {
                React_Post("funny");
              };

              var sad = document.createElement("img");
              sad.classList.add("post_reaction");
              sad.src = "Client_Includings/Reaction_Sad.gif";
              sad.title = "Sad";
              sad.alt = "";
              post_reactions_container.append(sad);

              sad.onclick = function () {
                React_Post("sad");
              };

              var angry = document.createElement("img");
              angry.classList.add("post_reaction");
              angry.src = "Client_Includings/Reaction_Angry.gif";
              angry.title = "Angry";
              angry.alt = "";
              post_reactions_container.append(angry);

              angry.onclick = function () {
                React_Post("angry");
              };

              react_icon_container.append(post_reactions_container);
            };

            post_footer.append(react_icon_container);
          }

          post.append(post_footer);
        }

        post.dataset.loading = "loaded";

        xhr_feedline = null;
      };
      xhr_feedline.onerror = function () {
        post.dataset.loading = "not_requested";
        post.innerHTML = "";
      };
    }
  }
}
