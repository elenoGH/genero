<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="shortcut icon" href="images/favicon.png">
        <title>Bar Chart</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
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
                        <select class="form-control" name="nivel-gobierno" id="nivel-gobierno">
                            <option value="">-- Todas</option>
                            <option value="federal">Federal</option>
                            <option value="estatal">Estatal</option>
                        </select>
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <label class="text-uppercase">Cargo</label>
                        <select class="form-control" name="cargo" id="cargo">
                            <option value="">-- Todas</option>
                            <option value="congresos">Diputaciones</option>
                        </select>
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4" id="div-entidad-federativa">
                        <label class="text-uppercase">Entidad Federativa</label>
                        <select class="form-control" name="entidad-federativa-mcpl" id="entidad-federativa-mcpl">
                            <option value="" selected="selected">-- Todas</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4" id="div-partido-politico">
                        <label class="text-uppercase">Partido Politico</label>
                        <select class="form-control" name="partido-politico" id="partido-politico">
                            <option value="">--Todos</option>
                        </select>
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4" id="div-principio-representacion">
                        <label class="text-uppercase">P. de representación</label>
                        <select class="form-control" name="principio-rep" id="principio-rep">
                            <option value="">--Todos</option>
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
                    <div class="col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px; margin-bottom: 20px;text-align: right;">
                        <button name="search-data-mc" type="button"
                                id="search-data-mc"
                                class="btn btn-primary">
                            &nbsp;Buscar</button>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-sm-12">
            <div class="col-md-10">
                    <div class="consex"><div class="hombre"></div>Hombre</div>
                    <div class="consex"><div class="mujer"></div>Mujer</div>
                <canvas id="grafica_mc" style="width: 100%; height: 95%"></canvas>
            </div>
            <br/>
            <div class="col-md-10">
                <h4>Total de Mujeres y Hombres en el Nivel de Gobierno
                    <b id='p_nivel_gob'></b> por el cargo.
                    <b id='p_cargo'></b> en la Entidad Federativa de
                    <b id='p_entidad_federativa'></b>. por el Partido Politico.
                    <b id='p_partido_pol'></b>, por el Principio de Representación  
                    <b id='p_princ_rep'></b> y siendo 
                    <b id='p_pro_sup'></b>.
                </h4>
            </div>
        </div>
<style type="text/css">
.hombre{
	width:45px;
	height:14px;
	background-color:#79d1cf;
	border:3px solid #099;
	float:left;
	margin-right:4px;
}
.mujer{
	width:45px;
	height:14px;
	background-color:#3ca807;
	border:3px solid #2c7b05;
	float:left;
	margin-right:4px;
}
.consex{
	width:110px;
	height:18px;
	float:left;
}
</style>
        <!-- Custom js file -->
