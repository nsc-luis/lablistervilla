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
	<script src="js/fnGeneralesClientes.js" language="javascript"></script>
	<script src="js/jquery.cookie.js" language="javascript"></script>
</head>
<body>
	<div id="encabezado">
		<div id="encabezadoAreaPrincipal">
			<div class="titulo-logo">
				<img class="imgLogo" src="php/lib/blobLogoClinica.php" />
				<p class="titulo">Laboratorio de análisis clínicos "Lister".</p>
			</div>
		</div>
	</div>
	<div id="main">
		<h3>PORTAL DE ACCESO PARA CLIENTES.</h3>
		<hr />
		<div class="loginCliente">
			<label>Clave del cliente: </label>
			<input type="text" id="cveWebCte" /> <br />
			<label>Contraseña: </label>
			<input type="password" id="passWebCte" /> <br /> <br />
			<button id="btnIniciarSesionCliente">Iniciar sesion</button>
		</div>
		<div id="msjCliente" class="ui-state-error"></div>
		<hr />
	</div>
	<div id="pieDePagina">
		<div id="pieDePaginaAreaPrincipal">
		</div>
	</div>
	</div>
</body>
</html>