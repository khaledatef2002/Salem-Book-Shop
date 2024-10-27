$(document).ready(function(){

    $(".activity-carousel").owlCarousel({
        margin:30,
        loop:false,
        autoWidth:true,
        items: 4,
        autoWidth:false,
        nav: true,
        rtl: rtl,
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
    $(".book-carousel").owlCarousel({
        margin:30,
        loop:false,
        autoWidth:true,
        items: 1,
        autoWidth:false,
        nav: true,
        rtl: rtl,
    });

    $(".articles-carousel").owlCarousel({
        margin:30,
        loop:false,
        autoWidth:true,
        items: 3,
        autoWidth:false,
        nav: true,
        rtl: rtl,
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
        rtl: rtl,
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
        dots: true,
        rtl: rtl,
    });
    
    var navbar = $('.nav-container');
    var navbarOffset = navbar.offset()?.top ?? 0;

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

        if (!target.closest('.dropdown-menu').length) {
            $('.dropdown-menu').removeClass("show");
        }
    });
    $('.nav-item.dropdown').click(function (event) {
        event.stopPropagation(); 
    });

});
// List of books page filteration
function books_filters()
{
    var search = $(".search-bar input").val()
    var sort_by = $(".sort select").val()
    var limit = $(".limit select").val()

    var categories = [];
    $('input[name="category"]:checked').each(function() {
        categories.push($(this).val());
    });

    $(".books-container").html(`<div class="spinner-grow text-info d-block mx-auto mt-4" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>`)

    $.get('getAllBooksAjax', {search, sort_by, limit, categories}, function(response){
        $(".books-container").html(response)
    })
}

// Change general info ajax
$("form#general_info_form").submit(function(e){
    e.preventDefault();

    var formData = new FormData(this);
    
    var submit_button = $(this).find("button[type='submit']")
    submit_button.prop("disabled", true)

    $.ajax({
        url: "profile/general_info",  // Laravel route to handle name change
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                text: "Your general info has been changed successfully!",
                icon: "success"
            });
            submit_button.prop("disabled", false)
        },
        error: function(xhr) {
            var errors = xhr.responseJSON.errors;
            console.log(errors)
            var firstKey = Object.keys(errors)[0];
            Swal.fire({
                text: errors[firstKey][0],
                icon: "error"
            });
            submit_button.prop("disabled", false)
        }
    });
})

// Change password ajax
$("form#password_form").submit(function(e){
    e.preventDefault();

    var form = $(this)
    var formData = new FormData(this);
    
    var submit_button = $(this).find("button[type='submit']")
    submit_button.prop("disabled", true)

    $.ajax({
        url: "profile/update_password",  // Laravel route to handle name change
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                text: "Your general info has been changed successfully!",
                icon: "success"
            });
            form.find("input").val("")
            submit_button.prop("disabled", false)
        },
        error: function(xhr) {
            var errors = xhr.responseJSON.errors;
            var firstKey = Object.keys(errors)[0];
            Swal.fire({
                text: errors[firstKey][0],
                icon: "error"
            });
            submit_button.prop("disabled", false)
        }
    });
})

// Login Ajax
$("form#login-form").submit(function(e){
    e.preventDefault();

    var form = $(this)
    var formData = new FormData(this);
    
    var submit_button = $(this).find("button[type='submit']")
    submit_button.prop("disabled", true)

    $.ajax({
        url: "login",  // Laravel route to handle name change
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            location.reload();
        },
        error: function(xhr) {
            var errors = xhr.responseJSON.errors;
            var firstKey = Object.keys(errors)[0];
            Swal.fire({
                text: errors[firstKey][0],
                icon: "error"
            });
            submit_button.prop("disabled", false)
        }
    });
})

// Register ajax
$("form#register-form").submit(function(e){
    e.preventDefault();

    var form = $(this)
    var formData = new FormData(this);
    
    var submit_button = $(this).find("button[type='submit']")
    submit_button.prop("disabled", true)

    $.ajax({
        url: "register",  // Laravel route to handle name change
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            location.href = 'profile';
        },
        error: function(xhr) {
            var errors = xhr.responseJSON.errors;
            var firstKey = Object.keys(errors)[0];
            Swal.fire({
                text: errors[firstKey][0],
                icon: "error"
            });
            submit_button.prop("disabled", false)
        }
    });
})

