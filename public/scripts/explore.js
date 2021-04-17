let seeDetailsButtons = document.querySelectorAll("#page-explore .part .see-details");
const page = document.querySelector("#page-explore");
const modal = document.querySelector("#modal");
const close = document.querySelector("#modal .close");

seeDetailsButtons.forEach(button => {
    button.addEventListener("click", () => {
        modal.classList.remove("hide");
        page.classList.add("blur")
    })
})

close.addEventListener("click", () => {
    modal.classList.add("hide");
    page.classList.remove("blur")
})