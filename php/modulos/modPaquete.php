	<style>
		.btnBorrarPaquete {
			padding: 10px;
			margin-right: 3px;
			font-size: 1px;
		}
	</style>
	<script src="js/modPaquete.js" language="javascript"></script>
	<div id="contenido">
		<p class="tituloDeSeccion">Paquetes de estudios.</p>
		<hr />
	<label>Nombre del paquete*: </label>
		<input type="text" value="texto" />
		<label>Precio*: </label>
		<input type="text" value="texto" /> <br />
		<label>Tipo de estudio*: </label>
		<select id="idCliente">
			<option value="1">Quimica sanguinea</option>
			<option value="2">Otro 1</option>
			<option value="3">Orina</option>
		</select> <br />
		
		<button id="btnAddNvoEstudio">Agregar estudio</button>
		<table width="80%">
			<tr>
				<th width="20%">Clave</th>
				<th width="50%">Nombre</th>
				<th width="15%">Precio</th>
				<th width="15%"></th>
			</tr>
			<tr>
				<td style="text-align: center">TRI</td>
				<td>Trigliseridos sericos</td>
				<td style="text-align: right">$ 35.00</td>
				<td style="text-align: center">
					<button class="btnEditarEstudio">Editar</button>
					<button class="btnBorrarEstudio">Borrar</button>
				</td>
			</tr>
		</table>
		<div id="dlgBorrarEstudio" title="Borrar estudio">
			Solo se podran borrar estudios que no tengan registrados movimientos. <br />
			¿Desea continuar borrando el estudio: %estudio%?
		</div>