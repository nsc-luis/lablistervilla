<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>:: Laboratorio Lister ::</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link type="text/css" href="css/jquery-ui.css" rel="stylesheet">
	<link type="text/css" href="css/index.style.css" rel="stylesheet">
	<script src="js/jquery.js" language="javascript"></script>
	<script src="js/jquery-ui.min.js" language="javascript"></script>
	<script src="js/fnGenerales.js" language="javascript"></script>
</head>
<body>
	<div id="contenedor">
		<fieldset>
			<legend>- Ingreso al sistema -</legend>
			<p class="imgLogin"><img src="images/imgLogin.png" /></p>
			<p class="datosDeIngreso">
				<label>Usuario:</label>
				<input type="text" id="txtUser" placeholder="Ingresa tu usuario" /> <br />
				<label>Contrase&ntilde;a:</label>
				<input type="password" id="txtPass" placeholder="Ingresa tu contraseña" /> <br />
			</p>
			<p class="fright">
				<button type="button" id="ingresoBtn">Ingresar</button><br/>
				<!-- <a href="#">¿Olvidaste la contraseña?</a> -->
			</p>
		</fieldset>
		<div id="msjIngreso" class="ui-state-error">
			<div id="resultado"></div>
			<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
			<strong>Error: </strong>El usuario y/o contraseña son incorrectos.
		</div>
	</div>
</body>
</html>