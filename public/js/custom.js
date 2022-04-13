
$(document).on('click','#other-yes',function(){
    $('.more-info-background').show();
});
$(document).on('click','#other-no',function(){
    $('.more-info-background').hide();
});

// search for a client from the home page
$(document).on('keyup','#search-client',function(){
    var name = $(this).val();
    // send ajax request
    if(name.length>=3)
    {
        $('.search-results').show();// show the div to display the results
        $.ajax({
            url:'/search',
            data:{
                name:name
            },
            dataType:'json',
            beforeSend:function(){
                $('.search-results').html('<h5><i>Loading...</i></h5>');
            },
            success:function(res){
                var list ="";
                if(res.data!="")
                {
                    $.each(res.data,function(index,data)
                    {
                        list+= "<li class='custom-list' id='"+data.id+"'><a class='nav-link' href='/client/"+data.id+"/view'>"+data.name+"<span class='right text-muted'><a href='/clients/"+data.id+"/schedules' class='nav-link text-muted'>Schedules</a></span></a></li>";
                    });
                    $('.search-results').html(list);
                }else{
                    $('.search-results').html("<h5><i>No results found</i><span class='right'><i class='fa fa-plus-circle'></i></span></h5>");
                }
                
            }
        });
    }else{
        $('.search-results').html('');
        $('.search-results').hide();
    }
});
// get the value of the clicked list
$('.custom-list').on('click',function(){
    var id = $('.custom-list').attr('id');
    console.log(id);
});

// load user data for schedules creation
$(document).on('keyup','#client_id_schedule',function(){
    var name= $(this).val();
    if(name.length>=2)
    {
        $('.search-results-schedule').show();
        $.ajax({
            url:'/search',
            data:{
                name:name
            },
            dataType:'json',
            beforeSend:function(){
                $('.search-results-schedule').html('<h5>Loading...</h5>');
            },
            success:function(res){
                var list ='';
                if(res.data!="")
                {
                    $.each(res.data,function(index,data)
                    {
                        list+= "<li class='custom-list schedule-id' id='"+data.id+"'>"+data.name+"</li>";
                    });
                    $('.search-results-schedule').html(list);
                }else{
                    $('.search-results-schedule').html('<h5><i>No results found</i></h5>');
                }
            }
        });
    }else{
        $('.search-results-schedule').html('');
    }
});

// autopopulate inputs on item select
$(document).on('click','.schedule-id',function(){
    var id = $(this).attr('id');
    var name = $(this).text();
    $(this).hide();
    $('#client_id_schedule').val(name);
    $('#client_id').val(id);
    $('.search-results-schedule').hide();
    $('#schedule-issues').html("");
// send a request to get the issues for the cliet selected
    $.ajax({
        url:'/search/client',
        data:{
            id:id
        },
        dataType:'json',
        success:function(res){
            var option ='';
            if(res.data !='')
            {
                $.each(res.data,function(index,data){
                    option += "<option value='"+data.id+"'>"+data.issue_title+"</option>";
                });
                $('#schedule-issues').append(option);
                
            }else{
                option ='<option value="">No issues registered for user</option>';
                $('#schedule-issues').html(option);
                
            }
        }
    });
})
// set time interval 
//setInterval(function(){$('#schedules').html(schedules());}, 1000);
var now = new Date();
var mydateyear = now.getFullYear();
var mydatemonth = now.getMonth()+1;
var mydateday = now.getDate();
if(mydatemonth < 10)
{
    mydatemonth = "0"+mydatemonth;
}
var mydateHour = now.getHours()
var mydateMinutes = now.getMinutes();
var mydate = mydateyear+"-"+mydatemonth+"-"+mydateday+" "+mydateHour+":"+mydateMinutes+":00";
// display schedules comming up
    $.ajax({
        url:'schedules/get',
        dataType:'json',
        data:{
            date:mydate
        },
        success:function(res){
            if(res !='') // if data has been fetched and is not empty
            {
                setInterval(function(){schedules(res);}, 1000);//schedules(res.data);
            }else{
                 'No data found';
            }
        }
    });

function formatdate(date)
{
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        days = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (days.length < 2) 
        days = '0' + days;

    var complete = [year, month, days].join('-');
}


