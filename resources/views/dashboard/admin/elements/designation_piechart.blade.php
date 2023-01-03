<div id="designation_pie_chart" style="width: 80%; height: 500px;"></div>

@push('script')
   
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
 //Draw Gender Chart
 google.charts.load("current", { packages: ["corechart","bar"] });
    function drawChart() {
        var userData = JSON.parse('{!! json_encode($designation_pie_chart)!!}');
        var data = google.visualization.arrayToDataTable(userData);
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

        var chart = new google.visualization.PieChart(document.getElementById('designation_pie_chart'));
        chart.draw(data, options);
    }
</script>

@endpush