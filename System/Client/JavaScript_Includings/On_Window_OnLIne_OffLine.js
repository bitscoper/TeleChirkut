/* By Abdullah As-Sadeed */

window.onoffline = function () {
  Show_Alert("You are offline now!");
};

window.ononline = function () {
  Show_Alert("You are online again.");

  Try_Loading_Posts();
};
