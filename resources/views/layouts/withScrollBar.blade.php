<!--
=========================================================
 Material Dashboard - v2.1.2
=========================================================

 Product Page: https://www.creative-tim.com/product/material-dashboard
 Copyright 2020 Creative Tim (https://www.creative-tim.com)
 Licensed under MIT (https://github.com/creativetimofficial/material-dashboard/blob/master/LICENSE.md)

 Coded by Creative Tim

=========================================================

 The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
 <!DOCTYPE html>
 @if( LaravelLocalization::getCurrentLocale() == 'en')
 <html lang="en">
 @elseif(LaravelLocalization::getCurrentLocale() == 'ar')
 <html lang="fa" dir="rtl">
  @endif
 
 <head>
   <meta charset="utf-8" />
   <link rel="apple-touch-icon" sizes="76x76" href="{{asset('public/img/apple-icon.png')}}">
   <link rel="icon" type="image/png" href="{{asset('public/img/favicon.png')}}">
   <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
   <title>
    RoFood
  </title>
   <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
   <!-- Extra details for Live View on GitHub Pages -->
   <!-- Canonical SEO -->
  
   <!--     Fonts and icons     -->
   <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
   <!-- Markazi Text font include just for persian demo purpose, don't include it in your project -->
   <link href="https://fonts.googleapis.com/css?family=Cairo&amp;subset=arabic" rel="stylesheet">
   <!-- CSS Files -->
   <link href="{{asset('public/css/material-dashboard.min.css?v=2.1.2')}}" rel="stylesheet" />
   <link href="{{asset('public/css/material-dashboard-rtl.min.css?v=1.1')}}" rel="stylesheet" />
   <!-- CSS Just for demo purpose, don't include it in your project -->
   <link href="{{asset('public/demo/demo.css')}}" rel="stylesheet" />

  <!-- Global site tag (gtag.js) - Google Ads: 10867249101 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-10867249101"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-10867249101');
</script>
   @if(LaravelLocalization::getCurrentLocale() == 'ar')
   <style>
     body{
       text-align: right !important;
       direction: rtl !important;
     }
    </style>
    @endif
     <style>
     form a:hover{
       color: white !important;
     }
     .ps-scrollbar-x{
       display: none !important;   /* hide scroll bar */
     }
     #logo{
      border-radius: 50%;
       width: 75px;
       height: 75px;
       z-index: 2;
       margin-top: 25px;
       filter: drop-shadow(0px 3px 5px black);
     }
     .logo-container{
       display: flex;
       justify-content: center;
       align-items: center;
     }
     .user-info{
       margin-top: 5px;       
       z-index: 2;
     }
    </style>
   @yield('links')
 
   <!-- End Google Tag Manager -->
   <!-- Style Just for persian demo purpose, don't include it in your project -->
   <style>
     body,
     h1,
     h2,
     h3,
     h4,
     h5,
     h6,
     .h1,
     .h2,
     .h3,
     .h4 {
       font-family: "Cairo";
     }
   </style>
 </head>
 <body class="">
    <!-- Extra details for Live View on GitHub Pages -->
  
    <div class="wrapper ">
      <div class="sidebar" data-color="azure" data-background-color="white" data-image="{{asset('public/img/sidebar-1.jpg')}}">
        <!--
          Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"
  
          Tip 2: you can also add an image using data-image tag
      -->
      <div class="logo-container">
        {{-- <a style="z-index: 2" href="/"> --}}
       @if(isset($repositories))  {{-- page for multi repositories --}}
       <div style="display: flex; flex-direction: row">
       @if($repositories[0]->logo)
       <img src="{{asset('public/storage/'.$repositories[0]->logo)}}" id="logo">
       @else
       <img src="{{asset('public/img/rofood.jpg')}}" id="logo">
       @endif
       </div>
       @elseif(isset($repository)) {{-- page for one repository --}}
       @if($repository->logo)
       <img src="{{asset('public/storage/'.$repository->logo)}}" id="logo">
       @else
       <img src="{{asset('public/img/rofood.jpg')}}" id="logo">
       @endif
       @else  {{-- not sending repo variable at all --}}
      <img src="{{asset('public/img/rofood.jpg')}}" id="logo">
       @endif
        {{-- </a>  --}}
       </div>
        <div class="sidebar-wrapper">
          <?php $auther = Auth::user() ?>
        <div class="user-info">
         <span class="badge badge-success"> {{__('menu.welcome')}} {{$auther->name}} </span> {{__('reports.last_login')}} 
         {{$auther->last_login_old()}}
        </div>
          <ul class="nav">
            @can('لوحة التحكم')
            <li class="nav-item {{ request()->is('dashboard')||request()->is('/') ? 'active' : '' }}">
              <a class="nav-link" href="/">
                <i class="material-icons">dashboard</i>
                <p>لوحة التحكم</p>
              </a>
            </li>
            @endcan
            @can('المناصب')
            <li class="nav-item {{ request()->is('roles')||request()->is('role/add/form')||request()->is('edit/role/permissions/*') ? 'active' : '' }}">
             <a class="nav-link" href="{{route('roles')}}">
               <i class="material-icons">
                 work </i>
               <p> المناصب</p>
             </a>
           </li>
           @endcan
           @can('صلاحيات الوصول')
           <li class="nav-item {{ request()->is('permissions')||request()->is('permission/add/form') ? 'active' : '' }} ">
            <a class="nav-link" href="{{route('permissions')}}">
              <i class="material-icons">
                accessibility</i>
              <p> صلاحيات الوصول</p>
            </a>
          </li>
          @endcan
  
          @can('المخازن')
          <li class="nav-item {{ request()->is('repositories')||request()->is('repositories/create')? 'active' : ''}}">
            <a class="nav-link" href="{{route('repositories.index')}}">
              <i class="material-icons">storefront</i>
              <p>المخازن</p>
            </a>
          </li>
           @endcan 
           @can('لوحة تحكم مالك-مخزن')
            <li class="nav-item {{ request()->is('dashboard')||request()->is('/') ? 'active' : '' }}">
              <a class="nav-link" href="{{route('in.repository',$repository->id)}}">
                <i class="material-icons">dashboard</i>
                <p>{{__('menu.owner_dashboard')}}</p>
              </a>
            </li>
            @endcan
            @can('لوحة تحكم موظف')
            <li class="nav-item {{ request()->is('dashboard')||request()->is('/') ? 'active' : '' }}">
              <a class="nav-link" href="{{route('in.repository',$repository->id)}}">
                <i class="material-icons">dashboard</i>
                <p>{{__('menu.employee')}}</p>
              </a>
            </li>
            @endcan
            @can('المبيعات')
           <li class="nav-item {{ request()->is('sales')? 'active' : ''}}">
            <a class="nav-link" href="{{route('sales.index',$repository->id)}}">
              <i class="material-icons">shopping_bag</i>
              <p>{{__('menu.sales')}}</p>
            </a>
          </li>
          @endcan
          @can('التقارير')
          <li class="nav-item {{ request()->is('reports')? 'active' :'' }}">
            <a class="nav-link" href="{{route('reports.index',$repository->id)}}">
              <i class="material-icons">receipt_long</i>
              <p>{{__('menu.reports')}}</p>
            </a>
          </li>
         @endcan
          @can('المخزون')
          <li class="nav-item {{ request()->is('repository')||request()->is('add/product/form/*')||request()->is('show/products/*')||request()->is('import/products/excel/*')? 'active' : ''}}">
            <a class="nav-link" href="{{route('repository.index',$repository->id)}}">
              <i class="material-icons">store</i>
              <p>{{__('menu.stock')}}</p>
            </a>
          </li>
          @endcan
          @can('المشتريات')
          <li class="nav-item {{ request()->is('purchases')? 'active' : ''}}">
            <a class="nav-link" href="{{route('purchases.index',$repository->id)}}">
              <i class="material-icons">local_shipping</i>
              <p>{{__('purchases.purchases')}}</p>
            </a>
          </li>
          @endcan
          @can('الكاشير')
          <li class="nav-item {{ request()->is('cashier')? 'active' : ''}}">
            <a class="nav-link" href="{{route('cashier.index',$repository->id)}}">
              <i class="material-icons">point_of_sale</i>
              <p>{{__('menu.cashier')}}</p>
            </a>
          </li>
          @endcan
          @can('الاعدادات')
          <li class="nav-item {{ request()->is('manager/settings')? 'active' : ''}}">
            <a class="nav-link" href="{{route('manager.settings.index',$repository->id)}}">
              <i class="material-icons">settings</i>
              <p>{{__('menu.settings')}}</p>
            </a>
          </li>
          @endcan
          @can('المخزون')
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="material-icons">support_agent</i>
              <p>{{__('menu.tech_support')}}</p>
            </a>
          </li>
          @endcan
          








            

















           
          </ul>
        </div>
      </div>
       <!-- Navbar -->

    <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
      <div class="container-fluid">
        <div class="navbar-wrapper">
         
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
          <span class="sr-only">Toggle navigation</span>
          <span class="navbar-toggler-icon icon-bar"></span>
          <span class="navbar-toggler-icon icon-bar"></span>
          <span class="navbar-toggler-icon icon-bar"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end">
          
          <ul class="navbar-nav">
            {{--<li>
              <a rel="alternate" hreflang="ar" href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}">
                <img src="{{asset('img/ar_lang.png')}}" width="75px" height="50px">
              </a>
              <a rel="alternate" hreflang="en" href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}">
                <img src="{{asset('img/en_lang.png')}}" width="75px" height="50px">
              </a>
          </li>--}}
          <li class="nav-item dropdown">
            <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="material-icons">language</i>
              <p class="d-lg-none d-md-block">
                الحساب
              </p>
            </a> {{-- language selectors --}}
            <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdownProfile">
              @if(LaravelLocalization::getCurrentLocale() == 'ar')
            <a rel="alternate" class="dropdown-item" hreflang="en" href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}">{{__('settings.english')}}</a>
            @elseif(LaravelLocalization::getCurrentLocale() == 'en')
            <a rel="alternate" class="dropdown-item" hreflang="ar" href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}"> {{__('settings.arabic')}} </a>
            @endif
          </li>
            <li class="nav-item">
              <a class="nav-link" href="javascript:;">
                <i class="material-icons">email</i>
                <p class="d-lg-none d-md-block">
                  صندوق البريد
                </p>
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="material-icons">notifications</i>
                <span class="notification">1</span>
                <p class="d-lg-none d-md-block">
                  الإشعارات
                </p>
              </a>
              <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="#"> سنضع الإشعارات هنا </a>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="material-icons">account_circle</i>
                <p class="d-lg-none d-md-block">
                  الحساب
                </p>
              </a>
              <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdownProfile">
                <a class="dropdown-item" href="#">{{__('settings.account')}}</a>
                <a class="dropdown-item" href="#">{{__('settings.settings')}}</a>
                <a class="dropdown-item" href="{{route('switch.sub')}}">تبديل الفرع</a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{route('logout')}}">
                  @csrf
                  <a style="cursor: pointer;color:red;" onclick="this.parentNode.submit();" class="dropdown-item">{{__('settings.logout')}}</a>
                </form>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
 <!-- End Navbar -->
 @yield('body')
  <!--   Core JS Files   -->
  <script src="{{asset('public/js/core/jquery.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('public/js/core/popper.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('public/js/core/bootstrap-material-design.min.js')}}" type="text/javascript"></script>
  {{--<script src="{{asset('js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>--}}
  <!--  Google Maps Plugin    -->
  {{--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2Yno10-YTnLjjn_Vtk0V8cdcY5lC4plU"></script>--}}
  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Chartist JS -->
  <script src="{{asset('public/js/plugins/chartist.min.js')}}"></script>
  <!--  Notifications Plugin    -->
  <script src="{{asset('public/js/plugins/bootstrap-notify.js')}}"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{asset('public/js/material-dashboard.min.js?v=2.1.2')}}" type="text/javascript"></script>
 @yield('scripts')
    </body>
 </html>