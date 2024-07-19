"use strict";

// observer.js
document.addEventListener('DOMContentLoaded', function () {
  var cards = document.querySelectorAll('.mycard');
  var observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0.5
  };

  var observerCallback = function observerCallback(entries, observer) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('active');
      } else {
        entry.target.classList.remove('active');
      }
    });
  };

  var observer = new IntersectionObserver(observerCallback, observerOptions);
  cards.forEach(function (card) {
    observer.observe(card);
  });
});