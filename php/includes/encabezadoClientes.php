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
<body ng-app="portalClientes">
	<div id="encabezado">
		<div id="encabezadoAreaPrincipal">
			<div class="titulo-logo">
				<img class="imgLogo" src="php/lib/blobLogoClinica.php" />
				<p class="titulo">Laboratorio de análisis clínicos "Lister".</p>
			</div>
			<div id="menuPrincipal">
				<ul>
					<li class="menuLv1"><a href="#">Herramientas</a>
						<ul class="menuLv2">
							<li><a class="muestraDlgHistorialPorFecha" href="#">Historial de pacientes por fecha</a></li>
							<li><a class="muestraDlgHistorialPorNoIMSS" href="#">Historial de pacientes por número de afiliación (IMSS)</a></li>
							<li><a class="muestraDlgHistorialPorNombre" href="#">Historial por nombre del paciente</a></li>
							<!-- <li><a class="muestraDlgOpciones" href="#">Cambiar contraseña</a></li> -->
							<li><a class="muestraDlgInfoCliente" href="#">Informacion del cliente</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
	
	<div id="dlgHistorialPorFecha" title="Historial de pacientes por fecha" >
		<div class="ui-state-highlight">
			<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em; margin-top: 3px"></span>
			<strong>Aviso: </strong>Debes ingresar al menos una fecha.
		</div> <br />
		<label>Fecha inicial: </label>
		<input type="text" id="fechaInicial" placeholder="Ej: 2016-11-01" /> <br />
		<label>Fecha final: </label>
		<input type="text" id="fechaFinal" placeholder="Ej: 2016-11-30" />
		<hr />
		<button id="btnCmdHistorialPacientesPorFecha">Ejecutar consulta</button>
	</div>
	
	<div id="dlgHistorialPorNoIMSS" title="Historial de pacientes por número de afiliación (IMSS)" >
		<div class="ui-state-highlight">
			<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em; margin-top: 3px"></span>
			<strong>Aviso: </strong>Se debe ingresar el no. de serguro exactamente como <br />lo capturó el laboratorio.
		</div> <br />
		<label>No. IMSS: </label>
		<input type="text" placeholder="Ej: 1234-567-890" id="noIMSS"/>
		<hr />
		<button id="btnCmdHistorialPacientesPorNoIMSS">Ejecutar consulta</button>
	</div>
	
	<div id="dlgHistorialPorNombre" title="Historial por nombre del paciente" >
		<div class="ui-state-highlight">
			<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em; margin-top: 3px"></span>
			<strong>Aviso: </strong>Puedes ingresar nombre, apellido o nombre completo.
		</div> <br />
		<label>Texto a buscar: </label>
		<input type="text" placeholder="Ej: Luis Gerardo Rodriguez" id="nombreDelPaciente" />
		<hr />
		<button id="btnCmdHistorialPorNombrePaciente">Ejecutar consulta</button>
	</div>
	
	<!-- <div id="dlgOpciones" title="Cambiar contraseña">
		<div class="ui-state-highlight">
			<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em; margin-top: 3px"></span>
			<strong>Aviso: </strong>La contraseña es sensible a MAYUSCULAS y minusculas. 
			<br />Los cambios seran aplicados en el proximo inicio de sesión.
		</div> <br />
		<label>Nueva contraseña: </label>
		<input type="password" id="passWebCte_nva" /> <br />
		<label>Confirmar: </label>
		<input type="password" id="passWebCte_confirmacion" />
		<hr />
		<button id="btnCmdCambiarPassWebCte">Guardar</button>
	</div> -->
	
	<div id="dlgInfoCliente" title="Información del cliente" ng-controller="getInfoCte" >
		<div class="ui-state-highlight">
			<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em; margin-top: 3px"></span>
			<strong>Aviso: </strong>Si requiere modificar algún dato favor de 
			<br />comunicarse al laboratorio.
		</div> <br />
		<span ng-repeat="cliente in currentCliente">
			<label>Nombre: </label> {{cliente.nombreCte}} <br />
			<label>RFC: </label> {{cliente.rfcCte}} <br />
			<label>Telefono: </label> {{cliente.tel1Cte}} <br />
			<label>E-mail: </label> {{cliente.emailCte}} <br />
			<label>Clave web: </label> {{cliente.cveWebCte}} <br />
			<label>Contraseña web: </label> {{cliente.passWebCte}} <br />
		</span>
		<hr />
		<button id="btnCmdInfoCliente">Cerrar</button>
	</div>
	