function schedules(data)
{
    var date = new Date();
    var schedule ;
    var time;
    var list ='';
    var hours;
    var mins;
    var previous="";
    var timediff;
    var minutes;
    var day;
    var days;
    var time;
    var other_days;
    var year;
    var month;
    var dd;
    var active ="";
    var end_date;
    var duration;
    var current_month;

    if(data.upcoming!="")
    {

            $.each(data.upcoming,function(index,fetched){ // upcoming schedules
                schedule = new Date(fetched.date);
                if(schedule > date) // if their date and time is not yet
                {
                    date = new Date();
                    schedule = new Date(fetched.date);
                    end_date = new Date(fetched.end_time);
                    hours= schedule.getHours();
                    mins = schedule.getMinutes();
                    time = hours+":"+mins+" Hrs";
                    timediff = schedule - date;
                    other_days = schedule.getDate();
                    day = date.getDate();
                    month = schedule.getMonth() + 1;
                    year = schedule.getFullYear();
                    duration = end_date - schedule;
                    duration = duration / 60000;
                    duration = Math.round(duration);
                    current_month = date.getMonth() + 1;

                    // show the schedule
                    //console.log(other_days);
                    //console.log(day);
                    // convert duration into minutes and hours
                    if(duration > 59)
                    {
                        duration = duration / 60;
                        duration = Math.round(duration)+" Hr";
                    }else if(duration < 0){
                        duration = "UnKnown";
                    }else{
                        duration = duration+" mins";
                    }

                    //check the chedule month
                    if(month >= current_month)
                    {
                        if(other_days < day) // if the days of the month for the upcoming are below the days for the current mont
                        {
                                date = new Date(fetched.date);
                                list += "<div class='p-3 my-1 header upcoming-link'>"+fetched.name+""+
                                            " <span class='text-muted right'> Duration: "+duration+"</span><br>"+
                                            " <span class='text-muted'>("+fetched.topic+")</span> "+
                                            "<span class='text-muted right'>"+date+"</span>"+
                                        "</div>";  
                        }else if(other_days > day){
                            date = new Date(fetched.date);
                                list += "<div class='p-3 my-1 header upcoming-link'>"+fetched.name+""+
                                            " <span class='text-muted right'> Duration: "+duration+"</span><br>"+
                                            " <span class='text-muted'>("+fetched.topic+")</span> "+
                                            "<span class='text-muted right'>"+date+"</span>"+
                                        "</div>";  
                        }else if(other_days === day)
                        {
                            time = schedule - date;
                            timediff = schedule - date;
                            minutes = timediff / 60000;
                            minutes = Math.round(minutes);
                            // check if minutes is greater that 59 and convert to hours
                            if(minutes > 59)
                            {
                                minutes = minutes / 60;
                                minutes = Math.round(minutes)+" Hrs";
                            }else{
                                minutes = minutes+" Mins";
                            }

                            list += "<div class='p-2 header active-schedule mt-2'>"+fetched.name+
                                    ", <span class='text-muted'> Duration: "+duration+"</span>"+
                                    " <span class='text-muted right text-danger'>"+minutes+"</span>"+
                                    " <span class='text-muted'>("+fetched.topic+")</span></div>";
                            
                                            // display the notification
                            if(minutes < 30){
                                $('.schedules-top').show();
                                $('#schedules').html(list);
                            }else{
                                $('.schedules-top').hide();
                            }
                        } 
                    } 
                }
            });// end each function for upcoming schedules
        }else{ // if the upcoming schedules array is empty
            list +='<li class="list-group-item"><h4><i>No Schedules Available</i></h4></li>';
        }

        $('#upcoming-schedules').html(list);
        $('.home-dash-schedules').html(list);
        //console.log(list);
    /**
     * start each function for ended schedules
     */
     $.each(data.previous,function(index,ended){
            date = new Date();
            schedule = new Date(ended.date);
            end_date = new Date(ended.end_time);
            hours= schedule.getHours();
            mins = schedule.getMinutes();
            time = hours+":"+mins+" Hrs";
            timediff = date - schedule;
            minutes = timediff / 60000;
            minutes = Math.round(minutes);
            other_days = schedule.getDate();
            month = schedule.getMonth();
            year = schedule.getFullYear();
            dd = other_days+"/"+month+"/"+year;
            duration = end_date - schedule;
            duration = duration / 60000;
            duration = Math.round(duration);
            remaining_time = duration - minutes;


            // convert duration into minutes and hours
            if(duration > 59)
            {
                duration = duration / 60;
                duration = Math.round(duration)+" Hr";
            }else if(duration < 0){
                duration = "UnKnown";
            }else{
                duration = duration+" mins";
            }
            
                // active schedules
                if(end_date > date)
                {
                    $('.schedules-top-active').show();
                    // ended schedules
                    if(minutes > 59)
                    {
                        // check hours 
                        Hoursdd = minutes / 60;
                        if(Hoursdd > 24)
                        {
                            days = Hoursdd / 24;
                            if(days > 1)
                            {
                                minute = Math.round(days)+" Days";
                            }else{
                                minute = Math.round(days)+" Day";
                            }
                        }else{
                            minute = Math.round(Hoursdd)+" Hours";
                        }
                    }else{
                        minute = minutes +" mins";
                    }
                    active += "<div class='p-2 header active-schedule mt-2'>"+ended.name+
                                " <br><span class='text-muted'> Duration: "+duration+"</span>"+
                                "<br> <span class='text-muted'>Topic: "+ended.topic+"</span>"+
                                "<br><span class=' text-danger'>Active Time: "+minute+"</span>"+
                                "<br><span class=' text-danger'><h5>Ending in: "+remaining_time+" mins</h5></span>"+
                            "</div>";
                }else{
                    // ended schedules
                    
                    if(minutes > 59)
                    {
                        // check hours 
                        Hoursdd = minutes / 60;
                        if(Hoursdd > 24)
                        {
                            days = Hoursdd / 24;
                            if(days > 1)
                            {
                                minute = Math.round(days)+" Days";
                            }else{
                                minute = Math.round(days)+" Day";
                            }
                        }else{
                            minute = Math.round(Hoursdd)+" Hours";
                        }
                    }else{
                        minute = minutes +" mins";
                    }
                    previous += "<div class='p-2 header'>"+ended.name+"<br>"+
                                    "<span class='text-muted'>"+ended.topic+"</span>, "+
                                    " <span class='text-muted'> Duration: "+duration+"</span>"+
                                    "<span class='text-muted right mx-2'>"+schedule+"</span>"+
                                    "<span class='text-muted right mx-2'>"+minute+"</span>"+
                                "</div>";
                }
                //$('.schedules-top-active').hide();        
        });// end each function
    $('#schedules-active').html(active);
    $('#previous-schedules').html(previous);
    
}

