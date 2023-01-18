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
  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="/assets/css/soft-ui-dashboard.css" rel="stylesheet" />
  <script src="{{asset('alpine.min.js')}}" defer></script>
</head>

<body class="g-sidenav-show  bg-gray-100">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/soft-ui-dashboard/pages/dashboard.html " target="_blank">
        <span class="ms-1 font-weight-bold">ADMIN PANEL</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        @if(auth()->user()->user_role == 0)
          @if(auth()->user()->username == 'owner')
            <li class="nav-item">
              <button class="nav-link" data-href="{{ route('dashboard.order.new', 2) }}" onclick="openModal(this)">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                </div>
                <span class="nav-link-text ms-1">Розничный заказ</span>
              </button>
              <script>
                function openModal(el){
                  window.open(`${el.dataset.href}`, 'name' + Math.random(), 'width=1200,height=800');
                }
              </script>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('dashboard.orders.index', 1) }}">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                </div>
                <span class="nav-link-text ms-1">Принятые Заказы</span>
              </a>
            </li> 
            <li class="nav-item">
              <a class="nav-link" href="{{ route('dashboard.orders.index', 2) }}">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                </div>
                <span class="nav-link-text ms-1">Завершенные Заказы</span>
              </a>
            </li> 
            <li class="nav-item">
              <a class="nav-link" href="{{ route('dashboard.orders.index', 3) }}">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                </div>
                <span class="nav-link-text ms-1">Отбр. Заказы</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('dashboard.orders.index', ['status'=>2, 'other_shop'=>1]) }}">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                </div>
                <span class="nav-link-text ms-1">Заказы от др.</span>
              </a>
            </li> 
            <li class="nav-item">
              <a class="nav-link" href="{{ route('dashboard.client.index') }}">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                </div>
                <span class="nav-link-text ms-1">Клиенты</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('dashboard.party.index') }}">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                </div>
                <span class="nav-link-text ms-1">Приход товаров</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('dashboard.transfer.index') }}">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                </div>
                <span class="nav-link-text ms-1">Перемешения товаров</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('dashboard.reports.main') }}">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                </div>
                <span class="nav-link-text ms-1">Отчеты</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('dashboard.expense.index') }}">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                </div>
                <span class="nav-link-text ms-1">Расходы</span>
              </a>
            </li>
          @endif

          <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard.metric.index') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
              </div>
              <span class="nav-link-text ms-1">Единицы измерение</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard.category.index') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
              </div>
              <span class="nav-link-text ms-1">Категории</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard.brand.index') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
              </div>
              <span class="nav-link-text ms-1">Бренды</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard.point.index') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
              </div>
              <span class="nav-link-text ms-1">Магазины и склады</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard.product.index') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
              </div>
              <span class="nav-link-text ms-1">Продукты</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard.user.index') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
              </div>
              <span class="nav-link-text ms-1">Персонал</span>
            </a>
          </li>
        @endif

        @if(auth()->user()->user_role == 1 || auth()->user()->user_role == 3)
          <li class="nav-item">
            <button class="nav-link" data-href="{{ route('dashboard.order.new', 2) }}" onclick="openModal(this)">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
              </div>
              <span class="nav-link-text ms-1">Розничный заказ</span>
            </button>
            <script>
              function openModal(el){
                window.open(`${el.dataset.href}`, 'name' + Math.random(), 'width=1200,height=800');
              }
            </script>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard.orders.index', 1) }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
              </div>
              <span class="nav-link-text ms-1">Принятые Заказы</span>
            </a>
          </li> 
          <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard.orders.index', 2) }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
              </div>
              <span class="nav-link-text ms-1">Завершенные Заказы</span>
            </a>
          </li> 
          <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard.orders.index', 3) }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
              </div>
              <span class="nav-link-text ms-1">Отбр. Заказы</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard.orders.index', ['status'=>2, 'other_shop'=>1]) }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
              </div>
              <span class="nav-link-text ms-1">Заказы от др.</span>
            </a>
          </li>  
          <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard.client.index') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
              </div>
              <span class="nav-link-text ms-1">Клиенты</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard.party.index') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
              </div>
              <span class="nav-link-text ms-1">Приход товаров</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard.transfer.index') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
              </div>
              <span class="nav-link-text ms-1">Перемешения товаров</span>
            </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="{{ route('dashboard.reports.main') }}">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                </div>
                <span class="nav-link-text ms-1">Отчеты</span>
              </a>
           </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard.expense.index') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
              </div>
              <span class="nav-link-text ms-1">Расходы</span>
            </a>
          </li>
        @endif

        
      </ul>
    </div>
    <div class="sidenav-footer mx-3 ">

    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <h6 class="font-weight-bolder mb-0"></h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">

          </div>
          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <div style="margin-right:50px"> {{ auth()->user()->username }} </div>
            </li>
            <li class="nav-item d-flex align-items-center">
              <a href="{{ route('dashboard.logout') }}" class="nav-link text-body font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none">Logout</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="card">
            @yield('content')
        </div>
      <footer class="footer pt-3  ">
        <div class="container-fluid">

        </div>
      </footer>
    </div>
  </main>

  <!--   Core JS Files   -->
  <script src="/assets/js/core/popper.min.js"></script>
  <script src="/assets/js/core/bootstrap.min.js"></script>
  <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="/assets/js/soft-ui-dashboard.js?v=1.0.4"></script>
</body>

</html>
