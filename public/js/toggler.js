$("document").ready(toggle);

// Este javascript selecciona los nodos que tienen la clase toggle y poner/quitan la clase escondido
function toggle() {
    let elementos = $('.toggler');

    elementos.each(function (index) {
        let elemento = $(this);
        let trSpoiler = $('.spoiler')[index];
        elemento.parent().click(function () {
            mover(trSpoiler);
            girar(this.querySelector("i"));
        })
    });
}

function mover(trSpoiler) {
    //Por el funcionamiento de symfony, hay que disponer de los elementos viuales
    //de tal manera que haya que esconder al padre y al elemento para mostrarlo.
    if ($(trSpoiler).is(':visible')) {
        $(trSpoiler).parent().hide(600);
        $(trSpoiler).hide(200);
    } else {
        $(trSpoiler).parent().show(600);
        $(trSpoiler).show(300);
    }
}

function girar(icono) {
    $(icono).toggleClass(function () {
        if ($(this).is(".cerrado")) {
            return "abierto";
        } else {
            return "cerrado";
        }
    })
}