<script language="javascript">
    $(document).ready(function () {
        
        $( "#p_nivel_gob" ).text('Todos');
        $( "#p_cargo" ).text('Todos');
        $( "#p_entidad_federativa" ).text('Todas');
        $( "#p_partido_pol" ).text('Todos');
        $( "#p_princ_rep" ).text('Todos');
        $( "#p_pro_sup" ).text('Todos');
        
        get_entidadFederativa();
        function get_entidadFederativa()
        {
            $.post("modelo.php", {entidad_federativa_mcpl: true}, function (data) {
                var array_obj = JSON.parse(data);
                var opt_sec = "<option value=''>--Todas</option>";
                $.each(array_obj, function (index, value) {
                    opt_sec = opt_sec + "<option value='" + value.entidad_federativa + "'>" + value.entidad_federativa + "</option>";
                });
                $('#entidad-federativa-mcpl').html(opt_sec);
            });
        }
        
        get_partidoPolitico('');
        function get_partidoPolitico(ent_fed)
        {
            $.post("modelo.php", {partido_politico_mcpl: {
                    ent_fed_: ent_fed
                }}, function (data) {
                var array_obj = JSON.parse(data);
                var opt_sec = "<option value=''>--Todos</option>";
                $.each(array_obj, function (index, value) {
                    opt_sec = opt_sec + "<option value='" + value.part_pol + "'>" + value.part_pol + "</option>";
                });
                $('#partido-politico').html(opt_sec);
            });
        }
        
        get_principioRepresentacion();
        function get_principioRepresentacion(){
            $.post("modelo.php", {principio_representacion_mcpl: true}, function (data) {
                var array_obj = JSON.parse(data);
                var opt_sec = "<option value=''>--Todos</option>";
                $.each(array_obj, function (index, value) {
                    opt_sec = opt_sec + "<option value='" + value.principio_representacion + "'>" + value.principio_representacion + "</option>";
                });
                $('#principio-rep').html(opt_sec);
            });
        }
        
        $("#nivel-gobierno").change(function () {
            $( "#p_nivel_gob" ).text($(this).val()==''?'Todos':$(this).val());
        });
        $("#cargo").change(function () {
            $( "#p_cargo" ).text($(this).val()==''?'Todos':$(this).val());
        });
        $("#entidad-federativa-mcpl").change(function () {
            $( "#p_entidad_federativa" ).text($(this).val()==''?'Todos':$(this).val());
            get_partidoPolitico($(this).val());
        });
        $("#partido-politico").change(function () {
            $( "#p_partido_pol" ).text($(this).val()==''?'Todos':$(this).val());
        });
        $("#principio-rep").change(function () {
            $( "#p_princ_rep" ).text($(this).val()==''?'Todos':$(this).val());
        });
        $("#prop-sup").change(function () {
            var var_prop_sup = '';
            if ($(this).val() == 'Propietario') {
                var_prop_sup = 'Propietario/a'
            } else if ($(this).val() == 'Suplente'){
                var_prop_sup = 'Suplente'
            }
            $( "#p_pro_sup" ).text(var_prop_sup);
        });
        
        var lienso = null;
        get_grafica('', '', '', '', '', '');
        $('#search-data-mc').on('click', function (event) {

            var nivel_gobierno = $('#nivel-gobierno').val();
            var cargo = $('#cargo').val();
            var entidad_federativa_mcpl = $('#entidad-federativa-mcpl').val();
            var partido_politico = $('#partido-politico').val();
            var principio_rep = $('#principio-rep').val();
            var prop_sup = $('#prop-sup').val();
            
            get_grafica(nivel_gobierno, cargo, entidad_federativa_mcpl, partido_politico, principio_rep, prop_sup);

        });
        function get_grafica(nivel_gobierno, cargo, entidad_federativa_mcpl, partido_politico, principio_rep, prop_sup)
        {
            $.post("modelo.php", {search_data_mcpl: {
                    nivel_gobierno_: nivel_gobierno
                    , cargo_: cargo
                    , entidad_federativa_mcpl_: entidad_federativa_mcpl
                    , partido_politico_: partido_politico
                    , principio_rep_: principio_rep
                    , prop_sup_: prop_sup
                }
            }, function (data) {
                if (lienso != undefined || lienso != null) {
                    lienso.destroy();
                }
                console.log(JSON.parse(data));
                var array_data_search = JSON.parse(data);
                var array_label_x = [];
                var array_data_hombres = [];
                var array_data_mujeres = [];

                $.each(array_data_search, function (index, value) {
                    array_label_x.push(value.anio_ini + '-' + value.anio_fin);
                    array_data_hombres.push(parseInt(value.totales_hombres_suma));
                    array_data_mujeres.push(parseInt(value.totales_mujeres_suma));
                });

                var chartData = {
                    datasets: [{
                            label: "Hombres",
                            fillColor: "#79D1CF",
                            strokeColor: "#79D1CF",
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
                            fillColor: "#3ca807",
                            strokeColor: "#3ca807",
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
                    labels: array_label_x
                };

                var ctx = document.getElementById("grafica_mc").getContext("2d");
                var myBar = new Chart(ctx).Bar(chartData, {
                    showTooltips: false,
                    onAnimationComplete: function () {

                        var ctx = this.chart.ctx;
                        ctx.font = this.scale.font;
                        ctx.fillStyle = this.scale.textColor
                        ctx.textAlign = "center";
                        ctx.textBaseline = "bottom";

                        this.datasets.forEach(function (dataset) {
                            dataset.bars.forEach(function (bar) {
                                ctx.fillText(bar.value, bar.x, bar.y - 5);
                            });
                        })
                    }
                });
            });
        }
    });
</script>
    </body>
</html>
