var modal = new bootstrap.Modal(document.getElementById('addBookCategoryModal'))

$("#add-book-category-form").submit(function(e){
    e.preventDefault()

    var formData = new FormData(this)
    
    var submit_button = $(this).find("button[type='submit']")
    submit_button.prop("disabled", true)

    $.ajax({
        url: "/dashboard/books-category",  // Laravel route to handle name change
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                text: "Your book category has been added successfully",
                icon: "success"
            });
            modal.hide()
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

function remove(form) {
    var formData = new FormData(form);
    
    var submit_button = $(form).find("button[type='submit']")
    submit_button.prop("disabled", true)
    
    let category_id = $(form).attr("data-id")
    
    $.ajax({
        url: "/dashboard/books-category/" + category_id,  // Laravel route to handle name change
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                text: "This category has been deleted successfully!",
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

let editModal = new bootstrap.Modal(document.getElementById('editBookCategoryModal'))

function openEditCategory(id)
{
    $.ajax({
        url: "/dashboard/books-category/" + id + "/edit",
        method: 'GET',
        success: function(response) {
            $("#editBookCategoryModal form input[name='name']").val(response.name)
            $("#editBookCategoryModal form").attr("data-id", response.id)
            editModal.show()
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
}

$("#edit-book-category-form").submit(function(e){
    e.preventDefault()

    var formData = new FormData(this)
    
    let category_id = $(this).attr("data-id")

    var submit_button = $(this).find("button[type='submit']")
    submit_button.prop("disabled", true)

    $.ajax({
        url: "/dashboard/books-category/" + category_id,  // Laravel route to handle name change
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                text: "Your book category has been added successfully",
                icon: "success"
            });
            editModal.hide()
            table.ajax.reload(null, false)
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