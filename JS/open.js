main = function() {
    openToStatic()
    
    // Show login window when the login button is clicked
    $('.enterSite').click(function() {
        // make the loginBox appear as a dialogue
        $('.loginBox').fadeIn(600);
        $('.bodyCover').fadeIn(600);
    });
    // change colors on hover
    $('.enterSite').hover(function() {
        $(this).css({backgroundColor: "#315B76",
                     color: "#B98645",
                     'font-weight': 'bold'});
    }, function() {
        $(this).css({backgroundColor: "#B98645",
                     color: "#315B76",
                     'font-weight': 'normal'});
    });

    // login box
    $('.toSignIn').click(function () {
        $('.signupWindow').css({
            "z-index": 0});
        $('.loginWindow').css({
            "z-index": 4});
        $('.signupWindow').fadeOut(600);
        $('.loginWindow').fadeIn(600);
    });
    
    $('.toSignUp').click(function () {
        $('.signupWindow').css({
            "z-index": 4});
        $('.loginWindow').css({
            "z-index": 0});
        $('.loginWindow').fadeOut(600);
        $('.signupWindow').fadeIn(600);
    });
    
    // close the window
    $('.exitLogin').click(function() {
        $('.loginBox').fadeOut(600);
        $('.bodyCover').fadeOut(600);
    });
    
    $('.signin').hover(function() {
        $(this).css({backgroundColor: "#B98645",
                     color: "#315B76",
                     'font-weight': 'normal'});
            }, function() {
        $(this).css({backgroundColor: "#315B76",
                     color: "#B98645",
                     'font-weight': 'bold'});

    });
    
    $('.signUp').hover(function() {
        $(this).css({backgroundColor: "#B98645",
                     color: "#315B76",
                     'font-weight': 'normal'});
            }, function() {
        $(this).css({backgroundColor: "#315B76",
                     color: "#B98645",
                     'font-weight': 'bold'});

    });
    
    $('.signUp').click(function() {
        var username = $('#usernameUp').val()
        var password = $('#passwordUp').val()
        var passwordConf = $('#passwordConfUp').val()
        
        if (password === passwordConf) {
            
            $.ajax({
                type: "POST",
                url: "/PHP/open/signup.php",
                data: {username: username, password: password},
                dataType: "html",
                success: function(html){    
                    if(html === 'false')    {
                        $('.loginResponse p').html('This username already exists!');
                        $('#usernameUp').css("color", "#FF0000");
                    } else {
                        // Load climber's data using ajax 
                        $.ajax({
                            type: "GET",
                            url: "/PHP/data/getData.php",
                            dataType: "html",
                            success: function(response) {
                                $('body').html(response);
                                $('body').css("background", "#FFFFFF");
                            }
                        });
                        
                        window.location="/App/calendar.php";
                    }
                },
                beforeSend:function() {
                    // show some loading window
                    
                }
                
            });
            return false;
        } else {
            $('.loginResponse p').html("Passwords don't match!")    
        };
    });
    
    $('.signIn').click(function() {
        var user = $('#username').val()
        var pass = $('#password').val()
        
        $.ajax({
            type: "POST",
            url: "/PHP/open/login.php",
            dataType: "html",
            data: { username: user, password: pass},
            success: function(html){    
                if(html === 'false')    {
                    // $("#add_err").css('display', 'inline', 'important');
                    // $("#add_err").html("<img src='images/alert.png' />Wrong username or password");
                    $('.loginResponse p').html('Wrong username or password');
                    $('#usernameUp').css("color", "#FF0000");
                } else {
                    //$('body').html(html);
                    
                    // Load climber's data using ajax 
                    $.ajax({
                        type: "GET",
                        url: "/PHP/data/getData.php",
                        dataType: "html",
                        success: function(response) {
                            $('body').html(response);
                            $('body').css("background", "#FFFFFF");
                        }
                    });
                    
                    window.location="/App/calendar.php";


                }       
            },
            beforeSend:function() {
                // show some loading window
                
            }
        });
        return false;  
    });
    //*************************************************************


    
    
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