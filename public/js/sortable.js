$('.burbujas').sortable({
    stop: function (event, ui) {
        /*
                let element_dd = ui.item[0].querySelector('li').value,
                    position = ui.item.index(),
                    link = '/seccion/ordenar/' + element_dd;
                $.ajax({
                    type: "POST",
                    url: link,
                    data: {
                        'orden': position
                    },
                    success: function (result) {
                        console.log("yes!");
                    },
                    error: function (error) {
                        console.log("false");
                    }
                });
            */
    }
});
/* Funcion para commitear los cambios al orden*/
$('#aceptar').click(function () {
    let burbujas = document.querySelectorAll('li');
    burbujas.forEach(function (e, i) {
        link = '/seccion/ordenar/' + e.value;

        $.ajax({
            type: "POST",
            url: link,
            data: {
                'orden': i
            },
            success: function (result) {
                console.log("yes!");
            },
            error: function (error) {
                console.log("false");
            }
        });
    })
    alert('¡Cambios realizados!');

});