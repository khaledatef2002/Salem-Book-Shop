var default_country = window.CountryList.findOneByDialCode('+971')
$("#default-country-icon").html(window.CountryFlagSvg[default_country.code])

var countries = window.CountryList.getAll()
for(country of countries)
{
    $("#countries_list").append(`
        <li class="option" data-code="${country.code}">
            <div>
                <div class="flag">${window.CountryFlagSvg[country.code]}</div>
                <span class="country-name">${country.name}</span>
            </div>
            <strong id="default-tel-code" class="me-2">${country.dial_code}</strong>
        </li>
    `)
}

const select_box = $(".select-box .options")
const selected_option = $(".selected-option .country_data")

selected_option.click(function(){
    select_box.fadeToggle()
})
$(".select-box .selected-option input").focus(function(){
    select_box.hide()
})

$("#countries_list li").click(function(){
    var code = $(this).attr("data-code")
    var country = window.CountryList.findOneByCountryCode(code)
    $("#default-country-icon").html(window.CountryFlagSvg[code])
    $("#default-tel-code").html(country.dial_code)
    $("#country_code").val(String(country.dial_code).substring(1))
    select_box.hide()
})

$(document).click(function (event) {
    var target = $(event.target);

    if (!target.closest('.country_data').length) {
        $('.options').hide();
    }
});