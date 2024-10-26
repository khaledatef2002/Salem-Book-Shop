function attend_event(e, form, id)
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

            $("#auth-attendance").html(response)
            $("#event-info .counter").text(parseInt($("#event-info .counter").text()) + 1)
            $("#event-info #auth-attendance-info").show()

            $("#auth-attendance").show()
            $("#no-attendance-message").hide()
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

function unattend_event(e, form, id)
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
            $("#auth-attendance").hide()
            $("#event-info #auth-attendance-info").hide()
            $("#event-info .counter").text(parseInt($("#event-info .counter").text()) - 1)


            if(response == 0)
            {
                $("#no-attendance-message").show()
            }
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

$(".event-media-container").click(function(){
    var image = $(this).find("img").clone()
    
    $("#mediaZoom .image").html(image)

    const Modal = new bootstrap.Modal(document.getElementById('mediaZoom'))
    Modal.show()
})

$("form#add-review-form").submit(function(e){
    e.preventDefault();

    var formData = new FormData(this);

    var form = $(this)

    var stars = parseInt(form.find("i[data-select]").attr("data-id") ?? 0)
    formData.append("review_star", stars)

    var submit_button = $(this).find("button[type='submit']")
    submit_button.prop("disabled", true)

    
    $.ajax({
        url: "/event/review",  // Laravel route to handle name change
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

function delete_review(e, form, event_id)
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
            formData.append('seminar_id', event_id)

            var submit_button = $(form).find("button[type='submit']")
            submit_button.prop("disabled", true)

            
            $.ajax({
                url: "/event/review/delete",  // Laravel route to handle name change
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

function edit_review(e, form, seminar_id)
{
    e.preventDefault();

    var submit_button = $(form).find("button[type='submit']")
    submit_button.prop("disabled", true)

    
    $.ajax({
        url: "/event/review/data?seminar_id=" + seminar_id,  // Laravel route to handle name change
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
        url: "/event/editReview",  // Laravel route to handle name change
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