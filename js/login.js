$(function(){

    var windowHeight = window.innerHeight;
    
    $('#admin-nav-bar ul').css('padding-bottom', windowHeight-200);
    
//	$("#login_register_window").dialog({
//		autoOpen: false,
//		height: 250,
//		width: 285,
//		modal: true,
//		title: 'Login:',
//		resizable: false
//
//	});

    //$('.button').css('width', '100px'); // fixed a css bug I am having.
	$('.button').bind('mouseenter',function(){
        $(this).css('box-shadow','0 3px 2px -3px #888');
        $(this).css('-webkit-box-shadow','0 3px 5px -3px #888');
        $(this).css('cursor','pointer');
        $(this).css('color', '#e9671f');
    });

    $('.button').bind('mouseleave',function(){
        $(this).css('box-shadow','0px 0px 0px 0px #888');
        $(this).css('-webkit-box-shadow','0px 0px 0px 0px #888');
        $(this).css('cursor','pointer');
        $(this).css('color', '#666');
    });

    $('.close').bind('mouseenter', function(){
        $(this).css('cursor', 'pointer');
        $(this).bind('mouseleave', function(){

        });
    });

    $('.close').bind('click',function(){
        $('#help').fadeOut(400);
    });

    $("#addPages_dialog").dialog({
		autoOpen: false,
		height: 450,
		width: 675,
		modal: true,
		title: 'Add Page',
		resizable: false
	});

    $('article#pages aside#create').click(function(){
		$("#addPages_dialog").dialog("open");
	});

    $('.next').hide();
    $('.prev').hide();
    $('ul#rotating-banner').ready(function(){

        //window.user_button_pressed = false;
       // gallery(0);
        window.gallery_image = 0;
        $('ul#rotating-banner li').eq(window.gallery_image).fadeIn(300, function(){
            gallery(window.gallery_image);

        });
//        $('ul#rotating-banner li').each(function(i){
//            gallery(i);
//
//        });



    });

    /*
    Managing icon actions
     */
    $('.delete').bind('mouseenter', function(){
        $(this).css('cursor','pointer');
        $(this).bind('mouseleave', function(){
            $(this).css('cursor','normal');
        });
    });
    $('.delete').bind('click', function(){
        var delete_item = $(this).attr('id');
               
        $('#delete').dialog({
        autoOpen: true,
        height: 235,
        width: 400,
        modal: true,
        title: 'Delete Item',
        resizable: false,
        buttons: {
            "Ok": function(){
                $.ajax({
                    type: "POST",
                    url: delete_item,
                    data: '',
                    success: function() {
                        window.location =delete_item;


                    }
                }),
                    $(this).dialog("close");

            },
            "Cancel": function(){$(this).dialog("close");} }
    });
    });



    function gallery(i)
    {
            $('ul#rotating-banner li').eq(i).hide(1, function(){
                $('ul#rotating-banner li').eq(i + 1).fadeIn(300).delay(3000);
                    if (i != $('ul#rotating-banner > li').size()- 1)
                    {
                        gallery(i+1);
                    } else {
                        $('ul#rotating-banner li').eq(0).fadeIn(300, function(){
                            $('.next').show("slide", {direction: "left"}, 1000);
                            $('.prev').show("slide", {direction: "right"}, 1000);

                        });
                    }
            });

    }

    $('.next').bind('click',function(){
        var total_images = $('ul#rotating-banner > li').size();
        window.user_button_pressed = true;
        if (window.gallery_image === undefined)
        {
            window.gallery_image = 0;
        }

        if (window.gallery_image === total_images)
        {
            // then window.listitems value is tooooo high.

            window.gallery_image = total_images - total_images;  // should give the answer 0
        }


        
        $('ul#rotating-banner li').eq(window.gallery_image).hide();
        if (window.gallery_image == total_images - 1)
        {
            window.gallery_image = -1;

        }

        $('ul#rotating-banner li').eq(window.gallery_image + 1).fadeIn(900);

        window.gallery_image = window.gallery_image + 1;

        
    });

    $('.prev').bind('click',function(){
    	var total_images = $('ul#rotating-banner > li').size();

        if (window.gallery_image == 0)
        {
            $('ul#rotating-banner li').eq(window.gallery_image).hide();
            $('ul#rotating-banner li').eq((total_images - window.gallery_image) -1).fadeIn(900);
            window.gallery_image = (total_images - window.gallery_image) -1;
            
        } else {
            
            $('ul#rotating-banner li').eq(window.gallery_image).hide();
            $('ul#rotating-banner li').eq(window.gallery_image -1).fadeIn(900);
            window.gallery_image = window.gallery_image -1;
        }





    });

});

