"use strict";

document.addEventListener('DOMContentLoaded', function () {
  var currentIndex = 0;
  var slidesText = document.querySelectorAll('.text .slide');
  var slidesImage = document.querySelectorAll('.image .slide');
  var totalSlides = slidesText.length;
  var prevButton = document.querySelector('.prev');
  var nextButton = document.querySelector('.next');

  function showSlide(index) {
    slidesText.forEach(function (slide) {
      return slide.classList.remove('active');
    });
    slidesImage.forEach(function (slide) {
      return slide.classList.remove('active');
    });
    slidesText[index].classList.add('active');
    slidesImage[index].classList.add('active');
  }

  prevButton.addEventListener('click', function () {
    currentIndex = currentIndex === 0 ? totalSlides - 1 : currentIndex - 1;
    showSlide(currentIndex);
  });
  nextButton.addEventListener('click', function () {
    currentIndex = currentIndex === totalSlides - 1 ? 0 : currentIndex + 1;
    showSlide(currentIndex);
  });
  showSlide(currentIndex);
});