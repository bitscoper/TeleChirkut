/* By Abdullah As-Sadeed */

function Make_Clickable_Link(text) {
  return text.replace(
    /(https:\/\/[^\s]+)/g,
    "<a target='new' title='External Link' href='$1'>$1</a>"
  );
}
