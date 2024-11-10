/* By Abdullah As-Sadeed */

var face_logo_editor_form = document.getElementById("face_logo_editor_form");

if (
  typeof face_logo_editor_form !== "undefined" &&
  face_logo_editor_form !== null
) {
  var face_logo_editor = new Croppie(
    document.getElementById("face_logo_editor"),
    {
      viewport: {
        width: 128,
        height: 128,
        type: "circle",
      },
      boundary: {
        width: 256,
        height: 256,
      },
      showZoomer: true,
      enableOrientation: true,
      enableResize: false,
      enableZoom: true,
      mouseWheelZoom: true,
    }
  );

  face_logo_editor_form.face_logo.onchange = function () {
    var file_reader = new FileReader();

    file_reader.onload = function (selection) {
      face_logo_editor.bind({
        url: selection.target.result,
      });
    };
    file_reader.readAsDataURL(this.files[0]);
  };

  document.getElementById("rotate_negative").onclick = function () {
    face_logo_editor.rotate(-90);
  };

  document.getElementById("rotate_positive").onclick = function () {
    face_logo_editor.rotate(90);
  };

  face_logo_editor_form.onsubmit = function (submission) {
    submission.preventDefault();
    waiting(true);

    var face_logo_editor_submit = document.querySelector(
      '#face_logo_editor_page input[type="submit"]'
    );

    face_logo_editor_submit.value = "Editing ...";

    face_logo_editor
      .result({
        type: "blob",
        size: "viewport",
        format: "webp",
        quality: 1,
        circle: true,
      })
      .then(function (blob) {
        var data = new FormData();
        data.append("type", "Edit_Profile");
        data.append("face_logo", blob);

        fetch("/", {
          method: "POST",
          body: data,
        }).then(function () {
          Update_Profile_Icon();

          waiting(false);

          face_logo_editor_submit.value = "Edited";

          setTimeout(function () {
            face_logo_editor_submit.value = "Edit Face / Logo";
          }, 2000);
          Show_Alert("Edited");
        });
      });
  };
}
