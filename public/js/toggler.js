$("document").ready(toggle);

// Este javascript selecciona los nodos que tienen la clase toggle y ponen/quitan la clase escondido
function toggle() {
    let elementos = $('.toggler');

    elementos.each(function () {
        let elemento = $(this);
        let tooltip = $(this).children().last()
        tooltip.hide()
        $(this).parent().click(function () {
            if (tooltip.is(':visible')) {
                tooltip.hide(600);
            } else {
                tooltip.show(600);
            }
        });
    });


}
