function events_filters()
{
    var search = $(".search-bar input").val()
    var sort_by = $(".sort select").val()
    var limit = $(".limit select").val()

    var status = [];
    $('input[name="status"]:checked').each(function() {
        status.push($(this).val());
    });

    $(".events-container").html(`<div class="spinner-grow text-info d-block mx-auto mt-4" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>`)

    $.get('getAllEventsAjax', {search, sort_by, limit, status}, function(response){
        $(".events-container").html(response)
    })
}