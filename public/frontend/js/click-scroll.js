//jquery-click-scroll
//by syamsul'isul' Arifin

$(document).ready(function(){
    var $navLinks = $('.navbar-nav .nav-item .nav-link.click-scroll');
    var header_height = $(".navbar").height();

    // Set initial active state
    $navLinks.addClass('inactive');    
    $navLinks.eq(0).addClass('active').removeClass('inactive');

    // Scroll event for active class
    $(document).scroll(function(){
        $navLinks.each(function(index) {
            var targetId = $(this).attr('href').split('#')[1];
            if (targetId) {
                var $targetSection = $('#' + targetId);
                if ($targetSection.length) {
                    var offsetSection = $targetSection.offset().top - header_height;
                    var docScroll = $(document).scrollTop();
                    var docScroll1 = docScroll + 1;
                    
                    if ( docScroll1 >= offsetSection ){
                        $navLinks.removeClass('active').addClass('inactive');
                        $(this).addClass('active').removeClass('inactive');
                    }
                }
            }
        });
    });
    
    // Click event for smooth scroll
    $navLinks.click(function(e){
        var targetId = $(this).attr('href').split('#')[1];
        if (targetId) {
            var $targetSection = $('#' + targetId);
            if ($targetSection.length) {
                var offsetClick = $targetSection.offset().top - header_height;
                e.preventDefault();
                $('html, body').animate({
                    'scrollTop':offsetClick
                }, 300);
            }
        }
    });
});