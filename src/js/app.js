window.$ = window.jQuery = require('jquery');

/** handle side navigation **/
function init_navigation(sidebar_links,clickedBtnID) {

    var clicked_item = $('#'+clickedBtnID);

    sidebar_links.filter( ".active" ).removeClass('active');

    clicked_item.addClass('active');

    edit_data(clickedBtnID);

}

function init_buttons() {

    $('#update_btn').click(function () {
        update_stanza();
    })

    $('#delete_btn').click(function () {

        var stanza_title = $('#stanza_title').val();

        $("#stanza_to_delete").text(stanza_title);

    })

    $('#delete_stanza_btn').click(function () {
        delete_stanza();
        $('#deleteModal').modal('hide');
    })

    $('#revert_btn').click(function () {
        revert_editor();
    })

    $('#clear_btn').click(function () {
        $("#editor_form").trigger('reset');
        $("#save_btn").attr('disabled','disabled');
    })

    $('#save_btn').click(function () {
        insert_new_stanza();
    })


}



function list_item_template(clickedBtnID,text) {

    return "<li class=\"text-success\" data-id=\""+clickedBtnID+"\" class=\"font-weight-bold\">"+text+"</li>";

}


function create_list_item(clickedBtnID, text, button) {

    var target = $(button),
        item = target.find('*[data-id="'+clickedBtnID+'"]');

    if(!item.length) {

        target.append(list_item_template(clickedBtnID,text));

    }

    disable_buttons();

    return true;
}

function edit_data(clickedBtnID) {

    var stanza_title = $('#'+clickedBtnID+' input.stanza_title').val().trim(),
        stanza_body = $('#'+clickedBtnID+' input.stanza_body').val().trim();
    // last_edited = $('#'+clickedBtnID+' input.last_edited').val().trim();

    $('#previous_title').val(stanza_title);
    $('#previous_body').val(stanza_body);
    $('#origin_id').val(clickedBtnID);

    // update delete modal
    $('#stanza_to_delete').val(stanza_title);


    $('#stanza_title').val(stanza_title).removeAttr('readonly');
    $('#stanza_body').val(stanza_body).removeAttr('readonly');

    disable_buttons();

    $('#delete_btn').removeAttr('disabled');


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

    create_list_item(target_id,stanza_title,'#edited_stanzas');

    disable_buttons();

    enable_update_button();

}

function delete_stanza() {

    var target_id = $('#origin_id').val(),
        stanza_title = $('#stanza_title').val(),
        status = $('.sidebar.right .card.deleted');

    status.removeClass('hide');

    create_list_item(target_id,stanza_title,'#deleted_stanzas');

    $("#"+target_id).remove();

    $("#editor_form").trigger('reset');

    $('#delete_btn').attr('disabled');

    enable_update_button();

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

    $('#update_btn').attr('disabled');

    $('#delete_btn').attr('disabled');

}

function enable_buttons() {

    $('#revert_btn').removeAttr('disabled');
    $('#update_btn').removeAttr('disabled');
    $('#clear_btn').removeAttr('disabled');
    $('#save_btn').removeAttr('disabled');
    $('#delete_btn').removeAttr('disabled');

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

function select_category() {

    $("#category").on('change', function () {

        var value = $(this).val();

        if(value) {

            var category_select = $("#menu"+value);

            $(category_select).collapse('toggle');

        } else {

            $('.bd-toc-item .show').removeClass('show').parent().find('.bd-toc-link').attr('aria-expanded',false);

        }

    })

}

function stanza_template(title, content, section, iterate) {

    return '<li id="stanza-'+section+'_'+iterate+'" class="ui-sortable-handle active updated">\n' +
        '        <a href="javascript:void(0)"\n' +
        '           class="stanza"\n' +
        '           data-section="'+section+'"\n' +
        '           data-stanza="'+iterate+'"\n' +
        '           data-parent="#menu'+section+'">'+title+'</a>\n' +
        '        <input class="stanza_title"\n' +
        '               type="hidden"\n' +
        '               value="'+title+'"\n' +
        '               name="section['+section+'][content]['+iterate+'][stanza_title]">\n' +
        '        <input class="stanza_body"\n' +
        '               type="hidden"\n' +
        '               name="section['+section+'][content]['+iterate+'][stanza_body]"\n' +
        '               value="'+content+'">\n' +
        '    </li>';

}

function insert_new_stanza() {

    var section = $("#category").val(),
        stanza_title = $('#stanza_title').val(),
        stanza_body = $('#stanza_body').val(),
        status = $('.sidebar.right .card.edited'),
        menu = $("#menu"+section);


    var count = menu.children();
    var offset = count.length + Math.floor(Math.random() * 10);

    menu.parents('.bd-toc-item').find('h5').addClass('updated');

    status.removeClass('hide');

    menu.prepend(stanza_template(stanza_title,stanza_body,section,offset));
    menu.sortable('refresh');

    create_list_item("stanza_00",stanza_title,'#edited_stanzas');

    $("#editor_form").trigger('reset');

    disable_buttons();

    enable_update_button();


}

$( document ).ready(function() {

    var sidebar_links = $('#sidebar .edit ul li a');

    $(sidebar_links).on("click", function () {
        var clickedBtnID = $(this).parent().attr('id'); // or var clickedBtnID = this.id

        init_navigation(sidebar_links,clickedBtnID);
    });

    init_buttons();

    // setTimeout(function() {
    //     $(".alert").alert('close');
    // }, 8000);

    enable_reorder();

    select_category();

    $(function () {
        $('#editor_form').on('change', function () {
            var title = $('#stanza_title'),
                body = $('#stanza_body'),
                i = 0;

            if (title.val().length > 1) i = i + 1;
            if (body.val().length > 1) i = i + 1;

            if(i >= 2) {
               enable_buttons();
            } else {
                disable_buttons();
            }
        });
    });

});

$( document ).on("click", "#update_config_button", function(){
    $("#update_config_form").submit(); // Submit the form
});

