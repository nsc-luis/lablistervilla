	<script src="js/modCatClientes.js" language="javascript"></script>
	<div id="contenido">
		<p class="tituloDeSeccion">Catálogo de clientes.</p>
		<hr />
		
		<div ng-app="catClientes">
			<div ng-controller="listaClientes">
				<button id="btnNvoCte" ng-click="nuevoCte()">Nuevo cliente</button> <br />
				<input type="text" placeholder="Filtrar clientes" ng-model="filtrarCliente" style="width: 40%" />
			
				<div id="msjModClientes"></div>
			
				<table width="100%">
					<tr>
						<th width="15%">RFC</th>
						<th width="45%">Cliente</th>
						<th width="25%">e-mail</th>
						<th width="15%"></th>
					</tr>
					<tr class="trBD" ng-repeat="cliente in clientes | filter:filtrarCliente">
						<td style="text-align: center">{{ cliente.rfcCte }}</td>
						<td>{{ cliente.nombreCte }}</td>
						<td>{{ cliente.emailCte }}</td>
						<td style="text-align: center">
							<button ng-click="editarCte(cliente)" title="Editar cliente"><span class="ui-icon ui-icon-pencil"></span></button>
							<button ng-click="mostrarDlgEstudiosPaquetesPrecios(cliente)" title="Relacion cliente/estudios"><span class="ui-icon ui-icon-clipboard"></span></button>
							<button ng-click="borrarCte(cliente)" title="Borrar cliente"><span class="ui-icon ui-icon-trash"></span></button>
						</td>
					</tr>
				</table>
				
				<div id="dlgFrmCte">
					<div class="ui-state-highlight">
						<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em; margin-top: 3px"></span>
						<strong>Aviso: </strong>Los campos marcados con (*) son obligatorios.
					</div>
					<label>Nombre (*): </label>
					<input type="text" placeholder="Nombre del cliente" value="{{currentData.nombreCte}}" ng-model="currentData.nombreCte" style="width: 40%" />
					<label>RFC: </label>
					<input type="text" placeholder="Ej: XAXX010101000" value="{{currentData.nombreCte}}" ng-model="currentData.rfcCte" />
					<label>Direccion: </label>
					<input type="text" placeholder="Calle No, Colonia, Municipio, Estado, CP" value="{{currentData.nombreCte}}" ng-model="currentData.direccionCte" style="width: 50%"/> <br />
					<label>e-mail: </label>
					<input type="email" placeholder="Ej: buzon@dominio.com" value="{{currentData.nombreCte}}" ng-model="currentData.emailCte" />
					<label>Telefono1: </label>
					<input type="text" placeholder="Ej: 81 83112233" value="{{currentData.nombreCte}}" ng-model="currentData.tel1Cte" /> <br />
					<label>Publicar resultados: </label>
					<input type="checkbox" ng-model="currentData.publicarResultados" ng-true-value="'1'" ng-false-value="'0'"/><br />
					<label>Logo del cliente: </label>
					<input type="file" id="logoCte" />
					<label>Logo en orden: </label>
					<input type="checkbox" ng-model="currentData.logoEnOrden" ng-true-value="'1'" ng-false-value="'0'"/>
					<label>Logo en resultado: </label>
					<input type="checkbox" ng-model="currentData.logoEnResultado" ng-true-value="'1'" ng-false-value="'0'"/>
					<label>Logo en reporte: </label>
					<input type="checkbox" ng-model="currentData.logoEnReporte" ng-true-value="'1'" ng-false-value="'0'"/> <br />
					<label>Clave web: </label>
					<input type="text" value="{{currentData.cveWebCte}}" readonly ng-model="currentData.cveWebCte" />
					<label>Contraseña web: </label>
					<input type="text" value="{{currentData.passWebCte}}" ng-model="currentData.passWebCte" />
					
					<hr>
					<button id="btnGuardarNvoCte" ng-disabled="currentData.$invalid" ng-click="guardarNvoCte(currentData)">Guardar</button>
					<button id="btnGuardarCte" ng-disabled="currentData.$invalid" ng-click="guardarCliente(currentData)">Guardar</button>
				</div>
				
				<div id="dlgBorrarCte" title="Borrar cliente">
					¿Deseas borrar el cliente: <strong>{{ currentData.nombreCte }}</strong>?
					<hr>
					<button id="btnBorrarCte" ng-click="borrarCliente(currentData)">Borrar cliente</button>
				</div>
				
				<div id="dlgEstudiosPaquetesPrecios" title="Relacion cliente -> estudio / paquete -> precio">
					<label>CLIENTE: </label> {{nombreCte}}
					<div id="accordionEstudiosPaquetes">
						<h3>Estudios</h3>
						<div id="dlgAgregarEstudiosAlCte">
							<input type="text" placeholder="Filtro estudios" ng-model="filtroEstudios">
							<table>
								<tr>
									<th></th>
									<th>Clave</th>
									<th>Nombre del estudio</th>
									<th>Precio</th>
									<th></th>
								</tr>
								<tr class="trBD" ng-repeat="estudio in estudios | filter: filtroEstudios">
									<td><input type="checkbox" value="{{estudio}}" />
									<td>{{estudio.cveEstudio}}</td>
									<td>{{estudio.nombreEstudio}}</td>
									<td><input type="text" placeholder="Ej: 50.00" class="{{estudio.idEstudio}}" style="width:80px" /></td>
									<td><button ng-click="agregarEstudioAlCliente(estudio)"><span class="ui-icon ui-icon-plus"></span></button></td>
								</tr>
							</table>
							<hr />
							<button class="btnAgregarExamen" ng-click="agregarEstudiosAlCliente()">Agregar estudios</button>
						</div>
						<h3>Paquetes</h3>
						<div id="dlgAgregarPaquetesAlCte">
							<input type="text" placeholder="Filtro paquetes" ng-model="filtroPaquetes">
							<table>
								<tr>
									<th></th>
									<th>Clave</th>
									<th>Nombre del paquete</th>
									<th>Precio</th>
									<th></th>
								</tr>
								<tr class="trBD" ng-repeat="paquete in paquetes | filter: filtroPaquetes">
									<td><input type="checkbox" value="{{paquete}}" />
									<td>{{paquete.cvePaquete}}</td>
									<td>{{paquete.nombrePaquete}}</td>
									<td><input type="text" placeholder="Ej: 50.00" class="{{paquete.idPaquete}}" style="width:80px" /></td>
									<td><button ng-click="agregarPaqueteAlCliente(paquete)"><span class="ui-icon ui-icon-plus"></span></button></td>
								</tr>
							</table>
							<hr />
							<button class="btnAgregarExamen" ng-click="agregarPaquetesAlCliente()">Agregar paquetes</button>
						</div>
					</div>
					<hr />
					<table>
						<tr>
							<th>Clave</th>
							<th>Nombre del estudio/paquete</th>
							<th>Tipo</th>
							<th>Precio</th>
							<th></th>
						</tr>
						<tr class="trBD" ng-repeat="data in relacionCteEstudioPaquetePrecio">
							<td>{{data.cveEstudio}} {{data.cvePaquete}}</td>
							<td>{{data.nombreEstudio}} {{data.nombrePaquete}}</td>
							<td>{{data.tipoExamen}}</td>
							<td>{{data.precio | currency : "$" : 2}}</td>
							<td>
								<button ng-click="mostrarEditarPrecio(data)"><span class="ui-icon ui-icon-pencil"></span></button>
								<button ng-click="borrarEstudioPaqueteDelCte(data)"><span class="ui-icon ui-icon-trash"></span></button>
							</td>
						</tr>
					</table>
					<div id="dlgEditarPrecio" title="Precio estudio/paquete">
						<label>Precio</label>
						<input type="text" ng-model="precioEstudioPaquete.precio" value="{{precioEstudioPaquete.precio}}" placeholder="Ej: 50.00" />
						<hr />
						<button id="btnGuardarPrecio" ng-click="guardarPrecio(precioEstudioPaquete)">Guardar</button>
					</div>
				</div>
			</div>
		</div>	
	</div>