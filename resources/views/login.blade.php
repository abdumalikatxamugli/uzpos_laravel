<!--
=========================================================
Material Dashboard - v2.1.2
=========================================================

Product Page: https://www.creative-tim.com/product/material-dashboard
Copyright 2020 Creative Tim (https://www.creative-tim.com)
Coded by Creative Tim

=========================================================
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets2/img/apple-icon.png')}}">
  <link rel="icon" type="image/png" href="{{asset('assets2/img/favicon.png')}}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Protools
  </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="{{asset('assets2/css/material-dashboard.css?v=2.1.2')}}" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="{{asset('assets2/demo/demo.css')}}" rel="stylesheet" />
  <style>
    body{
        background-image: url({{asset('assets2/img/background.jpg')}});
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-blend-mode: luminosity;
    }
    .shade{
        background-color: #00000030;
        position: absolute;
        height: 100vh;
        width: 100vw;
    }
    .wrapper{
        display: flex;
        width: 100vw;
        height: 100vh;
        align-items: center;
        justify-content: center;
        transition: 1s;
    }
    .normal-body{
        background-blend-mode: normal !important;
        transition: 1s;
    }
    .card-header{
        transition: .5s;
    }
    .card:hover .card-header{
        margin-top: -40px !important;
        transition: .5s;
    }
  </style>
</head>
<body>
    <div class="wrapper">
        <div class="shade"></div>
        <div class="container">
            <div class="my-login row">
                <div class="col-md-4"></div>
                <div class="col-md-4 ">
                    <div class="card login-card">
                        <div class="card-header card-header-primary p-5 text-center">
                            <h4 class="text-bold">
                               <strong>Войти в систему</strong>
                            </h4>
                        </div>
                        <div class="card-body p-5">
                                @include("partials.validation_errors")
                                <form action="{{route('dashboard.login')}}" method="POST" class="text-center">
                                    @csrf
                                    <input  autocomplete="off" type="text" name="username" class="form-control form-control-sm mb-3" placeholder="Username">
                                    <input type="password" name="password" class="form-control form-control-sm mb-3" placeholder="Password">
                                    <button class="btn btn-link text-danger btn-lg">Login</button>
                                </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </div>
    <script src="{{asset('assets2/js/core/jquery.min.js')}}"></script> 
    <script>
        $(".login-card input").focusin(
        function()
        {
            $("body").addClass("normal-body");
        }
        );
        $(".login-card input").focusout(
        function()
        {
            $("body").removeClass("normal-body");
        }
        );
        
    </script>
</body>
</html>