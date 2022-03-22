window.onload = function () {
    console.log('Onload disparado');

    let navMobile = false;

    $(".mobileBar").on('mouseup', function () {
        if (navMobile == false) {
            $('.bar').css({
                'display': 'flex'
            })

            $(".bar").animate({
                'left': '0px'
            })

            navMobile = true;
        } else {
            $(".bar").animate({
                'left': '-280px'
            })

            setTimeout(() => {
                $('.bar').css({
                    'display': 'none'
                })
                $(".bar").removeAttr("style");
            }, 500);
            setTimeout(() => {
                navMobile = false;
            }, 600);
        }
    })
}