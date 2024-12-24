/* By Abdullah As-Sadeed */

document.onkeydown = function (keyboard) {
  if (
    keyboard.key == "F12" ||
    (keyboard.ctrlKey && keyboard.shiftKey && keyboard.key == "i") ||
    (keyboard.ctrlKey && keyboard.shiftKey && keyboard.key == "j") ||
    (keyboard.ctrlKey && keyboard.key == "u")
  ) {
    keyboard.preventDefault();

    Show_Alert("Developer tools are not allowed");

    return false;
  } else if (
    keyboard.Code == "PrintScreen" ||
    (keyboard.ctrlKey && keyboard.key == "p")
  ) {
    keyboard.preventDefault();

    Show_Alert("Printing is not allowed");

    return false;
  } else if (keyboard.ctrlKey && keyboard.key == "s") {
    keyboard.preventDefault();

    Show_Alert("Saving is not allowed");

    return false;
  }
};
