@extends('common')

@section('content')
    <h1>Article #{{$model->articleId}}: {{$model->title}}</h1>
    <h2>Views statistics for one year</h2>
    <canvas id="myChart" style="width:100%;max-width:900px"></canvas>
    <script>
        const xValues = atob('{{$model->datesStr}}').split(', ');
        const yValues = atob('{{$model->valuesStr}}').split(', ').map((x) => parseInt(x));
        console.log(xValues);
        console.log(yValues);


        new Chart("myChart", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "rgba(0,0,255,1.0)",
                    borderColor: "rgba(0,0,255,0.1)",
                    data: yValues
                }]
            },
            options: {
                legend: {display: false},
                scales: {
                    yAxes: [{ticks: {min: 0, max:3000}}],
                }
            }
        });
    </script>
@endsection

@section('article-action')
    <div class="create-article-component">
        <div class="create-article-component-link">
            <a href="/">Back</a>
        </div>
    </div>
@endsection
