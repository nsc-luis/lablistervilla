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
	<script src="js/fnGeneralesPacientes.js" language="javascript"></script>
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
		<div class="claveWebLoginPaciente">
			<label>Ingresa tu clave web: </label>
			<input type="text" placeholder="Ej: 20161015-M3xbgFOkz" id="txtCveWeb" />
			<button id="btnInfoClaveWeb"><span class="ui-icon ui-icon-info"></span></button>
			<div id="imgInfoClaveWeb" title="ClaveWeb -> impreso en orden de estudio." >
				<img src="images/infoClaveWeb.png" />
			</div>
			<br /><br />
			<button id="btnBuscarClaveWeb">Descargar</button><br /><br />
		</div>
		<div class="claveWebLoginPaciente bordeIzquierdo">
			<label>Clave del paciente: </label>
			<input type="text" id="txtCvePaciente" /> <br />
			<label>Contraseña: </label>
			<input type="password" id="txtPassPaciente" /> <br /> <br />
			<button id="btnIniciarSesionPaciente">Iniciar sesion</button>
		</div>
		<div id="msjPaciente" class="ui-state-error"></div>
	</div>
	<div id="pieDePagina">
		<div id="pieDePaginaAreaPrincipal">
		</div>
	</div>
	</div>
</body>
</html>