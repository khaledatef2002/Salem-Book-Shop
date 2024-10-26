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

$(document).ready(function() {
    const body = $("#book-read .modal-body");

    $.ajax({
        url: `/books/${book_id}/read/1`,
        type: 'POST',
        data: { _token: csrf },
        xhrFields: {
            responseType: 'blob' // Ensure binary data is handled as a Blob
        },
        success: function(response) {
            if (response instanceof Blob) { // Check if response is a Blob
                const url = URL.createObjectURL(response);
                console.log(url);
                body.append(`
                    <iframe src="${url}#toolbar=0" style="width:100%;height:100%"></iframe>
                `);
                setTimeout(() => URL.revokeObjectURL(url), 1000);
            } else {
                console.error("Response is not a Blob");
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
});