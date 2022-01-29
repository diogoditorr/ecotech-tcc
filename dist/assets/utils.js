function r(e){const n=new FormData;for(let t in e)n.append(t,e[t]);return n}function a(e){switch(e){case"pending":return"pendente";case"delivered":return"entregue";case"cancelled":return"cancelado";default:return"pendente"}}var u={toFormData:r,handleStatus:a};export{u};
//# sourceMappingURL=utils.js.map
