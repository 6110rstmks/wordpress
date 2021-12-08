$(function() {
    $("#plan-slick").slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        autoplay: true,
        autoplaySpeed: 5000,
        speed: 1000,
        arrows: false,
        centerMode: true,
        centerPadding: "100px",
        responsive: [
            {
                breakpoint: 767,
                settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                centerMode: true,
                centerPadding: 0,
                infinite: true,
                }
            },
        ]
    });
});
//header > nav
$(function() {
    $("#nav-btn").on("click",function() {
        $(this).toggleClass("-active");
        $("#nav").toggleClass("-active");
    });
});
//FAQ
$(function() {
    $('.js-acordion').on('click',function() {
        $(this).toggleClass("-active");
        $(this).next().slideToggle();
    });
});

$(function() {
    new WOW().init();
});
