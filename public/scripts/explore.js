// import FavoriteButton from './classes/favorite-button.js';
import Part from './classes/part.js';

const parts = document.querySelectorAll("#page-explore .part");

parts.forEach((part) => {
    new Part(part);
});
