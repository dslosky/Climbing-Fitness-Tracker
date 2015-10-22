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

    $(document).on('click', '.addWorkout', function() {
        
        $('.calDayPopup').animate({"left": "115%"}, 600, function() {
            $('.calDayPopup').hide();
        });
        
        //if (($(this).is('.ARC')) && ($(this).is('.notAdded'))) {
        var workout = ""
        var wo_class = ""
        if ($(this).is('.ARC')) {
            workout = 'arc'
            wo_class = 'ARC'
        } else if ($(this).is('.Hangboard')) {
            workout = 'hangboard'
            wo_class = 'Hangboard'
        } else if ($(this).is('.OM')) {
            workout = 'om'
            wo_class = 'OM'
        } else if ($(this).is('.Limit_Bouldering')) {
            workout = 'limit_bouldering'
            wo_class = 'Limit_Bouldering'
        } else if ($(this).is('.LBC')) {
            workout = 'lbc'
            wo_class = 'LBC'
        } else if ($(this).is('.Campus')) {
            workout = 'campus'
            wo_class = 'Campus'
        } else if ($(this).is('.Others')) {
            workout = 'others'
            wo_class = 'Others'
        }
        
        $.ajax({
            type: "POST",
            url: "/PHP/calendar/loadWorkout.php",
            dataType: "html",
            data:{date: $('.calDayTitle').html(), workout: workout},
            success: function(response) {
                
                $('.addWorkoutPopup').addClass(wo_class)
                $('.addWorkoutPopup').html(response);
                $('.addWorkoutPopup').show();
                $('.addWorkoutPopup').animate({"left": "30%"}, 600)
            }
        });
    });
    
    $('.windowOption.done').click(function() {
            
                $.ajax({    //create an ajax request to load_page.php
                type: "POST",
                url: "/PHP/calendar/loadCalendar.php",
                //data: {startDate: start, endDate: end, workouts: workouts, weeks: weeks} ,
                dataType: "html",   //expect html to be returned                
                success: function(response){
                    $('.calendarContainer').fadeOut(600)
                    $('.calDayPopup').fadeOut(600, function() {
                        $('.calendarContainer').html(response);
                    });
                    
                    
                    $('.bodyCover').fadeOut(600)
                    $('.calendarContainer').fadeIn(600)
                    $('.calDayWorkouts').children('.newWorkout').remove()
                    
                    }
                });
        });
    
// ------------------------------------------------------------------------

