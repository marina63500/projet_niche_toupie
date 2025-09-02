document.addEventListener('turbo:load', () => {



// Sélection des éléments du DOM
const slides = document.querySelectorAll('.slide'); 
const prev = document.getElementById('prevBtn');
const next = document.getElementById('nextBtn');

let index = 0;


function showSlide(i){
    document.querySelector('.slide.active').classList.remove('active');
    slides[i].classList.add('active');
}

next.addEventListener('click', () => {
    index++;
    if (index >= slides.length) {
        index = 0;
    }
    showSlide(index);
});

prev.addEventListener('click', () => {
    index--;
    if (index < 0) {
        index = slides.length - 1;
    }
    showSlide(index);
});

// Initialisation
showSlide(index);
});