$(document).on('click','#close-notification',function(){
    $(this).parent().parent().parent().hide();
})
$(document).on('click','#close-notification-active',function(){
    $(this).parent().parent().parent().parent().parent().hide();
})


// display the choose file form o edit click
$('.edit-profile').on('click',function(){
    $('.choose-image-form').show();
    $('.image-info').hide();

});

// hide the form and cancel the upload
$(document).on('click','.cancel',function(){
    $(this).parent().hide();
});


/**
 * Show forms on button click
 */
function showForm(id)
{
    $('#'+id).show();
}

// hide form if clicked outside the range;
$(document).on('mouseup',function(e) 
{
    var container = $(".more-info-toggle");

    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0) 
    {
        container.hide();
    }
});

// show the upload document form
$(document).on('focus','.new-doc-btn',function(){
    $('.new-doc-form').show();
});


/**
 * resetting use password when logged in
 */

$(document).on('blur','#current-password',function(){
    var password = $(this).val();
    if(password !='')
    {
       /**
        * send an ajax call to check for the correctness of the password entered
        */

       $.ajax({
        url:'/password/check',
        data:{
            password:password
        },
        dataType:'json',
        success:function(res){
            console.log(res);
            if(res !='')
            {
                $('.password-message').html('<h4 class="text-success"><i>Password is correct</i></h4>');
            }else{
                $('.password-message').html('<h4 class="text-success"><i>Wrong password entered</i></h4>');
            }
        }
       });

    }else{
        alert('please enter your current password');
    }
    
});

