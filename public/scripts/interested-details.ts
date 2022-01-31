import FavoriteButton from "./classes/favorite-button";

const favoriteButton = document.querySelector(".favorite") as HTMLButtonElement;

new FavoriteButton(
    favoriteButton,
    Boolean(favoriteButton.getAttribute("data-is-favorited")),
    { 
        favorited: "Remover", 
        notFavorited: "Tenho Interesse" 
    }
);