var query = location.search.slice(1);
var partes = query.split('&');
var data = {};
partes.forEach(function (parte) {
    var chaveValor = parte.split('=');
    var chave = chaveValor[0];
    var valor = chaveValor[1];
    data[chave] = valor;
});

if (data.erro == 'email') {
    $("#alert").css("display", "flex");
    $(".alertText").html('O E-mail já está em uso!');
} else if (data.erro == 'cnpj') {
    $("#alert").css("display", "flex");
    $(".alertText").html('O CNPJ já está em uso!');
}

$("#confirmBox").on('mouseup', function () {
    $("#alert").css("display", "none");
})

/*https://receitaws.com.br/v1/cnpj/14380200000121*/
let cnpj = false;
$("#cnpj").on('keyup', function () {
    $("#erro1").html('')
    if ($("#cnpj").val().length == 18) {
        if (cnpj == false) {
            $.ajax({
                type: 'JSON',
                url: 'https://receitaws.com.br/v1/cnpj/' + $("#cnpj").val().replace(/[^0-9]/g, ''),
                dataType: 'jsonp',
                success: function (data) {
                    console.log(data);
                    if (data.status == "OK") {
                        cnpj = true;
                        $("#corporateName").val(data.nome);

                        if (data.cep == "") {
                        } else {
                            $("#cep").val(data.cep);
                            cep();
                        }
                    } else {
                        $("#cnpj").focus()
                        $("#erro1").html('CNPJ inválido favor digite um CNPJ válido')
                    }
                }
            });
        }
    } else {
        cnpj = false;
    }
})

$("#cep").on('keyup', function () {
    if ($("#cep").val().length == 10) {
        cep();
    }
});
function cep() {
    $.ajax({
        type: 'GET',
        url: 'https://viacep.com.br/ws/' + $("#cep").val().replace(/[^0-9]/g, '') + '/json/',
        data: { get_param: 'value' },
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $("#city").val(data.localidade)
            $("#district").val(data.bairro)
            $("#state").val(data.uf).change();
            $("#address").val(data.logradouro);
        }
    });
}

$(function ($) {

    $('#cnpj').mask("00.000.000/0000-09");
    $('#cnpj').keyup(function (event) {
        if ($(this).val().length < 15) { // Celular com 9 dígitos + 2 dígitos DDD e 4 da máscara
            $(this).mask("000.000.000-000009");
        } else {
            $(this).mask("00.000.000/0000-09");
        }
    });

    $('#cpf').mask("000.000.000-09");
    $('#cpf').keyup(function (event) {
        $(this).mask("000.000.000-09");
    });
    
    $('#phone').mask('(00) 0000-00009');
    $('#phone').keyup(function (event) {
        if ($(this).val().length == 15) { // Celular com 9 dígitos + 2 dígitos DDD e 4 da máscara
            $(this).mask('(00) 00000-0009');
        } else {
            $(this).mask('(00) 0000-00009');
        }
    });

    $('#cep').mask("00.000-009");

});

$("form").submit(function (e) {
    let erro = 0;

    $("#erro1").html('');
    $("#erro2").html('');
    $("#erro3").html('');
    $("#erro4").html('');
    $("#erro5").html('');
    $("#erro6").html('');
    $("#erro7").html('');
    $("#erro8").html('');

    if ($("#cnpj").val() == '') {
        erro++;
        $("#cnpj").focus()
        $("#erro1").html('Por favor digite o seu CPF ou CNPJ')
    } else if ($("#corporateName").val() == '') {
        erro++;
        $("#corporateName").focus()
        $("#erro1").html('Por favor digite a sua Razão Social')
    } else if ($("#name").val() == '') {
        erro++;
        $("#corporateName").focus()
        $("#erro2").html('Por favor digite o seu Nome da loja')
    } else if ($("#phone").val() == '') {
        erro++;
        $("#phone").focus()
        $("#erro2").html('Por favor digite o seu número de Telefone da loja')
    } else if ($("#cep").val() == '') {
        erro++;
        $("#cep").focus()
        $("#erro3").html('Por favor digite o seu CEP')
    } else if ($("#city").val() == '') {
        erro++;
        $("#city").focus()
        $("#erro4").html('Por favor digite a sua Cidade')
    } else if ($("#district").val() == '') {
        erro++;
        $("#district").focus()
        $("#erro4").html('Por favor digite o seu Bairro')
    } else if ($("#address").val() == '') {
        erro++;
        $("#address").focus()
        $("#erro5").html('Por favor digite o seu Endereço')
    } else if ($("#number").val() == '') {
        erro++;
        $("#number").focus()
        $("#erro5").html('Por favor digite o seu Número')
    } else if ($("#email").val() == '') {
        erro++;
        $("#email").focus()
        $("#erro7").html('Por favor digite o seu E-mail')
    } else if ($("#email2").val() == '') {
        erro++;
        $("#email2").focus()
        $("#erro7").html('Por favor repita o seu E-mail')
    } else if ($("#email").val() != $("#email2").val()) {
        erro++;
        $("#email").focus()
        $("#erro7").html('Os E-mails não são iguais. tente novamente')
    } else if ($("#password").val() == '') {
        erro++;
        $("#password").focus()
        $("#erro8").html('Por favor digite a sua Senha')
    } else if ($("#password2").val() == '') {
        erro++;
        $("#password2").focus()
        $("#erro8").html('Por favor repita a sua Senha')
    } else if ($("#password").val() != $("#password2").val()) {
        erro++;
        $("#password").focus()
        $("#erro8").html('Os Senhas não são iguais. tente novamente')
    }

    if (erro == 0) {

    } else {
        e.preventDefault();
    }
});
