document.addEventListener("DOMContentLoaded", cargarSecciones);

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

// primera parte de la inrfaz para seleccionar los elementos a mostrar
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
        let texto = document.createTextNode(" " + e.nombre);
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
    let texto = document.createTextNode("  Seleccionar");

    icono.classList.add("fas", "fa-check");
    boton.appendChild(icono);
    boton.appendChild(texto);
    boton.classList.add("btn", "btn-success");
    botonEventos(boton);
    botonera.appendChild(boton);
    botonera.classList.add("botones", "text-center", "mt-4")
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
        animaBoton(this);
        setTimeout(function () {
            escribirListas();
        }, 1500);
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
        values.push(sessionStorage.getItem(keys[i]));
    }
    let arrSeccion = [];
    values.forEach((e) => {

        arrSeccion.push(JSON.parse(e))
    });
    return arrSeccion;
}

//segunda parte de la intefaz una vez ya estan seleccionados las secciones
let escribirListas = () => {
    let div = document.querySelector('.data');
    let divListas = document.createElement('div');
    divListas.classList.add("formulario_lista_spans")
    let sessionStorage = window.sessionStorage;
    div.innerHTML = "";
    let contenedor = document.createElement("div");
    let titulo = document.createElement("p");
    titulo.classList.add("texto_grande", "text-center", "mb-4");
    titulo.innerText = "Se creará una carta con los siguientes elementos..."
    div.appendChild(titulo)
    let carta = leerStorage();
    carta.forEach((e) => {
        let divlista = document.createElement('div');
        divlista.classList.add("formulario_lista_individual")

        let lista = document.createElement('ol');
        e.forEach(function (elemento) {
            let elementoLista = document.createElement('li');
            let span1 = document.createElement('span');
            let span2 = document.createElement('span');

            if (elemento.tipo === "seccion") {
                let icono = document.createElement('i')
                icono.classList.add("fas", elemento.icono);
                divlista.classList.add("order-" + elemento.ordenSec);
                span1.appendChild(icono);
                span2.innerText = " " + elemento.titulo;

                elementoLista.classList.add("texto_grande", "mb-1");
            } else {
                span1.innerText = elemento.nombre;
                span2.innerText = elemento.precio;
                elementoLista.classList.add("formulario_lista_elemento")
            }

            elementoLista.value = elemento.id;

            elementoLista.appendChild(span1);
            if (!e[0].titulo.includes("Tapas")) {
                elementoLista.appendChild(span2);
            } else {
                if (elemento.tipo == "seccion") elementoLista.appendChild(span2)
            }
            lista.appendChild(elementoLista);

        });
        divlista.appendChild(lista);
        divListas.appendChild(divlista);
        div.appendChild(divListas);


    })
    //creacion de botones de esta interfaz
    let divbotones = document.createElement("div");
    divbotones.classList.add("botones");
    //Creacion de boton para volver al principio
    let btnCancelar = document.createElement("button");
    btnCancelar.addEventListener("click", cargarSecciones);
    btnCancelar.classList.add("btn", "btn-danger");
    let iconoCancelar = document.createElement("i");
    iconoCancelar.classList.add("fas", "fa-arrow-left");
    let spanCancelar = document.createElement("span")
    spanCancelar.innerText = " cancelar"
    btnCancelar.appendChild(iconoCancelar)
    btnCancelar.appendChild(spanCancelar)
    //creacion de boton para submitear
    let btnImprimir = document.createElement("button");
    btnImprimir.addEventListener("click", cargarSecciones);
    btnImprimir.classList.add("btn", "btn-success");
    let iconoImprimir = document.createElement("i");
    iconoImprimir.classList.add("fas", "fa-check");
    let spanImprimir = document.createElement("span")
    spanImprimir.innerText = " Aceptar"
    btnImprimir.appendChild(iconoImprimir)
    btnImprimir.appendChild(spanImprimir)

    divbotones.appendChild(btnCancelar)
    divbotones.appendChild(btnImprimir)
    div.appendChild(divbotones);
}

let animaBoton = (e) => {
    e.childNodes[0].classList.remove("fa-check");
    e.childNodes[0].classList.add("fa-spinner", "fa-spin");
}