// Contact form
$("form#contact-form").submit(function(e){
    e.preventDefault();

    var formData = new FormData(this);
    
    var form = $(this)

    var submit_button = $(this).find("button[type='submit']")
    submit_button.prop("disabled", true)

    
    $.ajax({
        url: "contact",  // Laravel route to handle name change
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                text: "Your Message has been sent successfully!",
                icon: "success"
            });
            submit_button.prop("disabled", false)
            form.find("textarea").val("")
        },
        error: function(xhr) {
            var errors = xhr.responseJSON.errors;
            var firstKey = Object.keys(errors)[0];
            Swal.fire({
                text: errors[firstKey][0],
                icon: "error"
            });
            submit_button.prop("disabled", false)
        }
    });
})

// Displaying image after select
$('.image-upload input').on('change', function() {
    var file = this.files[0];
    var input = $(this)
    if (file) {
        var reader = new FileReader();

        reader.onload = function(e) {
            input.parent().find("img").attr('src', e.target.result);
        }

        reader.readAsDataURL(file);
    }
});

// Password eye handler
$("div:has( > input[type='password']) i").click(function(){
    var icon = $(this)
    var input = $(this).parent().find("input")
    if(input.attr("type") == 'password')
    {
        input.attr("type", "text")
        icon.addClass('fa-eye-slash')
        icon.removeClass('fa-eye')
    }
    else
    {
        input.attr("type", "password")
        icon.addClass('fa-eye')
        icon.removeClass('fa-eye-slash')
    }
})

// List of all quotes filers
function quotes_filters()
{
    var search = $(".search-bar input").val()
    var sort_by = $(".sort select").val()
    var limit = $(".limit select").val()


    $(".quotes-container").html(`<div class="spinner-grow text-info d-block mx-auto mt-4" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>`)

    $.get('getAllQuotesAjax', {search, sort_by, limit}, function(response){
        $(".quotes-container").html(response)
    })
}

// Like Quote
$("button.like-quote").click(function(e){

    var button = $(this)
    var id = button.attr("data-quote-id")
    var _token = button.parent().find("input[name='_token']").val()
    button.prop("disabled", true)

    $.ajax({
        url: "quotes/like",  // Laravel route to handle name change
        method: 'POST',
        data: {id, _token},
        success: function(response) {
            console.log(response)
            var data = JSON.parse(response)
            if(data.state.toLowerCase() == "liked")
            {
                button.removeClass("btn-outline-primary")
                button.addClass("btn-primary")
            }
            else
            {
                button.removeClass("btn-primary")
                button.addClass("btn-outline-primary")
            }
            button.parent().find("span.count").text(data.likes_count)
            button.parent().find("span.text").text(data.state)
            button.prop("disabled", false)
        },
        error: function(xhr) {
            var errors = xhr.responseJSON.errors;
            var firstKey = Object.keys(errors)[0];
            Swal.fire({
                text: errors[firstKey][0],
                icon: "error"
            });
            button.prop("disabled", false)
        }
    });
})

$(".review-form i").mouseover(function(){
    var index = parseInt($(this).attr("data-id"))
    $(this).parent().find("i").each((i, star) => {
        console.log(i)
        if (i < index) {
            $(star).addClass('text-warning');
        } else {
            if(!$(star).hasClass('fa-solid'))
            {
                $(star).removeClass('text-warning');
            }
        }
    })
})
$(".review-form i").mouseout(function(){
    console.log("yes")
    $(".review-form i.text-warning:not(.fa-solid)").removeClass('text-warning');
})

