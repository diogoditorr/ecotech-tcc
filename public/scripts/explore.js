const parts = document.querySelectorAll("#page-explore .part");

const page = document.querySelector("#page-explore");
const modal = document.querySelector("#modal");
const modalContent = document.querySelector("#modal .content");
const close = document.querySelector("#modal .close");

function seeDetails(id) {
    fetch("../../src/php/get-part-details.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json;charset=utf-8",
        },
        body: JSON.stringify({
            partId: id,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            const defaultStorage = '../../storage/parts/';
            console.log(data);
            modalContent.innerHTML = `
                <div class="left">
                    <section>
                        <div class="image">
                            <img src="${defaultStorage + data.part.image}" alt="">
                        </div>
                        <div class="name">${data.part.name}</div>
                        <div class="stock">
                            <span>Estoque:</span>
                            <div class="amount">${data.part.stock} unidades</div>
                        </div>
                    </section>

                    <div class="button-wrapper">
                        <button class="favorite">
                            <img src="../../public/assets/heart.svg" alt="">
                            <span>Tenho Interesse</span>
                        </button>
                    </div>
                </div>
        
                <div class="right">
                    <section>
                        <div class="field">
                            <h2>Tipo:</h2>
                            <p>${data.part.type}</p>
                        </div>
        
                        <div class="field">
                            <h2>Modelo:</h2>
                            <p>${data.part.model}</p>
                        </div>
                        
                        <div class="field">
                            <h2>Sobre:</h2>
                            <p>${data.part.description}</p>
                        </div>
        
                        <div class="field">
                            <h2>Contato:</h2>
                            <p>
                                NÃO IMPLEMENTADO!!! <br>
                                ${data.part.person.address.city} - 
                                ${data.part.person.address.state}
                            </p>
                            <p>
                                Telefone:<br> 
                                ${data.part.person.phoneNumber1}<br>
                                ${data.part.person.phoneNumber2}
                            </p>
                        </div>
                    </section>
        
                    <div class="button-wrapper">
                        <button class="order">
                            <span>Fazer Pedido</span>
                        </button>
                    </div>
                </div>
            `;
        })
        .catch((error) => {
            console.log(error);
        });
}

parts.forEach(part => {
    part.querySelector(".see-details").addEventListener("click", () => {
        modal.classList.remove("hide");
        page.classList.add("blur");

        const partId = part.getAttribute("data-id");
        seeDetails(partId);
    });
});

close.addEventListener("click", () => {
    modal.classList.add("hide");
    page.classList.remove("blur");
    modalContent.innerHTML = "";
});
