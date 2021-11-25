<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>:: Laboratorios Lister ::</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link type="text/css" href="css/jquery-ui.css" rel="stylesheet">
	<link type="text/css" href="css/default2.css" rel="stylesheet">
	<script src="js/jquery.js" language="javascript"></script>
	<script src="js/jquery-ui.min.js" language="javascript"></script>
	<script src="js/angular.min.js" language="javascript"></script>
	<script src="js/fnGenerales.js" language="javascript"></script>
	<script src="js/jquery.cookie.js" language="javascript"></script>
</head>
<body>
	<div id="encabezado">
		<div id="encabezadoAreaPrincipal">
			<div class="titulo-logo">
				<img class="imgLogo" src="images/logo_tmp.png" />
				<p class="titulo">Laboratorio de análisis clínicos "Lister".</p>
			</div>
			<div id="menuPrincipal">
				<ul>
					<!-- <li class="menuLv1"><a href="?mod=NuevaOrdenDeEstudio">Nueva orden</a></li> -->
					<li class="menuLv1"><a href="#">Catálogos</a>
						<ul class="menuLv2">
							<li><a href="?mod=estudios">Estudios</a></li>
							<li><a href="?mod=paquetes">Paquetes</a></li>
							<li><a href="?mod=clientes">Clientes</a></li>
							<li><a href="?mod=pacientes">Pacientes</a></li>
						</ul>
					</li>
					<li class="menuLv1"><a href="?mod=ordenesDeEstudios">Ordenes de estudios</a></li>
					<li class="menuLv1"><a href="#">Reportes</a>
						<ul class="menuLv2">
							<!-- <li><a href="#">Pacientes por fecha</a></li>
							<li><a href="#">Estudios por fecha</a></li>
							<li><a href="#">Ventas por estudio</a></li>
							<li><a href="#">Ventas por paquete</a></li> -->
							<li><a href="?mod=rptCobCte" id="ventasPorCliente_">Ventas por cliente</a></li>
						</ul>
					</li>
					<li class="menuLv1"><a href="#">Configuración</a>
						<ul class="menuLv2">
							<li><a href="doctos/manualDeOperacion.pdf" target="_blank">Manual de operación</a></li>
							<li><a href="?mod=usuarios">Usuarios</a></li>
							<!-- <li><a href="#">Perfiles</a></li> -->
							<li><a href="?mod=infoSMTP">Correo SMTP</a></li>
							<li><a href="?mod=clinica">Datos de la clinica</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>