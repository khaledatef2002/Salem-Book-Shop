function remove(form) {
    var formData = new FormData(form);
    
    var submit_button = $(form).find("button[type='submit']")
    submit_button.prop("disabled", true)
    
    let book_id = $(form).attr("data-id")
    
    $.ajax({
        url: "/dashboard/books/" + book_id,  // Laravel route to handle name change
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                text: "This book has been deleted successfully!",
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

$("#create-book-form").submit(function(e){
    e.preventDefault()

    var formData = new FormData(this)
    uploaded_temp.forEach((item, index) => {
        formData.append(`images[${index}]`, item);
    });
    var submit_button = $(this).find("button[type='submit']")
    submit_button.prop("disabled", true)

    $.ajax({
        url: "/dashboard/books",  // Laravel route to handle name change
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            window.location = response.redirectUrl
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

$("#edit-book-form").submit(function(e){
    e.preventDefault()

    var formData = new FormData(this)

    uploaded_temp.forEach((item, index) => {
        formData.append(`upload_images[${index}]`, item);
    });

    deletedImages.forEach((item, index) => {
        formData.append(`delete_images[${index}]`, item);
    });

    var submit_button = $(this).find("button[type='submit']")
    submit_button.prop("disabled", true)

    var book_id = $(this).attr("data-id")

    $.ajax({
        url: "/dashboard/books/" + book_id,  // Laravel route to handle name change
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                text: "Your edits has been saved successfully!",
                icon: "success"
            });
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