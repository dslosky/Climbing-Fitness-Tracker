var main = function () {
    
    $(window).resize(function () {
        if (window.innerWidth < 1000) {
            
            window.moveTo(0, 0); 
            window.resizeTo(screen.width, screen.height)
            
            $('body').css({
                "overflow":"auto" });
            
            $('.pagecontentContainer').css({"overflow-x":"auto"})
            
        } else {
            $('body').css({
                "overflow": "hidden" });
            
            $('.pagecontentContainer').css({"overflow-x":"hidden"})
        };
            
        }); 
    
    if ($('.calendarContainer').is(".empty")) {
        $('.weekDays p').hide();
        
        /*
        $('.calendarContainer').html("<div class='emptyCal'> \
                                        <h1 style='margin-top: 10%'>You don't have any calendars</h1> \
                                        <h3>Click here to create a new one!</h3> \
                                      </div>");
        */
        
        $('.emptyCal').show()
        
    };

    // Make the page static once it's been fluidly created
    fluidToStatic()
    
    $(document).on("mouseenter", ".calDay", function () {
            $(this).children('.caldayGradbottom').stop(true).fadeTo(1200,1)
            $(this).children('.caldayGradtop').stop(true).fadeTo(1200,1)
            $(this).children('.caldayGradleft').stop(true).fadeTo(1200,1)
            $(this).children('.caldayGradright').stop(true).fadeTo(1200,1) 
    });
     
     $(document).on("mouseleave", '.calDay', function() {
            $(this).children('.caldayGradbottom').stop(true).fadeTo(600,0)
            $(this).children('.caldayGradtop').stop(true).fadeTo(600,0)
            $(this).children('.caldayGradleft').stop(true).fadeTo(600,0)
            $(this).children('.caldayGradright').stop(true).fadeTo(600,0)
    }); 
    
    // Make the options title slide when clicked
    $('.calendarOptionsButton').click(function() {
        
        if ($(this).is('.moved')) { 
            $(this).animate({
                'marginLeft': "-="+$(this).width()*3
            }, 600);
            
            $(this).removeClass('moved');
            $('.calendarOptionsButton span').removeClass('glyphicon-chevron-left');
            $('.calendarOptionsButton span').addClass('glyphicon-chevron-right');
            
            // Hide options menu
            $('.optionsBody').animate({ 'width' : 'hide'}, 600)
            
        } else {
            $(this).animate({
                'marginLeft': "+="+$(this).width()*3
            }, 600);
            
            $(this).addClass('moved');
            $('.calendarOptionsButton span').removeClass('glyphicon-chevron-right');
            $('.calendarOptionsButton span').addClass('glyphicon-chevron-left');
            
            // show options menu
            $('.optionsBody').animate({ 'width' : 'show'}, 600)
        };
    });
    
    // hide the options menu
    $('.optionsBody').css({ "display" : "none"});
    
    // set cal date
    $('.calendarDateButton').click(function() {
        $('.day1week1').datepicker("setDate", "+0");
        
    });
   
    // fade in the page. We have to turn off the display and make the div visible before we can fade it in
    $('.contentContainer').css("display", "none");
    $('.contentContainer').css("visibility", "visible");
    $('.contentContainer').fadeIn(600);
    
    $(".newCalButton").click(function() {                

        $('.bodyCover').fadeIn(600);
        $('.addCalPopup').fadeIn(600);
        /*
      $.ajax({    //create an ajax request to load_page.php
        type: "GET",
        url: "/PHP/blankCalendar.php",             
        dataType: "html",   //expect html to be returned                
        success: function(response){
            $('.weekDays p').css({opacity: 0});
            $('.calendarContainer').css({opacity: 0});
            $('.calendarContainer').html(response);
            
            $('.calendarContainer').animate({opacity: 1}, 600);
            $('.weekDays p').animate({opacity: 1}, 600);
        }

        });
        
        */
    });
    
    $('.exitAddCal').click(function() {
    
        $('.addCalPopup').fadeOut(600)
        $('.bodyCover').fadeOut(600)
    
    });
    
    $('.logOut').on("click", function() {
        
        $.removeCookie('username', { path: '/' });
        
        $('.bodyCover').fadeIn(600, function() {
            $.ajax({
               type: "GET",
               url: "/PHP/logout.php",
               dataType: "html",
               success: function() {
                   window.location="/App/open.php";
               }
           });   
        });
        
        
    });
  
    //$('#jqDrop').selectmenu();
    
    $('.createCal').hover(function() {
    $(this).css({backgroundColor: "#315B76",
                 color: "#B98645",
                 'font-weight': 'normal'});
        }, function() {
    $(this).css({backgroundColor: "#B98645",
                 color: "#315B76",
                 'font-weight': 'bold'});

    });
    
    $('#startDate').datepicker({
      showOtherMonths: true,
      selectOtherMonths: true,
      onSelect: function() {
        if ($('#endDate').val() && $('#startDate').val()) {
            var start = $('#startDate').val().split('/');
            var end = $('#endDate').val().split('/');
            var startDate = new Date(start[2], start[0], start[1]);
            var endDate = new Date(end[2], end[0], end[1]);
            
            var diff = endDate - startDate;
            
            if (diff < 0) {
                var temp = endDate
                endDate = startDate
                startDate = temp
                
                diff = endDate - startDate
            }
            
            var weeks = Math.ceil(diff/1000/60/60/24/7);
            
            if (weeks < 1) {
                weeks = 1
                $('.durationContainer h3').html(weeks + " Week");
            } else {
            $('.durationContainer h3').html(weeks + " Weeks");
            
            };
        } else if ($('#startDate')) {
            var start = $('#startDate').val().split('/');
            var startDate = new Date(start[2], start[0], start[1]);
            var endDate = new Date();
            
            endDate = startDate + 7 * 14;
            
            $('#endDate').html(endDate.getDate);
            
            var diff = endDate - startDate;
            
            if (diff < 0) {
                var temp = endDate
                endDate = startDate
                startDate = temp
                
                diff = endDate - startDate
            }
            
            var weeks = Math.ceil(diff/1000/60/60/24/7);
            
            if (weeks < 1) {
                weeks = 1
                $('.durationContainer h3').html(weeks + " Week");
            } else {
            $('.durationContainer h3').html(weeks + " Weeks");
            
            };
                
        };
      }
      
    });
    $('#endDate').datepicker({
      showOtherMonths: true,
      selectOtherMonths: true,
      onSelect: function() {
        if ($('#endDate').val() && $('#startDate').val()) {
            var start = $('#startDate').val().split('/');
            var end = $('#endDate').val().split('/');
            var startDate = new Date(start[2], start[0], start[1]);
            var endDate = new Date(end[2], end[0], end[1]);
            
            var diff = endDate - startDate;
            
            if (diff < 0) {
                var temp = endDate
                endDate = startDate
                startDate = temp
                
                diff = endDate - startDate
            }
            
            var weeks = Math.ceil(diff/1000/60/60/24/7);
            
            if (weeks < 1) {
                weeks = 1
                $('.durationContainer h3').html(weeks + " Week");
            } else {
            $('.durationContainer h3').html(weeks + " Weeks");
            
            };
        }
      }
    });
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
};

function dateDiffWeeks(startDate, endDate) {
    
}








