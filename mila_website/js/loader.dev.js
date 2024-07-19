"use strict";

// loader.js
(function () {
  var minimumLoadTime = 4000; // 4000 ms = 4 secondes

  var startTime = new Date().getTime();
  document.body.classList.add('no-scroll');
  window.addEventListener('load', function () {
    var currentTime = new Date().getTime();
    var elapsedTime = currentTime - startTime;

    var hideLoader = function hideLoader() {
      document.getElementById('loader').classList.add('fade-out');
      setTimeout(function () {
        document.getElementById('loader').classList.add('hidden');
        document.body.classList.remove('no-scroll');
      }, 1000);
    };

    if (elapsedTime >= minimumLoadTime) {
      hideLoader();
    } else {
      setTimeout(hideLoader, minimumLoadTime - elapsedTime);
    }
  });
})();