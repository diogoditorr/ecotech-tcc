var o=Object.defineProperty;var n=(e,t,s)=>t in e?o(e,t,{enumerable:!0,configurable:!0,writable:!0,value:s}):e[t]=s;var i=(e,t,s)=>(n(e,typeof t!="symbol"?t+"":t,s),s);class r{constructor(t,s,a){i(this,"button");i(this,"isFavorited");i(this,"message");i(this,"span");this.button=t,this.button.addEventListener("click",this.toggleFavorite.bind(this)),this.isFavorited=s,this.updateButtonDataset(),a&&(this.message=a,this.span=this.button.querySelector("span"),this.updateText())}toggleFavorite(){this.disableButton(),fetch("../../src/php/favorite-part.php",{method:"POST",headers:{"Content-Type":"application/json;charset=utf-8"},body:JSON.stringify({eletronicPartId:Number(new URLSearchParams(window.location.search).get("eletronicPartId"))})}).then(t=>{if(t.status===200){const s=!this.isFavorited;this.setFavorite(s),this.enableButton(),this.updateButtonDataset(),this.updateText()}}).catch(t=>{this.enableButton(),console.log(t)})}enableButton(){this.button.disabled=!1,this.button.classList.remove("disabled")}disableButton(){this.button.disabled=!0,this.button.classList.add("disabled")}setFavorite(t){this.isFavorited=t}updateButtonDataset(){this.button.setAttribute("data-is-favorited",this.isFavorited.toString())}updateText(){!this.span||!this.message||(this.span.textContent=this.isFavorited?this.message.favorited:this.message.notFavorited)}}export{r as F};
//# sourceMappingURL=favorite-button.bdf40a1a.js.map