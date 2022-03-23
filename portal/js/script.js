window.onload = function () {
    console.log('Onload disparado');

    let navMobile = false;

    $("#showMobile").on('mouseup', function () {
        if (navMobile == false) {
            $('nav').css({
                'display': 'flex'
            })
            $("nav").animate({
                'left': '0px'
            })
            $("#mobileBar").animate({
                'left': '280px'
            })
            $("#shadownMobile").fadeIn()

            navMobile = true;
        } else {
            $("nav").animate({
                'left': '-280px'
            })
            $("#mobileBar").animate({
                'left': '0px'
            }, 500)
            $("#shadownMobile").fadeOut();
            setTimeout(() => {
                $('nav').css({
                    'display': 'none'
                })
            }, 500);
            setTimeout(() => {
                navMobile = false;
            }, 600);
        }
    })
}