function remove(form) {
    var formData = new FormData(form);
    
    var submit_button = $(form).find("button[type='submit']")
    submit_button.prop("disabled", true)
    
    let article_id = $(form).attr("data-id")
    
    $.ajax({
        url: "/dashboard/articles/" + article_id,  // Laravel route to handle name change
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                text: "This article has been deleted successfully!",
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

$("#create-article-form").submit(function(e){
    e.preventDefault()

    $(this).find('textarea[name="content"]').val(ckEditor.getData())

    var formData = new FormData(this)

    images.forEach((item, index) => {
        formData.append(`images[${index}]`, item);
    });

    var submit_button = $(this).find("button[type='submit']")
    submit_button.prop("disabled", true)

    $.ajax({
        url: "/dashboard/articles",  // Laravel route to handle name change
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            window.location = response.redirectUrl
            images = []
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


$("#edit-article-form").submit(function(e){
    e.preventDefault()

    $(this).find('textarea[name="content"]').val(ckEditor.getData())

    var formData = new FormData(this)

    images.forEach((item, index) => {
        formData.append(`images[${index}]`, item);
    });

    var submit_button = $(this).find("button[type='submit']")
    submit_button.prop("disabled", true)

    let article_id = $(this).attr("data-id")

    $.ajax({
        url: "/dashboard/articles/" + article_id,  // Laravel route to handle name change
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                text: "Your changes has been saved successfully!",
                icon: "success"
            });
            images = []
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