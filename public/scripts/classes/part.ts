import Modal from './modal.js';
import ExploreFavoriteButton from './explore-favorite-button.js';

export default class Part {
    element: HTMLDivElement;
    id: number;
    isFavorited: boolean;
    favoriteButton: ExploreFavoriteButton;

    constructor(part: HTMLDivElement) {
        const seeDetailsButton = part.querySelector(".see-details") as HTMLButtonElement;
        const favoriteButton = part.querySelector(".favorite") as HTMLButtonElement;

        this.element = part
        this.id = Number(part.getAttribute("data-id"));
        this.isFavorited = favoriteButton.getAttribute("data-is-favorited") === "true";
        this.favoriteButton = new ExploreFavoriteButton(this, favoriteButton, this.isFavorited)
        
        seeDetailsButton.addEventListener("click", Modal.create.bind(null, this));
    }

    setFavorite(value: boolean) {
        this.isFavorited = value;
    }
}