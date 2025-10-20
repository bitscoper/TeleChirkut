/* By Abdullah As-Sadeed */

function Is_Partially_Inside_Viewport(element) {
  var x = element.getBoundingClientRect().left;
  var y = element.getBoundingClientRect().top;

  var ww = Math.max(
    document.documentElement.clientWidth,
    window.innerWidth || 0
  );

  var hw = Math.max(
    document.documentElement.clientHeight,
    window.innerHeight || 0
  );

  var w = element.clientWidth;
  var h = element.clientHeight;

  return y < hw && y + h > 0 && x < ww && x + w > 0;
}
