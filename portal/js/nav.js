$(function($) {

    var query = location.search.slice(1);
    var partes = query.split('&');
    var data = {};
    let page = "";
    partes.forEach(function(parte) {
        var chaveValor = parte.split('=');
        var chave = chaveValor[0];
        var valor = chaveValor[1];
        data[chave] = valor;
    });
    console.log(page)
    if (data.pag == undefined) {
        page = "index"
    } else {
        page = data.pag;
    }

    if (data.pag == 'acess') {
        $("footer").css({
            "display": "none"
        })
    }
    console.log(page)
    $.ajax({
        url: './view/' + page + '.php',
        method: 'GET',
        beforeSend: function() {
            $('#loading').css("display", "flex")
                .fadeIn(500);
        },
        success: function(resp) {
            $('main').html(resp);
            $("main").css({
                "min-height": "auto"
            })
            $('#loading').css("display", "flex").fadeOut(500);
        }
    });

});