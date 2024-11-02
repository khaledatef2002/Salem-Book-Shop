$('.auto-image-show input[type="file"]').on('change', function() {
    var file = this.files[0];
    var input = $(this)
    if (file) {
        var reader = new FileReader();

        reader.onload = function(e) {
            input.closest(".auto-image-show").find("img").attr('src', e.target.result);
        }

        reader.readAsDataURL(file);
    }
});


// Change website logo
$("#website-logo-change-form input").on('change', function(){
    $(this).closest("form").submit()
})
$("#website-logo-change-form").submit(function(e){
    e.preventDefault()

    var formData = new FormData(this)
    
    var form = $(this)
    
    $.ajax({
        url: "settings/change-logo",  // Laravel route to handle name change
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                text: "Website logo has been changed successfully!",
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
        }
    });
})

// Change website banner
$("#website-banner-change-form input").on('change', function(){
    $(this).closest("form").submit()
})
$("#website-banner-change-form").submit(function(e){
    e.preventDefault()

    var formData = new FormData(this)
    
    var form = $(this)
    
    $.ajax({
        url: "settings/change-banner",  // Laravel route to handle name change
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                text: "Website banner has been changed successfully!",
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
        }
    });
})

// Change website settings
$("#website-settings-change-form").submit(function(e){
    e.preventDefault()

    var formData = new FormData(this)
    
    var form = $(this)

    var submit_button = $(this).find("button[type='submit']")
    submit_button.prop("disabled", true)
    
    $.ajax({
        url: "settings/change",  // Laravel route to handle name change
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                text: "Website settings has been changed successfully!",
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

// Remove Action
function remove_button(button){
    Swal.fire({
        title: "Do you really want to delete this person?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Delete",
        confirmButtonColor: "red",
    }).then((result) => {
        if (result.isConfirmed) {
            remove(button.closest("form"))
        }
    });
}