/**
 * filter section
 */
 function SearchItem(id,id2,section)
 {
    var value = $('#'+id).val().toLowerCase();
    $("#"+id2+" "+section).filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });      
 }

 // filter by class
 function SearchItemClass(id,id2,section)
 {
    var value = $('#'+id).val().toLowerCase();
    $("#"+id2+" "+'.'+section).filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
    console.log(value);      
 }

 /**
  * generate report functions
  */
  function checkDate(dat1,dat2)
        {        
            if(dat1 !='' && dat2 !='')
            {
                // call a function to load the data basing on what has been selected
                if(dat1 > dat2){
                    alert('Start date cannot be greater than end Date. Please check your date and try again.')
                }else{
                    fetchIssues(dat1,dat2)
                }
            }
        }

        // call a function to fetch data
        function fetchIssues(dat1,dat2)
        {
            $.ajax({
                url:'/issues/get',
                data:{
                    date1:dat1,
                    date2:dat2
                },
                beforeSend:function(){
                    $('.results').html("<div class='h4 p-4'><i><center>Loading...</center></i></div>");
                },
                success:function(res){
                    var data ="";
                    if(res.issues.length > 0){  
                        $.each(res.issues,function(index,issue){
                            data+= "<div class='border-bottom p-2'>"+issue.issue_title+
                                "<span class='right'>"+issue.records.length+" records</span>"+
                            "</div>";
                        });
                        $('.results').html(data);
                    }else{
                        $('.results').html("<div class='h4 p-4'><i><center>No data found</center></i></div>");
                    }
                },
                error:function(error){
                    $('.results').html("<div class='h4 p-4'><i><center>Error Loading requested data</center></i></div>");
                }
            });
        }
        
        /**
         * fetch data basing on the category selected
         */
        function fetchIssuesStatus(status)
        {
            var dat1 = $('#start_date').val();
            var dat2 = $('#end_date').val();
            var id = $('#category_name').val();
            if(dat1 !='' && dat2 !='' && id !='')
            {
                $.ajax({
                    url:'/issues/get',
                    data:{
                        date1:dat1,
                        date2:dat2,
                        id:id,
                        status:status
                    },
                    beforeSend:function(){
                        $('.results').html("<div class='h4 p-4'><i><center>Loading...</center></i></div>");
                    },
                    success:function(res){
                        var data ="";
                        if(res.issues.length > 0){                        
                            $.each(res.issues,function(index,issue){
                                data+= "<div class='border-bottom p-2'>"+issue.issue_title+
                                    "<span class='right'>"+issue.records.length+" records</span>"+
                                "</div>";
                            });
                            $('.results').html(data);
                        }else{
                            $('.results').html("<div class='h4 p-4'><i><center>No data found</center></i></div>");
                        }
                    },
                    error:function(error){
                        $('.results').html("<div class='h4 p-4'><i><center>Error Loading requested data</center></i></div>");
                    }
                });
            }else if(id !='' && (dat1 =='' || dat2 =='')){
                $.ajax({
                    url:'/issues/get',
                    data:{
                        id:id,
                        status:status
                    },
                    beforeSend:function(){
                        $('.results').html("<div class='h4 p-4'><i><center>Loading...</center></i></div>");
                    },
                    success:function(res){
                        var data ="";
                        if(res.issues.length > 0){ 
                            $.each(res.issues,function(index,issue){
                                data+= "<div class='border-bottom p-2'>"+issue.issue_title+
                                    "<span class='right'>"+issue.records.length+" records</span>"+
                                "</div>";
                            });
                            $('.results').html(data);
                        }else{
                            $('.results').html("<div class='h4 p-4'><i><center>No data found</center></i></div>");
                        }
                    },
                    error:function(error){
                        $('.results').html("<div class='h4 p-4'><i><center>Error Loading requested data</center></i></div>");
                    }
                });
               
            }else{
                $.ajax({
                    url:'/issues/get',
                    data:{
                        status:status
                    },
                    beforeSend:function(){
                        $('.results').html("<div class='h4 p-4'><i><center>Loading...</center></i></div>");
                    },
                    success:function(res){
                        var data ="";
                        if(res.issues.length > 0){ 
                            $.each(res.issues,function(index,issue){
                                data+= "<div class='border-bottom p-2'>"+issue.issue_title+
                                    "<span class='right'>"+issue.records.length+" records</span>"+
                                "</div>";
                            });
                            $('.results').html(data);
                        }else{
                            $('.results').html("<div class='h4 p-4'><i><center>No data found</center></i></div>");
                        }
                    },
                    error:function(error){
                        $('.results').html("<div class='h4 p-4'><i><center>Error Loading requested data</center></i></div>");
                    }
                });
            }
        }

        /**
         * fetch issues basing on issue title
         */
        function fetchIssuesCategory(id)
        {
            var dat1 = $('#start_date').val();
            var dat2 = $('#end_date').val();
            if(dat1 !='' && dat2 !='')
            {
                $.ajax({
                    url:'/issues/get',
                    data:{
                        date1:dat1,
                        date2:dat2,
                        id:id
                    },
                    beforeSend:function(){
                        $('.results').html("<div class='h4 p-4'><i><center>Loading...</center></i></div>");
                    },
                    success:function(res){
                        var data ="";
                        if(res.issues.lenth > 0){                        
                            $.each(res.issues,function(index,issue){
                                data+= "<div class='border-bottom p-2'>"+issue.issue_title+
                                    "<span class='right'>"+issue.records.length+" records</span>"+
                                "</div>";
                            })
                            $('.results').html(data);
                        }else{
                            $('.results').html("<div class='h4 p-4'><i><center>No data found</center></i></div>");
                        }
                    },
                    error:function(error){
                        $('.results').html("<div class='h4 p-4'><i><center>Error Loading requested data</center></i></div>");
                    }
                });
            }else{
                $.ajax({
                    url:'/issues/get',
                    data:{
                        id:id
                    },
                    beforeSend:function(){
                        $('.results').html("<div class='h4 p-4'><i><center>Loading...</center></i></div>");
                    },
                    success:function(res){
                        var data ="";
                            $.each(res.issues,function(index,issue){
                                data+= "<div class='border-bottom p-2'>"+issue.issue_title+
                                    "<span class='right'>"+issue.records.length+" records</span>"+
                                "</div>";
                            })
                            $('.results').html(data);
                    },
                    error:function(error){
                        $('.results').html("<div class='h4 p-4'><i><center>Error Loading requested data</center></i></div>");
                    }
                });
            }
        }
