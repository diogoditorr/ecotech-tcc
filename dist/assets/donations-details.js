import{u as o}from"./utils.js";const t=document.querySelector("#page-donations-details .buttons .save"),a=document.querySelector("#page-donations-details .buttons .cancel-order"),s=document.querySelector("#page-donations-details input[name='orderId']"),n=document.querySelector("#page-donations-details select[id='status']");t.addEventListener("click",()=>{c(),fetch("../../src/php/order-edit.php",{method:"POST",body:o.toFormData({orderId:s.value,status:o.handleStatus(n.options[n.selectedIndex].value)})}).then(e=>e.json()).then(e=>{r(),console.log(e),alert("Status changed with success!")}).catch(e=>{console.error(e),alert("Something went wrong. Please try again later.")})});a.addEventListener("click",()=>{fetch("../../src/php/order-cancel.php",{method:"POST",body:o.toFormData({orderId:s.value})}).then(e=>e.json()).then(e=>{if(console.log(e),e.success)alert("Order canceled with success!"),window.location.href="./donations.php";else throw new Error}).catch(e=>{console.error(e),alert("Something went wrong. Please try again later.")})});function r(){t.classList.remove("disabled"),t.disabled=!1}function c(){t.classList.add("disabled"),t.disabled=!0}
//# sourceMappingURL=donations-details.js.map
