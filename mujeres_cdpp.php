<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="shortcut icon" href="images/favicon.png">
    <title>Bar Chart</title>
    <script src="dist/chart.js"></script>
    <script src="utils.js"></script>
    <script src="utilidades/jquery/jquery-1.11.2.min.js"></script>
    <link href="utilidades/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

    <body class="wide">

        <!-- WRAPPER -->
        <div class="wrapper">

            <!-- ACCESIBILIDAD -->
            <section>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <canvas id="chart"></canvas>
              	</div>
            </div>
            </section>
        </div>
        <!-- /WRAPPER -->
        <!-- IR ARRIBA -->

        <!-- Componenetes -->
        <script src="js/theme-functions.js"></script>

        <!-- Custom js file -->
        <script src="js/custom.js"></script>
        <script language="javascript">
            $(document).ready(function () {
            
            var array_label_x = ['', 'PAN', 'PRI', 'PRD', 'PVET', 'PT', 'PNA', 'MORENA', 'PES'];
            var array_data_hombres = [0, 50, 9, 12, 50, 99, 9, 17, 7];
            var array_data_mujeres = [0, 23, 5, 13, 30, 19, 4, 2, 2];

            var datos = {
                type: "line",
                data : {
                  datasets :[{
                    label: "Hombres",
                    fill: true,
                    lineTension: 0,
                    backgroundColor: "rgba(201,91,50,0.1)",
                    borderColor: "rgba(201,91,50,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(201,91,50,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(201,91,50,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: array_data_hombres,
                    spanGaps: false,
                  }, {
                    label: "Mujeres",
                    fill: true,
                    lineTension: 0,
                    backgroundColor: "rgba(0,150,136,0.1)",
                    borderColor: "rgba(0,150,136,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(0,150,136,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(0,150,136,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: array_data_mujeres,
                    spanGaps: false,
                  }],
                  labels : array_label_x,
                },
                options : {
                  responsive : true,
                }
              };
              var canvas = document.getElementById('chart').getContext('2d');
              lienso = new Chart(canvas, datos);
              window.pie = lienso;
            });
        </script>
    </body>
</html>
