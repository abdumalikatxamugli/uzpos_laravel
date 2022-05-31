<!--
=========================================================
* Soft UI Dashboard - v1.0.4
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <title>
    UZPOS LARAVEL
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="/assets/css/soft-ui-dashboard.css" rel="stylesheet" />
</head>
<body>
<style>
    body{
        background-image: url("/assets/img/bg.jpg");
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        height: 100vh;
    }
</style>
<main>
    <div class="d-flex align-items-center justify-content-center" style="height: 100vh">
        <div class="card " style="background-color: rgba(22, 109, 22, 0.4);">
            <div class="card-body">
                @include("partials.validation_errors")
                <form action="{{route('dashboard.login')}}" method="POST" class="text-center">
                    @csrf
                    <input type="text" name="username" class="form-control form-control-sm mb-3">
                    <input type="password" name="password" class="form-control form-control-sm mb-3">
                    <button class="btn btn-sm btn-success">Login</button>
                </form>
            </div>
        </div>
    </div>
</main>
<script src="../assets/js/core/popper.min.js"></script>
<script src="../assets/js/core/bootstrap.min.js"></script>
<script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
<script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.4"></script>
</body>

</html>
