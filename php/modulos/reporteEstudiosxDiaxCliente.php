	<script src="js/reportes.js" language="javascript"></script>
	<div id="contenido" ng-app="reportes" ng-controller="rptEstudiosDiariosxCliente">
		<p class="tituloDeSeccion">Reporte de estudios por día.</p>
		<hr />
		<div id="msjReportes"></div>
		
		<label>Cliente: </label>
		<select ng-model="cliente">
			<option ng-repeat="cliente in clientes" value="{{cliente.idCliente}}">{{cliente.nombreCte}}</option>
		</select> <br />
		
		<label>Fecha: </label>
		<input type="text" ng-model="fechaInicial" id="fechaInicial" placeholder="Ej: 2016-01-01" />
		
		<p><button id="btnRptEstudiosDiariosxCte" ng-click="cmdRptEstudiosDiariosxCte()">Ejecutar reporte</button></p>
	</div>
	
