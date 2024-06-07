document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.menu-button');
    const slides = document.querySelectorAll('.slide');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const index = this.getAttribute('data-index');

            buttons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            slides.forEach(slide => {
                if (slide.getAttribute('data-index') === index) {
                    slide.classList.add('active');
                } else {
                    slide.classList.remove('active');
                }
            });
        });
    });
});