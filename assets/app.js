import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */

// import bootstrap css
import './vendor/bootstrap/dist/css/bootstrap.min.css';

// import bootstrap js
import 'bootstrap';


//mon css
import './styles/app.css';
// import './styles/slider.css';
// import './styles/services.css';

// import mon js  
import './js/navbarmobile.js';
import './js/flashmessages.js';
import './js/slider.js';
// import './js/sidebar.js';




console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
