import FavoriteButton from "./favorite-button.js";

export default class Modal {
    constructor(part) {
        this.part = part;
        this.page = document.querySelector("#page-explore");
        this.modal = document.querySelector("#modal");
        this.modalContent = document.querySelector("#modal .content");
        this.modalSkeletonTemplate = document.getElementById(
            "modal-skeleton-template"
        );

        const close = document.querySelector("#modal .close");
        close.addEventListener("click", this.closeModal.bind(this));
    }

    static create(part) {
        const modal = new Modal(part);
        modal.openModal();
        modal.loadData();
    }

    openModal() {
        this.modal.classList.remove("hide");
        this.page.classList.add("blur");
    }

    closeModal() {
        this.modal.classList.add("hide");
        this.page.classList.remove("blur");
        this.modalContent.innerHTML = "";
    }

    loadData() {
        this.modalContent.innerHTML = this.modalSkeletonTemplate.innerHTML;

        fetch("../../src/php/get-part-details.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json;charset=utf-8",
            },
            body: JSON.stringify({
                partId: this.part.id,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                const defaultStorage = "../../storage/parts/";
                console.log(data);
                this.modalContent.innerHTML = `
                    <div class="left">
                        <section>
                            <div class="image">
                                <img src="${
                                    defaultStorage + data.part.image
                                }" alt="">
                            </div>
                            <div class="name">${data.part.name}</div>
                            <div class="stock">
                                <span>Estoque:</span>
                                <div class="amount">${
                                    data.part.stock
                                } unidades</div>
                            </div>
                        </section>
    
                        <div class="button-wrapper">
                            <button class="favorite">
                                <img src="../../public/assets/heart.svg" alt="">
                                <img src="../../public/assets/heart-filled.svg" alt="">
                                <span></span>
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
                            <form action="../../src/php/make-order.php" method="post">
                                <input type="hidden" name="partId" value="${
                                    data.part.id
                                }">
                                <input type="hidden" name="doadorId" value="${
                                    data.part.person.id
                                }">
                                <button class="order">
                                    <span>Fazer Pedido</span>
                                </button>
                            </form>
                        </div>
                    </div>
                `;

                new FavoriteButton(
                    this.part,
                    this.modalContent.querySelector(".left button.favorite"),
                    this.part.isFavorited,
                    {
                        favorited: "Remover",
                        notFavorited: "Tenho Interesse",
                    }
                );
            })
            .catch((error) => {
                console.log(error);
            });
    }
}
