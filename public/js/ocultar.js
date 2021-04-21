/* Funcion para commitear los cambios al orden*/
$('.btn_ocultador').click(function () {
    let elemento = $(this)[0]
    let id = $(this)[0].value;
    let link = '/elemento/ocultar/' + id;
    ajax(link);
    elemento.disabled = true;
    setTimeout(function () {
        cambiaClase(elemento);
        elemento.disabled = false;
    }, 600)

});

function cambiaClase(elemento) {
    let fila = $(elemento).parent().parent();
    let icono = elemento.children[0];
    $(fila).toggleClass('texto_opaco')
    if ($(icono).hasClass("fa-eye")) {
        $(icono).removeClass("fa-eye")
        $(icono).addClass("fa-eye-slash")
    } else {
        $(icono).removeClass("fa-eye-slash")
        $(icono).addClass("fa-eye")
    }
}


function ajax(link) {
    let ok = true
    $.ajax({
        type: "POST",
        url: link,
    });
};
