<!DOCTYPE html>
<html lang="en">
<head>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sakhawat app</title>
        <link type="text/css" href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('bootstrap/css/bootstrap-responsive.min.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('css/theme.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('images/icons/css/font-awesome.css') }}" rel="stylesheet">
        <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
            rel='stylesheet'>
        
      <!--   <link href="{{ asset('css/bootstrap-datepicker.css')}}" rel="stylesheet">-->
         <script src="{{ asset('scripts/jquery-1.9.1.min.js') }}" type="text/javascript"></script>
       <!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>  <!-- jQuery CDN -->
      <!--  <script src="{{ asset('scripts/jquery-3.5.0.min.js') }}" type="text/javascript"></script-->
        <script src="{{ asset('scripts/jquery-ui-1.10.1.custom.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('scripts/flot/jquery.flot.js') }}" type="text/javascript"></script>
        <script src="{{ asset('scripts/flot/jquery.flot.resize.js') }}" type="text/javascript"></script>
        <script src="{{ asset('scripts/common.js') }}" type="text/javascript"></script>
        
        
        
        
        
        <!--   Date picker links here-->
      <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
      <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
         
                                                   
         
    </head>
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                        <i class="icon-reorder shaded"></i></a><a class="brand" href="{{route('home')}}">Sakhawat App </a>
                    <div class="nav-collapse collapse navbar-inverse-collapse">
                       <!-- <ul class="nav nav-icons">
                            <li class="active"><a href="#"><i class="icon-envelope"></i></a></li>
                            <li><a href="#"><i class="icon-eye-open"></i></a></li>
                            <li><a href="#"><i class="icon-bar-chart"></i></a></li>
                        </ul>
                        <form class="navbar-search pull-left input-append" action="#">
                        <input type="text" class="span3">
                        <button class="btn" type="button">
                            <i class="icon-search"></i>
                        </button>
                        </form>-->
                        <ul class="nav pull-right">
                           <!-- <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown
                                <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Item No. 1</a></li>
                                    <li><a href="#">Don't Click</a></li>
                                    <li class="divider"></li>
                                    <li class="nav-header">Example Header</li>
                                    <li><a href="#">A Separated link</a></li>
                                </ul>
                            </li>-->
                            <li><a href="#">{{ Auth::user()->name }}</a></li>
                            <li class="nav-user dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ asset('images/user.png') }}" class="nav-avatar" />
                                <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Your Profile</a></li>
                                    <li><a href="#">Edit Profile</a></li>
                                    <li><a href="#">Account Settings</a></li>
                                    <li class="divider"></li>
                                    <li> <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- /.nav-collapse -->
                </div>
            </div>
            <!-- /navbar-inner -->
        </div>
        <!-- /navbar -->
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="span3">
                        <div class="sidebar">
                            <ul class="widget widget-menu unstyled">
                                <li class="active"><a href="{{route('home')}}"><i class="menu-icon icon-dashboard"></i>Dashboard
                                </a></li>
                               
                             <!--   <li><a href="task.html"><i class="menu-icon icon-tasks"></i>Tasks <b class="label orange pull-right">
                                    19</b> </a></li>-->
                            </ul>
                            <!--/.widget-nav-->
                            <ul class="widget widget-menu unstyled">
                                <li><a class="collapsed" data-toggle="collapse" href="#togglePages1"><i class="menu-icon icon-book">
                                </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right">
                                </i>Reciept Books </a>
                                    <ul id="togglePages1" class="collapse unstyled">
                                        <li><a href="{{route('Rt2registerbook')}}"><i class="icon-inbox"></i>Register Book </a></li>
                                        <li><a href="{{route('RtVassignRbooks')}}"><i class="icon-inbox"></i>Assign Book </a></li>
                                        <li><a href="{{route('disposeRecieptBook')}}"><i class="icon-inbox"></i>Dispose Book </a></li>
                                    </ul>
                                </li>
                                
                                <li><a class="collapsed" data-toggle="collapse" href="#togglePages2"><i class="menu-icon icon-paste">
                                </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right">
                                </i>Collection </a>
                                    <ul id="togglePages2" class="collapse unstyled">
                                        <li><a href="{{route('RtDonar')}}"><i class="icon-inbox"></i>Donar </a></li>
                                        <li><a href="{{route('Rt6getDonee')}}"><i class="icon-inbox"></i>Donee </a></li>
                                         <li><a href="{{route('bankledger')}}"><i class="icon-inbox"></i>Banking</a></li>
                                    </ul>
                                </li>
                                
                           <!--     <li><a class="collapsed" data-toggle="collapse" href="#togglePages3"><i class="menu-icon icon-paste">
                                </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right">
                                </i>Distribution </a>
                                    <ul id="togglePages3" class="collapse unstyled">
                                        <li><a href="other-login.html"><i class="icon-inbox"></i>Benificiary </a></li>
                                        <li><a href="other-user-profile.html"><i class="icon-inbox"></i>Fund Approval </a></li>
                                        
                                    </ul>
                                </li>-->
                                
                                <li><a class="collapsed" data-toggle="collapse" href="#togglePages4"><i class="menu-icon icon-cog">
                                </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right">
                                </i>App Setting </a>
                                    <ul id="togglePages4" class="collapse unstyled">
                                        <li><a href="{{route('setFyIntialisation')}}"><i class="icon-inbox"></i>Intialise Financial year</a></li>
                                        <li><a href="{{route('AppSetting')}}"><i class="icon-inbox"></i>Set Organisation </a></li>
                                        <li><a href="{{route('Rt4userRegistration')}}"><i class="icon-inbox"></i>User </a></li>
                                        <li><a href="other-user-listing.html"><i class="icon-inbox"></i>User Access </a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><i class="menu-icon icon-signout"></i>Logout </a></li>
                            </ul>
                            <!--/.widget-nav-->
                            
                       <!--     
                            <ul class="widget widget-menu unstyled">
                                <li><a href="ui-button-icon.html"><i class="menu-icon icon-bold"></i> Buttons </a></li>
                                <li><a href="ui-typography.html"><i class="menu-icon icon-book"></i>Typography </a></li>
                                <li><a href="form.html"><i class="menu-icon icon-paste"></i>Forms </a></li>
                                <li><a href="table.html"><i class="menu-icon icon-table"></i>Tables </a></li>
                                <li><a href="charts.html"><i class="menu-icon icon-bar-chart"></i>Charts </a></li>
                            </ul>
                        -->    
                        </div>
                        <!--/.sidebar-->
                    </div>
                    <!--/.span3-->
                    <div class="span9">
                        <div class="content">
                     @yield('content')
                        </div>
                        <!--/.content-->
                    </div>
                    <!--/.span9-->
                </div>
            </div>
            <!--/.container-->
        </div>
        <!--/.wrapper-->
        <div class="footer">
            <div class="container">
                <b class="copyright">Developed By <a href="www.redzoon.com">Redzoon</a></b> &copy;<small>2020, PHP Framework {{config('app.framework')}}-Ver {{config('app.version')}}</small><br>
                <small> Template Designed By:&copy; 2014 Edmin - EGrappler.com  All rights reserved.</small><br>
                    Registered to {{ $regEstbl->estbname ?? 'Nemo'}}<br>{{ $regEstbl->address ??''}} {{ $regEstbl->mobile ??''}}<br>{{ $regEstbl->email ??''}} <br> {{ $regEstbl->url ??''}}
                    
		
            </div>
        </div>
        
       
      
    </body>
