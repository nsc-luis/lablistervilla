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
	$conf['historial'] = array (
		'archivo' => 'modHistorialPacientePortalCliente.php'
	);
?>