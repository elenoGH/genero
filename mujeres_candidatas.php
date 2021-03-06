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
    <link href="estilos.css" rel="stylesheet">
</head>

<body class="wide">
    <div class="wrapper">
        <section>
            <div class="row">
                <div class="col-sm-4 col-md-4 col-lg-4">
                   <label class="text-uppercase">Nivel de Gobierno</label>
                   <select class="form-control" name="ef_c1" id="ef_c1">
                       <option value="">-- Todas</option>
                       <option value="federal">Federal</option>
                       <option value="estatal">Estatal</option>
                   </select>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4">
                  <label class="text-uppercase">Cargo</label>
                  <select class="form-control" name="categoria3" id="categoria3">
                      <option value="">-- Todas</option>
                  </select>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4" id="div-partido-politico">
                  <label class="text-uppercase">Partido Politico</label>
                  <select class="form-control" name="part-pol" id="part-pol">
                      <option value=""></option>
                  </select>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 col-md-4 col-lg-4" id="div-entidad-federativa">
                    <label class="text-uppercase">Entidad federativa</label>
                    <select class="form-control" name="entidad-federativa-mc" id="entidad-federativa-mc">
                      <option value="" selected="selected">-- Todas</option>
                    </select>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4" id="div-principio-representacion">
                    <label class="text-uppercase">Principio de representación</label>
                    <select class="form-control" name="principio-rep" id="principio-rep">
                        <option value="">--Todos</option>
                        <option value="Mayoria Relativa">Mayoría Relativa</option>
                        <option value="Representacion Proporcional">Representación Proporcional</option>
                    </select>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4" id="div-propietario-suplente">
                    <label class="text-uppercase">Propietario/Suplente</label>
                    <select class="form-control" name="prop-sup" id="prop-sup">
                        <option value="">--Todos</option>
                        <option value="Propietario">Propietario</option>
                        <option value="Suplente">Suplente</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <!--div class="col-sm-4 col-md-4 col-lg-4" id="div-periodo-inicial">
                    <label class="text-uppercase">Periodo Inicial</label>
                    <select class="form-control" name="periodo-ini" id="periodo-ini">
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4" id="div-periodo-final">
                    <label class="text-uppercase">Periodo Final</label>
                    <select class="form-control" name="periodo-fin" id="periodo-fin">
                        <option value=""></option>
                    </select>
                </div-->
                <div class="col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px; margin-bottom: 20px;text-align: right;">
                    <button name="search-data-mc" type="button"
                        id="search-data-mc"
                        class="btn btn-primary">
                    &nbsp;Buscar</button>
                </div>
            </div>
        </section>
    </div>
    
    
    <div id="container">
        <canvas id="chart"></canvas>
    </div>
    <script>
        $(document).ready(function () {
            $("#div-partido-politico").addClass('hide');
            $("#div-entidad-federativa").addClass('hide');
            $("#div-principio-representacion").addClass('hide');
            $("#div-propietario-suplente").addClass('hide');
//            $("#div-periodo-inicial").addClass('hide');
//            $("#div-periodo-final").addClass('hide');

            $("#categoria3").prop("disabled", true);
            
            $('#categoria3').change(function () {
                $.post("modelo.php", {partido_politico_mc:{
                        categoria3_ : $(this).val()
                }}, function (data) {
                    var array_obj_pp = JSON.parse(data);
                    var option_pp = "<option value='' selected='selected'>-- Todos</option>";
                    $.each(array_obj_pp, function(index_, value_){
                        option_pp = option_pp + "<option values='"+index_+"'>"+value_.part_pol+"</option>";
                    });
                    $("#part-pol").html(option_pp);
                });
            });
            
            $("#ef_c1").change(function () {
                    
                var option_c3 = "<option value=''>-- Todas</option>";
                var dis_cat3 = true;

                if ($(this).val() == 'federal') {
                    option_c3 = option_c3 +"<option value='precidencia'>Presidencia de la República</option>"
                    +"<option value='diputados'>Diputaciones</option>"
                    +"<option value='senadores'>Senadurías</option>";
                    dis_cat3 = false;
                    $('#entidad-federativa-mc').val('');
                    $("#div-entidad-federativa").removeClass('hide');
                    get_ent_fed('federal');
                } else if ($(this).val() == 'estatal') {
                    option_c3 = option_c3+"<option value='gubernatura'>Gubernatura</option>"
                    +"<option value='diputados'>Congresos</option>";
                    dis_cat3 = false;
                    $('#entidad-federativa-mc').val('');
                    $("#div-entidad-federativa").removeClass('hide');
                    get_ent_fed('estatal');
                } else if ($(this).val() == '') {
                    $('#part-pol').val('');
                    $('#entidad-federativa-mc').val('');
                    $('#principio-rep').val('');
                    $('#prop-sup').val('');
//                    $('#periodo-ini').val('');
//                    $('#periodo-fin').val('');
                    $("#div-partido-politico").addClass('hide');
                    $("#div-entidad-federativa").addClass('hide');
                    $("#div-principio-representacion").addClass('hide');
                    $("#div-propietario-suplente").addClass('hide');
//                    $("#div-periodo-inicial").addClass('hide');
//                    $("#div-periodo-final").addClass('hide');
                    get_ent_fed('');
                } 
                if ($(this).val() != '') {
                    $("#div-partido-politico").removeClass('hide');
                    $("#div-principio-representacion").removeClass('hide');
                    $("#div-propietario-suplente").removeClass('hide');
//                    $("#div-periodo-inicial").removeClass('hide');
//                    $("#div-periodo-final").removeClass('hide');
                }

                $("#categoria3").prop("disabled", dis_cat3);
                $("#categoria3").html(option_c3);
                    
            });
            get_ent_fed('');
//            $.post("modelo.php", {entidades_mc:true}, function (data) {
//                var array_obj_ent = JSON.parse(data);
//                var option_entidades = "<option value='' selected='selected'>-- Todas</option>";
//                $.each(array_obj_ent, function( index, value ) {
//                    option_entidades = option_entidades + "<option value='"+index+"'>"+value.estado+"</option>";
//                });
//
//                $("#entidad-federativa-mc").html(option_entidades);
//            });

            $.post("modelo.php", {partido_politico_mc:true}, function (data) {
                var array_obj_pp = JSON.parse(data);
                var option_pp = "<option value='' selected='selected'>-- Todos</option>";
                $.each(array_obj_pp, function(index_, value_){
                    option_pp = option_pp + "<option values='"+index_+"'>"+value_.part_pol+"</option>";
                });
                $("#part-pol").html(option_pp);
            });
            
            function get_ent_fed(by_){
                $.post("modelo.php", {entidades_mc:{
                        by_e_f_: by_
                }}, function (data) {
                    var array_obj_ent = JSON.parse(data);
                    var option_entidades = "<option value='' selected='selected'>-- Todas</option>";
                    $.each(array_obj_ent, function( index, value ) {
                        option_entidades = option_entidades + "<option value='"+index+"'>"+value.estado+"</option>";
                    });

                    $("#entidad-federativa-mc").html(option_entidades);
                });
            }
//            $.post("modelo.php", {periodos_mc:true}, function (data) {
//                var array_obj_pp = JSON.parse(data);
//                var option_pp = "<option value='' selected='selected'>-- Todos</option>";
//                $.each(array_obj_pp, function(index_, value_){
//                    option_pp = option_pp + "<option values='"+index_+"'>"+value_.periodo+"</option>";
//                });
//                $("#periodo-ini").html(option_pp);
//                $("#periodo-fin").html(option_pp);
//            });
                
            var lienso = null;
            get_grafica('', '', '', '', '', '', '', '');
            $('#search-data-mc').on('click', function(event){

                var e_f = $('#ef_c1').val();
                var cat3 = $('#categoria3').val();
                var part_pol = $('#part-pol').val();
                var ent_fed = $('#entidad-federativa-mc').val();
                var princ_rep = $('#principio-rep').val();
                var prop_sup = $('#prop-sup').val();
//                var per_ini = $("#periodo-ini").val();
//                var per_fin = $("#periodo-fin").val();

                get_grafica(e_f, cat3, part_pol, ent_fed, princ_rep, prop_sup, '', '');

            });
            function get_grafica(e_f, cat3, part_pol, ent_fed, princ_rep, prop_sup, per_ini, per_fin)
            {
                $.post("modelo.php", {search_data_ag: {
                          tipo_search: 'candidatas'
                        , e_f_:e_f
                        , cat3_:cat3
                        , part_pol_: part_pol
                        , ent_fed_ : ent_fed
                        , princ_rep_: princ_rep
                        , prop_sup_ : prop_sup
                        , per_ini_ : (per_ini!=''?parseInt(per_ini):'')
                        , per_fin_ : (per_fin!=''?parseInt(per_fin):'')
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
                        array_label_x.push(parseInt(value.anio_ini));
                        array_data_hombres.push(parseInt(value.totales_hombres_suma==null?0:value.totales_hombres_suma));
                        array_data_mujeres.push(parseInt(value.totales_mujeres_suma==null?0:value.totales_mujeres_suma));
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

