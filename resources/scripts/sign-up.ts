function populateUFs() {
    const ufSelect =
        document.querySelector("select[name=uf]") as HTMLSelectElement;

    fetch("https://servicodados.ibge.gov.br/api/v1/localidades/estados")
        .then((response) => response.json())
        .then((states: Array<any>) => {
            states.forEach((state) => {
                ufSelect.innerHTML += `<option value="${state.id}">${state.nome}</option>`;
            });
        });
}

populateUFs();

function getCities(event: Event) {
    // type event.target = HTMLSelectElement;
    // define property event.target type to HTMLSelectElement in typescript


    const citySelect = document.querySelector("select[name=city]") as HTMLSelectElement;
    const stateInput = document.querySelector("input[name=state]") as HTMLInputElement;

    const ufValue = (event.target as HTMLSelectElement).value;

    const indexOfSelectedState = (event.target as HTMLSelectElement).selectedIndex;
    stateInput.value = (event.target as HTMLSelectElement).options[indexOfSelectedState].text;

    const url = `https://servicodados.ibge.gov.br/api/v1/localidades/estados/${ufValue}/municipios`;

    citySelect.innerHTML = "<option value>Selecione a Cidade</option>";
    citySelect.disabled = true;

    fetch(url)
        .then((response) => response.json())
        .then((cities) => {
            for (const city of cities) {
                citySelect.innerHTML += `<option value="${city.nome}">${city.nome}</option>`;
            }

            citySelect.disabled = false;
        });
}

(document.querySelector("select[name=uf]") as HTMLSelectElement).addEventListener("change", getCities);
