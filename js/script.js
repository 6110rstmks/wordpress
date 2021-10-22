$(function() {
    $("#plan-slick").slick({
        infinite: true,
        //↓一度にひょうじするスライドの数
        slidesToShow: 3,
        //↓一度にスクロールするスライドの数
        slidesToScroll: 3,
        //↓スライダーが自動で回る、そのスピード
        autoplay: true,
        autoplaySpeed: 5000,
        speed: 1000,
        //矢印を消す
        arrows: false,
        //↓この二つを指定することでセンターモード時のサイドパディングが設定される
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
                //↓これが原因で数字がでる
                // dots: true,
                }
            },
        ]
    });
});
//header > nav
$(function() {
    //できるだけidで指定してあげたい
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
