<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rofood</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">   
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <!-- Icofont -->
    <link rel="stylesheet" href="{{asset('public/css/icofont.min.css')}}">
    <!-- material icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <!-- Main Style -->
    <link rel="stylesheet" href="{{asset('public/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('public/css/responsive.css')}}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- Global site tag (gtag.js) - Google Ads: 10845715257 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-10845715257"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'AW-10845715257');
    </script>
    @yield('links')
</head>
<body> 
    <!-- Start Top Nav -->
    <nav class="navbar navbar-expand-lg top-nav">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <h2 style="color: #001bb7; font-weight:bold;">
                    اهلا بك@if(Auth::user())
                    {{Auth::user()->name}}
                   @endif
                    في Rofood
                </h2>
               
                    
                
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="color-main"><i class="fa fa-bars"></i></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <div class="d-flex align-items-center top-nav-content">
                    <span class="mx-2" id="dateTime"></span>

                    
                    <ul class="navbar-nav">
                        {{--
                        <li class="nav-item dropdown">
                            <a class="nav-link text-secondary dropdown-toggle" href="#" id="navbarDropdown0" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="icon color-blue"><i class="bi bi-globe2"></i></span>  
                            </a>
                            <ul class="dropdown-menu text-end" aria-labelledby="navbarDropdown0">
                                    @if(LaravelLocalization::getCurrentLocale() == 'ar')
                                <li>
                                    <a rel="alternate" class="dropdown-item" hreflang="en" href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}">{{__('settings.english')}}</a>
                                </li>
                                    @elseif(LaravelLocalization::getCurrentLocale() == 'en')
                                <li>
                                    <a rel="alternate" class="dropdown-item" hreflang="ar" href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}"> {{__('settings.arabic')}} </a>
                                </li>
                                    @endif
                            </ul>
                        </li>--}}
                        <li class="nav-item dropdown">
                            <a class="nav-link text-secondary dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{asset('public/images/person1.jpg')}}" width="40" class="rounded-circle" alt="">
                                @if(Auth::user())
                                {{Auth::user()->name}}
                                @else
                                guest
                                @endif   
                            </a>
                            <?php $auther = Auth::user() ?>
                            <ul class="dropdown-menu text-end" aria-labelledby="navbarDropdown">
                                @if(!$auther->hasRole('مشرف'))
                                <li><a class="dropdown-item" href="{{route('switch.sub')}}">تبديل الفروع</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                <form method="POST" action="{{route('logout')}}">
                                    @csrf
                                <a onclick="this.parentNode.submit();" class="dropdown-item color-red">{{__('settings.logout')}}</a>
                                </form>
                                </li>
                                </ul>
                        </li>
                    </ul>
                </div>         
          </div>
        </div>
    </nav>
    <!-- Start Side Nav -->
    <nav class="side-nav">
        <div class="side-nav-toggler">
            <i class="bi bi-layout-text-sidebar"></i>
        </div>
        <div class="logo"><img src="{{asset('public/images/logo.png')}}" alt="rofood_logo"></div>
        <ul class="menu">
            {{--
            <p style="color: white">
                id={{Session::get('repo_id')}}</p>
            --}} 
        </ul>
    </nav> <!-- End Side Nav -->

    <!-- Start Content -->
    <body>
    @yield('body')


    <!-- JavaScript Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    {{--
    <script src="{{asset('js/jquery-3.6.0.min.js')}}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    {{--
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>--}} {{-- use it in specific page only --}}
    <script src="{{asset('public/js/main.js')}}"></script>
    @yield('scripts')

</body>
</html>