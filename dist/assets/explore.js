var l=Object.defineProperty;var d=(i,t,e)=>t in i?l(i,t,{enumerable:!0,configurable:!0,writable:!0,value:e}):i[t]=e;var o=(i,t,e)=>(d(i,typeof t!="symbol"?t+"":t,e),e);import{F as c}from"./favorite-button.bdf40a1a.js";class r extends c{constructor(t,e,s,n){super(e,s,n);o(this,"part");this.part=t}toggleFavorite(){this.disableButton(),this.part.favoriteButton!==this&&this.part.favoriteButton.disableButton(),fetch("../../src/php/favorite-part.php",{method:"POST",headers:{"Content-Type":"application/json;charset=utf-8"},body:JSON.stringify({eletronicPartId:this.part.id})}).then(t=>{if(t.status===200){const e=!this.isFavorited;this.setFavorite(e),this.part.favoriteButton!==this&&this.part.favoriteButton.setFavorite(e),this.enableButton(),this.part.favoriteButton!==this&&this.part.favoriteButton.enableButton(),this.updatePart(),this.updateButtonDataset(),this.part.favoriteButton!==this&&this.part.favoriteButton.updateButtonDataset(),this.updateText(),this.part.favoriteButton!==this&&this.part.favoriteButton.message!==void 0&&this.part.favoriteButton.updateText()}}).catch(t=>{this.enableButton(),console.log(t)})}updatePart(){this.part.setFavorite(this.isFavorited)}}class a{constructor(t){o(this,"part");o(this,"page");o(this,"modal");o(this,"modalContent");o(this,"modalSkeletonTemplate");this.part=t,this.page=document.querySelector("#page-explore"),this.modal=document.querySelector("#modal"),this.modalContent=document.querySelector("#modal .content"),this.modalSkeletonTemplate=document.getElementById("modal-skeleton-template"),document.querySelector("#modal .close").addEventListener("click",this.closeModal.bind(this))}static create(t){const e=new a(t);e.openModal(),e.loadData()}openModal(){this.modal.classList.remove("hide"),this.page.classList.add("blur")}closeModal(){this.modal.classList.add("hide"),this.page.classList.remove("blur"),this.modalContent.innerHTML=""}loadData(){this.modalContent.innerHTML=this.modalSkeletonTemplate.innerHTML,fetch("../../src/php/get-part-details.php",{method:"POST",headers:{"Content-Type":"application/json;charset=utf-8"},body:JSON.stringify({eletronicPartId:this.part.id})}).then(t=>t.json()).then(t=>{const e="../../storage/parts/";console.log(t),this.modalContent.innerHTML=`
                    <div class="left">
                        <section>
                            <div class="image">
                                <img src="${e+t.eletronicPart.image.name}" alt="">
                            </div>
                            <div class="name">${t.eletronicPart.name}</div>
                            <div class="stock">
                                <span>Estoque:</span>
                                <div class="amount">${t.eletronicPart.stock} unidades</div>
                            </div>
                        </section>
    
                        <div class="button-wrapper">
                            <button class="favorite">
                                <svg width="24" height="22" viewBox="0 0 24 22" xmlns="http://www.w3.org/2000/svg" fill="white">
                                    <path d="M21.4875 2.01407C18.7781 -0.264057 14.5922 0.07813 12 2.71719C9.40782 0.07813 5.22188 -0.268745 2.51251 2.01407C-1.01249 4.98125 -0.49687 9.81875 2.01563 12.3828L10.2375 20.7594C10.7063 21.2375 11.3344 21.5047 12 21.5047C12.6703 21.5047 13.2938 21.2422 13.7625 20.7641L21.9844 12.3875C24.4922 9.82344 25.0172 4.98594 21.4875 2.01407ZM20.3813 10.8031L12.1594 19.1797C12.0469 19.2922 11.9531 19.2922 11.8406 19.1797L3.61876 10.8031C1.90782 9.05938 1.56094 5.75938 3.96094 3.73907C5.78438 2.20625 8.59688 2.43594 10.3594 4.23125L12 5.90469L13.6406 4.23125C15.4125 2.42657 18.225 2.20625 20.0391 3.73438C22.4344 5.75469 22.0781 9.07344 20.3813 10.8031Z"/>
                                </svg>
                                <svg width="512" height="449" viewBox="0 0 512 449" fill="black" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M462.3 31.6C407.5 -15.1 326 -6.7 275.7 45.2L256 65.5L236.3 45.2C186.1 -6.7 104.5 -15.1 49.6996 31.6C-13.1004 85.2 -16.4004 181.4 39.7996 239.5L233.3 439.3C245.8 452.2 266.1 452.2 278.6 439.3L472.1 239.5C528.4 181.4 525.1 85.2 462.3 31.6V31.6Z" />
                                </svg>
                                <span></span>
                            </button>
                        </div>
                    </div>
            
                    <div class="right">
                        <section>
                            <div class="field">
                                <h2>Tipo:</h2>
                                <p>${t.eletronicPart.type}</p>
                            </div>
            
                            <div class="field">
                                <h2>Modelo:</h2>
                                <p>${t.eletronicPart.model}</p>
                            </div>
                            
                            <div class="field">
                                <h2>Sobre:</h2>
                                <p>${t.eletronicPart.description}</p>
                            </div>
            
                            <div class="field">
                                <h2>Contato:</h2>
                                <p>
                                    ${t.eletronicPart.person.address.address}, 
                                    ${t.eletronicPart.person.address.district} <br>
                                    ${t.eletronicPart.person.address.city} - 
                                    ${t.eletronicPart.person.address.state}
                                </p>
                                <p>
                                    Telefone:<br> 
                                    ${t.eletronicPart.person.phoneNumber1}<br>
                                    ${t.eletronicPart.person.phoneNumber2}
                                </p>
                            </div>
                        </section>
            
                        <div class="button-wrapper">
                            <form action="../../src/php/request-order.php" method="post">
                                <input type="hidden" name="eletronicPartId" value="${t.eletronicPart.id}">
                                <input type="hidden" name="donorId" value="${t.eletronicPart.person.id}">
                                <button class="order">
                                    <span>Fazer Pedido</span>
                                </button>
                            </form>
                        </div>
                    </div>
                `,new r(this.part,this.modalContent.querySelector(".left button.favorite"),this.part.isFavorited,{favorited:"Remover",notFavorited:"Tenho Interesse"})}).catch(t=>{console.log(t)})}}class p{constructor(t){o(this,"element");o(this,"id");o(this,"isFavorited");o(this,"favoriteButton");const e=t.querySelector(".see-details"),s=t.querySelector(".favorite");this.element=t,this.id=Number(t.getAttribute("data-id")),this.isFavorited=s.getAttribute("data-is-favorited")==="true",this.favoriteButton=new r(this,s,this.isFavorited),e.addEventListener("click",a.create.bind(null,this))}setFavorite(t){this.isFavorited=t}}const h=document.querySelectorAll("#page-explore .part");h.forEach(i=>{new p(i)});
//# sourceMappingURL=explore.js.map
