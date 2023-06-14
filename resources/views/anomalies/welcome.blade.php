@extends('common')

@section('content')
    <h1>Article #{{$model->articleId}}: {{$model->title}} <a href="download/{{$model->articleId}}">Download</a></h1>
    <h2>Views statistics for one year</h2>
    <canvas id="myChart" style="width:100%;max-width:900px"></canvas>
    <script>
        const xDates = atob('{{$model->datesStr}}').split(', ');
        const yValues = atob('{{$model->valuesStr}}').split(', ').map((x) => parseInt(x));

        const anomalyIndexes = atob('{{$model->anomalyIndexes}}').split(', ').map((x) => parseInt(x));

        const verticalLinePlugin = {
            getLinePosition: function (chart, pointIndex) {
                const meta = chart.getDatasetMeta(0); // first dataset is used to discover X coordinate of a point
                const data = meta.data;
                return data[pointIndex]._model.x;
            },
            renderVerticalLine: function (chartInstance, pointIndex) {
                const lineLeftOffset = this.getLinePosition(chartInstance, pointIndex);
                const scale = chartInstance.scales['y-axis-0'];
                const context = chartInstance.chart.ctx;

                // render vertical line
                context.beginPath();
                context.strokeStyle = '#ff0000';
                context.moveTo(lineLeftOffset, scale.top);
                context.lineTo(lineLeftOffset, scale.bottom);
                context.stroke();

                // write label
                context.fillStyle = "#ff0000";
                context.textAlign = 'center';
            },

            afterDatasetsDraw: function (chart, easing) {
                if (chart.config.lineAtIndex) {
                    chart.config.lineAtIndex.forEach(pointIndex => this.renderVerticalLine(chart, pointIndex));
                }
            }
        };

        Chart.plugins.register(verticalLinePlugin);

        let chart = new Chart("myChart", {
            type: "line",
            data: {
                labels: xDates,
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
                    yAxes: [{ticks: {min: 0, max:1000}}],
                }
            },
            lineAtIndex: anomalyIndexes,
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
