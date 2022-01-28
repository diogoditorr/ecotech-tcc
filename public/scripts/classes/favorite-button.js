export default class FavoriteButton {
    constructor(part, button, isFavorited, message) {
        this.part = part;
        this.button = button;
        this.button.addEventListener("click", this.toggleFavorite.bind(this));
        this.isFavorited = isFavorited;

        this.updateButtonDataset();

        if (message) {
            this.message = message;
            this.span = this.button.querySelector("span");
            this.updateText();
        }
    }

    toggleFavorite() {
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
                partId: this.part.id,
            }),
        })
            .then((response) => {
                setTimeout(() => {
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

                        if (this.message) {
                            this.updateText();
                        }

                        if (
                            this.part.favoriteButton !== this &&
                            this.part.favoriteButton.message !== undefined
                        ) {
                            this.part.favoriteButton.updateText();
                        }
                    }
                }, 1000);
            })
            .catch((error) => {
                this.enableButton();
                console.log(error);
            });
    }

    enableButton() {
        this.button.disabled = false;
        this.button.classList.remove("disabled");
    }

    disableButton() {
        this.button.disabled = true;
        this.button.classList.add("disabled");
    }

    setFavorite(value) {
        this.isFavorited = value;
    }

    updateButtonDataset() {
        this.button.setAttribute("data-is-favorited", this.isFavorited);
    }

    updateText() {
        this.span.textContent = this.isFavorited
            ? this.message.favorited
            : this.message.notFavorited;
    }

    updatePart() {
        this.part.setFavorite(this.isFavorited);
    }
}
