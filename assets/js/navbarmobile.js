//mon js
//js barre navigation mobile
  const burger = document.getElementById('burger');
  const mobileMenu = document.getElementById('mobile-menu');


  if(burger !== null && mobileMenu !== null) {

      burger.addEventListener('click', () => {
    mobileMenu.classList.toggle('show');
  });
  }
