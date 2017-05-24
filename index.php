<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="shortcut icon" href="images/favicon.png">
        <title>INE | Instito Nacional Electoral</title>

        <!-- Bootstrap -->
        <link href="utilidades/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="utilidades/fontawesome/css/font-awesome.min.css" type="text/css" rel="stylesheet">
        <link href="utilidades/animateit/animate.min.css" rel="stylesheet">

        <!-- Utilidades css -->
        <link href="utilidades/owlcarousel/owl.carousel.css" rel="stylesheet">
        <link href="utilidades/magnific-popup/magnific-popup.css" rel="stylesheet">

        <!-- Estilos css -->
        <link href="css/base-ine.css" rel="stylesheet">
        <link href="css/elementos-ine.css" rel="stylesheet">
        <link href="css/color-ine.css" rel="stylesheet">
        <link href="css/responsivo.css" rel="stylesheet">
        <link href="css/custom.css" rel="stylesheet" type="text/css" media="screen" />

        <!--[if lt IE 9]>
                        <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
                <![endif]-->

        <!-- FUENTES GOOGLE -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,800,700,600%7CRaleway:100,300,600,700,800" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700" rel="stylesheet">

        <!-- SLIDER REVOLUTION 5.x CSS SETTINGS -->
        <link rel="stylesheet" property="stylesheet" href="utilidades/rs-plugin/css/settings.css" type="text/css" media="all" />
        <link rel="stylesheet" href="css/rs-plugin-styles.css" type="text/css" />

        <!--UTILIDADES SCRIPT-->
        <script src="utilidades/jquery/jquery-1.11.2.min.js"></script>
        <script src="utilidades/plugins-compressed.js"></script>

        <!-- SCRIPT GRAFICAS-->
        <script src="dist/chart.js"></script>
        <script src="utils.js"></script>

        <!-- SLIDER REVOLUTION 5.x SCRIPTS  -->
        <script type="text/javascript" src="utilidades/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
        <script type="text/javascript" src="utilidades/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
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
                    <label class="text-uppercase">Tipo de Cámara</label>
                    <select class="form-control" name="tipo-camara" id="tipo-camara">
                        <option value="0">-- Todas</option>
                        <option value="1">Senadores</option>
                        <option value="2">Diputados - Federal</option>
                        <option value="3">Diputados - Estatal</option>
                    </select>
                  </div>
                  <div class="col-md-3" id="div-entidad-federativa">
                    <label class="text-uppercase">Entidad federativa</label>
                    <select class="form-control" name="entidad-federativa" id="entidad-federativa">
                      <option value="" selected="selected">-- Todas</option>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <label class="text-uppercase">Partido político</label>
                    <select class="form-control" name="partido_politico" id="partido_politico">
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
                <div class="col-md-10 col-md-offset-1">
                    <canvas id="chart"></canvas>
              	</div>
              </div>
            </section>
        </div>
        <!-- /WRAPPER -->
        <!-- IR ARRIBA -->
        <a class="gototop gototop-button" href="#"><i class="fa fa-chevron-up"></i></a>

        <!-- Componenetes -->
        <script src="js/theme-functions.js"></script>

        <!-- Custom js file -->
        <script src="js/custom.js"></script>
        <script language="javascript">
            $(document).ready(function () {
                $("#div-entidad-federativa").addClass('hide')
//                $("#entidad-federativa").prop("disabled", true);
                $("#partido_politico").prop("disabled", true);

                /**
                 * traemos las entidades federativas (estados)
                 */
                $.post("modelo.php", {entidades:true}, function (data) {
                    var array_obj_ent = JSON.parse(data);
                    var option_entidades = "<option value='' selected='selected'>-- Todas</option>";
                    $.each(array_obj_ent, function( index, value ) {
                        option_entidades = option_entidades + "<option value='"+index+"'>"+value.estado+"</option>";
                    });

                    $("#entidad-federativa").html(option_entidades);
                });

                $.post("modelo.php", {partido_politico:true}, function (data) {
                    var array_obj_pp = JSON.parse(data);
                    var option_pp = "<option value='' selected='selected'>-- Todos</option>";
                    $.each(array_obj_pp, function(index_, value_){
                        option_pp = option_pp + "<option values='"+index_+"'>"+value_.part_pol+"</option>";
                    });
                    $("#partido_politico").html(option_pp);
                });

                $("#tipo-camara").change(function () {
                    $("#tipo-camara option:selected").each(function () {
                        tipo_camara = $(this).val();
                        if (tipo_camara == 0) {
                            $('#partido_politico').val('');
                            $("#partido_politico").prop("disabled", true);
                            $('#entidad-federativa').val('');
                            $("#div-entidad-federativa").addClass('hide');
//                            $("#entidad-federativa").prop("disabled", true);
                        } else if (tipo_camara == 1 || tipo_camara == 2) {
                            $('#entidad-federativa').val('');
                            $("#div-entidad-federativa").addClass('hide');
//                            $("#entidad-federativa").prop("disabled", true);
                            $.post("modelo.php", {partido_politico:true, and_tipo_camara_:tipo_camara}, function (data) {
                                $("#partido_politico").prop("disabled", false);
                                var array_obj_pp = JSON.parse(data);
                                var option_pp = "<option value='' selected='selected'>-- Todos</option>";
                                $.each(array_obj_pp, function(index_, value_){
                                    option_pp = option_pp + "<option values='"+index_+"'>"+value_.part_pol+"</option>";
                                });
                                $("#partido_politico").html(option_pp);
                            });
                        }else {
                            $("#div-entidad-federativa").removeClass('hide');
//                            $("#entidad-federativa").prop("disabled", false);
                            $.post("modelo.php", {partido_politico:true, and_tipo_camara_:tipo_camara}, function (data) {
                                $("#partido_politico").prop("disabled", false);
                                var array_obj_pp = JSON.parse(data);
                                var option_pp = "<option value='' selected='selected'>-- Todos</option>";
                                $.each(array_obj_pp, function(index_, value_){
                                    option_pp = option_pp + "<option values='"+index_+"'>"+value_.part_pol+"</option>";
                                });
                                $("#partido_politico").html(option_pp);
                            });
                        }
                    });
                });

                $("#entidad-federativa").change(function () {
                    tipo_camara = $('#tipo-camara').val();
                    entidad_fed = $('#entidad-federativa').val();
                    $.post("modelo.php", {partido_politico:true, and_tipo_camara_:tipo_camara, and_entidad_fed_:entidad_fed}, function (data) {
                        $("#partido_politico").prop("disabled", false);
                        var array_obj_pp = JSON.parse(data);
                        var option_pp = "<option value='' selected='selected'>-- Todos</option>";
                        $.each(array_obj_pp, function(index_, value_){
                            option_pp = option_pp + "<option values='"+index_+"'>"+value_.part_pol+"</option>";
                        });
                        $("#partido_politico").html(option_pp);
                    });
                });
                var lienso = null;
                get_grafica('0', '', '');
                $('#search-data').on('click', function(event){
                    var t_camara = $('#tipo-camara').val();
                    var entidad_federativa = $('#entidad-federativa').val();
                    var partido_politico = $('#partido_politico').val();
                    get_grafica(t_camara, entidad_federativa, partido_politico);
                    
                });
                function get_grafica(t_camara, entidad_federativa, partido_politico)
                {
                    $.post("modelo.php", {search_data: {
                            tipo_camara_:t_camara
                            , entidad_fed_:entidad_federativa
                            , partido_politico_:partido_politico
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
                            /**
                             * Tipo de Principio de Representación
                             * mayoria relativa, primera minoria, proporcional
                             */
//                            if () {
//                                
//                            }
                            
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
