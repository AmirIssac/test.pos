<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Change Branch</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">   
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <!-- Icofont -->
    <link rel="stylesheet" href="{{asset('public/css/icofont.min.css')}}">
    <!-- Main Style -->
    <link rel="stylesheet" href="{{asset('public/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('public/css/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('public/alerts/style.css')}}"/>
</head>
<style>
  #logo{
    border-radius: 50%;
  }
</style>
<body>
    <div class="change-branch">
      @foreach($repositories as $repository)
        <a href="{{route('in.repo',$repository->id)}}" class="item">
          @if($repository->logo)
          <img src="{{asset('public/storage/'.$repository->logo)}}" id="logo">
          @else
          <img src="{{asset('public/img/rofood.jpg')}}" id="logo">
          @endif
            <h2>{{$repository->name}}</h2>
            <h6 style="color: #0d6efd; font-weight: bold">النوع : ({{$repository->category->name}}) - الباقة : ({{$repository->package->name_ar}})</h6>
            <button class="btn">تسجيل الدخول</button>
        </a>
      @endforeach
      {{--
      <p>
        id={{Session::get('repo_id')}}</p> --}}
          </div>
          {{-- redirect when open more than one repository at the same session --}}
          @if(request()->is('select/repository/redirect'))
            <input type="hidden" value="error" id="redirect-error">
          @endif
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9Ah20zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{asset('public/alerts/cute-alert.js')}}"></script>
          <script>
            var x = $('#redirect-error').val();
            if(x == 'error'){
              cuteAlert({
                type: "info",
                title: "لا يمكنك فتح اكثر من فرع في نفس الجلسة",
                message: "اغلق المتصفح في حال عدم الاستجابة",
                buttonText: "حسنا",
              });
            }
          </script>
</body>
</html>