

const flashes = document.querySelectorAll('.flash');

setTimeout(() => {
   flashes.forEach(flash => flash.remove());
}, 5000);
