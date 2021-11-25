	<style>
		label { width: 120px; }
		#dlgImprimeEtiqueta br, #codigoDeBarras { margin: 0px; padding: 0px; }
		#dlgImprimeEtiqueta { font-size: 12px; }
		#codigoDeBarras { height: 20px; }
	</style>
	<script src="js/ordenDeEstudio.js" language="javascript"></script>
	<script src="js/jquery-barcode.min.js" language="javascript"></script>
	<div id="contenido" ng-app="ordenDeEstudio">
		<div ng-controller="orden">
			<p class="tituloDeSeccion">Orden de estudio.</p>
			<hr />
			<div ng-repeat="data in currentOrden">
				<label>FOLIO</label>
				<!-- <input type="text" readonly value="{{data.folioCte}}" /> -->
				<input type="text" readonly value="{{data.folioDocto}}" />
				<label>Clave web: </label>
				<input type="text" readonly value="{{data.claveWebDocto}}" />
				<label>Fecha: </label>
				<input type="text" readonly value="{{data.fechaDocto}}" /> <br />
				<label>Paciente: </label>
				<input type="text" readonly value="{{data.nombreCompletoPaciente}}" />
				<label>No. IMSS: </label>
				<input type="text" readonly value="{{data.noIMSS}}" />
				<label>Edad: </label>
				<input type="text" ng-model="data.edadDelPaciente" value="{{data.edadDelPaciente}}" ng-blur="cambiarEdadDelPaciente(data)" /><br />
				<label>Genero: </label>
				<input type="text" readonly value="{{data.genero}}" />
				<label>e-mail: </label>
				<input type="text" readonly value="{{data.emailPaciente}}" />
				<label>Total: </label>
				<input type="text" style="border: 1px solid red" readonly value="{{data.importeDocto | currency : '$' : 2}}" />
				<label>Cliente: </label>
				<!-- <input type="text" readonly value="{{data.nombreCte}}" /> <br /> -->
				<select ng-model="data.idCliente" ng-change="cambiarCliente(data)" id="cambiarCteEnOrden">
					<option ng-repeat="cte in clientes" value="{{cte.idCliente}}" >{{cte.nombreCte}}</option>
				</select> <br />
			
				<button ng-click="mostrarEstudios(data)" >Agregar estudio</button>
				<button ng-click="mostrarPaquetes(data)" >Agregar paquete</button>
				<button ng-click="imprimirOrdenEnPDF(data)">Imprimir orden</button>
				<button ng-click="imprimeEtiqueta(data, partidasDeLaOrden)">Imprimir etiqueta</button>
				<!-- <button >Enviar orden</button> -->
				<button ng-click="capturarResultadosDelEstudio(data)">Resultados del estudio</button>
				<button ng-click="mostrarBorrarOrden(data)">Borrar orden de estudio</button>
			</div>
			<hr />
			<div id="msjOrdenDeEstudio" style="width:100%; text-align: center; color: red"></div>
			<table width="100%">
				<tr>
					<th width="15%">Clave</th>
					<th width="40%">Nombre</th>
					<th width="15%">Tipo de examen</th>
					<th width="15%">Precio</th>
					<th width="15%"></th>
				</tr>
				<tr class="trBD" ng-repeat="partida in partidasDeLaOrden">
					<td style="text-align: center">{{partida.cveEstudio}}{{partida.cvePaquete}}</td>
					<td>{{partida.nombreEstudio}}{{partida.nombrePaquete}}</td>
					<td>{{partida.tipoExamen}}</td>
					<td style="text-align: right">{{partida.precio}}</td>
					<td style="text-align: center">
						<button ng-click="mostrarPrecioPartida(partida)" title="Cambiar precio"><span class="ui-icon ui-icon-pencil"></span></button>
						<button ng-click="borrarPartidaOrdenDeEstudio(partida)" title="Borrar estudio/paquete"><span class="ui-icon ui-icon-trash"></span></button>
					</td>
				</tr>
			</table>
			<div id="importeTotal" style="width:100%;text-align:right;font-size:22px">
			</div>
			<div id="dlgEstudios" title="Agregar estudio">
				<input type="text" placeholder="Filtrar estudios" ng-model="filtroEstudios">
				<table>
					<tr>
						<th></th>
						<th>Clave</th>
						<th>Nombre</th>
						<th>Precio</th>
						<th></th>
					</tr>
					<tr class="trBD" ng-repeat="estudio in ods_estudios | filter: filtroEstudios">
						<td><input type="checkbox" value="{{estudio}}" /></td>
						<td>{{estudio.cveEstudio}}</td>
						<td>{{estudio.nombreEstudio}}</td>
						<td>{{estudio.precio | currency : "$" : 2}}</td>
						<td>
							<button ng-click="agregarEstudioAOrden(estudio)" ><span class="ui-icon ui-icon-plus"></span></button>
						</td>
					</tr>
				</table>
				<hr />
				<button class="agregarEstudiosAOrden" ng-click="agregarEstudiosAOrden()" >Agregar estudios</button>
			</div>
			<div id="dlgPaquetes" title="Agregar paquete">
				<input type="text" placeholder="Filtrar paquetes" ng-model="filtroPaquetes">
				<table>
					<tr>
						<th></th>
						<th>Clave</th>
						<th>Nombre</th>
						<th>Precio</th>
						<!-- <th></th> -->
					</tr>
					<tr class="trBD" ng-repeat="paquete in ods_paquetes | filter: filtroPaquetes">
						<td><input type="checkbox" value="{{paquete}}" /></td>
						<td>{{paquete.cvePaquete}}</td>
						<td>{{paquete.nombrePaquete}}</td>
						<td>{{paquete.precio | currency : "$" : 2}}</td>
						<td>
							<button ng-click="agregarEstudioAOrden(paquete)"><span class="ui-icon ui-icon-plus"></span></button>
						</td>
					</tr>
				</table>
				<hr />
				<button class="agregarEstudiosAOrden" ng-click="agregarPaquetesAOrden()" >Agregar paquetes</button>
			</div>
			<div id="dlgPrecioPartida" title="Precio del estudio/paquete">
				<label>Precio: </label>
				<input type="text" value="{{currentPartida.precio}}" ng-model="currentPartida.precio">
				<hr />
				<button ng-click="guardarPrecioPartida(currentPartida)" id="btnGuardarPrecioPartida">Guardar</button>
			</div>
			<div id="dlgBorrarOrdenDeEstudio" title="Borrar orden de estudio">
				<!-- ¿Deseas borrar la orden de estudio con folio: <strong>{{borrarOrden.folioCte}}</strong>?. <br /> -->
				¿Deseas borrar la orden de estudio con folio: <strong>{{borrarOrden.folioDocto}}</strong>?. <br />
				Todos los movimientos capturados tambien seran borrados.
				<hr />
				<button ng-click="borrarFolioDocto(borrarOrden)" id="btnBorrarOrdenDeEstudio">Borrar</button>
			</div>
			<!-- <div id="dlgImprimeEtiqueta">
				{{objImprimeEtiqueta.folioDocto}} {{objImprimeEtiqueta.nombreCompletoPaciente}}  <br />
				Fecha: {{objImprimeEtiqueta.fechaDocto}}  <br />
				No. de afiliacion: {{objImprimeEtiqueta.noIMSS}}  <br />
				{{objImprimeEtiqueta.clavesEstudiosPaquetes}} <br />
				<div id="codigoDeBarras"></div>
			</div> -->
			<hr />
		</div>
	</div>