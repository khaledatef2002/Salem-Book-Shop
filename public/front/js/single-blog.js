function like_action(button){

    var button = $(button)
    var id = button.attr("data-blog-id")
    var _token = button.parent().find("input[name='_token']").val()
    button.prop("disabled", true)

    $.ajax({
        url: "/blog/like",  // Laravel route to handle name change
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
}

$("a.comment_button").click(function(e){
    e.preventDefault();
    $('html, body').animate({
        scrollTop: $("#comments").offset().top
    }, 800); // 800ms for smooth scroll
})

function delete_blog(e, form, blog_id)
{
    e.preventDefault();

    Swal.fire({
        title: "Do you really want to delete your blog?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Delete",
        confirmButtonColor: "red",
    }).then((result) => {
        if (result.isConfirmed) {
            var formData = new FormData(form);
            formData.append('return', 'all-blogs')
            var submit_button = $(form).find("button[type='submit']")
            submit_button.prop("disabled", true)

            
            $.ajax({
                url: "/blog/" + blog_id,  // Laravel route to handle name change
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        text: "Your blog has been deleted successfully!",
                        icon: "success"
                    });
                    submit_button.prop("disabled", false)
                    $("#blog-info").replaceWith(response)
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

let EditEditor;
ClassicEditor.create(document.querySelector('#editBlog .ckEditor'), {
    toolbar: ['bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'imageUpload'],
    ckfinder: {
        uploadUrl: 'ckEditorUploadImage?command=QuickUpload&type=Images&responseType=json'
    }
}).then(editor => {
    EditEditor = editor;
    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
        return {
            upload: () => {
                return loader.file
                    .then(file => new Promise((resolve, reject) => {
                        const formData = new FormData();
                        formData.append('upload', file);

                        fetch('ckEditorUploadImage', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => resolve({ default: data.url }))
                        .catch(error => reject(error));
                    }));
            }
        };
    };
})
.catch(error => {
    console.error(error);
});

let blogEdit
var editModal = new bootstrap.Modal(document.getElementById('editBlog'))

function edit_blog(e, button, blog)
{
    e.preventDefault()

    blogEdit = $(button).parent().parent().parent().parent().parent()

    var submit_button = $(button)
    submit_button.prop("disabled", true)

    $.ajax({
        url: `/blog/${blog}/edit`,  // Laravel route to handle name change
        method: 'GET',
        success: function(response) {
            var data = JSON.parse(response)
            submit_button.prop("disabled", false)
            EditEditor.setData(data.content);
            $("#edit-blog-form input[name='blog_id']").val(blog)
            editModal.show()
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

$("#edit-blog-form").submit(function(e){
    e.preventDefault()

    var formData = new FormData(this);

    var submit_button = $(this).find("button[type='submit']")
    submit_button.prop("disabled", true)

    $.ajax({
        url: "/blog/" + formData.get('blog_id'),  // Laravel route to handle name change
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                text: "Your edites has been saved successfully!",
                icon: "success"
            });
            submit_button.prop("disabled", false)
            EditEditor.setData('');
            blogEdit.replaceWith(response)
            editModal.hide()
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

$("form#add-comment-form").submit(function(e){
    e.preventDefault();

    var formData = new FormData(this);

    var form = $(this)

    var submit_button = $(this).find("button[type='submit']")
    submit_button.prop("disabled", true)

    
    $.ajax({
        url: "/blog/comment/add",  // Laravel route to handle name change
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

function delete_comment(e, form, comment_id)
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
                url: "/blog/comment/delete",  // Laravel route to handle name change
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
        url: "/blog/comment/edit",  // Laravel route to handle name change
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