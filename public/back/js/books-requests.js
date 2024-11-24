function remove(form) {
    var formData = new FormData(form);
    
    var submit_button = $(form).find("button[type='submit']")
    submit_button.prop("disabled", true)
    
    let request_id = $(form).attr("data-id")
    
    $.ajax({
        url: "books-requests/" + request_id,
        method: 'POST', 
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                text: "This request has been deleted successfully!",
                icon: "success"
            });
            submit_button.prop("disabled", false)
            table.ajax.reload(null, false)
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

function cancel_book_request(button) {
    console.log(button)
    var submit_button = $(button)
    submit_button.prop("disabled", true)
    
    let request_id = submit_button.parent().attr("data-id")

    var formData = new FormData(submit_button.parent().get(0));

    $.ajax({
        url: "books-requests/cancel/" + request_id,
        method: 'POST', 
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            Swal.fire({
                text: "This request has been canceled successfully!",
                icon: "success"
            });
            submit_button.prop("disabled", false)
            table.ajax.reload(null, false)
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

function accept_book_request(button) {
    var submit_button = $(button)
    submit_button.prop("disabled", true)
    
    let request_id = submit_button.parent().attr("data-id")

    var formData = new FormData(submit_button.parent().get(0));

    $.ajax({
        url: "books-requests/accept/" + request_id,
        method: 'POST', 
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            Swal.fire({
                text: "This request has been accepted successfully!",
                icon: "success"
            });
            submit_button.prop("disabled", false)
            table.ajax.reload(null, false)
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