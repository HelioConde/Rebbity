
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

        $("#main").animate({
            'left': '260px'
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

        $("#main").animate({
            'left': '0px'
        })

        $("#shadownMobile").fadeOut();
        setTimeout(() => {
            $('nav').css({
                'display': 'none'
            })
            $("nav").removeAttr("style");
        }, 500);
        setTimeout(() => {
            navMobile = false;
        }, 600);
    }
})
