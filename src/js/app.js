window.$ = window.jQuery = require('jquery');

function init_navigation(sidebar_links,clickedBtnID) {

    var clicked_item = $('#'+clickedBtnID);

    sidebar_links.filter( ".active" ).removeClass('active');

    clicked_item.addClass('active');

    edit_data(clickedBtnID);

}

function init_buttons() {

    $('#save_btn').click(function () {
        update_stanza();
    })

    $('#revert_btn').click(function () {
        revert_editor();
    })


    $("#editor_form .form-control").on('input',function(e){
        if(e.target.value === ''){
            // Textarea has no value
            disable_buttons();
        } else {
            // Textarea has a value
            enable_buttons();
        }
    });

}

function edit_data(clickedBtnID) {

    var stanza_title = $('#'+clickedBtnID+' input.stanza_title').val().trim(),
        stanza_body = $('#'+clickedBtnID+' input.stanza_body').val().trim();

    $('#previous_title').val(stanza_title);
    $('#previous_body').val(stanza_body);
    $('#origin_id').val(clickedBtnID);


    $('#stanza_title').val(stanza_title).removeAttr('readonly');
    $('#stanza_body').val(stanza_body).removeAttr('readonly');

    disable_buttons();

}

function update_stanza() {

    var target_id = $('#origin_id').val(),
        stanza_title = $('#stanza_title').val(),
        stanza_body = $('#stanza_body').val(),
        target = $('#'+target_id+' a');

    target.find('a').text(stanza_title);
    target.find('.stanza_title').val(stanza_title);

}

function revert_editor() {

    var previous_title = $('#previous_title').val(),
        previous_body = $('#previous_body').val();

    $('#stanza_title').val(previous_title);

    $('#stanza_body').val(previous_body);

    disable_buttons();
}

function disable_buttons() {

    $('#revert_btn').attr('disabled');
    $('#save_btn').attr('disabled');

}

function enable_buttons() {
    
    $('#revert_btn').removeAttr('disabled');
    $('#save_btn').removeAttr('disabled');
    
}



$( document ).ready(function() {

    var sidebar_links = $('#sidebar ul li a');

    $(sidebar_links).on("click", function () {
        var clickedBtnID = $(this).parent().attr('id'); // or var clickedBtnID = this.id

       init_navigation(sidebar_links,clickedBtnID);
    });

    init_buttons();

    setTimeout(function() {
        $(".alert").alert('close');
    }, 8000);

});

