const addButton = document.querySelector(
    "form .field .stock-menu .add"
) as HTMLButtonElement;
const subtractButton = document.querySelector(
    "form .field .stock-menu .subtract"
) as HTMLButtonElement;
const stockInput = document.querySelector(
    "form .field .stock-menu input"
) as HTMLInputElement;

console.log(stockInput);

addButton.addEventListener("click", (event) => {
    event.preventDefault();

    stockInput.value = (Number(stockInput.value) + 1).toString();
});

subtractButton.addEventListener("click", (event) => {
    event.preventDefault();

    if (Number(stockInput.value) > 0) {
        stockInput.value = (Number(stockInput.value) - 1).toString();
    }
});
