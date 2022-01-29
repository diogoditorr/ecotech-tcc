var d=Object.defineProperty;var l=(i,t,e)=>t in i?d(i,t,{enumerable:!0,configurable:!0,writable:!0,value:e}):i[t]=e;var s=(i,t,e)=>(l(i,typeof t!="symbol"?t+"":t,e),e);class n{constructor(t,e,o,r){s(this,"part");s(this,"button");s(this,"isFavorited");s(this,"message");s(this,"span");this.part=t,this.button=e,this.button.addEventListener("click",this.toggleFavorite.bind(this)),this.isFavorited=o,this.updateButtonDataset(),r&&(this.message=r,this.span=this.button.querySelector("span"),this.updateText())}toggleFavorite(){this.disableButton(),this.part.favoriteButton!==this&&this.part.favoriteButton.disableButton(),fetch("../../src/php/favorite-part.php",{method:"POST",headers:{"Content-Type":"application/json;charset=utf-8"},body:JSON.stringify({partId:this.part.id})}).then(t=>{setTimeout(()=>{if(t.status===200){const e=!this.isFavorited;this.setFavorite(e),this.part.favoriteButton!==this&&this.part.favoriteButton.setFavorite(e),this.enableButton(),this.part.favoriteButton!==this&&this.part.favoriteButton.enableButton(),this.updatePart(),this.updateButtonDataset(),this.part.favoriteButton!==this&&this.part.favoriteButton.updateButtonDataset(),this.updateText(),this.part.favoriteButton!==this&&this.part.favoriteButton.message!==void 0&&this.part.favoriteButton.updateText()}},1e3)}).catch(t=>{this.enableButton(),console.log(t)})}enableButton(){this.button.disabled=!1,this.button.classList.remove("disabled")}disableButton(){this.button.disabled=!0,this.button.classList.add("disabled")}setFavorite(t){this.isFavorited=t}updateButtonDataset(){this.button.setAttribute("data-is-favorited",this.isFavorited.toString())}updateText(){!this.span||!this.message||(this.span.textContent=this.isFavorited?this.message.favorited:this.message.notFavorited)}updatePart(){this.part.setFavorite(this.isFavorited)}}class a{constructor(t){s(this,"part");s(this,"page");s(this,"modal");s(this,"modalContent");s(this,"modalSkeletonTemplate");this.part=t,this.page=document.querySelector("#page-explore"),this.modal=document.querySelector("#modal"),this.modalContent=document.querySelector("#modal .content"),this.modalSkeletonTemplate=document.getElementById("modal-skeleton-template"),document.querySelector("#modal .close").addEventListener("click",this.closeModal.bind(this))}static create(t){const e=new a(t);e.openModal(),e.loadData()}openModal(){this.modal.classList.remove("hide"),this.page.classList.add("blur")}closeModal(){this.modal.classList.add("hide"),this.page.classList.remove("blur"),this.modalContent.innerHTML=""}loadData(){this.modalContent.innerHTML=this.modalSkeletonTemplate.innerHTML,fetch("../../src/php/get-part-details.php",{method:"POST",headers:{"Content-Type":"application/json;charset=utf-8"},body:JSON.stringify({partId:this.part.id})}).then(t=>t.json()).then(t=>{const e="../../storage/parts/";console.log(t),this.modalContent.innerHTML=`
                    <div class="left">
                        <section>
                            <div class="image">
                                <img src="${e+t.part.image}" alt="">
                            </div>
                            <div class="name">${t.part.name}</div>
                            <div class="stock">
                                <span>Estoque:</span>
                                <div class="amount">${t.part.stock} unidades</div>
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
                                <p>${t.part.type}</p>
                            </div>
            
                            <div class="field">
                                <h2>Modelo:</h2>
                                <p>${t.part.model}</p>
                            </div>
                            
                            <div class="field">
                                <h2>Sobre:</h2>
                                <p>${t.part.description}</p>
                            </div>
            
                            <div class="field">
                                <h2>Contato:</h2>
                                <p>
                                    N\xC3O IMPLEMENTADO!!! <br>
                                    ${t.part.person.address.city} - 
                                    ${t.part.person.address.state}
                                </p>
                                <p>
                                    Telefone:<br> 
                                    ${t.part.person.phoneNumber1}<br>
                                    ${t.part.person.phoneNumber2}
                                </p>
                            </div>
                        </section>
            
                        <div class="button-wrapper">
                            <form action="../../src/php/make-order.php" method="post">
                                <input type="hidden" name="partId" value="${t.part.id}">
                                <input type="hidden" name="doadorId" value="${t.part.person.id}">
                                <button class="order">
                                    <span>Fazer Pedido</span>
                                </button>
                            </form>
                        </div>
                    </div>
                `,new n(this.part,this.modalContent.querySelector(".left button.favorite"),this.part.isFavorited,{favorited:"Remover",notFavorited:"Tenho Interesse"})}).catch(t=>{console.log(t)})}}class p{constructor(t){s(this,"element");s(this,"id");s(this,"isFavorited");s(this,"favoriteButton");const e=t.querySelector(".see-details"),o=t.querySelector(".favorite");this.element=t,this.id=Number(t.getAttribute("data-id")),this.isFavorited=o.getAttribute("data-is-favorited")==="true",this.favoriteButton=new n(this,o,this.isFavorited),e.addEventListener("click",a.create.bind(null,this))}setFavorite(t){this.isFavorited=t}}const h=document.querySelectorAll("#page-explore .part");h.forEach(i=>{new p(i)});
//# sourceMappingURL=explore.js.map
