	<style>
		.btnEditarPaciente,.btnBorrarPaciente,.btnEMailPaciente,.btnImprimirPaciente {
			padding: 10px;
			margin-right: 3px;
			font-size: 1px;
		}
	</style>
	<script src="js/modCatPacientes.js" language="javascript"></script>
	<div id="contenido">
		<p class="tituloDeSeccion">Catálogo de pacientes.</p>
		<hr />
		<div ng-app="catPacientes">
			<div ng-controller="listaPacientes">
			
				<div>
					<label>Buscar por: </label>
					<select id="filtroBuscarPaciente" ng-model="filtroBuscarPaciente">
						<option value="nombreCompletoPaciente">Nombre del paciente</option>
						<option value="noIMSS">No. de seguro social</option>
						<option value="cvePaciente">Clave paciente</option>
					</select>
					<input type="text" placeholder="Texto a buscar" id="strBuscarPaciente" ng-model="strBuscarPaciente" />
					<button id="btnBuscarPaciente" ng-click="buscarPaciente()" ><span class="ui-icon ui-icon-search"></span></button> <br />
					
					<div id="dlgResultadoBuscarPaciente" title="Resultado de busqueda">
						<table width="100%">
							<tr>
								<th width="15%" style="text-align: center">No. IMSS</th>
								<th width="40%">Nombre</th>
								<th width="25%">Cliente</th>
								<th width="20%"></th>
							</tr>
							<tr class="trBD" ng-repeat="pacienteEncontrado in resultadoDeBusqueda">
								<td>{{pacienteEncontrado.noIMSS}}</td>
								<td>{{pacienteEncontrado.nombreCompletoPaciente}}</td>
								<td>{{pacienteEncontrado.nombreCte}}</td>
								<td style="text-align: center">
									<button ng-click="editarPte(pacienteEncontrado)" title="Editar paciente"><span class="ui-icon ui-icon-pencil"></span></button>
									<button ng-click="nvaOrdenDeEstudio(pacienteEncontrado)" title="Nueva orden de estudio"><a href="php/molulos/ordenDeEstudio.php"><span class="ui-icon ui-icon-plus"></span></a></button>
									<button ng-click="borrarPte(pacienteEncontrado)" class="Eliminar paciente"><span class="ui-icon ui-icon-trash"></span></button>
									<button ng-click="verHistorialDelPaciente(pacienteEncontrado)" title="Historial del paciente"><span class="ui-icon ui-icon-info"></span></button>
								</td>
							</tr>
						</table>
					</div>
				</div>

				<button id="btnNvoPaciente" ng-click="nuevoPaciente()" >Nuevo paciente</button> <br />
				<input type="text" placeholder="Filtrar pacientes" ng-model="filtrarPaciente" style="width: 40%"/>
				<div id="msjModPacientes"></div>
				
				<div id="dlgFrmPaciente">
					<div class="ui-state-highlight">
						<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em; margin-top: 3px"></span>
						<strong>Aviso: </strong>Los campos marcados con (*) son obligatorios.
					</div>
					<label>Nombre(s) (*): </label>
					<input type="text" value="{{currentData.nombrePaciente}}" ng-model="currentData.nombrePaciente" placeholder="Nombre(s)" />
					<label>Apellido paterno (*): </label>
					<input type="text" value="{{currentData.apellidoPaternoPaciente}}" ng-model="currentData.apellidoPaternoPaciente" placeholder="Apellido paterno" />
					<label>Apellido Materno: </label>
					<input type="text" value="{{currentData.apellidoMaternoPaciente}}" ng-model="currentData.apellidoMaternoPaciente" placeholder="Apellido materno" /> <br />
					<label>Direccion: </label>
					<input type="text" value="{{currentData.direccionPaciente}}" style="width: 50%;" ng-model="currentData.direccionPaciente" placeholder="Direccion del paciente" />
					<!-- <label>Fecha de nacimiento: </label>
					<input type="text" value="{{currentData.fechaDeNacimiento}}" class="calFechaDeNacimiento" ng-model="currentData.fechaDeNacimiento" placeholder="Ej: 1982-02-03" /> <br /> -->
					<label>Edad: </label>
					<input type="text" value="{{currentData.edadDelPaciente}}" ng-model="currentData.edadDelPaciente" placeholder="Ej: 34" /> <br />
					<label>No. IMSS: </label>
					<input type="text" value="{{currentData.noIMSS}}" ng-model="currentData.noIMSS" placeholder="Ej: 123456780" />
					<label>e-mail: </label>
					<input type="text" value="{{currentData.emailPaciente}}" ng-model="currentData.emailPaciente" placeholder="Ej: buzon@dominio.com" />
					<label>Genero: </label>
					<select ng-model="currentData.genero">
						<option value="Hombre">Hombre</option>
						<option value="Mujer">Mujer</option>
					</select>
					<label>Clave paciente: </label>
					<input type="text" value="{{currentData.cvePaciente}}" ng-model="currentData.cvePaciente" readonly />
					<label>Contraseña: </label>
					<input type="text" value="{{currentData.passPaciente}}" ng-model="currentData.passPaciente" readonly /><br />
					<div ng-controller="listaClientes">
						<label>Cliente (*): </label>
						<select id="idCliente" ng-model="currentData.idCliente">
							<option ng-repeat="cliente in clientes" value="{{cliente.idCliente}}" >{{cliente.nombreCte}}</option>
						</select>
					</div>
					<hr />
					<button ng-click="guardarPaciente(currentData)" id="btnGuardarPaciente">Guardar</button>
					<button ng-click="guardarNvoPaciente(currentData)" id="btnGuardarNvoPaciente">Guardar</button>
				</div>
				
				<table width="100%">
					<tr>
						<th width="15%" style="text-align: center">No. IMSS</th>
						<th width="40%">Nombre</th>
						<th width="25%">Cliente</th>
						<th width="20%"></th>
					</tr>
					<tr class="trBD" ng-repeat="paciente in pacientes | filter: filtrarPaciente">
						<td>{{paciente.noIMSS}}</td>
						<td>{{paciente.nombreCompletoPaciente}}</td>
						<td>{{paciente.nombreCte}}</td>
						<td style="text-align: center">
							<button ng-click="editarPte(paciente)" title="Editar paciente"><span class="ui-icon ui-icon-pencil"></span></button>
							<button ng-click="nvaOrdenDeEstudio(paciente)" class="btnNvaOrdenDeEstudio" title="Nueva orden de estudio"><span class="ui-icon ui-icon-plus"></span></button>
							<button ng-click="borrarPte(paciente)" class="Eliminar paciente"><span class="ui-icon ui-icon-trash"></span></button>
							<button ng-click="verHistorialDelPaciente(paciente)" title="Historial del paciente"><span class="ui-icon ui-icon-info"></span></button>
						</td>
					</tr>
				</table>
				
				<div id="dlgBorrarPaciente" title="Borrar paciente">
					Solo se pueden borrar pacientes que NO TIENEN movimientos. <br />
					¿Deseas borrar el paciente: <strong>{{currentData.nombreCompletoPaciente}}.</strong>?
					<hr />
					<button ng-click="borrarPaciente(currentData)" id="btnBorrarPaciente" style="float: right">Borrar paciente</button>
				</div>
				
				<!-- <div id="dlgEmailPaciente" title="Enviar correo">
					Los datos del paciente LUIS GERARDO RODRIGUEZ OVALLE <br />
					seran enviados al correo: %buzon@dominio.com% <br />
					¿Deseas continuar?
				</div> -->
				<div id="dlgHistorialDelPaciente" title="Historial del paciente">
					<table>
						<tr>
							<th>Folio</th>
							<th>Nombre del paciente</th>
							<th>Cliente</th>
							<th>Fecha</th>
							<th></th>
						</tr>
						<tr class="trBD" ng-repeat="ordenDeEstudio in historialDelPaciente">
							<td> {{ordenDeEstudio.folioDocto}} </td>
							<td> {{ordenDeEstudio.nombreCompletoPaciente}} </td>
							<td> {{ordenDeEstudio.nombreCte}} </td>
							<td> {{ordenDeEstudio.fechaDocto}} </td>
							<td> <button ng-click="resultadoDeOrdenPDF(ordenDeEstudio)" title="Ver resultado"><span class="ui-icon ui-icon-clipboard"></span></button> </td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>