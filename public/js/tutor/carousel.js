const carousel = document.querySelector('.carousel');
const prevBtn = document.querySelector('.prev-btn');
const nextBtn = document.querySelector('.next-btn');

let index = 0;

function showSlide(n) {
    const items = document.querySelectorAll('.carousel-item');
    index = (n + items.length) % items.length;
    carousel.style.transform = `translateX(-${index * 100}%)`;
}

prevBtn.addEventListener('click', () => showSlide(index - 1));
nextBtn.addEventListener('click', () => showSlide(index + 1));

// Optional: Auto-slide functionality
setInterval(() => {
    showSlide(index + 1);
}, 3000);
