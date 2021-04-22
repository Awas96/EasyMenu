document.addEventListener("DOMContentLoaded", main);

function main() {
    cargarSecciones();

}


function cargarSecciones() {
    let link = "/secciones/datos"
    ajax(link, escribirSecciones)
}


function ajax(link, orden) {
    let ok = true
    $.ajax({
        type: "POST",
        url: link,
        success: function (texto) {
            orden(texto);
        }
    })
};


let escribirSecciones = (data) => {
    let ss = window.sessionStorage;
    /* Limpiamos session Storage por si el usuario recarga*/
    ss.clear();
    let div = document.querySelector('.data');
    div.innerHTML = "";
    let contenedor = document.createElement("form");
    contenedor.classList.add("formulario_elementos", "formulario_pdf", "texto_grande")
    /*Creacion de elementos con ajax*/
    data.forEach(function (e) {
        let tupla = document.createElement("div");
        let check = document.createElement("input");
        let label = document.createElement("label");
        let icono = document.createElement("i")
        let texto = document.createTextNode(e.nombre);
        check.type = "checkbox"
        check.id = "label_" + e.id;
        check.value = e.id;
        check.classList.add("form-check-input")
        label.htmlFor = "label_" + e.id;
        icono.classList.add("fas")
        icono.classList.add(e.icono)
        tupla.classList.add("formulario_elemento_unico")
        tupla.classList.add("form_element_style")
        label.appendChild(icono);
        label.appendChild(texto);
        tupla.appendChild(check);
        tupla.appendChild(label);
        tupla.classList.add()
        contenedor.appendChild(tupla)
    })
    div.appendChild(contenedor)

    /*creacion de boton para continuar*/
    let botonera = document.createElement("div");
    let boton = document.createElement("button");
    let icono = document.createElement("i");
    let texto = document.createTextNode("Seleccionar");

    icono.classList.add("fas", "fa-check")
    boton.appendChild(icono);
    boton.appendChild(texto);
    boton.classList.add("btn", "btn-success")
    botonEventos(boton);
    botonera.appendChild(boton);
    botonera.classList.add("botonera", "text-center", "mt-4")
    div.appendChild(botonera);


}

let botonEventos = (boton) => {
    boton.addEventListener("click", function () {
        this.disabled = true;
        let elementos = document.querySelectorAll("input:checked")
        elementos.forEach(function (e, i) {
            let link = "/carta/datos/" + e.attributes["value"].value
            ajax(link, escribirStorage)
        })
        setTimeout(function () {
            escribirListas();
        }, 1000);
    })
}

let escribirStorage = (data) => {
    let sessionStorage = window.sessionStorage
    sessionStorage.setItem("seccion_" + data[0].titulo, JSON.stringify(data));

}

let leerStorage = () => {
    var values = [],
        keys = Object.keys(sessionStorage),
        i = keys.length;
    //arreglar cosa para que solo coja los datos del storage si la key empieza por seccion o algo asi yo que se tio
    while (i--) {
        console.log(values)
        values.push(sessionStorage.getItem(keys[i]));
    }
    let arrSeccion = [];
    values.forEach((e) => {
        let objeto = JSON.parse(e);


    });
    return values;
}

let escribirListas = () => {
    let div = document.querySelector('.data');
    let sessionStorage = window.sessionStorage;
    div.innerHTML = "";
    let contenedor = document.createElement("div");
    leerStorage();
    let todas = sessionStorage.getItem('seccion_*')

    //Terminar cosa para que cargue los elementos y escriba todo en pdf o algo ykse

}