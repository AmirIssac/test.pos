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

    <!-- Global site tag (gtag.js) - Google Ads: 10867249101 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-10867249101"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-10867249101');
</script>
    @yield('links')
</head>
<body> 
    <!-- Start Top Nav -->
    <nav class="navbar navbar-expand-lg top-nav">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <h2>
                    @if(isset($repository) && !Auth::user()->hasRole('مشرف'))
                    @if(LaravelLocalization::getCurrentLocale() == 'ar')
                    {{$repository->name}}
                   @elseif(LaravelLocalization::getCurrentLocale() == 'en')
                    {{$repository->name_en}}
                    @else
                    {{$repository->name}}
                    @endif
                    @endif
                </h2>
                @if(isset($repository) && !Auth::user()->hasRole('مشرف'))
                <div class=" d-flex align-items-center">
                    <span class="icon ms-2 color-blue"><i class="bi bi-geo-alt"></i></span>
                    <span>{{$repository->address}}</span>
                </div> 
                @endif
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="color-main"><i class="fa fa-bars"></i></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <div class="d-flex align-items-center top-nav-content">
                    <span class="mx-2" id="dateTime"></span>

                    <a href="" class="position-relative me-2">
                        <span class="icon color-blue"><i class="bi bi-envelope"></i></span>
                        <span class="position-absolute translate-middle badge rounded-pill bg-secondary">5 <span class="visually-hidden">unread messages</span></span>
                        </span>
                    </a>
                    <a href="" class="position-relative mx-3">
                        <span class="icon color-blue"><i class="bi bi-bell"></i></span>
                        <span class="position-absolute translate-middle badge rounded-pill bg-secondary">5 <span class="visually-hidden">unread alerts</span></span>
                    </a>
                    <ul class="navbar-nav">
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
                        </li>
                        <?php $auther = Auth::user() ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link text-secondary dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{asset('public/images/person1.jpg')}}" width="40" class="rounded-circle" alt="">
                                {{$auther->name}}     
                            </a>
                            <ul class="dropdown-menu text-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{route('view.account',Auth::id())}}">{{__('settings.account')}}</a></li>
                            <li><a class="dropdown-item" href="#">{{__('settings.settings')}}</a></li>
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
        <div class="logo">
            <img src="{{asset('public/images/logo.png')}}" alt="rofood_logo">
        </div>
        <ul class="menu">
            @can('لوحة التحكم')
            <li><a class="{{ request()->is('dashboard')||request()->is('/') ||request()->is('en') ? 'active' : '' }}" href="/"><span class="icon"><i class="material-icons">dashboard</i></span>{{__('menu.dashboard')}}</a></li>
            @endcan
            @can('المناصب')
            <li><a class="{{ request()->is('roles')||request()->is('role/add/form')||request()->is('edit/role/permissions/*')||request()->is('en/roles') ? 'active' : '' }}" href="{{route('roles')}}"><span class="icon"><i class="material-icons">
                work </i></span>{{__('menu.roles')}}</a></li>
            @endcan
            @can('صلاحيات الوصول')
            <li><a class="{{ request()->is('permissions')||request()->is('permission/add/form')||request()->is('en/permissions') ? 'active' : '' }} " href="{{route('permissions')}}"><span class="icon"><i class="material-icons">
                accessibility</i></span>{{__('menu.permissions')}}</a></li>
            @endcan
            @can('المخازن')
            <li><a class="{{ request()->is('repositories')||request()->is('repositories/create') ||request()->is('en/repositories')? 'active' : ''}}" href="{{route('repositories.index')}}"><span class="icon"><i class="material-icons">storefront</i></span>{{__('menu.repositories')}}</a></li>
            @endcan
            @can('المخازن')
            <li><a class="{{ request()->is('our-clients')||request()->is('en/our-clients')? 'active' : ''}}" href="{{route('our.clients')}}"><span class="icon"><i class="material-icons">group</i></span>المستخدمون</a></li>
            @endcan
            @can('المخازن')
            <li><a class="{{ request()->is('products')||request()->is('en/products')? 'active' : ''}}" href="{{route('products.index')}}"><span class="icon"><i class="material-icons">category</i></span>{{__('menu.products')}}</a></li>
            @endcan
            @can('المخازن')
            <li><a class="{{ request()->is('system/index')||request()->is('en/system/index')? 'active' : ''}}" href="{{route('system.index')}}"><span class="icon"><i class="material-icons">dns</i></span>النظام</a></li>
            @endcan
            @can('لوحة تحكم مالك-مخزن')
            <li><a href="{{route('in.repository',$repository->id)}}" class="{{ request()->is('dashboard')||request()->is('/')||request()->is('en') ? 'active' : '' }}"><span class="icon"><i class="fa fa-home"></i></span>{{__('menu.owner_dashboard')}}</a></li>
            @endcan
            @can('لوحة تحكم موظف')
            <li><a href="{{route('in.repository',$repository->id)}}" class="{{ request()->is('dashboard')||request()->is('/')||request()->is('en') ? 'active' : '' }}"><span class="icon"><i class="fa fa-home"></i></span>{{__('menu.employee')}}</a></li>
            @endcan
            @if(isset($repository))
            {{--@if($repository->isSpecial())--}}
            @if(!$repository->isStorehouse())
            @can('المبيعات')
            <li><a class="{{request()->is('sales/*')||request()->is('en/sales/*')? 'active' : ''}}" href="{{route('sales.index',$repository->id)}}"><span class="icon"><i class="bi bi-journal-bookmark"></i></span>{{__('menu.sales')}}</a></li>
            @endcan
            @endif
            @endif
            {{-- مستودع --}}
            @if(isset($repository))
            @if($repository->isStorehouse())
            @can('المخزون')
            <li><a href="{{route('index.export',$repository->id)}}" class="{{ request()->is('index/export/*')||request()->is('en/index/export/*')? 'active' : ''}}"><span class="icon"><i class="material-icons">share</i></span>تصدير</a></li>
            @endcan
            @endif
            @endif
            @can('التقارير')
            <li><a href="{{route('reports.index',$repository->id)}}" class="{{ request()->is('reports/*')||request()->is('en/reports/*')? 'active' :'' }}"><span class="icon"><i class="bi bi-file-earmark-text"></i></span>{{__('menu.reports')}}</a></li>
            @endcan
            @can('المخزون')
            <li><a href="{{route('repository.index',$repository->id)}}" class="{{ request()->is('repository/*')||request()->is('en/repository/*')? 'active' : ''}}"><span class="icon"><i class="fa fa-battery-full"></i></span>{{__('menu.stock')}}</a></li>
            @endcan
            @can('المشتريات')
            <li><a href="{{route('purchases.index',$repository->id)}}" class="{{ request()->is('purchases/*')||request()->is('en/purchases/*')? 'active' : ''}}"><span class="icon"><i class="fa fa-shopping-cart"></i></span>{{__('purchases.purchases')}}</a></li>
            @endcan
            @if(isset($repository))
            @if($repository->isSpecial() || $repository->isBasic())
            @can('الكاشير')
            <li><a href="{{route('cashier.index',$repository->id)}}" class="{{ request()->is('cashier/*')||request()->is('en/cashier/*')? 'active' : ''}}"><span class="icon"><i class="bi bi-clipboard-data"></i></span>{{__('menu.cashier')}}</a></li>
            @endcan
            @endif
            @endif
            @can('الاعدادات')
            @if(isset($repository))
            <li><a href="{{route('manager.settings.index',$repository->id)}}" class="{{ request()->is('manager/settings/*')||request()->is('en/manager/settings/*')? 'active' : ''}}"><span class="icon"><i class="fa fa-cog"></i></span>{{__('menu.settings')}}</a></li>
            @endif
            @endcan
            @can('المخزون')
            <li><a href="#"><span class="icon"><i class="bi bi-shield-check"></i></span>{{__('menu.tech_support')}}</a></li>
            @endcan
             <p style="color: white"> {{__('reports.last_login')}} 
            {{$auther->last_login_old()}} </p>
            {{--
                <p style="color: white">
                    lock is : {{Session::get('lock_process')}}
                </p>
                --}}
        
            {{--
            <form action="{{route('send.sms')}}" method="POST">
                @csrf
                <button>send sms</button>
            </form>
            --}}
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