<div id="user_status_pie_chart" style="width: 80%; height: 500px;"></div>

@push('script')
   
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
 //Draw Gender Chart
 google.charts.load("current", { packages: ["corechart","bar"] });
 google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var userStatusData = JSON.parse('{!! json_encode($user_status_piechart)!!}');
        var data = google.visualization.arrayToDataTable(userStatusData);
        var options = {
            title: '',
            // pieHole: 0.4,
            colors: ['#5DBEFF', '#60FFC7', '#FFDF6A','#FFDF6A', '#00A36C', '#1F51FF'],
            legend: {
                position: "bottom",
            }
            // colors: ['#e0440e', '#e6693e', '#ec8f6e', '#f3b49f', '#f6c7b6'],
            // is3D: true
        };

        var chart = new google.visualization.PieChart(document.getElementById('user_status_pie_chart'));
        chart.draw(data, options);
    }
</script>

@endpush


