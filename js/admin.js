$(function(){
	$('.heading').bind('mouseenter', function() {
        $(this).fadeIn('slow', function(){
           $(this).css('background-color', '#fff');
           
        });
    });

    $('.heading').bind('mouseleave', function() {
        $(this).fadeIn('slow', function(){
           $(this).css('background-color', '#5193d6');
        });
    });

    $('.heading').bind('click', function(){
        $('ul.actions').first().children('li').css('color', '#ff00ff');

        $('.heading').addClass('.active');
    });

    $('#error').fadeIn(300).delay(1000).fadeOut();
    $('#success').fadeIn(300).delay(1000).fadeOut();
    $('#social_media_pick').hide();
    $('.social_media_icon').bind('click', function(){
        $(this).addClass('selected');
        $('input#url').val('');
        var icon = $(this);
        var bioid = $('input#bioid').val();
        var networkid = $('.selected input#smnid').val();  //input#smnid
        var base_url = $('input#base_url').val();
        
        $('#social_media_pick').dialog({
            autoOpen: false,
            height: 275,
            width: 675,
            modal: true,
            title: 'Social Media Profile Link',
            resizable: false,
            buttons: {
                "Ok": function(){
                    var url = $('input#url').val();
                    var dataString = 'bioid='+ bioid + '&smnid='+ networkid + '&url='+ url;
                    $.ajax({
                        type: "POST",
                        url: base_url+"index.php/cms/profile/addSocial",
                        data: dataString,
                        success: function() {
                            $(icon).fadeOut();
                           
                            
                        }
                    }),
                    $(this).dialog("close");

                },
                "Cancel": function(){$(this).dialog("close");} }
        });
        
        $('#social_media_pick').dialog("open");

        //$(this).fadeOut();
    });

    $('.upload_form').attr('disabled', 'disabled');


    $('#image_change_form').change(function(){
        if ($(this).is(':checked') == true)
        {
            $('.upload_form').attr('disabled', '');
        }

        if ($(this).is(':checked') == false)
        {
            $('.upload_form').attr('disabled', 'disabled');
        }

    });

    // new draggable and droppable images.

    $('.app_icon').bind('click', function(){
        var icon = $(this).attr('title');
    });
    
    $('.app_icon').draggable({
        revert: true,
        cursor: "move",
        activeClass: 'test',
        helper: 'original',
        zIndex:100
    });
    var inputarray = [];
    

    $('#tools').droppable({
        accept: ".app_icon",
        activeClass: "i_am_being_dragged",
        drop: function( event, ui){
            $('.ui-draggable-dragging').fadeOut();
            var icon = $('.ui-draggable-dragging').attr('title');
            //var usedtools = $('input#tools_input').val();
            inputarray.push(icon);
            $('input#tools_input').val(inputarray);
            var icon_img = '<div class="tool"><img src="'+$('.ui-draggable-dragging').attr('src')+'" /></div>';
            //alert(inputarray); // need to make this pass on with the array to have php sort it out.

            $('#tools_added').append(icon_img).fadeIn();
        }

    });

    // for edit / update project page;
    $('.used_tool').bind('click', function(){
        $(this).unbind('click');
        $(this).fadeOut(500);
        var icon_info = '<div class="tool_images"><img class="app_icon" src="'+$(this).attr('src')+'" title="'+$(this).attr('title')+'" alt="'+$(this).attr('title')+'" /></div>';
        $('.icons').append(icon_info).fadeIn(300);
        
    });
    
    
    


   
});

