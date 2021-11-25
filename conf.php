<?php
	/**
	 * Archivo de configuración para nuestra aplicación modularizada.
	 * Definimos valores por defecto y datos para cada uno de nuestros módulos.
	 */
	define('MODULO_DEFECTO', 'frase');
	//define('LAYOUT_DEFECTO', 'default.php');
	define('MODULO_PATH', realpath('./php/modulos/'));
	//define('LAYOUT_PATH', realpath('./php/layouts/'));
	
	$conf['frase'] = array(
		'archivo' => 'fraseDelDia.php'
	);
	$conf['NuevaOrdenDeEstudio'] = array (
		'archivo' => 'modNvaOrden.php'
	);
	$conf['ordenesDeEstudios'] = array (
		'archivo' => 'modOrdenesDeEstudios.php'
	);
	$conf['clientes'] = array (
		'archivo' => 'modCatClientes.php'
	);
	$conf['pacientes'] = array (
		'archivo' => 'modCatPacientes.php'
	);
	$conf['estudios'] = array (
		'archivo' => 'modCatEstudios.php'
	);
	$conf['paquetes'] = array (
		'archivo' => 'modCatPaquetes.php'
	);
	$conf['ordenDeEstudio'] = array (
		'archivo' => 'ordenDeEstudio.php'
	);
	$conf['resultados'] = array (
		'archivo' => 'resultadoDelEstudio.php'
	);
	$conf['clinica'] = array (
		'archivo' => 'infoClinica.php'
	);
	$conf['infoSMTP'] = array (
		'archivo' => 'envioSMTP.php'
	);
	$conf['usuarios'] = array (
		'archivo' => 'modUsuarios.php'
	);
	$conf['rptCobCte'] = array (
		'archivo' => 'reporteCobranzaPorCliente.php'
	);
	$conf['rptEstPorDia'] = array (
		'archivo' => 'reporteEstudiosPorDia.php'
	);
	$conf['rptEstPorCliente'] = array (
		'archivo' => 'reporteEstudiosxDiaxCliente.php'
	);
?>