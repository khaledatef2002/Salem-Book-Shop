$("form#add-comment-form").submit(function(e){
    e.preventDefault();

    var formData = new FormData(this);

    var form = $(this)

    var submit_button = $(this).find("button[type='submit']")
    submit_button.prop("disabled", true)

    
    $.ajax({
        url: "/article/comment/add",  // Laravel route to handle name change
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                text: "Your comment has been sent successfully!",
                icon: "success"
            });
            submit_button.prop("disabled", false)
            form.find("textarea").val("")
            $(".comment-list ul").html(response)
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

function delete_review(e, form, comment_id)
{
    e.preventDefault();

    Swal.fire({
        title: "Do you really want to delete your comment?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Delete",
        confirmButtonColor: "red",
    }).then((result) => {
        if (result.isConfirmed) {
            var formData = new FormData(form);
            formData.append('comment_id', comment_id)

            var submit_button = $(form).find("button[type='submit']")
            submit_button.prop("disabled", true)

            
            $.ajax({
                url: "/article/comment/delete",  // Laravel route to handle name change
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        text: "Your comment has been deleted successfully!",
                        icon: "success"
                    });
                    submit_button.prop("disabled", false)
                    submit_button.parent().parent().parent().parent().parent().parent().remove()
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

function edit_comment(button)
{
    $(".edit-comment-form").hide()
    $(".actions").show()
    $(".comment").show()


    var button = $(button)
    var comment = button.parent().parent().parent().find(".comment").text()
    button.parent().parent().parent().find(".edit-comment-form textarea").val(comment)
    button.parent().parent().parent().find(".edit-comment-form").show()
    button.parent().parent().parent().find(".actions").hide()
    button.parent().parent().parent().find(".comment").hide()
}

$(".cancel-edit-button").click(function(){
    var button = $(this)
    button.parent().parent().hide()
    button.parent().parent().parent().find(".actions").show()
    button.parent().parent().parent().find(".comment").show()
})

$(".edit-comment-form").submit(function(e){
    e.preventDefault();

    var formData = new FormData(this);

    var form = $(this)

    var submit_button = $(this).find("button[type='submit']")
    submit_button.prop("disabled", true)

    
    $.ajax({
        url: "/article/comment/edit",  // Laravel route to handle name change
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                text: "Your comment has been edited successfully!",
                icon: "success"
            });
            submit_button.prop("disabled", false)
            
            form.hide()
            form.parent().find(".actions").show()
            form.parent().find(".comment").text(response)
            form.parent().find(".comment").show()
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

$(".open-article-comment").click(function(){
    $('html, body').animate({
        scrollTop: $("#comments").offset().top
    }, 800); // 800ms for smooth scroll
})