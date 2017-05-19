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
<script type="text/javascript">
$(document).ready(function(){
  var datos = {
    type: "doughnut",
    data : {
      datasets :[{
        data : [
          56,
          46,
        ],
        backgroundColor: [
          "#DB9397",
          "#6493A3",
        ],
      }],
      labels : [
        "Mujeres",
        "Hombres",
      ]
    },
    options : {
      responsive : true,
    }
  };
  var canvas = document.getElementById('chart').getContext('2d');
  window.pie = new Chart(canvas, datos);
});
</script>

<!-- SLIDER REVOLUTION 5.x SCRIPTS  -->
<script type="text/javascript" src="utilidades/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
<script type="text/javascript" src="utilidades/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
</head>

<body class="wide">

<!-- WRAPPER -->
<div class="wrapper">
  <!-- TOPBAR -->
  <div id="topbar" class="">
    <div class="container">
      <div class="topbar-dropdown">
        <div class="title"><i class="fa fa-newspaper-o"></i>Central Electoral</div>
      </div>
      <div class="topbar-dropdown">
        <div class="title">Mi perfil es <i class="fa fa-caret-down"></i></div>
        <div class="dropdown-list"> <a class="list-entry" href="perfil-extranjero.html">Mexicana(o) en el extranjero</a> <a class="list-entry" href="perfil-primervotante.html">Primer votante</a> <a class="list-entry" href="perfil-actorpolitico.html">Actor Político</a> <a class="list-entry" href="perfil-proveedor.html">Proveedor</a> <a class="list-entry" href="perfil-estudiante.html">Estudiante</a> <a class="list-entry" href="perfil-investigacion.html">Investigador o Academia</a> <a class="list-entry" href="perfil-medios.html">Medio de comunicación</a> </div>
      </div>
      <div class="hidden-xs">
        <div class="social-icons social-icons-colored-hover">
          <ul>
            <li class="social-facebook"><a href="https://www.facebook.com/INEMexico/" target="_blank"><i class="fa fa-facebook"></i></a></li>
            <li class="social-twitter"><a href="https://twitter.com/INEMexico" target="_blank"><i class="fa fa-twitter"></i></a></li>
            <li class="social-youtube"><a href="https://www.youtube.com/user/IFETV" target="_blank"><i class="fa fa-youtube-play"></i></a></li>
            <li class="social-linkedin"><a href="contacto.html"><i class="fa fa-envelope"></i></a></li>
            <li class="social-rss"><a href="#"><i class="fa fa-rss"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- /TOPBAR -->

  <!-- ENCABEZADO -->
  <header id="header" class="">
    <div id="header-wrap">
      <div class="container">

        <!--LOGO-->
        <div id="logo"> <a href="index.html" class="logo" data-dark-logo="images/logo-dark.png"> <img src="images/logo.png" alt="Logo INE"> </a> </div>
        <!--/LOGO-->

        <!--MENU MOVIL -->
        <div class="nav-main-menu-responsive">
          <button class="lines-button x"> <span class="lines"></span> </button>
        </div>
        <!--/MENU MOVIL -->

        <!--BUSCAR EN MENÚ -->
        <div id="top-search"> <a id="top-search-trigger"><i class="fa fa-search"></i><i class="fa fa-close"></i></a>
          <form action="search-results-page.html" method="get" data-toggle="validator">
            <input type="text" name="q" id="q" class="form-control" value="" placeholder="Palabra clave + presiona  &quot;Enter&quot;" required>
          </form>
        </div>
        <!--/BUSCAR EN MENÚ -->

        <!--MENU PRINCIPAL-->
        <div class="navbar-collapse collapse main-menu-collapse navigation-wrap">
          <div class="container">
            <nav id="mainMenu" class="main-menu mega-menu">
              <ul class="main-menu nav nav-pills">
                <li><a href="sobreine.html">Sobre el INE</a></li>
                <li><a href="credencial.html">Credencial de Elector</a></li>
                <li><a href="elecciones.html">Voto y Elecciones</a></li>
                <li><a href="educacioncivica.html">Educación cívica</a></li>
                <li><a href="transparencia.html">Transparencia</a></li>
              </ul>
            </nav>
          </div>
        </div>
        <!--/MENU PRINCIPAL-->
      </div>
    </div>
  </header>
  <!-- /NCABEZADO -->

  <!-- ENCABEZADO BUSQUEDA -->
  <section class="no-margin p-t-50 p-b-50" style="background-image:url(images/ine-bg-home-slide.jpg)">
    <div class="container">
      <div class="row">
        <div class="col-md-5 col-sm-12">
          <h2 class="m-b-20 m-t-50 text-light">Gracias por visitarnos</h2>
          <p class="text-light">En este sitio encontrás información electoral y actividad del Consejo General del INE</p>
          <div class="m-b-20">
            <form id="widget-subscribe-form" action="" role="form" method="post">
              <div class="input-group input-group-lg">
                <input type="email" aria-required="true" name="widget-subscribe-form-email" class="form-control required email" placeholder="Buscar en ine.mx">
                <span class="input-group-btn">
                <button type="submit" id="widget-subscribe-submit-button" class="btn btn-primary">Buscar</button>
                </span> </div>
            </form>
          </div>
          <p class="text-light">Puedes buscar también en nuestro Repositorio de Documentos o nuestra actividad de noticias en Central Electoral.</p>
        </div>
        <div class="col-md-7" style="position: absolute;left: 65%; top:30px;"> <img id="gif-credencial" src="images/credencial.gif"> </div>
      </div>
    </div>
  </section>
  <!-- /ENCABEZADO BUSQUEDA -->

  <!-- ACCESIBILIDAD -->
  <section>
    <div class="col-md-2"></div>
    <div class="text-center col-md-8">
      <h2 class="text-uppercase">Conoce la composición de las Cámaras por género</h2>
      <span class="pleca"></span>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p><br>
    </div>
    <div class="container">
      <div class="row p-t-20 p-b-20">
        <div class="col-xs-6 col-sm-3">
          <label class="text-uppercase">Tipo de Cámara</label>
          <select class="form-control">
            <option>Senadores</option>
            <option>Diputados</option>
          </select>
        </div>
        <div class="col-xs-6 col-sm-3">
          <label class="text-uppercase">Periodo</label>
          <select class="form-control">
            <option>(1989-1992) XIII Legislatura</option>
            <option>(1992-1995) XIV Legislatura</option>
            <option>(1995-1998) XV Legislatura</option>
            <option>(1998-2001) XVI Legislatura</option>
            <option>(2001-2004) XVII Legislatura</option>
          </select>
        </div>
        <div class="col-xs-6 col-sm-3">
          <label class="text-uppercase">Partido político</label>
          <select class="form-control">
            <option>Ver todos</option>
            <option>PAN</option>
            <option>PRI</option>
            <option>PRD</option>
            <option>PVEM</option>
            <option>PT</option>
            <option>MC</option>
            <option>PNA</option>
          </select>
        </div>
        <div class="col-xs-6 col-sm-3">
          <label class="text-uppercase">Partido político</label>
          <select name="marca" id="marca">    
		    <option value="1">Renault</option>
		    <option value="2">Seat</option>
		    <option value="3">Peugeot</option>    
		</select>
        </div>
        <div class="col-xs-6 col-sm-3">
          <label class="text-uppercase">Partido político</label>
          <select name="modelo" id="modelo">    
			    <option value="1">4</option>
			    <option value="2">5</option>
			    <option value="3">7</option>
			    <option value="4">21</option>
			    <option value="5">Scennic</option>
			    <option value="6">Traffic</option>
			</select>
        </div>
        <div class="col-xs-6 col-sm-3 m-t-30">
          <button type="submit" class="btn btn-primary" id="">Buscar</button>
        </div>
      </div>
    </div>
    <div class="center-block" id="canvas-container" style="width:40%;">
  		<canvas id="chart" width="500" height="350"></canvas>
  	</div>
  </section>
  <hr class="no-margin">
  <!--section class=" no-padding">
    <div class="text-center m-t-40">
      <h2 class="text-uppercase">Consulta más datos de Género</h2>
      <span class="pleca"></span>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc auctor nibh a enim luctus, et facilisis est vehicula.</p>
      <div class="container clearfix">
      <div class="row">
      <div class="col-md-3 text-center"> <span class="pie-chart" data-percent="95"> <span class="percent" style="width: 160px; height: 160px; line-height: 160px;">95</span> <canvas height="160" width="160"></canvas></span>
        <h4>Sanchez</h4>
        <p>Lorem ipsum dolor sit amet, consecte adipiscing elit. Condimentum porttitor cursumus.</p>
      </div>
      <div class="col-md-3 text-center">
        <div class="pie-chart" data-percent="89" data-color="#EA4C89"> <span class="percent" style="width: 160px; height: 160px; line-height: 160px;">89</span> <canvas height="160" width="160"></canvas></div>
        <h4>García</h4>
        <p>Lorem ipsum dolor sit amet, consecte adipiscing elit. Suspendisse condimentum cursumus.</p>
      </div>
      <div class="col-md-3 text-center">
        <div class="pie-chart" data-percent="95" data-color="#FF675B"> <span class="percent" style="width: 160px; height: 160px; line-height: 160px;">95</span> <canvas height="160" width="160"></canvas></div>
        <h4>Perez</h4>
        <p>Lorem ipsum dolor sit amet, consecte adipiscing elit. Suspendisse condimentum porttitor.</p>
      </div>
      <div class="col-md-3 text-center">
        <div class="pie-chart" data-percent="66" data-color="#FF9900"> <span class="percent" style="width: 160px; height: 160px; line-height: 160px;">66</span> <canvas height="160" width="160"></canvas></div>
        <h4>Martinez</h4>
        <p>Lorem ipsum dolor sit amet, consecte adipiscing elit. Suspendisse condimentum porttitor cursumus.</p>
      </div>
    </div>
      </div>
    </div>
  </section-->


  <!-- FOOTER -->
  <footer id="footer">
    <section class=" background-grey no-margin no-padding">
      <div class="container">
        <div class="row">
          <div class="accordion clean m-t-20">
            <div class="ac-item">
              <h4 class="ac-title tit-opinion">¿Todo bien con esta página? Nos gustaría saber tu opinión </h4>
              <div class="ac-content " style="display: none;">
                <div class="col-md-6">
                  <label class="upper" for="name">¿Te ha sido útil la información de la página?</label>
                  <p>
                    <input type="radio" name="1" value="si" id="" aria-label="Si" class="">
                    <span class="m-10">Sí</span>
                    <input type="radio" name="1" value="no" id="" aria-label="No">
                    <span class="m-10">No</span></p>
                  <label class="upper" for="name">Envíanos tus dudas, comentarios y/o sugerencias :</label>
                  <p>
                    <input type="radio" name="2" value="Correo para recibir respuesta" id="group_" aria-label="No" checked="">
                    <span class="m-10">Correo para recibir respuesta</span>
                    <input type="radio" name="2" value="Anónimo" id="" aria-label="Si">
                    <span class="m-10">Anónimo</span> </p>
                </div>
                <div class="col-md-6">
                  <p>
                    <label class="upper" for="name"> * Correo electrónico </label>
                    <input type="email" class="form-control required" name="senderName" placeholder="Tu correo electrónico" id="name" aria-required="true">
                  </p>
                  <p>
                    <label class="upper" for="comment">Envíanos tus comentarios</label>
                    <textarea class="form-control required" name="comment" rows="9" placeholder="Escribe tu comentario" id="comment" aria-required="true"></textarea>
                  </p>
                  <button type="submit" class="btn btn-primary" id="encuesta">Enviar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <hr class="no-margin">
    <section class="p-t-30 p-b-0 background-pie" style="background-image:url(images/footer.jpg);">
      <div class="container">
        <div class="row">
          <div class="col-sm-8">
            <div class="carousel portfolio-basic-image" data-carousel-col="1"> <img alt="image" src="images/blog/1.png"> <img alt="image" src="images/blog/1.png"> <img alt="image" src="images/blog/1.png"> </div>
          </div>
          <div class="col-sm-2">
            <h6 class="widget-title">Páginas Útiles</h6>
            <ul class="list no-padding listafooter">
              <li> <a href="#">Contacto</a> </li>
              <li> <a href="#">Datos personales</a> </li>
              <li> <a href="#">Preguntas frecuentes</a> </li>
              <li> <a href="#">Redes sociales</a> </li>
              <li> <a href="#">Mapa del sitio</a> </li>
              <li> <a href="#">Creative Commons</a> </li>
              <li> <a href="#">Accesibilidad</a> </li>
            </ul>
          </div>
          <div class="col-sm-2">
            <h6 class="widget-title">Páginas Principales</h6>
            <ul class="list no-padding listafooter">
              <li> <a href="#">Sobre INE</a> </li>
              <li> <a href="#">Comunidad INE </a> </li>
              <li> <a href="#">Credencial de Elector </a> </li>
              <li> <a href="#">Voto y Elecciones </a> </li>
              <li> <a href="#">Voto en el extranjero</a> </li>
              <li> <a href="#">Transparencia</a> </li>
              <li> <a href="#">Central Electoral</a> </li>
            </ul>
          </div>
        </div>
      </div>
    </section>
    <hr class="no-margin">
    <section class="no-margin no-padding">
      <div class="container">
        <div class="row text-center p-t-40 p-b-20">
          <div class="col-sm-4"> 01 800 433 2000
            <p>Desde cualquier parte del país sin costo</p>
          </div>
          <div class="col-sm-4"> 1 (866) 986 8306
            <p>Desde Estados Unidos sin costo</p>
          </div>
          <div class="col-sm-4"> +52 (55) 5481 9897
            <p>Desde otros países por cobrar</p>
          </div>
        </div>
      </div>
    </section>
    <hr class="no-margin">
  </footer>
  <!-- END: FOOTER -->

</div>
<!-- /WRAPPER -->

<!-- IR ARRIBA -->
<a class="gototop gototop-button" href="#"><i class="fa fa-chevron-up"></i></a>

<!-- Componenetes -->
<script src="js/theme-functions.js"></script>

<!-- Custom js file -->
<script src="js/custom.js"></script>
<script language="javascript">
$(document).ready(function(){
   $("#marca").change(function () {
           $("#marca option:selected").each(function () {
            elegido=$(this).val();
            $.post("modelos.php", { elegido: elegido }, function(data){
            $("#modelo").html(data);
            });            
        });
   })
});
</script>
</body>
</html>