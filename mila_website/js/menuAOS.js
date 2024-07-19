// menuAOS.js
$(document).ready(function () {
    $('.burger').click(function () {
        $(this).toggleClass('burger-open');
        $('.menu').toggleClass('is-open');
        return false;
    });
    $('.menu ul li a').click(function (event) {
        $('.menu').toggleClass('is-open');
        $('.burger').toggleClass('burger-open');
        event.stopPropagation();
    });
});

document.querySelector('.vid').addEventListener('click', function () {
    this.classList.toggle('hide-overlay');
});

AOS.init();

function updateAOSAnimations() {
    var fadeLeftElements = document.querySelectorAll('[data-aos="fade-left"]');
    var fadeRightElements = document.querySelectorAll('[data-aos="fade-right"]');
    var fadeUpElements = document.querySelectorAll('[data-aos="fade-up"]');

    if (window.innerWidth <= 1024) {
        fadeLeftElements.forEach(function (element) {
            element.setAttribute('data-aos-original', 'fade-left');
            element.setAttribute('data-aos', 'fade-up');
        });
        fadeRightElements.forEach(function (element) {
            element.setAttribute('data-aos-original', 'fade-right');
            element.setAttribute('data-aos', 'fade-up');
        });
    } else {
        fadeUpElements.forEach(function (element) {
            var originalAnimation = element.getAttribute('data-aos-original');
            if (originalAnimation === 'fade-left' || originalAnimation === 'fade-right') {
                element.setAttribute('data-aos', originalAnimation);
                element.removeAttribute('data-aos-original');
            }
        });
    }
    AOS.refresh();
}
updateAOSAnimations();

window.addEventListener('resize', function () {
    updateAOSAnimations();
});
