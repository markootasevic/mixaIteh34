@extends('layouts.app')
@section('content')

 <button onclick="getBarChart()">Prikazi bar chart</button> 
 <button onClick="getPieChart()">Prikazi pie chart</button>
<div id="graph-container">
<canvas id="myChart" width="50px" height="50px"></canvas>
</div>

<script src="{{ URL::asset('node_modules/chart.js/dist/Chart.bundle.js') }}"></script>
<script src="{{ URL::asset('node_modules/chart.js/samples/utils.js') }}"></script>

<script>

    function drawPie(myData) {
        $('#myChart').remove(); 
  $('#graph-container').append('<canvas id="myChart"><canvas>');

        var ctx = $("#myChart");
        var data = {
        labels: [
            "Nepotvrdjene",
            "Prihvacene"
        ],
    datasets: [
        {
            data: myData,
            backgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56"
            ],
            hoverBackgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56"
            ]
        }]
};
    var myPieChart = new Chart(ctx,{
    type: 'pie',
    data: data
    });


    }
    
    function drawBar(dataa) {
        $('#myChart').remove(); 
        $('#graph-container').append('<canvas id="myChart"><canvas>');
            var ctx = $("#myChart");
            var chart1 = document.getElementById("myChart").getContext("2d");
        var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Nepotvrdjene", "Prihvacene"],
            datasets: [{
                label: 'Inicijative',
                data: dataa,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            onClick: function(e){
                chart1.data.datasets.backgroundColor = "rgba(192,192,192,1)";
        }
        }
    });
}

    function getPieChart () {
    
        var chartData1 = Array();
            $.ajax({
                type: "GET",
                url: "{{ url('/getInicijativeCount') }}", 
                success: function(result){
                    // console.log(result[0]);
                    // console.log(result[1]);
                    chartData1.push(result[0]);
                    chartData1.push(result[1]);
                    drawPie(chartData1);
                    // console.log(chartData);
                    // console.log(result);
            }});
    }

    function getBarChart() {
       
        var chartData = Array();
            $.ajax({
                type: "GET",
                url: "{{ url('/getInicijativeCount') }}", 
                success: function(result){
                    // console.log(result[0]);
                    // console.log(result[1]);
                    chartData.push(result[0]);
                    chartData.push(result[1]);
                    drawBar(chartData);
                    // console.log(chartData);
                    // console.log(result);
            }});
    }

    $(document).ready(function(){
        

        
    });
    
</script>

@stop