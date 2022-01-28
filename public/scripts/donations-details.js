import utils from "./utils.js";

const saveButton = document.querySelector(
    "#page-donations-details .buttons .save"
);
const cancelButton = document.querySelector(
    "#page-donations-details .buttons .cancel-order"
);
const orderId = document.querySelector(
    "#page-donations-details input[name='orderId']"
);
const select = document.querySelector(
    "#page-donations-details select[id='status']"
);

saveButton.addEventListener("click", () => {
    disableSaveButton();

    fetch("../../src/php/order-edit.php", {
        method: "POST",
        body: utils.toFormData({
            orderId: orderId.value,
            status: utils.handleStatus(
                select.options[select.selectedIndex].value
            ),
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            enableSaveButton();

            console.log(data);
            alert("Status changed with success!");
        })
        .catch((error) => {
            console.error(error);
            alert("Something went wrong. Please try again later.");
        });
});

cancelButton.addEventListener("click", () => {
    fetch("../../src/php/order-cancel.php", {
        method: "POST",
        body: utils.toFormData({
            orderId: orderId.value,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            if (data.success) {
                alert("Order canceled with success!");
                window.location.href = "./donations.php";
            } else {
                throw new Error();
            }
        })
        .catch((error) => {
            console.error(error);
            alert("Something went wrong. Please try again later.");
        });
});

function enableSaveButton() {
    saveButton.classList.remove("disabled");
    saveButton.disabled = false;
}

function disableSaveButton() {
    saveButton.classList.add("disabled");
    saveButton.disabled = true;
}