$(".review-form i").click(function(){
    var index = parseInt($(this).attr("data-id"))
    if($(this).attr("data-select") == index)
    {
        $(this).parent().find("i").removeAttr("data-select")
        $(this).parent().find("i").addClass('fa-regular');
        $(this).parent().find("i").removeClass('fa-solid');
        $(this).parent().find("i").removeClass('text-warning');
    }
    else
    {
        $(this).parent().find("i").removeAttr("data-select")
        $(this).attr("data-select", index)
        $(this).parent().find("i").each((i, star) => {
            console.log(i)
            if (i < index) {
                $(star).removeClass('fa-regular');
                $(star).addClass('fa-solid');
                $(star).addClass('text-warning');
    
            } else {
                $(star).addClass('fa-regular');
                $(star).removeClass('fa-solid');
                $(star).removeClass('text-warning');
            }
        })
    }
})

function main_attend_event(e, form, id)
{
    e.preventDefault();

    var formData = new FormData(form);
    formData.append('event_id', id)

    var form = $(form)

    var submit_button = $(this).find("button[type='submit']")
    submit_button.prop("disabled", true)

    
    $.ajax({
        url: "/event/auth/attend",  // Laravel route to handle name change
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                text: "You have attended the event",
                icon: "success"
            });
            submit_button.prop("disabled", false)
            form.hide()
            $("#unattend-form").show()
        },
        error: function(xhr) {
            var errors = xhr.responseJSON.errors;
            var firstKey = Object.keys(errors)[0];
            Swal.fire({
                text: errors[firstKey][0],
                icon: "error"
            });
            submit_button.prop("disabled", false)
        }
    });
}

function main_unattend_event(e, form, id)
{
    e.preventDefault();

    var formData = new FormData(form);
    formData.append('event_id', id)

    var form = $(form)

    var submit_button = $(this).find("button[type='submit']")
    submit_button.prop("disabled", true)

    
    $.ajax({
        url: "/event/auth/unAttend",  // Laravel route to handle name change
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                text: "You have unattended the event",
                icon: "success"
            });
            submit_button.prop("disabled", false)
            form.hide()
            $("#attend-form").show()
        },
        error: function(xhr) {
            var errors = xhr.responseJSON.errors;
            var firstKey = Object.keys(errors)[0];
            Swal.fire({
                text: errors[firstKey][0],
                icon: "error"
            });
            submit_button.prop("disabled", false)
        }
    });
}

function articles_filter()
{
    var search = $(".search-bar input").val()
    var sort_by = $(".sort select").val()
    var limit = $(".limit select").val()

    var categories = [];
    $('input[name="category"]:checked').each(function() {
        categories.push($(this).val());
    });

    $(".articles-container").html(`<div class="spinner-grow text-info d-block mx-auto mt-4" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>`)

    $.get('getAllArticlesAjax', {search, sort_by, limit, categories}, function(response){
        $(".articles-container").html(response)
    })
}

$(".auth-to-like").click(function(){
    Swal.fire({
        text: 'Please login to be able to react',
        icon: 'error',
        confirmButtonColor: "#00101f",
    })
})

$(".auth-to-comment").click(function(){
    Swal.fire({
        text: 'Please login to be able to comment',
        icon: 'error',
        confirmButtonColor: "#00101f",
    })
})

// Like Quote
$("button.like-article").click(function(e){

    var button = $(this)
    var id = button.attr("data-article-id")
    var _token = button.parent().find("input[name='_token']").val()
    button.prop("disabled", true)

    $.ajax({
        url: "/article/like",  // Laravel route to handle name change
        method: 'POST',
        data: {id, _token},
        success: function(response) {
            console.log(response)
            var data = JSON.parse(response)
            if(data.state.toLowerCase() == "liked")
            {
                button.removeClass("btn-outline-primary")
                button.addClass("btn-primary")
            }
            else
            {
                button.removeClass("btn-primary")
                button.addClass("btn-outline-primary")
            }
            button.find("span.count").text(data.likes_count)
            button.find("span.text").text(data.state)
            button.prop("disabled", false)
        },
        error: function(xhr) {
            var errors = xhr.responseJSON.errors;
            var firstKey = Object.keys(errors)[0];
            Swal.fire({
                text: errors[firstKey][0],
                icon: "error"
            });
            button.prop("disabled", false)
        }
    });
})