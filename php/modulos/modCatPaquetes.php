	
	<script src="js/modCatPaquetes.js" language="javascript"></script>
	<div id="contenido" ng-app="catPaquetes" ng-controller="listaPaquetes" >
		<p class="tituloDeSeccion">Catálogo de paquetes de estudios.</p>
		<hr />
		<button id="btnNvoPaquete" ng-click="mostrarFrmNvoPaquete()" >Nuevo paquete de estudios</button> <br />
		<div id="msjPaquetes" ></div>
		<table style="width: 80%">
			<tr>
				<th width="20%">Clave</th>
				<th width="50%">Nombre</th>
				<th width="15%"></th>
			</tr>
			<tr class="trBD" ng-repeat="paquete in paquetes">
				<td style="text-align: center">{{paquete.cvePaquete}}</td>
				<td>{{paquete.nombrePaquete}}</td>
				<td style="text-align: center">
					<button ng-click="mostrarFrmPaquete(paquete)" ><span class="ui-icon ui-icon-pencil"></span></button>
					<button ng-click="mostrarAgregarEstudios(paquete)" ><span class="ui-icon ui-icon-plus"></span></button>
					<button ng-click="mostrarBorrarPaquete(paquete)" ><span class="ui-icon ui-icon-trash"></span></button>
				</td>
			</tr>
		</table>
		<div id="dlgFrmPaquete">
			<label style="width: 180px">Clave del paquete: </label>
			<input type="text" ng-model="currentData.cvePaquete" value="{{currentData.cvePaquete}}" /> <br />
			<label style="width: 180px">Nombre del paquete: </label>
			<input type="text" placeholder="Ej: HEMATOLOGIA" ng-model="currentData.nombrePaquete" value="{{currentData.nombrePaquete}}" />
			<hr />
			<button ng-click="guardarPaquete(currentData)" id="btnGuardarPaquete">Guardar paquete</button>
			<button ng-click="guardarNvoPaquete(currentData)" id="btnGuardarNvoPaquete">Guardar paquete</button>
		</div>
		<div id="dlgAgregarEstudiosAlPaquete" title="Selecciona los estudios">
			<div id="acordionEstudios">
				<h3>Estudios agregados</h3>
				<div>
					<input type="text" placeholder="Filtro de estudios" ng-model="filtrarEstudiosAgregados" /> <br />
					<table style="width: 100%">
						<tr>
							<th>Clave</th>
							<th>Nombre del estudio</th>
							<th></th>
						</tr>
						<tr class="trBD" ng-repeat="estudioAgregado in estudiosAgregadosAlPaquete | filter: filtrarEstudiosAgregados">
							<td style="text-align:center" >{{estudioAgregado.cveEstudio}}</td>
							<td>{{estudioAgregado.nombreEstudio}}</td>
							<td style="text-align:center"><button ng-click="borrarEstudioDelPaquete(estudioAgregado)"><span class="ui-icon ui-icon-trash"></span></button></td>
						</tr>
					</table>
				</div>
				<h3>Estudios por agregar</h3>
				<div>
					<input type="text" placeholder="Filtro de estudios" ng-model="filtrarEstudiosPorAgregar" /> <br />
					<table style="width: 100%">
						<tr>
							<th></th>
							<th>Clave</th>
							<th>Nombre del estudio</th>
							<th></th>
						</tr>
						<tr class="trBD" ng-repeat="estudioPorAgregar in estudiosPorAgregarAlPaquete | filter: filtrarEstudiosPorAgregar">
							<td style="text-align: center"><input type="checkbox" value="{{estudioPorAgregar}}" /></td>
							<td style="text-align:center" >{{estudioPorAgregar.cveEstudio}}</td>
							<td>{{estudioPorAgregar.nombreEstudio}}</td>
							<td style="text-align:center"><button ng-click="agregarEstudioAlPaquete(estudioPorAgregar)"><span class="ui-icon ui-icon-plus"></span></button></td>
						</tr>
					</table>
					<hr />
					<button id="btnAgregarEstudios" ng-click="agregarEstudiosAlPaquete()">Agregar estudios</button>
				</div>
			</div>
			<div id="msjEstudiosDelPaquete"></div>
		</div>
		<div id="dlgBorrarPaquete" title="Borrar paquete de estudios">
			Solo se podran borrar paquetes que no tengan registrados movimientos. <br />
			¿Desea continuar borrando el paquete: <strong>{{currentData.nombrePaquete}}</strong>?
			<hr />
			<button ng-click="borrarPaquete(currentData)" id="btnBorrarPaquete">Borrar paquete</button>
		</div>
	</div>