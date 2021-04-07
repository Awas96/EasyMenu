$("document").ready(toggle);
// Este javascript selecciona los nodos que tienen la clase toggle y ponen/quitan la clase escondido
function toggle() {
    $('[data-toggle="tooltip"]').tooltip()
    $(".toggler").each(function () {
        let objeto = $(this);
        $(this).parent().hover(function () {
            objeto.toggleClass("esconder");
        })
    })
}
