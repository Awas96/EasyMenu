document.addEventListener("DOMContentLoaded", main);

function main() {
    let btnSave = document.querySelector("#elemento_save");
    let btnSaveAndAdd = document.querySelector("#elemento_saveAndAdd");
    let iconito = document.createElement("i");
    let iconito21 = document.createElement("i");
    let iconito22 = document.createElement("i");
    iconito.classList.add("fas",  "fa-save");
    btnSave.appendChild(iconito);
    iconito21.classList.add("fas", "fa-save", "fa-arrow-right", "mr-1");
    iconito22.classList.add("fas", "fa-arrow-right");
    btnSaveAndAdd.appendChild(iconito21);

    btnSaveAndAdd.appendChild(iconito22);
}