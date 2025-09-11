document.addEventListener('turbo:load', () => {




// Sélection des éléments du DOM
const slides = document.querySelectorAll('.slide'); 
const prev = document.getElementById('prevBtn');
const next = document.getElementById('nextBtn');
let interval = null;

if(slides.length === 0){
    console.log('ici');
        if(interval !== null){
        clearInterval(interval);
        interval = null;
    }
}
if (slides.length !== 0) {

    let index = 0;


function showSlide(i){
    // console.log(i);
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
interval = setInterval(() => {
    index++;
    if (index >= slides.length) {
        index = 0;
    }
    showSlide(index);
}, 3000); 


}



}



// }
);