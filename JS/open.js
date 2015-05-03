main = function() {
    openToStatic()
    
    // Show login window when the login button is clicked
    $('.enterSite').click(function() {
        // make the loginBox appear as a dialogue
        
        /*
        //$('#tabs').tabs();
        $('.loginBox').dialog({
            width: '30%',
            modal: true
            });
        */
        //$('.loginBox').centerHor()
        $('.loginBox').fadeIn(600);
        $('.bodyCover').fadeIn(600);
    });

    $('.toSignIn').click(function () {
        $('.signupWindow').hide(600);
        $('.loginWindow').show(600);
    });
    
    $('.toSignUp').click(function () {
        $('.loginWindow').hide(600);
        $('.signupWindow').show(600);
    });
    

    $('.exitLogin').click(function() {
        $('.loginBox').fadeOut(600);
        $('.bodyCover').fadeOut(600);
    });
    
    $('.enterSite').hover(function() {
        $(this).css({backgroundColor: "#315B76",
                     color: "#B98645",
                     'font-weight': 'bold'});
    }, function() {
        $(this).css({backgroundColor: "#B98645",
                     color: "#315B76",
                     'font-weight': 'normal'});
    });
    
    // once the JS is loaded, load the page
    $('body').animate({opacity: 1}, 600);
};

$(document).ready(main)

function openToStatic() {
    
    $('.enterSite').each(function() {
            $(this).css({
                "width": $(this).css("width"),
                "height": $(this).css("height")
            });
    });
    
    $('.jumbotron').each(function() {
            $(this).css({
                "width": $(this).css("width"),
                "height": $(this).css("height")
            });
    });
    
    $('.enterSite').each(function() {
            $(this).appendTo('body')
            $(this).css({
                "position": "absolute",
                "left": $(this).offset().left,
                "top": $(this).offset().top
            }); 
        
    });
    
    //$('body').css("position","absolute");
};