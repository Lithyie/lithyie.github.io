"use strict";

document.addEventListener('DOMContentLoaded', function () {
  var buttons = document.querySelectorAll('.menu-button');
  var slides = document.querySelectorAll('.slide');
  buttons.forEach(function (button) {
    button.addEventListener('click', function () {
      var index = this.getAttribute('data-index');
      buttons.forEach(function (btn) {
        return btn.classList.remove('active');
      });
      this.classList.add('active');
      slides.forEach(function (slide) {
        if (slide.getAttribute('data-index') === index) {
          slide.classList.add('active');
        } else {
          slide.classList.remove('active');
        }
      });
    });
  });
});
document.addEventListener('DOMContentLoaded', function (event) {
  var cards = document.querySelectorAll('.mycard');
  cards.forEach(function (card) {
    card.addEventListener('click', function () {
      this.classList.toggle('active');
    });
  });
});