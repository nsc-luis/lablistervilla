	<script src="js/modOrdenesDeEstudios.js" language="javascript"></script>
	<div id="contenido">
		<div ng-app="modOrdenesDeEstudios" ng-controller="ordenesDeEstudios">
			<p class="tituloDeSeccion">Ordenes de estudios.</p>
			<hr />
			<!-- <label>Folio del estudio</label>
			<input type="text" placeholder="Ej: 20000" />
			<button><span class="ui-icon ui-icon-search"></span></button><br /> -->
			<label>Entre fechas:</label>
			<input type="text" id="fechaInicial" placeholder="Ej: 2016-07-14" /> Y <input type="text" id="fechaFinal" placeholder="Ej: 2016-09-14" />
			<!-- <label>Cliente: </label>
			<select>
				<option value="0">Todos</option>
				<option ng-repeat="cliente in clientes" value="{{cliente.idCliente}}">{{cliente.nombreCte}}</option>
			</select> <br /> -->
			<button id="btnFiltroFechas">Aplicar</button>
			<hr />
			<div id="msjOrdenesDeEstudios" style="width:100%; text-align: center; color: red"></div>
			<div>
				<input type="text" placeholder="Refinar busqueda" ng-model="filtroOrdenesDeEstudios">
				<table width="100%">
					<tr>
						<th width="13%">Folio</th>
						<th width="35%">Nombre del paciente</th>
						<th width="25%">Cliente</th>
						<th width="12%">Importe</th>
						<th width="15%"></th>
					</tr>
					<tr class="trBD" ng-repeat="ordenDeEstudio in ordenesDeEstudios | filter: filtroOrdenesDeEstudios" >
						<!-- <td style="text-align: center">{{ordenDeEstudio.folioCte}}</td> -->
						<td style="text-align: center">{{ordenDeEstudio.folioDocto}}</td>
						<td>{{ordenDeEstudio.nombreCompletoPaciente}}</td>
						<td>{{ordenDeEstudio.nombreCte}}</td>
						<td style="text-align: right">{{ordenDeEstudio.importeDocto | currency : "$" : 2}}</td>
						<td style="text-align: center">
							<button ng-click="editarOrdenDeEstudio(ordenDeEstudio)" title="Editar estudio"><span class="ui-icon ui-icon-pencil"></span></button>
							<button ng-click="capturarResultadosDelEstudio(ordenDeEstudio)" title="Resultados del estudio"><span class="ui-icon ui-icon-clipboard"></span></button>
							<button ng-click="mostrarBorrarOrden(ordenDeEstudio)" title="Borrar estudio"><span class="ui-icon ui-icon-trash"></span></button>
						</td>
					</tr>
				</table>
			</div>
			<div id="dlgBorrarOrdenDeEstudio" title="Borrar orden de estudio">
				<!-- ¿Deseas borrar la orden de estudio con folio: <strong>{{borrarOrden.folioCte}}</strong>?. <br /> -->
				¿Deseas borrar la orden de estudio con folio: <strong>{{borrarOrden.folioDocto}}</strong>?. <br />
				Todos los movimientos capturados tambien seran borrados.
				<hr />
				<button ng-click="borrarFolioDocto(borrarOrden)" id="btnBorrarOrdenDeEstudio">Borrar</button>
			</div>
		</div>
	</div>