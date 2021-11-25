	<style>
		.btnEditarEstudio,.btnBorrarEstudio {
			padding: 10px;
			margin-right: 3px;
			font-size: 1px;
		}
		label { width: 200px; }
		#msjModEstudios {
			text-align: center;
			width: 100%;
		}
	</style>
	<script src="js/modCatEstudios.js" language="javascript"></script>
	<div id="contenido">
		<p class="tituloDeSeccion">Catálogo de estudios.</p>
		<hr />
		
		<div ng-app="catEstudios">
			<div ng-controller="listaEstudios">
				<button ng-click="mostrarFrmNvoEstudio()" id="btnNvoEstudio">Agregar estudio</button><br />
				<input type="text" placeholder="Filtrar estudios" ng-model="filtrarEstudios" style="width: 40%" />
				<div id="msjModEstudios"></div>
				
				<!-- LISTA DE ESTUDIOS -->
				<table width="100%">
					<tr>
						<th width="20%">Clave</th>
						<th width="50%">Nombre</th>
						<!-- <th width="15%">Precio</th> -->
						<th width="20%">Tipo de resultado</th>
						<th width="10%"></th>
					</tr>
					<tr class="trBD" ng-repeat="estudio in estudios | filter: filtrarEstudios">
						<td style="text-align: center">{{estudio.cveEstudio}}</td>
						<td>{{estudio.nombreEstudio}}</td>
						<!-- <td style="text-align: right">{{estudio.precioEstudio}}</td> -->
						<td style="text-align: center">{{estudio.tipoDeParametro}}</td>
						<td style="text-align: center">
							<button ng-click="mostrarEditarEstudio(estudio)" title="Editar estudio"><span class="ui-icon ui-icon-pencil"></span></button>
							<button ng-click="mostrarBorrarEstudio(estudio)" title="Borrar estudio"><span class="ui-icon ui-icon-trash"></span></button>
						</td>
					</tr>
				</table>
				
				<!-- OPCIONES GENERALES DE LOS ESTUDIOS -->
				<div id="dlgFrmEstudios">
					<div class="ui-state-highlight">
						<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em; margin-top: 3px"></span>
						<strong>Aviso: </strong>Los campos marcados con (*) son obligatorios.
					</div>
					<label>Nombre (*): </label>
					<input type="text" ng-model="currentData.nombreEstudio" value="{{currentData.nombreEstudio}}" placeholder="Ej: Glucosa" /> <br />
					<label>Clave (*): </label>
					<input type="text" ng-model="currentData.cveEstudio" value="{{currentData.cveEstudio}}" placeholder="Ej: GLU" /> <br />
					<!-- <label>Precio (*): </label>
					<input type="text" ng-model="currentData.precioEstudio" value="{{currentData.precioEstudio}}" placeholder="Ej: 50.00" /> <br /> -->
					<div id="opcionesDelEstudio">
						<h3>Opciones del estudio</h3>
						<div>
							<label>¿Usar limietes?</label>
							<input type="radio" style="margin-right: 155px;" ng-model="currentData.tipoDeParametro" value="limites" /> <br />
							<label>Limite inferior (*): </label>
							<input type="text" ng-model="currentData.limiteInferiorEstudio" value="{{currentData.limiteInferiorEstudio}}" placeholder="Ej: 100" /> <br />
							<label>Limite superior (*): </label>
							<input type="text" ng-model="currentData.limiteSuperiorEstudio" value="{{currentData.limiteSuperiorEstudio}}" placeholder="Ej: 200" /> <br />
							<label>Unidad de medida (*): </label>
							<input type="text" ng-model="currentData.unidadDeMedida" value="{{currentData.unidadDeMedida}}" placeholder="Ej: mg% | min | U/L" />
							<hr />
							<label>¿Usar valor de referencia?</label>
							<input type="radio" style="margin-right: 155px;" ng-model="currentData.tipoDeParametro" value="valorDeReferencia" /> <br />
							<label>Valor de referencia</label>
							<!-- <input type="text" value="{{currentData.valorDeReferencia}}" ng-model="currentData.valorDeReferencia" /> -->
							<textarea value="{{currentData.valorDeReferencia}}" ng-model="currentData.valorDeReferencia"></textarea>
							<hr />
							<label>¿Usar texto libre?</label>
							<input type="radio" style="margin-right: 155px;" ng-model="currentData.tipoDeParametro" value="textoLibre" />
						</div>
					</div>
					<hr />
					<button ng-click="guardarNvoEstudio(currentData)" id="btnGuardarNvoEstudio">Guardar</button>
					<button ng-click="guardarEstudio(currentData)" id="btnGuardarEstudio">Guardar</button>
				</div>
				<div id="dlgBorrarEstudio" title="Borrar estudio">
					Solo se podran borrar estudios que no tengan registrados movimientos. <br />
					¿Desea continuar borrando el estudio: <strong>{{currentData.nombreEstudio}}</strong>?
					<hr />
					<button ng-click="eliminarEstudio(currentData)" id="btnBorrarEstudio">Eliminar</button>
				</div>
			</div>
		</div>
	</div>