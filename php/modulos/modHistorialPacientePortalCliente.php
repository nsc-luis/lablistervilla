	<div id="contenido">
		<div ng-controller="historialPaciente">
			<h3>Historial del paciente </h3>
			{{infoDelFiltro}}
			<hr />
			<input type="text" placeholder="Refinar busqueda" ng-model="refinarBusqueda">
			<table width="100%">
				<tr>
					<th width="15%">Folio</th>
					<th width="45%">Nombre del paciente</th>
					<th width="15%">No. IMSS</th>
					<th width="15%">Fecha</th>
					<th width="10%"></th>
				</tr>
				<tr class="trBD" ng-repeat="orden in historialPaciente | filter: refinarBusqueda">
					<td align="center">{{orden.folioDocto}}</td>
					<td>{{orden.nombreCompletoPaciente}}</td>
					<td align="center">{{orden.noIMSS}}</td>
					<td align="center">{{orden.fechaDocto}}</td>
					<td align="center">
						<button ng-click="resultadoEnPDF(orden)" title="Ver resultado del estudio" >
							<span class="ui-icon ui-icon-clipboard"></span>
						</button>
					</td>
				</tr>
			</table>
		</div>
	</div>