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
<body ng-app="portalDelPaciente" ng-controller="infoDelPaciente">
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
							<li><a ng-click="mostrarDlgHistorialDeEstudios()" class="muestraDlgFiltroDelHistorial_no" href="#">Historial de estudios</a></li>
							<li><a class="muestraDlgOpciones" href="#">Opciones de seguridad</a></li>
							<li><a class="muestraDlgInfoPaciente" href="#">Informacion del paciente</a></li>
							<!-- <li><a class="cerrarSesionPaciente" href="#">Cerrar sesión</a></li> -->
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- <div id="dlgFiltroHistorialDeEstudios" title="Selecciona el mes y año." >
		<select id="fHistorialDeEstudiosMes">
			<option value="01">Enero</option>
			<option value="02">Febrero</option>
			<option value="03">Marzo</option>
			<option value="04">Abril</option>
			<option value="05">Mayo</option>
			<option value="06">Junio</option>
			<option value="07">Julio</option>
			<option value="08">Agosto</option>
			<option value="09">Septiembre</option>
			<option value="10">Octubre</option>
			<option value="11">Noviembre</option>
			<option value="12">Diciembre</option>
		</select>
		<select id="fHistorialDeEstudiosYear">
			<option ng-repeat="year in years" value="{{year}}">{{year}}</option>
		</select>
		<hr />
		<button ng-click="mostrarDlgHistorialDeEstudios()" class="ui-button ui-corner-all ui-widget" style="float: right;">
			<span class="ui-button-icon ui-icon ui-icon-disk"></span>
			<span class="ui-button-icon-space"> </span>
			Ejecutar reporte
		</button>
	</div> -->
	<div id="dlgOpcionesDelPaciente" title="Cambiar correo y/o contraseña.">
		<span ng-repeat="paciente in currentPaciente">
			<label>E-mail: </label>
			<input type="email" id="emailPaciente" ng-model="paciente.emailPaciente" value="{{paciente.emailPaciente}}" /> <br />
			<label>Contraseña: </label>
			<input type="text" id="passwordPaciente" ng-model="paciente.passPaciente" value="{{paciente.passPaciente}}" /> <br />
			<label>Repetir contraseña: </label>
			<input type="text" id="confirmacionPasswordPaciente" />
			<hr />
			<button ng-click="btnOpcionesDelPaciente(paciente)" class="ui-button ui-corner-all ui-widget" style="float: right;">
				<span class="ui-button-icon ui-icon ui-icon-disk"></span>
				<span class="ui-button-icon-space"> </span>
				Guardar
			</button>
		</span>
	</div>
	<div id="dlgInfoDelPaciente" title="Datos del paciente.">
		<div class="ui-state-highlight">
			<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em; margin-top: 3px"></span>
			<strong>Aviso: </strong>Algunos datos solo pueden ser modificados<br /> por el personal del laboratorio.
		</div>
		<span ng-repeat="paciente in currentPaciente">
			<label>Clave del paciente: </label>{{paciente.cvePaciente}}<br />
			<label>Contraseña: </label>{{paciente.passPaciente}}<br />
			<label>Nom. del paciente: </label>{{paciente.nombreCompletoPaciente}}<br />
			<label>No. IMSS: </label>{{paciente.noIMSS}}<br />
			<label>Genero: </label>{{paciente.genero}}<br />
			<label>Edad: </label>{{paciente.edadDelPaciente}} <br />
			<label>e-mail: </label>{{paciente.emailPaciente}}
		</span>
		<hr />
		<button class="btnCerrar">Cerrar</button>
	</div>
	<div id="dlgHistorialDeEstudios" title="Historial de estudios realizados al paciente">
		<span ng-repeat="paciente in currentPaciente">
			<label>Clave del paciente: </label>{{paciente.cvePaciente}}<br />
			<label>Nom. del paciente: </label>{{paciente.nombreCompletoPaciente}}<br />
		</span>
		<hr />
		
		<!-- <h3>Estudios del año <span class="fHistorialDeEstudiosYear" style="text-decoration: underline;"></span>
			en el mes de <span class="fHistorialDeEstudiosMes" style="text-decoration: underline;"></span></h3> -->
		
		<table>
			<tr>
				<th>ClaveWeb</th>
				<th>Nombre completo</th>
				<th>Fecha</th>
				<th>Cliente</th>
				<th></th>
			</tr>
			<tr class="trBD" ng-repeat="estudio in listaEstudiosHistorico">
				<td>{{estudio.claveWebDocto}}</td>
				<td>{{estudio.nombreCompletoPaciente}}</td>
				<td>{{estudio.fechaDocto}}</td>
				<td>{{estudio.nombreCte}}</td>
				<td>
					<button ng-click="btnVerResultadosDelEstudio(estudio)" title="Ver resultados">
						<span class="ui-button-icon ui-icon ui-icon-document"></span>
						<span class="ui-button-icon-space"> </span>
					</button>
				</td>
			</tr>
		</table>
	</div>
	<div id="msjPaciente"></div>