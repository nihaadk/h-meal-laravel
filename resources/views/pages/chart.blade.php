@extends('master')
@section('chart')
<div class="container" >
  <div class="section">
    <div class="row">
      <div class="col s12">
        {!! FORM::open(array('url' => 'app/chart/index', 'method' => 'post')) !!}
        <div class="row">
          <div class="col s3">
            {!!  FORM::select('chart', array('bar' => 'Bar chart', 'line' => 'Line chart'), $lastSelectChart) !!}
          </div>
          <div class="col s3">
             {!! FORM::input('text','patient', $bolnik, 
             ['data-list' => $list,'placeholder' => 'ZSSS number']) 
             !!}
          </div>
          <div class="col s3">
            {!! FORM::select('tabela', array('Daily entries' => 'Daily entries', 'Measured sugar' => 'Measured sugar'), $lastSelectTabel) !!}
          </div>
          <div class="col s3">
             {!! FORM::submit('Show', ['class' => 'btn btn-primary purple darken-4']) !!}
          </div>
        </div>
        {!! Form::close() !!}
      </div>
       
       
        @if($error != null)
            <div class="col s12">
              <div class="card-panel red center white-text"><h4>{{ $error }}</h4></div>
            </div>
        @elseif( $xdata1 == '[]' || $xdata1 == '[]' && $xdata2 == '[]' && $xdata3 == '[]' && $xdata4 == '[]' )
            <div class="col s12">
              <div class="card-panel red center white-text"><h4>The patient has entered data.</h4></div>
            </div>
        @else
            <div class="col s12">
              <canvas id="chart" width="300" height="150"></canvas>
            </div>
        @endif

    </div>
  </div>
</div>

<script>
    (function(){
      var ctx = document.getElementById('chart').getContext('2d');
      
     var charVersion = {!! json_encode($chartVersion) !!};

     if(charVersion == 1){

      console.log({!! json_encode($ydata) !!});

      var myChart = new Chart(ctx, {
        type: {!! json_encode($chart) !!},
        data: {
            labels: {!! json_encode($ydata) !!},
            datasets: [
            {
              label: 'Measured sugar', 
              fill: false,
              backgroundColor: "rgba(0,184,245,0.7)",
              borderColor: "rgba(0,184,245,1)",
              pointBackgroundColor: "rgba(0,184,245,1)",
              pointBorderColor: "#fff",
              pointHoverBackgroundColor: "#fff",
              pointHoverBorderColor: "rgba(0,184,245,1)",
              data: {!! json_encode($xdata1) !!}
            }
            ]
        }
      });
     }else if(charVersion == 2){
        var myChart = new Chart(ctx, {
        type: {!! json_encode($chart) !!},
        data: {
            labels: {!! json_encode($ydata) !!},
            datasets: [
            {
              label: 'Fat', 
              fill: false,
              backgroundColor: "rgba(255,61,61,0.7)",
              borderColor: "rgba(255,61,61,1)",
              pointBackgroundColor: "rgba(255,61,61,1)",
              pointBorderColor: "#fff",
              pointHoverBackgroundColor: "#fff",
              pointHoverBorderColor: "rgba(255,61,61,1)",
              data: {!! json_encode($xdata1) !!}
            },
            {
              label: 'Calories', 
              fill: false,
              backgroundColor: "rgba(0,245,61,0.7)",
              borderColor: "rgba(0,245,61,1)",
              pointBackgroundColor: "rgba(0,245,61,1)",
              pointBorderColor: "#fff",
              pointHoverBackgroundColor: "#fff",
              pointHoverBorderColor: "rgba(0,245,61,1)",
              data: {!! json_encode($xdata2) !!}
            },
            {
              label: 'Protein', 
              fill: false,
              backgroundColor: "rgba(0,184,245,0.7)",
              borderColor: "rgba(0,184,245,1)",
              pointBackgroundColor: "rgba(0,184,245,1)",
              pointBorderColor: "#fff",
              pointHoverBackgroundColor: "#fff",
              pointHoverBorderColor: "rgba(0,184,245,1)",
              data: {!! json_encode($xdata3) !!}
            },
            {
              label: 'Carbohydrates', 
              fill: false,
              backgroundColor: "rgba(255,255,61,0.7)",
              borderColor: "rgba(255,255,61,1)",
              pointBackgroundColor: "rgba(255,155,61,1)",
              pointBorderColor: "#fff",
              pointHoverBackgroundColor: "#fff",
              pointHoverBorderColor: "rgba(255,255,61,1)",
              data: {!! json_encode($xdata4) !!}
            }
            ]
        }
      });
     }

    
    })();
  </script>

@stop