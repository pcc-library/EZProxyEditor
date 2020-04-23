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

function list_item_template(clickedBtnID,text) {

    return "<li class=\"text-success\" data-id=\""+clickedBtnID+"\" class=\"font-weight-bold\">"+text+"</li>";

}

function create_list_item(clickedBtnID, text) {

    var target = $('#edited_stanzas'),
        item = target.find('*[data-id="'+clickedBtnID+'"]');

    if(!item.length) {

        target.append(list_item_template(clickedBtnID,text));

    }

    return true;
}

function edit_data(clickedBtnID) {

    var stanza_title = $('#'+clickedBtnID+' input.stanza_title').val().trim(),
        stanza_body = $('#'+clickedBtnID+' input.stanza_body').val().trim();
        // last_edited = $('#'+clickedBtnID+' input.last_edited').val().trim();

    $('#previous_title').val(stanza_title);
    $('#previous_body').val(stanza_body);
    $('#origin_id').val(clickedBtnID);


    $('#stanza_title').val(stanza_title).removeAttr('readonly');
    $('#stanza_body').val(stanza_body).removeAttr('readonly');

    // if(!last_edited) {
    //     var last_edited =  $.datepicker.formatDate('yy/mm/dd h:i:s A', new Date());
    //
    //     $('#last_edited').val(last_edited);
    //     $('#last_edited_text').text(last_edited);
    // } else {
    //
    //     $('#last_edited').val(last_edited);
    //     $('#last_edited_text').text(last_edited);
    // }

    disable_buttons();

}

function update_stanza() {

    var target_id = $('#origin_id').val(),
        stanza_title = $('#stanza_title').val(),
        stanza_body = $('#stanza_body').val(),
        // last_edited = $('#last_edited').val(),
        target = $('#'+target_id),
        status = $('.sidebar.right .card.edited');

    status.removeClass('hide');
    target.children('a').text(stanza_title);
    target.children('.stanza_title').val(stanza_title);
    target.children('.stanza_body').val(stanza_body);
    target.addClass('updated');
    target.parents('.bd-toc-item').find('h5').addClass('updated');

    create_list_item(target_id,stanza_title);

    enable_update_button();


    //disable_buttons();

}

function revert_editor() {

    var previous_title = $('#previous_title').val(),
        previous_body = $('#previous_body').val();

    $('#stanza_title').val(previous_title);

    $('#stanza_body').val(previous_body);

    disable_buttons();
}

function disable_buttons() {

    $('#stanza_title').blur();

    $('#stanza_body').blur();

    $('#revert_btn').attr('disabled');

    $('#save_btn').attr('disabled');

}

function enable_buttons() {

    $('#revert_btn').removeAttr('disabled');
    $('#save_btn').removeAttr('disabled');

}

function enable_update_button() {

    $('button#update_config_button').removeAttr('disabled');

}

function enable_reorder() {

        var menu = $( ".sortable" );

            menu.sortable({
                update: function(event, ui)
                {
                    enable_update_button();
                    console.log('end drag');
                }
            });
            menu.disableSelection();



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


    enable_reorder();

});

