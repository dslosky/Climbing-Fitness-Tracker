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
        $('.weekDays p').css("opacity", "0");
        
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
    
    // -------------------- Add Calendar Window ----------------------------
    $('.exitAddCal').click(function() {
    
        $('.addCalPopup').fadeOut(600)
        $('.bodyCover').fadeOut(600)
    
    });
    
    // create a new calendar
    $('.createCal .go').click(function() {
        var start = $('#startDate').val().split('/');
        var end = $('#endDate').val().split('/');
        var workouts = $('#workoutsDrop').val()
        var weeks = $('.durationContainer h3').html().split(' ')[0]
        
        start = start[2] + '-' + start[0] + '-' + start[1]
        end = end[2] + '-' + end[0] + '-' + end[1]
        
        $('.weekDays p').animate({opacity: 1}, 600);
        $('.calendarContainer').css({opacity: 0});
        $('.calendarContainer').addClass('full');
        
    
        $.ajax({    //create an ajax request to load_page.php
        type: "POST",
        url: "/PHP/calendar/newCalendar.php",
        data: {startDate: start, endDate: end, workouts: workouts, weeks: weeks} ,
        dataType: "html",   //expect html to be returned                
        success: function(response){
            
            $('.calendarContainer').html(response);
            
            $('.calendarContainer').animate({opacity: 1}, 600);
            
        }

        });
        
        $('.bodyCover').fadeOut(600);
        $('.addCalPopup').fadeOut(600);
    
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
            
            start[0] = parseInt(start[0]) - 1
            
            var startDate = new Date(start[2], start[0], start[1]);
            var endDate = new Date((startDate.getYear() + 1900), startDate.getMonth(), startDate.getDate())
            
            //endDate = startDate
            
            endDate.setDate(endDate.getDate() + 95)
            
            var endDay = ""
            var endMonth = ""
            var endYear = ""
            
            if ((endDate.getDate()) < 10) {
                endDay = "0" + (endDate.getDate())
            } else {
                endDay = (endDate.getDate())
            }
            
            if ((endDate.getMonth() + 1) < 10) {
                endMonth = "0" + (endDate.getMonth() + 1)
            } else {
                endMonth = (endDate.getMonth() + 1)
            }
            
            endYear = endDate.getYear() + 1900
            
            $('#endDate').val(endMonth + '/' + endDay + '/' + endYear);
            
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
    
//---------------- Calendar day popup ------------------------

    $(document).on("click", ".calDay", function() {
        
        $('.calDayTitle').html($(this).children('.dayInfo').children('.date').html());
        
        
        load_cal_day($('.calDayTitle').html());
        /*
        $.ajax({
            type: "POST",
            url: "/PHP/calendar/loadWorkouts.php",
            dataType: "html",
            data:{date: $('.calDayTitle').html()},
            success: function(response) {
                $('.calDayWorkouts').html(response);
            }
        });
        */
        
        $('.calDayPopup').fadeIn(600);
        $('.bodyCover').fadeIn(600);
            
    });
    
    $(document).on("mouseenter", ".addWorkout", function () {
        if ($(this).is('.notAdded')) {
            $(this).css("border-color", "#c4c4ff");
            $(this).children("h3").css("color", "#a1a1ff");
            $(this).css('background', "#dfdfdf");
        } else {
            $(this).children('h3').css("font-size", "30px");
        }
    });
    
    $(document).on("mouseleave", ".addWorkout", function () {
        if ($(this).is('.notAdded')) {
            $(this).css("border-color", "#a3a3a3")
            $(this).children("h3").css("color", "#a3a3a3");
            $(this).css('background', "#FFFFFF");
        } else {
            $(this).children('h3').css("font-size", "24px");
        }
    });
    /*
    $(".addWorkout").hover(function() {
        $(this).children("h2").css("color", "#000000");
    });
    */
    $(document).on('click', '.addWorkout', function() {
        
        $('.calDayPopup').animate({"left": "115%"}, 600, function() {
            $('.calDayPopup').hide();
        });
        
        //if (($(this).is('.ARC')) && ($(this).is('.notAdded'))) {
        if ($(this).is('.ARC')) {
            $.ajax({
                type: "POST",
                url: "/PHP/calendar/loadWorkout.php",
                dataType: "html",
                data:{date: $('.calDayTitle').html(), workout: 'arc'},
                success: function(response) {
                    
                    $('.addWorkoutPopup').html(response);
                    $('.addWorkoutPopup').show();
                    $('.addWorkoutPopup').animate({"left": "30%"}, 600)
                    $('.addWorkoutPopup').addClass('.ARC')
                }
            });
            
        }
    });
    
    $('.windowOption.done').click(function() {
            
                $.ajax({    //create an ajax request to load_page.php
                type: "POST",
                url: "/PHP/calendar/loadCalendar.php",
                //data: {startDate: start, endDate: end, workouts: workouts, weeks: weeks} ,
                dataType: "html",   //expect html to be returned                
                success: function(response){
                    
                    $('.calendarContainer').html(response);
                    
                    //$('.calendarContainer').animate({opacity: 1}, 600);
                    
                    $('.calDayPopup').fadeOut(600)
                    $('.bodyCover').fadeOut(600)
                    $('.calDayWorkouts').children('.newWorkout').remove()
                    
                    }
                });
        });
    
// ------------------------------------------------------------------------

// --------------------------- Add Arc Weekend ----------------------------

    $(document).on("mouseenter", ".addSet", function () {
        $(this).css("border-color", "#c4c4ff");
        $(this).css('background', "#dfdfdf");
    });
    $(document).on("mouseleave", ".addSet", function() {
        $(this).css("border-color", "#a3a3a3");
        $(this).css('background', "#a3a3a3");
    });


    // add an arc
    $(document).on('click', '.addSet', function() {
        
        setNum = $('.arcSets .set').size() + 1;
        
        $('.arcSets').html($('.arcSets').html() + ' \
                            <div class="set"> \
                                <p class="setNum col-1">' + setNum + '</p>\
                                <input class="duration col-2" name="duration"/>\
                                <input class="comments col-3" name="comments"/>\
                                <div class="deleteSet"><p>delete</p></div> \
                            </div> \
                        ')

                        
        $('.arcSets').animate({height: ($('.arcSets').height() + $('.set').height()) + "px"});
    });
    
    $(document).on('mouseenter', '.arcSets', function() {
        $('.arcSets').stop(true).animate({height: ($('.set').length * 35) + 25})
        //$('.addSet').stop(true).animate({"margin-top": "25px"})
    });
    
    $(document).on('mouseleave', '.arcSets', function() {
        $('.arcSets').stop(true).animate({height: $('.set').length * 35})
        //$('.addSet').stop(true).animate({"margin-top": "0px"})
    });
    
    // show the delete option
    
    $(document).on('mouseenter', '.set', function() {
        $(this).stop(true).animate({height: "60px"});
        $(this).children('.deleteSet').stop(true).animate({height: '25px',
                                                          opacity: 1});
        //$('.addSet').stop(true).animate({"margin-top": "50px"});
    });
    
    $(document).on('mouseleave', '.set', function() {
        $(this).stop(true).animate({height: "35px"});
        $(this).children('.deleteSet').stop(true).animate({height: '25px',
                                                          opacity: 0});
        //$('.addSet').stop(true).animate({"margin-top": "10px"});
    });
    
    // delete arc behaviour
    $(document).on('mouseenter', '.deleteSet p', function() {
        $(this).css("text-decoration", "underline")
    });
    
    $(document).on('mouseleave', '.deleteSet p', function() {
        $(this).css("text-decoration", "none")
    });
    
    $(document).on('click', '.deleteSet p', function() {
        
        if (($('.set').length - 1 <= 0))  {
            $('.arcSets').animate({height: 0});
        } else {
            $('.arcSets').animate({height: ($('.set').length - 1) * 35 + 25});
        }
        
        // remove the set
        $(this).parent().parent().remove()
        
        
        // renumber sets //
        n = 1
        $('.set').each(function() {
            $(this).children('.setNum').html(n);
            
            n++
        });
    });
    
    
    
    
    // cancel windowOption
    $(document).on('click', '.cancel', function() {
        $(this).parent().parent().animate({"left": "-55%"}, 600, function() {
            $(this).hide(); // this is now the object passed into the function
        });
        
        // load_cal_day($('.calDayTitle').html());
        
        $('.calDayPopup').show();
        $('.calDayPopup').animate({"left": "35%"}, 600);
    });
    
    // save windowOption
    $(document).on('click', '.save', function() {
        var type = ''
        var workouts = []
        
        var date = $('.addworkoutPopup .date').html()
        var new_date = []
        date = date.split('/')
        new_date[0] = date[2]
        new_date[1] = date[0]
        new_date[2] = date[1]
        date = new_date.join('-')
        
        var workouts = ''
        if ($('.popupheader').is('.ARC')) {
            type = 'arc';
            
            $('.set').each(function() {
                var location = $('.addworkoutPopup .location').val()
                var duration = $(this).children('.duration').val()
                var comments = $(this).children('.comments').val()
                var terrain = $('.addworkoutPopup .desc').val()
                var difficulty = $('.addworkoutPopup .difficulty').val()
                var setnum = $(this).children('.setNum').html()
                workout = [date, location, duration, comments, terrain, difficulty, setnum]
                workout = workout.join('!%$%!')
                
                if (workouts.length == 0) {
                    workouts = [workout]
                } else {
                    workouts = workouts.concat([workout])
                }
            });
            
            workouts = workouts.join('%!$!%')
        }
        
        if (workouts.length > 0) {
            $.ajax({
                type: "POST",
                url: "/PHP/dbi.php",
                data:{type: type, workouts: workouts},
                success: function(response) {
                    $('.save').parent().parent().animate({"left": "-55%"}, 600, function() {
                        $(this).hide(); // this is now the object passed into the function
                    });
                    $('.calDayPopup').show();
                    $('.calDayPopup').animate({"left": "35%"}, 600);
                }
            });
        }
    
    });
    
    // save and cancel day buttons
    $(document).on('mouseenter', '.windowOption', function() {
        $(this).css({backgroundColor: "#315B76",
                     color: "#B98645"});
            });
    $(document).on('mouseleave', '.windowOption',function() {
        $(this).css({backgroundColor: "#B98645",
                     color: "#315B76"});
        });
    



//--------------------- Log Out ------------------------------     
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

function load_cal_day(date_in) {
    
    $.ajax({
        type: "POST",
        url: "/PHP/calendar/loadWorkouts.php",
        dataType: "html",
        data:{date: date_in},
        success: function(response) {
            $('.calDayWorkouts').html(response);
        }
    });
    
}

function get_session(var_in) {
    
    $.ajax({
        type: "POST",
        url: "/PHP/my_session.php",
        dataType: "html",
        data:{var_in: var_in},
        success: function(response) {
        }
    });
    
}








