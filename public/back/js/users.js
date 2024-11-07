function remove(form) {
    var formData = new FormData(form);
    
    var submit_button = $(form).find("button[type='submit']")
    submit_button.prop("disabled", true)
    
    let user_id = $(form).attr("data-id")
    
    $.ajax({
        url: "/dashboard/users/" + user_id,  // Laravel route to handle name change
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                text: "This user has been deleted successfully!",
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

var defauly_code = $("#country-code-input > button span").text().trim()
var default_country = window.CountryList.findOneByDialCode(defauly_code)
$("#country-code-input > button .country-flag").html(window.CountryFlagSvg[default_country.code])

var countries = window.CountryList.getAll()
for(country of countries)
{
    $("#country-code-input ul").append(`
        <li href="#" class="dropdown-item" role="button" style="display:flex" onclick="selectCountry('${country.code}', '${country.dial_code}')">
            <div class="flag me-2" style="height:25px;width:25px">${window.CountryFlagSvg[country.code]}</div>
            <span class="country-name">${country.name}</span>
            <span class="ms-auto country-code">${country.dial_code}</span>
        </li>
    `)
}

function selectCountry(country_code, dial_code)
{
    $("#country-code-input > button .country-flag").html(window.CountryFlagSvg[country_code])
    $("#country-code-input > button span").text(dial_code)

    $("#country-code-input input[name='country_code']").val(dial_code.slice(1))
}

$("#country-code-input .search-countryList").on('input', function() {
    const search = $(this).val().trim().toLowerCase();

    $("#country-code-input ul li").each(function(_, item) { // Corrected usage of .each
        const countryName = $(item).find(".country-name").text().trim().toLowerCase()
        if(countryName.includes(search))
        {
            console.log(countryName)
        }
        $(item).css('display', countryName.includes(search) ? 'flex' : 'none')
    });
});

$("input[name='is_admin']").change(function(){
    const status = $(this).prop('checked')

    $("div:has( > select[name='role'])").css('display', status ? 'block' : 'none')
})

$("#create-user-form").submit(function(e){
    e.preventDefault()

    var formData = new FormData(this)
    var submit_button = $(this).find("button[type='submit']")
    submit_button.prop("disabled", true)

    $.ajax({
        url: "/dashboard/users",
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

$("#edit-user-form").submit(function(e){
    e.preventDefault()

    var formData = new FormData(this)
    var submit_button = $(this).find("button[type='submit']")
    submit_button.prop("disabled", true)

    const user_id = $(this).attr("data-id")

    $.ajax({
        url: "/dashboard/users/" + user_id,
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                text: "Your changes has been saved successfully",
                icon: "success"
            });
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