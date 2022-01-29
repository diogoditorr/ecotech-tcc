// import FavoriteButton from './classes/favorite-button.js';
import Part from './classes/part';

const parts = document.querySelectorAll<HTMLDivElement>("#page-explore .part");

parts.forEach((part) => {
    new Part(part);
});
