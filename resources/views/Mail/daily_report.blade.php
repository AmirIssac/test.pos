<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>تقرير يومي</title>
   
</head>

<body>
    <div>
        {{--
        <img src="{{$message->embed(asset('images/logo.png'))}}" width="50px" height="50px">
        --}}
        <h2>
                مرحبا سيد {{$details['user']->name}}
        </h2>
        <p>لقد تم اغلاق الكاشير في متجرك {{$details['repository']->name}}
            فرع {{$details['repository']->address}}
        </p>
        <?php $daily_report = $details['daily_report'] ?>
        <p>تاريخ {{$details['close_date']}}</p>
        <h3>
            مبيعات {{$details['today_sales']}}
        </h3>
        <h3>
            مشتريات {{$details['today_purchases']}}
        </h3>
        {{--
        {{ Request::root() }}
        --}}
    </div>
</body>
</html>