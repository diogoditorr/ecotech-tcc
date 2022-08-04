import FavoriteButton, { IMessageOptions } from "./favorite-button";
import Part from "./part";

export default class ExploreFavoriteButton extends FavoriteButton {
    part: Part;

    constructor(part: Part, button: HTMLButtonElement, isFavorited: boolean, message?: IMessageOptions) {
        super(button, isFavorited, message);
        this.part = part;
    }

    toggleFavorite(): void {
        this.disableButton();
        if (this.part.favoriteButton !== this) {
            this.part.favoriteButton.disableButton();
        }

        // Send request to add to favorites
        fetch("../../src/php/favorite-part.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json;charset=utf-8",
            },
            body: JSON.stringify({
                eletronicPartId: this.part.id,
            }),
        })
            .then((response) => {
                if (response.status === 200) {
                    const status = !this.isFavorited;

                    this.setFavorite(status);
                    if (this.part.favoriteButton !== this) {
                        this.part.favoriteButton.setFavorite(status);
                    }

                    this.enableButton();
                    if (this.part.favoriteButton !== this) {
                        this.part.favoriteButton.enableButton();
                    }

                    this.updatePart();

                    this.updateButtonDataset();
                    if (this.part.favoriteButton !== this) {
                        this.part.favoriteButton.updateButtonDataset();
                    }

                    this.updateText();

                    if (
                        this.part.favoriteButton !== this &&
                        this.part.favoriteButton.message !== undefined
                    ) {
                        this.part.favoriteButton.updateText();
                    }
                }
            })
            .catch((error) => {
                this.enableButton();
                console.log(error);
            });
    }

    updatePart() {
        this.part.setFavorite(this.isFavorited);
    }
}