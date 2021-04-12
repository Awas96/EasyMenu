$("document").ready(toggle);

// Este javascript selecciona los nodos que tienen la clase toggle y ponen/quitan la clase escondido
function toggle() {
    let elementos = $('.toggler');

    elementos.each(function (index) {
        let elemento = $(this);
        let trSpoiler = $('.spoiler')[index];
        elemento.parent().click(function () {
            if ($(trSpoiler))
                if ($(trSpoiler).is(':visible')) {
                    $(trSpoiler).parent().hide(600);
                    $(trSpoiler).hide(600);
                } else {
                    $(trSpoiler).parent().show(600);
                    $(trSpoiler).show(1000);
                }
        })
    });
}
