$('.sortable').sortable({
    /* stop: function (event, ui) {

                 let element_dd = ui.item[0].querySelector('li').value,
                     position = ui.item.index(),
                     link = '/seccion/ordenar/' + element_dd;
                 $.ajax({
                     type: "POST",
                     url: link,
                     data: {
                         'orden': position
                     },

                 });

    } */
});
/* Funcion para commitear los cambios al orden*/
$('#aceptarSeccion').click(function () {
    let elementos = document.querySelectorAll('li');
    elementos.forEach(function (e, i) {
        link = '/seccion/ordenar/' + e.value;
        ajax(link, i);
    });
    alert('¡Cambios realizados!');

});

$('#aceptarElemento').click(function () {

    let elemento = document.querySelectorAll('tr.tabla_fila');
    elemento.forEach(function (e, i) {
        link = '/elemento/AJAX/' + e.attributes['value'].value;
        ajax(link, i);
    });
    alert('¡Cambios realizados!');
});

function ajax(link, orden) {
    let ok = true
    $.ajax({
        type: "POST",
        url: link,
        data: {
            'orden': orden
        },
    });

};
