let post_id = null
function remove(form) {
    var formData = new FormData(form);
    
    var submit_button = $(form).find("button[type='submit']")
    submit_button.prop("disabled", true)
    
    post_id = $(form).attr("data-id")
    
    $.ajax({
        url: "/dashboard/api/post/" + post_id,  // Laravel route to handle name change
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                text: "This post has been deleted successfully!",
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
    post_id = null
}
const postModal = new bootstrap.Modal('#approvePost', options)

function approve_api_post(id){
    post_id = id

    postModal.show()

}

$("#approvePost .approve-button").click(function(){
    const category = $("#approvePost select[name='category_id']").val()  
    var submit_button = $(this)
    submit_button.prop("disabled", true)

    $.ajax({
        url: "/dashboard/api/post/approve/" + post_id,  // Laravel route to handle name change
        method: 'POST',
        data: { category_id: category },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            Swal.fire({
                text: "This post has been approved successfully!",
                icon: "success"
            });
            postModal.hide()
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
})