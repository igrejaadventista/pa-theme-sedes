export function pa_aumenta_texto(event) {
  event.preventDefault();
  var content = document.querySelector(".pa-content").children;

  var listArray = Array.from(content);

  console.log(listArray);

  listArray.forEach(function(element) {
    var item = window.getComputedStyle(element);

    var fontSize = item.getPropertyValue("font-size");
    var lineHeight = item.getPropertyValue("line-height");

    console.log(fontSize + " - " + lineHeight);

    fontSize = parseInt(fontSize.replace("px", ""));
    lineHeight = parseInt(lineHeight.replace("px", ""));

    element.style.fontSize = fontSize + 2 + "px";
    element.style.lineHeight = lineHeight + 3 + "px";
  });
}

export function pa_diminui_texto(event) {
  event.preventDefault();
  var content = document.querySelector(".pa-content").children;

  var listArray = Array.from(content);

  listArray.forEach(function(element) {
    var item = window.getComputedStyle(element);

    var fontSize = item.getPropertyValue("font-size");
    var lineHeight = item.getPropertyValue("line-height");

    fontSize = parseInt(fontSize.replace("px", ""));
    lineHeight = parseInt(lineHeight.replace("px", ""));

    element.style.fontSize = fontSize - 2 + "px";
    element.style.lineHeight = lineHeight - 3 + "px";
  });
}
