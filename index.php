<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<title>AutoPot</title>

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>

        <!-- <link href="../css/bootstrap.min.css" rel="stylesheet" /> -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Fjalla+One" rel="stylesheet" />
        <link href="autopotstyles.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;1,200&display=swap" rel="stylesheet"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://fonts.googleapis.com/css2?family=Anton&family=Cormorant+Garamond:ital,wght@1,700&family=Oswald&family=Pacifico&family=Redressed&family=Roboto+Serif&family=Ultra&display=swap" rel="stylesheet">
        <style>
            .statstext {
                font-family: "Fjalla One";
            }
        </style>

        <script type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/jquery-ui.min.js" ></script>
        <script type="text/javascript" src="js/jquery-1.6.3.min.js" ></script>
        <script type="text/javascript" src="js/jquery-ui.min.js" ></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <script>
            getCurrentStats();
            getImageStats();
            $(document).ready(function(){
                setInterval(getCurrentStats, 2000);
                setInterval(getImageStats, 2000);
                $( "#water" ).click(function() {
                    $.ajax({
                        url: "https://api.thingspeak.com/update?api_key=5T6XMZ0MZB3K8TVA&field1=1",
                        type: "GET",
                    });
                    $('#water').prop('disabled', true);
                    setTimeout(function() {
                        $('#water').prop('disabled', false);
                    }, 5000);
                });
                $("#temp_but").click(function () {
                    $.ajax({
                        url: "getChartData_ajax.php",
                        type: "POST",
                        dataType: "text",
                        data: { data: "temp" },
                        success: function(data){
                            var json = $.parseJSON(data);
                            chart.updateOptions({
                                title: { text: "Temperature" },
                            });
                              chart.updateSeries([
                                {
                                  name: "Temperature",
                                  data: json
                                }
                            ]);
                        }
                    });
                });
                $("#hum_but").click(function () {
                    $.ajax({
                        url: "getChartData_ajax.php",
                        type: "POST",
                        data: { data: "hum" },
                        success: function(data){
                            var json = $.parseJSON(data);
                            chart.updateOptions({
                                title: { text: "Humidity" },
                            });
                              chart.updateSeries([
                                {
                                  name: "Humidity",
                                  data: json
                                }
                            ]);
                        }
                    });
                });
                $("#soil_but").click(function () {
                    $.ajax({
                        url: "getChartData_ajax.php",
                        type: "POST",
                        data: { data: "soil" },
                        success: function(data){
                            var json = $.parseJSON(data);
                            chart.updateOptions({
                                title: { text: "Soil Moisture" },
                            });
                              chart.updateSeries([
                                {
                                  name: "Soil Moisture",
                                  data: json
                                }
                            ]);
                        }
                    });
                });
            });
            var str="";
    
            function getCurrentStats() {
                $.ajax({
	                type:'POST',
         	        url: 'getData_ajax.php',
                    success: function(data) {
	                    $('#current_stats').html(data);
                    }
                });
            }
            function getImageStats() {
                $.ajax({
                    type: 'POST',
                    url: 'getImageURL.php',
                    success: function (data) {
                        trimData = data.trim();
                        document.getElementById("plantimg").src = trimData;
                    }
                });
            }
        </script>

    </head>

    <body>
        <div class="NavDiv">
            <nav class="nav"> <!--class='navbar navbar-dark bg-success'-->
                <h1 class=NavTitle>Auto Pot <i class="fa-solid fa-seedling"></i> </h1>
            </nav>
        </div>

        <div class='container text-center mw-100'>
            <div class='row'>
                <div class='col'>
                    <div class='container float-start' style='height:auto;width:17vw;margin-top:10vh;margin-inline-start:2.5vw;justify-content:center;align-items:center;'>
                        <img src="/Images/sample1.png" id='plantimg' class='border-5' style='height:45vh;width:11vw;' alt="...">
                        <div class="waterBTN">
                        <button id='water' class="waterButton border-0 shadow">
                            Water <i class="fa-solid fa-droplet"></i>
                        </button>
                    </div>
                    </div>
                    <div id='current_stats' class='float-end'></div>
                </div>
                <div class='col-7'>
                    <div class='row h-100'>
                        <div class='col'>
                            <div id='chart'></div>
                            <script>
                                var options = {
                                    chart: {
                                        height: '80%',
                                        type: 'line',
                                    },
                                    dataLabels: {
                                        enabled: false
                                    },
                                    series: [],
                                    title: {
                                        text: 'Temperature',
                                    },
                                    noData: {
                                    text: 'Loading...'
                                    },
                                    xaxis: {
                                        type: "datetime"
                                    },
                                    colors: ['#B5C99A']
                                }

                                var chart = new ApexCharts(
                                document.querySelector("#chart"),
                                options
                                );

                                chart.render();
                                updateChart();
                                function updateChart() {
                                    $.getJSON('getChartData_ajax.php', function(response) {
                                        chart.updateSeries([{
                                            name: 'Temperature',
                                            data: response
                                        }])
                                    });
                                }
                            </script>
                            <div class="otherBtns">
                                <button id='temp_but'>Temperature</button>
                                <button id='hum_but'>Humidity</button>
                                <button id='soil_but'>Soil Moisture</button>
                            </div>
                           
                        </div>
                    </div>
                    <!--<div class='row h-50'>
                        <div class='col border'>
                            <button class='water' name='water'>Water</button>
                            <button class='no-water' name='no-water'>No Water</button>
                        </div>
                    </div>-->
                </div>
            </div>
        </div>
    </body>
</html>