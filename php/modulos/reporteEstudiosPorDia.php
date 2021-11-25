	<script src="js/reporteCobranzaPorCliente.js" language="javascript"></script>
	<div id="contenido" ng-app="reportes" ng-controller="reporteCobranzaPorCliente">
		<p class="tituloDeSeccion">Reporte de estudios por día.</p>
		<hr />
		<div id="msjReportes"></div>
		
		<label>Usuario: </label>
		<select ng-model="usuario">
			<option ng-repeat="usuario in usuarios" value="{{usuario.idUsuario}}">{{usuario.nombreUsr}}</option>
		</select> <br />
		
		<label>Fecha: </label>
		<input type="text" ng-model="fechaInicial" id="fechaInicial" placeholder="Ej: 2016-01-01" />
		
		<p><button id="btnRptCobranzaPorCliente" ng-click="cmdRptEstudiosPorDia()">Ejecutar reporte</button></p>
	</div>
	
