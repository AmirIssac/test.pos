<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rofood Login</title>
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
</head>
<body>
    <div class="login-page">
        <div class="logo">
            <img src="{{asset('public/images/logo.png')}}" alt="">
        </div>
        <div class="image">
            <img src="{{asset('public/images/login-image.png')}}" alt="">
        </div>
        <div class="form">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    @if(session()->has('message'))
                            <h4 style="color: rgb(35, 196, 35); font-weight:bold;">
                                {{ session()->get('message') }}
                            </h4>
                    @endif
                    <label for="email">??????????????</label>
                    <input id="email" type="email" name="email" class="login__input form-control" placeholder="?????? ????????????">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">???????? ????????</label>
                    <input id="password" type="password" name="password" class="login__input form-control" placeholder="???????? ????????????">
                        @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                </div>
                <div class="form-group text-center">
                    <input style="width: 150px;" type="submit" class="btn" value="?????????? ????????????" />
                </div>
                
                <div class="text-center">
                   <h6> ?????? ???????? ???????? ?? </h6>
                </div>
                <div class="text-center">
                    <a href="{{route('enter.credentials')}}" class="btn btn-success">?????????? ????????</a>
                </div>
                
            </form>
        </div>
    </div>

    <div>
       <a href="https://wa.me/966538027198"> <img style="float: left" src="{{asset('public/images/whatsapp_icon.png')}}" height="75px"> </a>
    </div>
    

    <!-- JavaScript Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    {{--
    <script src="{{asset('js/jquery-3.6.0.min.js')}}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{asset('public/js/main.js')}}"></script>

</body>
</html>