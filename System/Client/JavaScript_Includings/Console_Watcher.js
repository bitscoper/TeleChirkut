/* By Abdullah As-Sadeed */

function Watch_Console() {
  var fetch_observer = new PerformanceObserver(function (list) {
    for (var entry of list.getEntries()) {
      if (entry.initiatorType === "fetch") {
        console.clear();

        console.log(
          "%c%s",
          "background-color: red; padding: 20px 10px 20px 10px; font-size: large; color: white; font-weight: bold;",
          "Do not do anything here!"
        );
      }
    }
  });

  fetch_observer.observe({
    entryTypes: ["resource"],
  });
}
