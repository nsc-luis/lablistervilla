<?php
	session_start();
	if (!$_SESSION['idUsuario'])
	{
		header("location:http://" . $_SERVER['SERVER_NAME'] . "/index.php");
	}
	header('Content-Type: text/html; charset=UTF-8');
	
	// Primero incluimos el archivo de configuración
	include('conf.php');
	
	/** 
	 * Verificamos que se haya escogido un modulo, sino
	 * tomamos el valor por defecto de la configuración.
	 * También debemos verificar que el valor que nos
	 * pasaron, corresponde a un modulo que existe.
	 */
	if (!empty($_GET['mod'])) {
	  $modulo = $_GET['mod'];
	}
	else {
	  $modulo = MODULO_DEFECTO;
	}
	
	/** 
	 * También debemos verificar que el valor que nos
	 * pasaron, corresponde a un modulo que existe, caso
	 * contrario, cargamos el modulo por defecto
	 */
	if (empty($conf[$modulo])) {
	  $modulo = MODULO_DEFECTO;
	}

	/** 
	 * Finalmente, cargamos el archivo de Layout que a su vez, se
	 * encargará de incluir al módulo propiamente dicho. si el archivo
	 * no existiera, cargamos directamente el módulo. También es un
	 * buen lugar para incluir Headers y Footers comunes.
	 */
	$path_modulo = MODULO_PATH.'/'.$conf[$modulo]['archivo'];
	
	include('php/includes/encabezado.php');
	
	if (file_exists( $path_modulo )) {
		include( $path_modulo );
	} else {
		die('Error al cargar el módulo **'.$modulo.'**. No existe el archivo ** file.php **');
	}
	
	include('php/includes/pieDePagina.php');
?>