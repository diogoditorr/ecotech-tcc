export interface IMessageOptions {
    favorited: string;
    notFavorited: string;
}

export default class FavoriteButton {
    button: HTMLButtonElement;
    isFavorited: boolean;
    message?: IMessageOptions;
    span?: HTMLSpanElement | null;
    
    constructor(button: HTMLButtonElement, isFavorited: boolean, message?: IMessageOptions) {
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

        // Send request to add to favorites
        fetch("../../src/php/favorite-part.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json;charset=utf-8",
            },
            body: JSON.stringify({
                // Get part id as "peca_id" from query params
                partId: Number(new URLSearchParams(window.location.search).get("peca_id")),
            }),
        })
            .then((response) => {
                setTimeout(() => {
                    if (response.status === 200) {
                        const status = !this.isFavorited;
                        this.setFavorite(status);
                        this.enableButton();
                        this.updateButtonDataset();
                        this.updateText();
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

    setFavorite(value: boolean) {
        this.isFavorited = value;
    }

    updateButtonDataset() {
        this.button.setAttribute("data-is-favorited", this.isFavorited.toString());
    }

    updateText() {
        if (!this.span || !this.message)
            return

        this.span.textContent = this.isFavorited
            ? this.message.favorited
            : this.message.notFavorited;
    }

}
