/* By Abdullah As-Sadeed */

function Observe_Mutations(element_class, to_do) {
  var callback = function (mutations_list) {
    for (var mutation of mutations_list) {
      var addedNodes = mutation.addedNodes;

      for (var node of addedNodes) {
        if (node.classList && node.classList.contains(element_class)) {
          console.log(node);
          to_do(node);
        }
      }
    }
  };

  var observer = new MutationObserver(callback);

  var observer_options = {
    childList: true,
    subtree: true,
    attributes: true,
    attributeOldValue: true,
    characterData: true,
    characterDataOldValue: true,
  };

  observer.observe(document, observer_options);
}
