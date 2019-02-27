window.$ = window.jQuery = require('jquery');

function active_navigation(sidebar_links,clickedBtnID) {

    var clicked_item = $('#'+clickedBtnID);

    sidebar_links.filter( ".active" ).removeClass('active');

    clicked_item.addClass('active');

    edit_data(clickedBtnID);

    console.log(clicked_item);

}

function edit_data(clickedBtnID) {

    var stanza_title = $('#'+clickedBtnID+' input.stanza_title').val().trim(),
        stanza_body = $('#'+clickedBtnID+' input.stanza_body').val().trim();

    console.log(stanza_body);

    $('#stanza_title').val(stanza_title).removeAttr('readonly');

    $('#previous_title').val(stanza_title);

    $('#stanza_body').val(stanza_body).removeAttr('readonly');

    $('#previous_body').val(stanza_body)

}

function buttons() {

    $('#save_btn').click(function () {
        alert('save!');
    })

    $('#revert_btn').click(function () {
        revert_editor();
    })

}

function revert_editor() {

    var previous_title = $('#previous_title').val(),
        previous_body = $('#previous_body').val();

    $('#stanza_title').val(previous_title);
    $('#stanza_body').val(previous_body);
}

$( document ).ready(function() {

    var sidebar_links = $('#sidebar ul li a');

    $(sidebar_links).on("click", function () {
        var clickedBtnID = $(this).attr('id'); // or var clickedBtnID = this.id

       active_navigation(sidebar_links,clickedBtnID);
        console.log('you clicked on button #' + clickedBtnID);
    });

    buttons();

    setTimeout(function() {
        $(".alert").alert('close');
    }, 4000);

});

