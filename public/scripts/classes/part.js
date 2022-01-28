import Modal from './modal.js';
import FavoriteButton from './favorite-button.js';

export default class Part {
    constructor(part) {
        const seeDetailsButton = part.querySelector(".see-details");
        const favoriteButton = part.querySelector(".favorite");

        this.element = part
        this.id = part.getAttribute("data-id");
        this.isFavorited = favoriteButton.getAttribute("data-is-favorited") === "true";
        this.favoriteButton = new FavoriteButton(this, favoriteButton, this.isFavorited)
        
        seeDetailsButton.addEventListener("click", Modal.create.bind(null, this));
    }

    setFavorite(value) {
        this.isFavorited = value;
    }
}