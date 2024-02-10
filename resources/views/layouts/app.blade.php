<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Counselor') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <h3>{{ config('app.name', 'My Counselor') }}</h3>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a href="/clients" class="nav-link">Clients</a>
                        </li>
                        <li class="nav-item">
                            <a href="/category" class="nav-link">Category</a>
                        </li>
                        <li class="nav-item">
                            <a href="/records" class="nav-link">Records</a>
                        </li>
                        <li class="nav-item">
                            <a href="/schedule" class="nav-link">Schedules</a>
                        </li>
                        <li class="nav-item">
                            <a href="/reports" class="nav-link">Reports</a>
                        </li>
                        @if(Auth::user()->hasRole('superadministrator'))
                        <li class="nav-item">
                            <a href="/users" class="nav-link">Users</a>
                        </li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                    <input type="text" class="custom-input nav-search" id='search-client' placeholder='Search...' autocomplete='off'>
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->firstName }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('profile') }}">
                                        {{ __('Profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('passwordchange') }}">
                                        {{ __('Change Password') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
            <div class="p-2 bg-white search-results shadow-sm card-body">
            </div>
            <div class="bg-white p-2 shadow schedules-top">
                <h5 class="header">
                    Upcoming
                    <span class="right">
                        <button class="btn btn-sm btn-light" id='close-notification'>
                            &times;
                        </button>
                    </span>
                </h5>
                <div class="p-2" id="schedules"></div>
                <!--display schedules coming up-->
            </div>
            <div class="bg-white shadow schedules-top-active">
                <div class="row p-1">
                    <div class="col">
                        <h4 class="header bg-white">
                            Active Discussion
                            <span class="right">
                                <button class="btn btn-sm btn-danger" id='close-notification-active'>
                                    &times;
                                </button>
                            </span>
                        </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="p-1" id="schedules-active"></div>
                    <!--display schedules running-->
                    </div>
                </div>
            </div>
        </nav>
        <div class="p-2 bg-dark nav-2">
            @yield('crumbs')
        </div>
        <main class="py-2 main-content">
            @yield('content')
        </main>
    </div>
<!-- ckeditor script-->
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/custom.js') }}" defer></script>
    <script src="//cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}" defer></script>
    <script>
        CKEDITOR.replace( 'new-record-text' );

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

        //SearchItemClass('searchRecord','all-records','records-display')
        function SearchItemClass(id,id2,section)
        {
            var value = $('#'+id).val().toLowerCase();
            $("#"+id2+" "+'.'+section).filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });     
        }
    </script>
</body>
</html>
