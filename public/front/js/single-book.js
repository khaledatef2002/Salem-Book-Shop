$("form#add-review-form").submit(function(e){
    e.preventDefault();

    var formData = new FormData(this);

    var form = $(this)

    var stars = parseInt(form.find("i[data-select]").attr("data-id") ?? 0)
    formData.append("review_star", stars)

    var submit_button = $(this).find("button[type='submit']")
    submit_button.prop("disabled", true)

    
    $.ajax({
        url: "/book/review",  // Laravel route to handle name change
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                text: "Your reviews has been sent successfully!",
                icon: "success"
            });
            submit_button.prop("disabled", false)
            form.find("textarea").val("")
            form.find("i.text-warning").removeClass('text-warning')
            form.find("i.fa-solid").removeClass('fa-solid')
            form.find("i:not(.fa-regular)").addClass('fa-regular')
            form.hide()
            $("#auth-review").html(response)
            $("#auth-review").show()
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

function delete_review(e, form, book_id)
{
    e.preventDefault();

    Swal.fire({
        title: "Do you really want to delete your review?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Delete",
        confirmButtonColor: "red",
    }).then((result) => {
        if (result.isConfirmed) {
            var formData = new FormData(form);
            formData.append('book_id', book_id)

            var submit_button = $(form).find("button[type='submit']")
            submit_button.prop("disabled", true)

            
            $.ajax({
                url: "/book/review/delete",  // Laravel route to handle name change
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        text: "Your reviews has been deleted successfully!",
                        icon: "success"
                    });
                    submit_button.prop("disabled", false)
                    $("#auth-review").hide()
                    $("#add-review-form").show()
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
    });
}

function edit_review(e, form, book_id)
{
    e.preventDefault();

    var submit_button = $(form).find("button[type='submit']")
    submit_button.prop("disabled", true)

    
    $.ajax({
        url: "/book/review/data?book_id=" + book_id,  // Laravel route to handle name change
        method: 'GET',
        success: function(response) {
            var data = JSON.parse(response)
            submit_button.prop("disabled", false)
            var selected = $(`#edit-review-form i[data-id='${data.review_star}']`)

            selected.parent().find("i").removeAttr("data-select")
            selected.attr("data-select", data.review_star)
            selected.parent().find("i").each((i, star) => {
                if (i < data.review_star) {
                    $(star).removeClass('fa-regular');
                    $(star).addClass('fa-solid');
                    $(star).addClass('text-warning');
        
                } else {
                    $(star).addClass('fa-regular');
                    $(star).removeClass('fa-solid');
                    $(star).removeClass('text-warning');
                }
            })

            $(`#edit-review-form textarea`).val(data.review_text)

            $("#auth-review").hide()
            $("#edit-review-form").show()
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

$("form#edit-review-form").submit(function(e){
    e.preventDefault();

    var formData = new FormData(this);

    var form = $(this)

    var stars = parseInt(form.find("i[data-select]").attr("data-id") ?? 0)
    formData.append("review_star", stars)

    var submit_button = $(this).find("button[type='submit']")
    submit_button.prop("disabled", true)

    
    $.ajax({
        url: "/book/editReview",  // Laravel route to handle name change
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                text: "Your reviews has been edited successfully!",
                icon: "success"
            });
            submit_button.prop("disabled", false)
            form.find("textarea").val("")
            form.find("i.text-warning").removeClass('text-warning')
            form.find("i.fa-solid").removeClass('fa-solid')
            form.find("i:not(.fa-regular)").addClass('fa-regular')
            form.hide()
            $("#auth-review").html(response)
            $("#auth-review").show()
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

$(".cancel_edit_review").click(function(){
    $(this).parent().parent().hide()
    $("#auth-review").show()
})

$(document).keydown(function (event) {
    if (event.keyCode == 123) {
        return false;
    } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) {      
        return false;
    }
});

$(document).on("contextmenu", function (e) {        
    e.preventDefault();
});

const pdfWorker = new Worker('/front/js/pdf-worker.js?id=2');

pdfWorker.onmessage = function(e) {
    const { status, blob, page, error } = e.data;

    if (status === 'success') {
        const url = URL.createObjectURL(blob);
        document.querySelector(`.page[data-page='${page}']`).innerHTML = `
            <img src="${url}">
        `;
        loaded_pages.push(Number(page));
        pending_pages.shift();
        is_loading = false;

        // Revoke the Blob URL after a short delay to free memory
        setTimeout(() => URL.revokeObjectURL(url), 1000);
    } else if (status === 'error') {
        console.error('Error:', error);
    }
};


var is_loading = false

const loaded_pages = []
const pending_pages = []

$(document).ready(function() {
    const body = $("#book-read .modal-body");

    var limit = (pages_count < 3) ? pages_count : 3

    for(var i = 1; i <= limit;i++)
    {
        pending_pages.push(i)
    }
});

function load_page(page)
{
    pdfWorker.postMessage({ csrf, book_id, page });
}

$('.modal-body').on('scroll', function() {

    var scroll = $("#book-read .modal-body").scrollTop()
    $('#book-read .modal-body .page').each(function() {
        var scrolled = $(this).offset().top - $("#book-read .modal-body").offset().top + $("#book-read .modal-body").scrollTop()
        if(scroll >= scrolled && scroll <= scrolled + $(this).height())
        {
            let page_number = Number($(this).attr("data-page"))

            $("#book-read .pages-navigator input").val(page_number)
            if(!loaded_pages.includes(page_number) && !pending_pages.includes(page_number))
            {
                pending_pages.push(page_number)
            }

            if(page_number + 1 <= pages_count && !loaded_pages.includes(page_number + 1) && !pending_pages.includes(page_number + 1))
            {
                pending_pages.push(page_number + 1)
            }

            if(page_number + 2 <= pages_count && !loaded_pages.includes(page_number + 2) && !pending_pages.includes(page_number + 2))
            {
                pending_pages.push(page_number + 2)
            }
        }
    
    })
});

$("#book-read .pages-navigator input").change(function(){
    var page_number = $(this).val()
    $('#book-read .modal-body').animate({
        scrollTop: $(`#book-read .page[data-page='${page_number}']`).offset().top - $("#book-read .modal-body").offset().top + $("#book-read .modal-body").scrollTop()
    }, 500);
})

setInterval(function(){
    if(pending_pages.length > 0 && is_loading == false)
    {
        var poper = pending_pages[0]
        if(loaded_pages.includes(poper))
        {
            pending_pages.shift()
        }
        else
        {
            is_loading = true
            load_page(poper)
        }
    }
}, 1000)

function request_unlock_book(button, id){
    button = $(button)
    button.prop("disabled", true)

    $.ajax({
        url: "/book/unlock/" + id,  // Laravel route to handle name change
        method: 'GET',
        success: function(response) {
            button.replaceWith(response)
        },
        error: function(xhr) {
            var error = xhr.responseJSON.message;
            Swal.fire({
                text: error,
                icon: "error"
            });
            button.prop("disabled", false)
        }
    });
}

function cancel_request_unlock_book(button, id){
    button = $(button)
    button.prop("disabled", true)

    $.ajax({
        url: "/book/unlock/cancel/" + id,  // Laravel route to handle name change
        method: 'GET',
        success: function(response) {
            button.parent().replaceWith(response)
        },
        error: function(xhr) {
            var error = xhr.responseJSON.message;
            Swal.fire({
                text: error,
                icon: "error"
            });
            button.prop("disabled", false)
        }
    });
}