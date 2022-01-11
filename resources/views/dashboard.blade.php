@extends('layouts.main')
@section('body')
<div class="content home">
<div class="row">
  <div class="col-md-9">
      <div class="col-12">
          <!-- Chart -->
          <div class="chart">
              <select class="select" name="" id="">
                  <option value="">{{now()->year}}</option>
              </select>
              <canvas id="myChart" style="max-height: 100%;"></canvas>
          </div>
      </div>
  </div>
</div>
</div>
<?php for($i=1;$i<=24;$i++){  // from 1-12 is for repositories and from 13 to 24 is for users
      $$i = 0; // عدد المتاجر في كل شهر بشكل ديناميكي الاسم
     //$$i.$u =0; // عدد المستخدمين في كل شهر بشكل ديناميكي الاسم
}
?>
{{-- calculate count of repositories created this year in each month --}}
@foreach($repositories as $repository)
<?php $month = $repository->created_at->month;
      $i = $month;
      $$i += 1; 
?>
@endforeach
@for($i=1;$i<=12;$i++)
<input type="hidden" value="{{$$i}}" id="repo-count-month-{{$i}}"> 
@endfor

@foreach($users as $user)
<?php $month = $user->created_at->month;
      $j = $month+12;
      $$j += 1; 
?>
@endforeach
@for($j=13;$j<=24;$j++)
<input type="hidden" value="{{$$j}}" id="user-count-month-{{$j}}"> 
@endfor
<script src="{{asset('public/js/jquery-3.6.0.min.js')}}"></script>
{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{--<script src="js/main.js"></script>--}}

<script>
for(var i=1;i<=12;i++){
        window["repo_count_"+i] = $('#repo-count-month-'+i).val(); 
        var j = i + 12;
        window["user_count_"+j] = $('#user-count-month-'+j).val(); 
}
var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {
  type: 'line',
  data: {
      labels: ['1/2021', '2/2021', '3/2021', '4/2021', '5/2021', '6/2021','7/2021','8/2021','9/2021','10/2021','11/2021','12/2021'],
      datasets: [{
          label: 'المتاجر',
          data: [repo_count_1, repo_count_2, repo_count_3, repo_count_4, repo_count_5, repo_count_6,repo_count_7,repo_count_8,repo_count_9,repo_count_10,repo_count_11,repo_count_12],
          backgroundColor: '#001bb7',
          barThickness: 16,
      },
      {
          label: 'المستخدمين',
          data: [user_count_13, user_count_14, user_count_15, user_count_16, user_count_17, user_count_18,user_count_19,user_count_20,user_count_21,user_count_22,user_count_23,user_count_24],
          backgroundColor: '#0d6efd',
          barThickness: 16,
      },
      ]
  },
  options: {
      scales: {
          y: {
              beginAtZero: true,
              suggestedMin:0,
              suggestedMax:25,
          },
          
      },
      plugins: {
          title: {
              display: true,
              text: 'احصائيات السنة',
              font: {
                  size: 18
              }
          }
      },
      width: 10,
  }
});
</script>


 @endsection