document.addEventListener('turbo:load', () => {



// Sélection des éléments du DOM
const slides = document.querySelectorAll('.slide'); 
const prev = document.getElementById('prevBtn');
const next = document.getElementById('nextBtn');

// if (slides.length > 0){

if (slides.length === 0) {
    return; // Sortir si aucun slide n'est trouvé
}
    let index = 0;


function showSlide(i){
    document.querySelector('.slide.active').classList.remove('active');
    slides[i].classList.add('active');
}

// Gestion des clics sur les boutons
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


showSlide(index);


// interval automatique
setInterval(() => {
    index++;
    if (index >= slides.length) {
        index = 0;
    }
    showSlide(index);
}, 3000); 




}



// }
);