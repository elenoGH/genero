<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="shortcut icon" href="images/favicon.png">
        <title></title>
        <script src="Chart.bundle.js"></script>
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
                            <option value="Aguascalientes">Aguascalientes</option>
                            <option value="Baja California">Baja California</option>
                            <option value="Baja California Sur">Baja California Sur</option>
                            <option value="Campeche">Campeche</option>
                            <option value="Chiapas">Chiapas</option>
                            <option value="Chihuahua">Chihuahua</option>
                            <option value="Ciudad de México">Ciudad de México</option>
                            <option value="Coahuila">Coahuila</option>
                            <option value="Colima">Colima</option>
                            <option value="Durango">Durango</option>
                            <option value="Guanajuato">Guanajuato</option>
                            <option value="Guerrero">Guerrero</option>
                            <option value="Hidalgo">Hidalgo</option>
                            <option value="Jalisco">Jalisco</option>
                            <option value="México">México</option>
                            <option value="Michoacán">Michoacán</option>
                            <option value="Morelos">Morelos</option>
                            <option value="Nayarit">Nayarit</option>
                            <option value="Nuevo León">Nuevo León</option>
                            <option value="Oaxaca">Oaxaca</option>
                            <option value="Puebla">Puebla</option>
                            <option value="Querétaro">Querétaro</option>
                            <option value="Quintana Roo">Quintana Roo</option>
                            <option value="San Luis Potosí">San Luis Potosí</option>
                            <option value="Sinaloa">Sinaloa</option>
                            <option value="Sonora">Sonora</option>
                            <option value="Tabasco">Tabasco</option>
                            <option value="Tamaulipas">Tamaulipas</option>
                            <option value="Tlaxcala">Tlaxcala</option>
                            <option value="Veracruz">Veracruz</option>
                            <option value="Yucatán">Yucatán</option>
                            <option value="Zacatecas">Zacatecas</option>
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
                <canvas id="canvas"></canvas>
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
<style>
canvas {
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
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
        
//        get_entidadFederativa();
//        function get_entidadFederativa()
//        {
//            $.post("modelo.php", {entidad_federativa_mcpl: true}, function (data) {
//                var array_obj = JSON.parse(data);
//                var opt_sec = "<option value=''>--Todas</option>";
//                $.each(array_obj, function (index, value) {
//                    opt_sec = opt_sec + "<option value='" + value.entidad_federativa + "'>" + value.entidad_federativa + "</option>";
//                });
//                $('#entidad-federativa-mcpl').html(opt_sec);
//            });
//        }
        
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
            window.myBar.update();

        });
        var color = Chart.helpers.color;
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
                if(lienso != undefined || lienso != null){
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
                /*****/
                var barChartData = {
                    labels: array_label_x,
                    datasets: [{
                        type: 'bar',
                        label: 'Hombre',
                        backgroundColor: "#79D1CF",
                        borderColor: "#4c8382",
                        data: array_data_hombres
                    }, {
                        type: 'bar',
                        label: 'Mujer',
                        backgroundColor: "#3ca807",
                        borderColor: "#266407",
                        data: array_data_mujeres
                    }]
                };
                // Define a plugin to provide data labels
                Chart.plugins.register({
                    afterDatasetsDraw: function(chart, easing) {
                        // To only draw at the end of animation, check for easing === 1
                        var ctx = chart.ctx;

                        chart.data.datasets.forEach(function (dataset, i) {
                            var meta = chart.getDatasetMeta(i);
                            if (!meta.hidden) {
                                meta.data.forEach(function(element, index) {
                                    // Draw the text in black, with the specified font
                                    ctx.fillStyle = 'rgb(0, 0, 0)';

                                    var fontSize = 25;
                                    var fontStyle = 'normal';
                                    var fontFamily = 'Helvetica Neue';
                                    ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);

                                    // Just naively convert to string for now
                                    var dataString = dataset.data[index].toString();

                                    // Make sure alignment settings are correct
                                    ctx.textAlign = 'center';
                                    ctx.textBaseline = 'middle';

                                    var padding = 5;
                                    var position = element.tooltipPosition();
                                    ctx.fillText(dataString, position.x, position.y - (fontSize / 2) - padding);
                                });
                            }
                        });
                    }
                });
                
//                window.onload = function() {
                    var ctx = document.getElementById("canvas").getContext("2d");
                    lienso = new Chart(ctx, {
                        type: 'bar',
                        data: barChartData,
                        options: {
                            responsive: true,
                            title: {
                                display: true,
                                text: 'Mujeres y Hombres en cargos públicos'
                            },
                        }
                    });
                    window.myBar = lienso;
//                };
        
//                document.getElementById('randomizeData').addEventListener('click', function() {
//                    barChartData.datasets.forEach(function(dataset) {
//                        dataset.data = dataset.data.map(function() {
//                            return randomScalingFactor();
//                        })
//                    });
//                    window.myBar.update();
//                });
                /*****/
                
            });
        }
    });
</script>
<script src="Chart.bundle.js"></script>
    </body>
</html>
