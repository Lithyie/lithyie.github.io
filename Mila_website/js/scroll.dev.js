"use strict";

document.addEventListener('scroll', function () {
  var section = document.querySelector('.innovation');
  var sectionRect = section.getBoundingClientRect();
  var windowHeight = window.innerHeight; // Check if the section is in view

  if (sectionRect.top <= windowHeight && sectionRect.bottom >= 0) {
    section.classList.add('fixed');
  } else {
    section.classList.remove('fixed');
  }
});
window.addEventListener('scroll', function () {
  var nav = document.querySelector('.nav');

  if (window.scrollY > 0) {
    nav.classList.add('scrolled');
  } else {
    nav.classList.remove('scrolled');
  }
});