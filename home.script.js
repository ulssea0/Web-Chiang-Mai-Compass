let currentSlide = 0;
const slides = document.querySelectorAll('.carousel-item');
const indicators = document.querySelectorAll('.indicator');
const totalSlides = slides.length;

function showSlide(n) {
    const carousel = document.querySelector('.carousel');
    carousel.style.transform = `translateX(-${n * 100}%)`;
    
    // Update indicators
    indicators.forEach((indicator, index) => {
        if (index === n) {
            indicator.classList.add('active');
        } else {
            indicator.classList.remove('active');
        }
    });
}

function moveCarousel(direction) {
    currentSlide += direction;
    if (currentSlide >= totalSlides) {
        currentSlide = 0;
    } else if (currentSlide < 0) {
        currentSlide = totalSlides - 1;
    }
    showSlide(currentSlide);
}

function goToSlide(n) {
    currentSlide = n;
    showSlide(currentSlide);
}

// Auto slide every 5 seconds
setInterval(() => {
    moveCarousel(1);
}, 1000);