// --------------------------- Add Workout Popup ------------------------------

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
        if ($('.addWorkoutPopup').hasClass('ARC')) {
            var setNum = $('.arcSets .set').size() + 1;
            
            $('.arcSets').html($('.arcSets').html() + ' \
                                <div class="set"> \
                                    <p class="setNum col-1">' + setNum + '</p>\
                                    <input class="duration col-2" name="duration"/>\
                                    <input class="comments col-3" name="comments"/>\
                                    <div class="deleteSet"><p>delete</p></div> \
                                </div> \
                            ')
            
        $('.arcSets').animate({height: ($('.arcSets').height() + $('.set').height()) + "px"});
            
        } else if ($('.addWorkoutPopup').hasClass('OM')) {
            var setNum = $('.omSets .set').size() + 1;
            
            var ratings = ['5.5', '5.6', '5.7', '5.8',
                           '5.9', '5.10a','5.10b', '5.10c',
                           '5.10d', '5.11a', '5.11b', '5.11c',
                           '5.11d', '5.12a', '5.12b', '5.12c',
                           '5.12d', '5.13a', '5.13b', '5.13c',
                           '5.13d', '5.14a', '5.14b', '5.14c']
            
            var set_string = ' \
                                <div class="set"> \
                                    <p class="setNum col-1">' + setNum + '</p>\
                                    <input class="route col-2" name="Route"/>\
                                    <select class="rating col-3">'
            
            ratings.forEach(function(rating) {
                set_string = set_string + '<option value=' + rating + '>' + rating + '</option>'    
            });
            
            $('.omSets').html($('.omSets').html() + set_string +         
                                    '</select>\
                                    <div class="deleteSet"><p>delete</p></div> \
                                </div> \
                            ')
        

            $('.omSets').animate({height: (setNum * $('.set').height()) + "px"});
        } else if ($('.addWorkoutPopup').hasClass('Hangboard')) {
            var setNum = $('.hangSets .set').size() + 1;
            
            $('.hangSets').html($('.hangSets').html() + ' \
                                <div class="set"> \
                                    <p class="setNum col-1">' + setNum + '</p> \
                                    <input class="grip col-2" name="grip" /> \
                                    <input class="goal col-3" name="goal"/> \
                                    <input class="resistance col-4" name="resistance"/> \
                                    <input class="reps col-5" name="reps"/> \
                                    <input class="comments col-6" name="comments"/> \
                                    <div class="deleteSet"><p>delete</p></div>\
                                  </div>'
                            )
            
            $('.hangSets').animate({height: ($('.hangSets').height() + $('.set').height()) + "px"});
        
        } else if ($('.addWorkoutPopup').hasClass('Limit_Bouldering')) {
            var setNum = $('.lbSets .set').size() + 1;
            
            $('.lbSets').html($('.lbSets').html() + ' \
                                <div class="set"> \
                                    <p class="setNum col-1">' + setNum + '</p> \
                                    <input class="description col-2" name="description" /> \
                                    <input class="grade col-3" name="grade"/> \
                                    <input class="attempts col-4" name="attempts"/> \
                                    <input class="comments col-5" name="comments"/> \
                                    <div class="deleteSet"><p>delete</p></div>\
                                  </div>'
                            )
            
            $('.lbSets').animate({height: ($('.lbSets').height() + $('.set').height()) + "px"});
        }
    });
    
    // make arc sets grow and shrink on hover
    $(document).on('mouseenter', '.Sets', function() {
        $('.Sets').stop(true).animate({height: ($('.set').length * 35) + 25})
        //$('.addSet').stop(true).animate({"height": "25px"})
    });
    $(document).on('mouseleave', '.Sets', function() {
        $('.Sets').stop(true).animate({height: $('.set').length * 35})
        //$('.addSet').stop(true).animate({"height": "0px"})
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
        $(this).children('.deleteSet').stop(true).animate({height: '0px',
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
            $('.Sets').animate({height: 0});
        } else {
            $('.Sets').animate({height: ($('.set').length - 1) * 35 + 25});
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
        remove_workout_class($('.addWorkoutPopup'))
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
            
        } else if ($('.popupheader').is('.OM')) {
            type = 'om';
            
            $('.set').each(function() {
                var crag = $('.addworkoutPopup .crag').val()
                var total_time = $('.addworkoutPopup .total_time').val()
                var comments = $('.addworkoutPopup .comments').val()
                var description = $('.addworkoutPopup .desc').val()
                var route = $(this).children('.route').val()
                var rating = $(this).children('.rating').val()
                var setnum = $(this).children('.setNum').html()
                workout = [date, crag, total_time, comments, description, route, rating, setnum]
                workout = workout.join('!%$%!')
                
                if (workouts.length == 0) {
                    workouts = [workout]
                } else {
                    workouts = workouts.concat([workout])
                }
            });
        } else if ($('.popupheader').is('.Hangboard')) {
            type = "hangboard"
            
            $('.set').each(function() {
                var weight = $('.addworkoutPopup .weight').val()
                var humidity = $('.addworkoutPopup .humidity').val()
                var temp = $('.addworkoutPopup .temp').val()
                var rep_duration = $('.addworkoutPopup .rep_dur').val()
                var rest_duration = $('.addworkoutPopup .rest_dur').val()
                var grip = $(this).children('.grip').val()
                var goal = $(this).children('.goal').val()
                var resistance = $(this).children('.resistance').val()
                var reps = $(this).children('.reps').val()
                var comments = $(this).children('.comments').val()
                var setnum = $(this).children('.setNum').html()
                workout = [date, weight, humidity, temp,
                           rep_duration, rest_duration,
                           grip, goal, resistance,
                           reps, comments, setnum]
                workout = workout.join('!%$%!')
                
                if (workouts.length == 0) {
                    workouts = [workout]
                } else {
                    workouts = workouts.concat([workout])
                }
            });
            
        } else if ($('.popupheader').is('.Limit_Bouldering')) {
            type = "limit_bouldering"
            
            $('.set').each(function() {
                var location = $('.addworkoutPopup .location').val()
                var duration = $('.addworkoutPopup .duration').val()
                var prob_num = $('.addworkoutPopup .prob_num').val()
                var wbl = $('.addworkoutPopup .wbl').val()
                var description = $(this).children('.description').val()
                var grade = $(this).children('.grade').val()
                var attempts = $(this).children('.attempts').val()
                var comments = $(this).children('.comments').val()
                var setnum = $(this).children('.setNum').html()
                workout = [date, location, duration,
                           prob_num, wbl, description,
                           grade, attempts, comments, setnum]
                
                workout = workout.join('!%$%!')
                
                if (workouts.length == 0) {
                    workouts = [workout]
                } else {
                    workouts = workouts.concat([workout])
                }
            });
            
        }
        if (workouts.length > 0) {
            workouts = workouts.join('%!$!%')
            del = 'NO'
        } else {
            del = 'YES'
        }
            
            console.log(workouts)
            
            
                $.ajax({
                    type: "POST",
                    url: "/PHP/dbi.php",
                    data:{type: type, workouts: workouts, date: date, del: del},
                    success: function(response) {
                        $('.save').parent().parent().animate({"left": "-55%"}, 600, function() {
                            $(this).hide(); // this is now the object passed into the function
                        });
                        
                        console.log('RESPONSE: ' + response)
                        
                        load_cal_day($('.calDayTitle').html())
                        $('.calDayPopup').show();
                        $('.calDayPopup').animate({"left": "35%"}, 600);
                        
                        remove_workout_class($('.addWorkoutPopup'))
                    }
                });
            
        
    
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


///////////////////////////////// FUNCTIONS ///////////////////////////
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
            // debugging
            console.log(response)
        }
    });
    
}

function remove_workout_class(element) {
    element.removeClass('ARC')
    element.removeClass('OM')
    element.removeClass('Hangboard')
    element.removeClass('Limit_Boulder')
    element.removeClass('Other')
}








