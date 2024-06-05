document.addEventListener('DOMContentLoaded', function() {
    let currentIndex = 0;
    const slidesText = document.querySelectorAll('.text .slide');
    const slidesImage = document.querySelectorAll('.image .slide');
    const totalSlides = slidesText.length;

    const prevButton = document.querySelector('.prev');
    const nextButton = document.querySelector('.next');

    function showSlide(index) {
        slidesText.forEach(slide => slide.classList.remove('active'));
        slidesImage.forEach(slide => slide.classList.remove('active'));
        
        slidesText[index].classList.add('active');
        slidesImage[index].classList.add('active');
    }

    prevButton.addEventListener('click', function() {
        currentIndex = (currentIndex === 0) ? totalSlides - 1 : currentIndex - 1;
        showSlide(currentIndex);
    });

    nextButton.addEventListener('click', function() {
        currentIndex = (currentIndex === totalSlides - 1) ? 0 : currentIndex + 1;
        showSlide(currentIndex);
    });

    showSlide(currentIndex);
});