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
        
        $('.loginBox').fadeIn(600);
        $('.bodyCover').fadeIn(600);
    });
    
    $('.toSignIn').click(function () {
        $('.SignUp').hide(600);
        $('.SignIn').show(600);
    });
    
    $('.toSignUp').click(function () {
        $('.SignIn').hide(600);
        $('.SignUp').show(600);
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
};