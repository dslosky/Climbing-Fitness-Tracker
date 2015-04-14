var main = function () {
   
    
    $(window).resize(function () {
        if (window.innerWidth < 1000) {
            $('body').css({
                "overflow":"auto" });
            
            $('.pagecontentContainer').css({"overflow-x":"auto"})
            
        } else {
            $('body').css({
                "overflow": "hidden" });
            
            $('.pagecontentContainer').css({"overflow-x":"hidden"})
        };
            
        }); 
    
    fluidToStatic()
        
    
};

$(document).ready(main);

var adjustPageSize = function() {
    var screenHeight = window.screen.height;
    var screenWidth = window.screen.width;
    
    var widthProp = .95;
    //var heightProp = .92;
 
    var heightProp = .15;
    
    $('.contentContainer').css({
        minHeight: screenHeight * heightProp,
        minWidth: screenWidth * widthProp
    });
    
};

function fluidToStatic() {
    
    $('div').each(function() {
            $(this).css({
                "width": $(this).css("width"),
                "height": $(this).css("height")
            });
        
    });
        
    $('calDay').each(function() {
        $(this).appendTo('body')
        $(this).css({
                "position": "absolute",
                "left": $(this).offset().left,
                "top": $(this).offset().top
        }); 
    });
     /*   
    $('title').each(function() {
            $(this).appendTo('body')
            $(this).css({
                    "position": "absolute",
                    "left": $(this).offset().left,
                    "top": $(this).offset().top
            }); 
    });            */
};










