/* By Abdullah As-Sadeed */

function Normalize_Position(mouseX, mouseY, context_menu) {
  var scope = document.body;

  var { left: scopeOffsetX, top: scopeOffsetY } = scope.getBoundingClientRect();

  scopeOffsetX = scopeOffsetX < 0 ? 0 : scopeOffsetX;
  scopeOffsetY = scopeOffsetY < 0 ? 0 : scopeOffsetY;

  var scopeX = mouseX - scopeOffsetX;
  var scopeY = mouseY - scopeOffsetY;

  var outOfBoundsOnX = scopeX + context_menu.clientWidth > scope.clientWidth;
  var outOfBoundsOnY = scopeY + context_menu.clientHeight > scope.clientHeight;

  var normalizedX = mouseX;
  var normalizedY = mouseY;

  if (outOfBoundsOnX) {
    normalizedX = scopeOffsetX + scope.clientWidth - context_menu.clientWidth;
  }

  if (outOfBoundsOnY) {
    normalizedY = scopeOffsetY + scope.clientHeight - context_menu.clientHeight;
  }

  return {
    normalizedX,
    normalizedY,
  };
}
