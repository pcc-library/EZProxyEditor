window.$ = window.jQuery = require('jquery');

function active_navigation(sidebar_links,clickedBtnID) {

    var clicked_item = $('#'+clickedBtnID);

    sidebar_links.filter( ".active" ).removeClass('active');

    clicked_item.addClass('active');

    edit_data(clickedBtnID);

}

function edit_data(clickedBtnID) {

    var stanza_title = $('#'+clickedBtnID+' input.stanza_title').val().trim(),
        stanza_body = $('#'+clickedBtnID+' input.stanza_body').val().trim();

    $('#previous_title').val(stanza_title);
    $('#previous_body').val(stanza_body)

    $('#stanza_title').val(stanza_title).removeAttr('readonly');
    $('#stanza_body').val(stanza_body).removeAttr('readonly');

    $('#save_btn').removeAttr('disabled');

}

function buttons() {

    $('#save_btn').click(function () {
        alert('save!');
    })

    $('#revert_btn').click(function () {
        revert_editor();
    })


    $("#stanza_body").on('input',function(e){
        if(e.target.value === ''){
            // Textarea has no value
            $('#revert_btn').attr('disabled');
        } else {
            // Textarea has a value
            $('#revert_btn').removeAttr('disabled');
        }
    });



}
function disable_revert_button() {

    $('#revert_btn').attr('disabled');

}

function revert_editor() {

    var previous_title = $('#previous_title').val(),
        previous_body = $('#previous_body').val();

    $('#stanza_title').val(previous_title);

    $('#stanza_body').val(previous_body);

    disable_revert_button();
}

$( document ).ready(function() {

    var sidebar_links = $('#sidebar ul li a');

    $(sidebar_links).on("click", function () {
        var clickedBtnID = $(this).attr('id'); // or var clickedBtnID = this.id

       active_navigation(sidebar_links,clickedBtnID);
    });

    buttons();

    setTimeout(function() {
        $(".alert").alert('close');
    }, 8000);

});

