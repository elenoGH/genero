<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="shortcut icon" href="images/favicon.png">
        <title>INE | Instito Nacional Electoral</title>

        <!-- Bootstrap -->
        <link href="utilidades/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="utilidades/fontawesome/css/font-awesome.min.css" type="text/css" rel="stylesheet">
        <link href="utilidades/animateit/animate.min.css" rel="stylesheet">

        <!-- Estilos css -->
        <link href="css/base-ine.css" rel="stylesheet">
        <link href="css/elementos-ine.css" rel="stylesheet">
        <link href="css/color-ine.css" rel="stylesheet">
        <link href="css/responsivo.css" rel="stylesheet">
        <link href="css/custom.css" rel="stylesheet" type="text/css" media="screen" />

        <!--UTILIDADES SCRIPT-->
        <script src="utilidades/jquery/jquery-1.11.2.min.js"></script>
        <script src="utilidades/plugins-compressed.js"></script>

        <!-- SCRIPT GRAFICAS-->
        <script src="dist/chart.js"></script>
    </head>

    <body class="wide">

        <!-- WRAPPER -->
        <div class="wrapper">

            <!-- ACCESIBILIDAD -->
            <section>
              <div class="container">
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-3">
                    <label class="text-uppercase">Categoria 1</label>
                    <select class="form-control" name="categoria1" id="categoria1">
                        <option value="">-- Todas</option>
                        <option value="consejo_general">Consejo General del INE</option>
                        <option value="oples">OPLES</option>
                    </select>
                  </div>
                  <div class="col-md-3" id="div-entidad-federativa">
                    <label class="text-uppercase">Entidad federativa</label>
                    <select class="form-control" name="entidad-federativa" id="entidad-federativa">
                      <option value="" selected="selected">-- Todas</option>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <label class="text-uppercase">Tipo de Cargo</label>
                    <select class="form-control" name="tipo-cargo" id="tipo-cargo">
                        <option value="" selected="selected">-- Todos</option>
                    </select>
                  </div>
                  <div class="col-md-2 m-t-30">
                    <button name="search-data" type="button"
                                    id="search-data"
                                    style="display: block; margin: 0 auto;"
                                    class="btn btn-primary">
                                &nbsp;Buscar</button>
                  </div>
                </div>
                  </div>
                  <br><br><br>
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
                
//                $("#entidad-federativa").prop("disabled", true);
//                $("#partido_politico").prop("disabled", true);
                
                
                $.post("modelo.php", {entidad_moea:true}, function (data) {
                    var array_obj_ent = JSON.parse(data);
                    var option_entidades = "<option value='' selected='selected'>-- Todas</option>";
                    $.each(array_obj_ent, function( index, value ) {
                        option_entidades = option_entidades + "<option value='"+index+"'>"+value.entidad_edo+"</option>";
                    });

                    $("#entidad-federativa").html(option_entidades);
                    $("#div-entidad-federativa").addClass('hide');
                });
//
                $.post("modelo.php", {tipo_cargo_moea:true}, function (data) {
                    var array_obj_moea = JSON.parse(data);
                    var option_tc = "<option value='' selected='selected'>-- Todos</option>";
                    $.each(array_obj_moea, function(index_, value_){
                        option_tc = option_tc + "<option values='"+index_+"'>"+value_.tipo_cons+"</option>";
                    });
                    $("#tipo-cargo").html(option_tc);
                });
                
                $("#categoria1").change(function () {
                    if ( $(this).val() == 'consejo_general' || $(this).val() == '' ) {
                        $('#entidad-federativa').val('');
                        $("#div-entidad-federativa").addClass('hide');
                    } else {
                        $("#div-entidad-federativa").removeClass('hide');
                    }
                    var cat1 = $('#categoria1').val();
                    var entidad = $('#entidad-federativa').val();
                    
                    $.post("modelo.php", {tipo_cargo_moea:{
                              cat1_   :  cat1
                            , entidad_: entidad
                    }}, function (data) {
                        var array_obj_moea = JSON.parse(data);
                        var option_tc = "<option value='' selected='selected'>-- Todos</option>";
                        $.each(array_obj_moea, function(index_, value_){
                            option_tc = option_tc + "<option values='"+index_+"'>"+value_.tipo_cons+"</option>";
                        });
                        $("#tipo-cargo").html(option_tc);
                    });
                });
//
                $("#entidad-federativa").change(function () {
                    var cat1 = $('#categoria1').val();
                    var entidad = $(this).val();
                    
                    $.post("modelo.php", {tipo_cargo_moea:{
                              cat1_   :  cat1
                            , entidad_: entidad
                    }}, function (data) {
                        var array_obj_moea = JSON.parse(data);
                        var option_tc = "<option value='' selected='selected'>-- Todos</option>";
                        $.each(array_obj_moea, function(index_, value_){
                            option_tc = option_tc + "<option values='"+index_+"'>"+value_.tipo_cons+"</option>";
                        });
                        $("#tipo-cargo").html(option_tc);
                    });
                });
                
                var lienso = null;
                get_grafica('', '', '');
                $('#search-data').on('click', function(event){
                    var entidad_federativa = $('#entidad-federativa').val();
                    var tipo_cargo = $('#tipo-cargo').val();
                    var categoria1 = $('#categoria1').val();
                    get_grafica(entidad_federativa, tipo_cargo, categoria1);
                });
                function get_grafica(entidad_federativa, tipo_cargo, categoria1)
                {
                    $.post("modelo.php", {search_data_moea: {
                              categoria_1: categoria1
                            , entidad_fed_:entidad_federativa
                            , tipo_cargo_:tipo_cargo
                        }
                    }, function (data) {
                        
                        if(lienso != undefined || lienso != null){
                            lienso.destroy();
                        }
                        console.log(JSON.parse(data));
                        var array_data_search = JSON.parse(data);
                        var array_label_x = [1980-1980];
                        var array_data_hombres = [0];
                        var array_data_mujeres = [0];

                        $.each(array_data_search, function( index, value ) {                            
                            array_label_x.push(value.anio_ini+'-'+value.anio_fin);
                            array_data_hombres.push(parseInt(value.totales_hombres_suma));
                            array_data_mujeres.push(parseInt(value.totales_mujeres_suma));
                        });
                        
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
                }
            });
        </script>
    </body>
</html>