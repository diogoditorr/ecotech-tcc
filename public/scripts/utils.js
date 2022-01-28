function toFormData(data) {
    const formData = new FormData();

    for (let key in data) {
        formData.append(key, data[key]);
    }

    return formData;
}

function handleStatus(status) {
    switch (status) {
        case "pending":
            return "pendente";
        case "delivered":
            return "entregue";
        case "cancelled":
            return "cancelado";
        default:
            return "pendente";
    }
}

export default {
    toFormData,
    handleStatus,
};
