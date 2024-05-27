"use strict";

var cursorDot = document.querySelector("[data-cursor-dot]");
var cursorOutline = document.querySelector("[data-cursor-outline]");
window.addEventListener("mousemove", function (e) {
  var posX = e.clientX;
  var posY = e.clientY;
  cursorDot.style.left = "".concat(posX, "px");
  cursorDot.style.top = "".concat(posY, "px"); // cursorOutline.style.left = `${posX}px`;
  // cursorOutline.style.top = `${posY}px`;

  cursorOutline.animate({
    left: "".concat(posX, "px"),
    top: "".concat(posY, "px")
  }, {
    duration: 1,
    fill: "forwards"
  });
});