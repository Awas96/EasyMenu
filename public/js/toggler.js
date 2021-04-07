$("document").ready(toggle);
// Este javascript selecciona los nodos que tienen la clase toggle y ponen/quitan la clase escondido
function toggle() {
    $(".toggler").each(function () {
        let objeto = $(this);
        $(this).parent().hover(function () {
            objeto.toggleClass("esconder");
        })
    })
}