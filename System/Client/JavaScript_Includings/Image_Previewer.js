/* By Abdullah As-Sadeed */

function Preview_Image(input, output) {
  var previewer = new FileReader();

  previewer.onload = function (selection) {
    output.src = selection.target.result;
  };

  previewer.readAsDataURL(input.files[0]);
}
