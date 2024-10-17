$(document).ready(function(){

    $(".activity-carousel").owlCarousel({
        margin:30,
        loop:false,
        autoWidth:true,
        items: 4,
        autoWidth:false,
        nav: true,
        responsive:{
            0:{
                items:1,
            },
            550:{
                items:2,
            },
            992:{
                items:3,
            },
            1200:{
                items:4,
            }
        }
    });

    $(".articles-carousel").owlCarousel({
        margin:30,
        loop:false,
        autoWidth:true,
        items: 3,
        autoWidth:false,
        nav: true,
        responsive:{
            0:{
                items:1,
            },
            550:{
                items:2,
            },
            992:{
                items:3,
            }
        }
    });

    $(".blogs-carousel").owlCarousel({
        margin:30,
        loop:false,
        autoWidth:true,
        items: 3,
        autoWidth:false,
        nav: true,
        responsive:{
            0:{
                items:1,
            },
            550:{
                items:2,
            },
            992:{
                items:3,
            }
        }
    });

    $(".quotes-carousel").owlCarousel({
        margin:30,
        loop:false,
        autoWidth:true,
        items: 1,
        autoWidth:false,
        nav: true,
        dots: true
    });
    
    var navbar = $('.nav-container');
    var navbarOffset = navbar.offset().top;

    $(window).on('scroll', function () {
        if ($(window).scrollTop() > navbarOffset) {
            navbar.addClass('floating-nav');
        } else {
            navbar.removeClass('floating-nav');
        }

        $('.dropdown-menu').removeClass("show");
    });

    $(".nav-item.dropdown").click(function(){
        var menu = $(this).find(".dropdown-menu")
        if(menu.hasClass("show"))
        {
            menu.removeClass("show")
        }
        else
        {
            menu.addClass("show")
        }
    })

    $(document).click(function (event) {
        var target = $(event.target);

        // Check if the clicked element is not the menu or a descendant of the menu
        if (!target.closest('.dropdown-menu').length) {
            $('.dropdown-menu').removeClass("show");  // Hide the menu
        }
    });
    $('.nav-item.dropdown').click(function (event) {
        event.stopPropagation();  // Stop the event from bubbling up to the document
    });
});