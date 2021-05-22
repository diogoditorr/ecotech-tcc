const addButton = document.querySelector("form .field .stock-menu .add")
const subtractButton = document.querySelector("form .field .stock-menu .subtract")
const stockInput = document.querySelector("form .field .stock-menu input")
console.log(stockInput)
addButton.addEventListener("click", (event) => {
    event.preventDefault();
    
    stockInput.value = Number(stockInput.value) + 1
})

subtractButton.addEventListener("click", (event) => {
    event.preventDefault();

    if (Number(stockInput.value) > 0) {
        stockInput.value = Number(stockInput.value) - 1;
    }
})
