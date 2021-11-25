	<script src="js/reporteCobranzaPorCliente.js" language="javascript"></script>
	<div id="contenido" ng-app="reportes" ng-controller="reporteCobranzaPorCliente">
		<p class="tituloDeSeccion">Reporte de cobranza por cliente.</p>
		<hr />
		<div id="msjReportes"></div>
		<label>Cliente: </label>
		<select ng-model="cliente">
			<option ng-repeat="cliente in clientes" value="{{cliente.idCliente}}">{{cliente.nombreCte}}</option>
		</select> <br />
		
		<label>Usuario: </label>
		<select ng-model="usuario">
			<option ng-repeat="usuario in usuarios" value="{{usuario.idUsuario}}">{{usuario.nombreUsr}}</option>
		</select> <br />
		
		<label>Entre fechas: </label>
		<input type="text" ng-model="fechaInicial" id="fechaInicial" placeholder="Ej: 2016-01-01" />
		Y 
		<input type="text" ng-model="fechaFinal" id="fechaFinal" placeholder="Ej: 2016-01-31" />
		
		<p><button id="btnRptCobranzaPorCliente" ng-click="cmdRptCobranzaPorCliente()">Ejecutar reporte</button></p>
	</div>
	
