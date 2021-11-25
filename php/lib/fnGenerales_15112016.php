<?php
	session_start();
	$proceso = ($_POST['proceso']) ? ($_POST['proceso']) : $_GET['proceso'];
	switch ($proceso) {
		case "login":
			include_once ("cConectaBD.php");
			$bd = new ConectaBD();
			$bd->setNombreBD("u462865425_lab");
			
			$txtUser = $_POST['txtUser'];
			$txtPass = $_POST['txtPass'];
			$txtUser = stripslashes($txtUser);
			$txtPass = stripslashes($txtPass);
			
			// consultas a base de datos
			$sql = "SELECT * FROM usuarios WHERE cveUsr = '$txtUser' AND passUsr LIKE BINARY '$txtPass'";
			$consulta = $bd->consulta($sql);
			while ($row = mysqli_fetch_assoc($consulta)) {
				$idUsuario = $row['idUsuario'];
				$cveUsr = $row['cveUsr'];
				$nombreUsr = $row['usrNombre'];
				$idPerfil = $row['idPerfil'];
			}
			$count = mysqli_num_rows($consulta);
			if($count > 0){
				// Register $myusername, $mypassword and redirect to file "login_success.php"
				session_start();
				$_SESSION['idUsuario'] = $idUsuario;
				$_SESSION['cveUsr'] = $cveUsr;
				$_SESSION['nombreUsr'] = $nombreUsr;
				$_SESSION['idPerfil'] = $idPerfil;
				$_SESSION['bd'] = "u462865425_lab";
				$_SESSION['idClinica'] = "1";
				setcookie("idUsuario", $idUsuario);
				setcookie("nombreUsr", $nombreUsr);
				setcookie("idPerfil", $idPerfil);
				setcookie("idClinica", "1");
				$url = "http://" . $_SERVER['SERVER_NAME'] . "/main.php";
				echo "
					<SCRIPT>
						$( '#msjIngreso' ).css('background-color','#A9F5D0');
						$( '#msjIngreso' ).html('Acceso correcto!');
						window.location='$url';
					</SCRIPT>
				"; 
			} else {
				echo "
					<script> $( '#msjIngreso' ).css('display','block'); </script>
				";
			}
			$bd->cerrarBD();
		break;
		
		case "cerrarSesion":
			session_destroy();
			$url = "http://" . $_SERVER['SERVER_NAME'] . "/";
			echo $url;
			echo "<SCRIPT>window.location='$url'</SCRIPT>";
		break;
		
		/********* CLIENTES *********/
		
		case "listaClientes":
			include_once ("cClientes.php");
			$cte = new Clientes();
			$cte->bd->setNombreBD($_SESSION['bd']);
			
			$listaClientes = $cte->listaClientes();
	
			$data = array();
			if (mysqli_num_rows($listaClientes) !=0) {
				while ($row = mysqli_fetch_assoc($listaClientes)) {
					$data[] = $row;
				}
			}
			echo $json_info = json_encode($data);
		break;
		
		case "nuevoCliente":
			include_once ("cClientes.php");
			$cte = new Clientes();
			$cte->bd->setNombreBD($_SESSION['bd']);
			
			$cte->setNombreCte($_POST['nombreCte']);
			$cte->setRfcCte($_POST['rfcCte']);
			$cte->setTel1Cte($_POST['tel1Cte']);
			$cte->setDireccionCte($_POST['direccionCte']);
			// $cte->setSerieFolioCte($_POST['serieFolioCte']);
			$cte->setFolioCte($_POST['folioCte']);
			$cte->setEmailCte($_POST['emailCte']);
			$cte->setPublicarResultados($_POST['publicarResultados']);
			$cte->setLogoEnOrden($_POST['logoEnOrden']);
			$cte->setLogoEnResultado($_POST['logoEnResultado']);
			$cte->setLogoEnReporte($_POST['logoEnReporte']);
			
			if(isset($_FILES['logoCte'])){
				$fp = fopen($_FILES['logoCte']['tmp_name'],"r+b");
				$dataFile = fread($fp, $_FILES['logoCte']['size']);
				$dataFile = addslashes($dataFile);
				fclose($fp);
				$cte->setLogoCte($dataFile);
			}
			
			$cte->nuevoCliente();
			$msj = $cte->getMsj();
			
			if ( $msj != "" ) {
				echo "<script>
					$( '#msjModClientes' ).html('$msj');
					$( '#msjModClientes' ).css( 'display', 'block' );
				</script>";
			} else {
				echo "
					<SCRIPT>
						location.reload();
					</SCRIPT>
				"; 
			}
			$cte->bd->cerrarBD();
		break;
		
		case "guardarCliente":
			include_once ("cClientes.php");
			$cte = new Clientes();
			$cte->bd->setNombreBD($_SESSION['bd']);
			
			$cte->setNombreCte($_POST['nombreCte']);
			$cte->setRfcCte($_POST['rfcCte']);
			$cte->setTel1Cte($_POST['tel1Cte']);
			$cte->setDireccionCte($_POST['direccionCte']);
			// $cte->setSerieFolioCte($_POST['serieFolioCte']);
			$cte->setFolioCte($_POST['folioCte']);
			$cte->setEmailCte($_POST['emailCte']);
			$cte->setPublicarResultados($_POST['publicarResultados']);
			$cte->setLogoEnOrden($_POST['logoEnOrden']);
			$cte->setLogoEnResultado($_POST['logoEnResultado']);
			$cte->setLogoEnReporte($_POST['logoEnReporte']);
			
			$cte->editaCliente($_POST['idCliente']);
			
			if(isset($_FILES['logoCte'])){
				$fp = fopen($_FILES['logoCte']['tmp_name'],"r+b");
				$dataFile = fread($fp, $_FILES['logoCte']['size']);
				$dataFile = addslashes($dataFile);
				fclose($fp);
				$cte->setLogoCte($dataFile);
				$cte->agregarLogoCte($_POST['idCliente']);
			}

			echo "
				<SCRIPT>
					location.reload();
				</SCRIPT>
			"; 
			$cte->bd->cerrarBD();
		break;
		
		case "borrarCliente":
			include_once ("cClientes.php");
			$cte = new Clientes();
			$cte->bd->setNombreBD($_SESSION['bd']);
			
			$cte->borraCliente($_POST['idCliente']);
			
			$url = "http://" . $_SERVER['SERVER_NAME'] . "/main.php?mod=clientes";
			echo "
				OK! <br />
				<SCRIPT>
					window.location='$url';
				</SCRIPT>
			"; 
		break;
		
		case "agregarEstudioAlCliente":
			include_once ("cClientes.php");
			$cte = new Clientes();
			$cte->bd->setNombreBD($_SESSION['bd']);
			
			$cte->setIdCliente($_POST['idCliente']);
			$cte->setIdEstudio($_POST['idEstudio']);
			$cte->setIdPaquete($_POST['idPaquete']);
			$cte->setTipoExamen($_POST['tipoExamen']);
			$cte->setPrecio($_POST['precio']);
			
			$cte->agregarEstudioAlCliente();
			
			if ($_POST['agregarEstudioIndividual']) {
				$url = "http://" . $_SERVER['SERVER_NAME'] . "/main.php?mod=clientes";
				echo "
					<SCRIPT> window.location='$url'; </SCRIPT>
				"; 
			}
		break;
		
		case "agregarPaqueteAlCliente":
			include_once ("cClientes.php");
			$cte = new Clientes();
			$cte->bd->setNombreBD($_SESSION['bd']);
			
			$cte->setIdCliente($_POST['idCliente']);
			$cte->setIdEstudio($_POST['idEstudio']);
			$cte->setIdPaquete($_POST['idPaquete']);
			$cte->setTipoExamen($_POST['tipoExamen']);
			$cte->setPrecio($_POST['precio']);
			
			$cte->agregarPaqueteAlCliente();
			
			if ($_POST['agregarPaqueteIndividual']) {
				$url = "http://" . $_SERVER['SERVER_NAME'] . "/main.php?mod=clientes";
				echo "
					<SCRIPT> window.location='$url'; </SCRIPT>
				"; 
			}
		break;
		
		case "relacionCteEstudioPaquetePrecio":
			include_once ("cClientes.php");
			$cte = new Clientes();
			$cte->bd->setNombreBD($_SESSION['bd']);
			
			$relacionCteEstudioPaquetePrecio = $cte->relacionCteEstudioPaquetePrecio($_GET['idCliente']);
	
			$data = array();
			if (mysqli_num_rows($relacionCteEstudioPaquetePrecio) !=0) {
				while ($row = mysqli_fetch_assoc($relacionCteEstudioPaquetePrecio)) {
					$data[] = $row;
				}
			}
			echo $json_info = json_encode($data);
		break;
		
		case "estudiosPorAgregarAlCte":
			include_once ("cClientes.php");
			$cte = new Clientes();
			$cte->bd->setNombreBD($_SESSION['bd']);
			
			$estudiosPorAgregarAlCte = $cte->estudiosPorAgregarAlCte($_GET['idCliente']);
	
			$data = array();
			if (mysqli_num_rows($estudiosPorAgregarAlCte) !=0) {
				while ($row = mysqli_fetch_assoc($estudiosPorAgregarAlCte)) {
					$data[] = $row;
				}
			}
			echo $json_info = json_encode($data);
		break;
		
		case "paquetesPorAgregarAlCte":
			include_once ("cClientes.php");
			$cte = new Clientes();
			$cte->bd->setNombreBD($_SESSION['bd']);
			
			$paquetesPorAgregarAlCte = $cte->paquetesPorAgregarAlCte($_GET['idCliente']);
	
			$data = array();
			if (mysqli_num_rows($paquetesPorAgregarAlCte) !=0) {
				while ($row = mysqli_fetch_assoc($paquetesPorAgregarAlCte)) {
					$data[] = $row;
				}
			}
			echo $json_info = json_encode($data);
		break;
		
		case "borrarEstudioPaqueteDelCte":
			include_once ("cClientes.php");
			$cte = new Clientes();
			$cte->bd->setNombreBD($_SESSION['bd']);
			
			$cte->borrarEstudioPaqueteDelCte($_POST['idPrecio']);
			
			$url = "http://" . $_SERVER['SERVER_NAME'] . "/main.php?mod=clientes";
			echo "
				OK! <br />
				<SCRIPT>
					window.location='$url';
				</SCRIPT>
			"; 
		break;
		
		case "guardarPrecio":
			include_once ("cClientes.php");
			$cte = new Clientes();
			$cte->bd->setNombreBD($_SESSION['bd']);
			
			$cte->setPrecio($_POST['precio']);
			$cte->guardarPrecio($_POST['idPrecio']);
			
			echo "
				<SCRIPT>
					location.reload();
				</SCRIPT>
			";
		break;
		
		/********* PACIENTES *********/
		
		case "listaPacientes":
			include_once ("cPacientes.php");
			$pte = new Pacientes();
			$pte->bd->setNombreBD($_SESSION['bd']);
			
			$pte->setIdPerfil($_SESSION['idPerfil']);
			$pte->setIdUsuario($_SESSION['idUsuario']);
			$listaPacientes = $pte->listaPacientes();
	
			$data = array();
			if (mysqli_num_rows($listaPacientes) !=0) {
				while ($row = mysqli_fetch_assoc($listaPacientes)) {
					$data[] = $row;
				}
			}
			echo $json_info = json_encode($data);
		break;
		
		case "buscarPaciente":
			include_once ("cPacientes.php");
			$pte = new Pacientes();
			$pte->bd->setNombreBD($_SESSION['bd']);
			
			$strBuscarPaciente = $_GET['strBuscarPaciente'];
			$filtroBuscarPaciente = $_GET['filtroBuscarPaciente'];
			$pte->setIdPerfil($_SESSION['idPerfil']);
			$pte->setIdUsuario($_SESSION['idUsuario']);
			$infoPaciente = $pte->getInfoPaciente($strBuscarPaciente,$filtroBuscarPaciente);
	
			$data = array();
			if (mysqli_num_rows($infoPaciente) !=0) {
				while ($row = mysqli_fetch_assoc($infoPaciente)) {
					$data[] = $row;
				}
			}
			echo $json_info = json_encode($data);
		break;
		
		case "nuevoPaciente":
			include_once ("cPacientes.php");
			$pte = new Pacientes();
			$pte->bd->setNombreBD($_SESSION['bd']);
			
			$pte->setNombrePaciente($_POST['nombrePaciente']);
			$pte->setApellidoPaternoPaciente($_POST['apellidoPaternoPaciente']);
			$pte->setApellidoMaternoPaciente($_POST['apellidoMaternoPaciente']);
			$pte->setDireccionPaciente($_POST['direccionPaciente']);
			$pte->setGenero($_POST['genero']);
			// if ($_POST['fechaDeNacimiento'] == "") { $pte->setFechaDeNacimiento("1900-01-01"); } else { $pte->setFechaDeNacimiento($_POST['fechaDeNacimiento']); }
			$pte->setEdadDelPaciente($_POST['edadDelPaciente']);
			$pte->setEmailPaciente($_POST['emailPaciente']);
			$pte->setNoIMSS($_POST['noIMSS']);
			$pte->setIdCliente($_POST['idCliente']);
			$pte->setIdUsuario($_SESSION['idUsuario']);
			
			$pte->nuevoPaciente();
			
			$msj = $pte->getMsj();
			
			if ( $msj != "" ) {
				echo "<script>
					$( '#msjModPacientes' ).html('$msj');
					$( '#msjModPacientes' ).css( 'display', 'block' );
				</script>";
			} else {
				echo "
					<SCRIPT>
						location.reload();
					</SCRIPT>
				"; 
			}
			$pte->bd->cerrarBD();
		break;
		
		case "guardarPaciente":
			include_once ("cPacientes.php");
			$pte = new Pacientes();
			$pte->bd->setNombreBD($_SESSION['bd']);
			
			$pte->setNombrePaciente($_POST['nombrePaciente']);
			$pte->setApellidoPaternoPaciente($_POST['apellidoPaternoPaciente']);
			$pte->setApellidoMaternoPaciente($_POST['apellidoMaternoPaciente']);
			$pte->setDireccionPaciente($_POST['direccionPaciente']);
			$pte->setGenero($_POST['genero']);
			// if ($_POST['fechaDeNacimiento'] == "") { $pte->setFechaDeNacimiento("1900-01-01"); } else { $pte->setFechaDeNacimiento($_POST['fechaDeNacimiento']); }
			$pte->setEdadDelPaciente($_POST['edadDelPaciente']);
			$pte->setEmailPaciente($_POST['emailPaciente']);
			$pte->setNoIMSS($_POST['noIMSS']);
			$pte->setIdCliente($_POST['idCliente']);
			
			$pte->editaPaciente($_POST['idPaciente']);
			
			echo "
				<SCRIPT>
					location.reload();
				</SCRIPT>
			";
			$pte->bd->cerrarBD();
		break;
		
		case "borrarPaciente":
			include_once ("cPacientes.php");
			$pte = new Pacientes();
			$pte->bd->setNombreBD($_SESSION['bd']);
			
			$pte->borraPaciente($_POST['idPaciente']);
			
			echo "
				<SCRIPT>
					location.reload();
				</SCRIPT>
			";
		break;
		
		/********* ESTUDIOS *********/
		
		case "listaEstudios":
			include_once ("cEstudios.php");
			$estudio = new Estudios();
			$estudio->bd->setNombreBD($_SESSION['bd']);
			
			$listaEstudios = $estudio->listaEstudios();
	
			$data = array();
			if (mysqli_num_rows($listaEstudios) !=0) {
				while ($row = mysqli_fetch_assoc($listaEstudios)) {
					$data[] = $row;
				}
			}
			echo $json_info = json_encode($data);
		break;
		
		case "guardarEstudio":
			include_once ("cEstudios.php");
			$estudio = new Estudios();
			$estudio->bd->setNombreBD($_SESSION['bd']);
			
			$estudio->setCveEstudio($_POST['cveEstudio']);
			$estudio->setNombreEstudio($_POST['nombreEstudio']);
			$estudio->setPrecioEstudio($_POST['precioEstudio']);
			$estudio->setLimiteInferiorEstudio($_POST['limiteInferiorEstudio']);
			$estudio->setLimiteSuperiorEstudio($_POST['limiteSuperiorEstudio']);
			$estudio->setUnidadDeMedida($_POST['unidadDeMedida']);
			$estudio->setTipoDeParametro($_POST['tipoDeParametro']);
			$estudio->setValorDeReferencia(mysqli_real_escape_string($estudio->bd->getConexion(),$_POST['valorDeReferencia']));
			
			$estudio->editaEstudio($_POST['idEstudio']);
			
			$url = "http://" . $_SERVER['SERVER_NAME'] . "/main.php?mod=estudios";
			
			echo "
				OK! <br />
				<SCRIPT>
					window.location='$url';
				</SCRIPT>
			"; 
			$estudio->bd->cerrarBD();
		break;
		
		case "guardarNvoEstudio":
			include_once ("cEstudios.php");
			$estudio = new Estudios();
			$estudio->bd->setNombreBD($_SESSION['bd']);
			
			$estudio->setCveEstudio($_POST['cveEstudio']);
			$estudio->setNombreEstudio($_POST['nombreEstudio']);
			$estudio->setPrecioEstudio($_POST['precioEstudio']);
			$estudio->setLimiteInferiorEstudio($_POST['limiteInferiorEstudio']);
			$estudio->setLimiteSuperiorEstudio($_POST['limiteSuperiorEstudio']);
			$estudio->setUnidadDeMedida($_POST['unidadDeMedida']);
			$estudio->setTipoDeParametro($_POST['tipoDeParametro']);
			$estudio->setValorDeReferencia($_POST['valorDeReferencia']);
			
			$estudio->nuevoEstudio();
			$msj = $estudio->getMsj();
			
			$url = "http://" . $_SERVER['SERVER_NAME'] . "/main.php?mod=estudios";
			
			
			if ( $msj != "" ) {
				echo "<script>
					$( '#msjModEstudios' ).html('$msj');
					$( '#msjModEstudios' ).css( {
						display	: 'block',
						color	: 'red'
					});
					$( '#dlgFrmEstudios' ).dialog( 'close' );
				</script>";
			} else {
				$url = "http://" . $_SERVER['SERVER_NAME'] . "/main.php?mod=estudios";
				echo "
					OK! <br />
					<SCRIPT>
						window.location='$url';
					</SCRIPT>
				"; 
			}
			$estudio->bd->cerrarBD();
		break;
		
		case "borrarEstudio":
			include_once ("cEstudios.php");
			$estudio = new Estudios();
			$estudio->bd->setNombreBD($_SESSION['bd']);
			
			$estudio->borraEstudio($_POST['idEstudio']);
			$msj = $estudio->getMsj();
			$url = "http://" . $_SERVER['SERVER_NAME'] . "/main.php?mod=estudios";
			
			if ( $msj != "" ) {
				echo "<script>
					$( '#msjModEstudios' ).html('$msj');
					$( '#msjModEstudios' ).css( {
						display	: 'block',
						color	: 'red'
					});
					$( '#dlgBorrarEstudio' ).dialog( 'close' );
				</script>";
			} else {
				$url = "http://" . $_SERVER['SERVER_NAME'] . "/main.php?mod=estudios";
				echo "
					OK! <br />
					<SCRIPT>
						window.location='$url';
					</SCRIPT>
				"; 
			}
		break;
		
		/********* PAQUETES *********/
		
		case "listaPaquetes":
			include_once ("cPaquetes.php");
			$paq = new Paquetes();
			$paq->bd->setNombreBD($_SESSION['bd']);
			
			$listaPaquetes = $paq->listaPaquetes();
	
			$data = array();
			if (mysqli_num_rows($listaPaquetes) !=0) {
				while ($row = mysqli_fetch_assoc($listaPaquetes)) {
					$data[] = $row;
				}
			}
			echo $json_info = json_encode($data);
		break;
		
		case "guardarPaquete":
			include_once ("cPaquetes.php");
			$paq = new Paquetes();
			$paq->bd->setNombreBD($_SESSION['bd']);
			
			$paq->setCvePaquete($_POST['cvePaquete']);
			$paq->setNombrePaquete($_POST['nombrePaquete']);
			
			$paq->guardarPaquete($_POST['idPaquete']);
			
			$url = "http://" . $_SERVER['SERVER_NAME'] . "/main.php?mod=paquetes";
			
			if ($paq->getMsj() != "") {
				echo $paq->getMsj() . "<script> $('#dlgFrmPaquete').dialog('close'); </script>";
			} else {
				echo "OK! <br /><SCRIPT>window.location='$url';</SCRIPT>";
			}
			$paq->bd->cerrarBD();
		break;
		
		case "guardarNvoPaquete":
			include_once ("cPaquetes.php");
			$paq = new Paquetes();
			$paq->bd->setNombreBD($_SESSION['bd']);
			
			$paq->setCvePaquete($_POST['cvePaquete']);
			$paq->setNombrePaquete($_POST['nombrePaquete']);
			
			$paq->nuevoPaquete();
			
			$url = "http://" . $_SERVER['SERVER_NAME'] . "/main.php?mod=paquetes";
			
			if ($paq->getMsj() != "") {
				echo $paq->getMsj() . "<script> $('#dlgFrmPaquete').dialog('close'); </script>";
			} else {
				echo "OK! <br /><SCRIPT>window.location='$url';</SCRIPT>";
			}
			$paq->bd->cerrarBD();
		break;
		
		case "borrarPaquete":
			include_once ("cPaquetes.php");
			$paq = new Paquetes();
			$paq->bd->setNombreBD($_SESSION['bd']);
			
			$paq->borrarPaquete($_POST['idPaquete']);
			
			$url = "http://" . $_SERVER['SERVER_NAME'] . "/main.php?mod=paquetes";
			
			if ($paq->getMsj() != "") {
				echo $paq->getMsj() . "<script> $('#dlgFrmPaquete').dialog('close'); </script>";
			} else {
				echo "OK! <br /><SCRIPT>window.location='$url';</SCRIPT>";
			}
			$paq->bd->cerrarBD();
		break;
		
		case "estudiosAgregadosAlPaquete":
			include_once ("cPaquetes.php");
			$paq = new Paquetes();
			$paq->bd->setNombreBD($_SESSION['bd']);
			
			$estudiosAgregadosAlPaquete = $paq->estudiosAgregadosAlPaquete($_GET['idPaquete']);
	
			$data = array();
			if (mysqli_num_rows($estudiosAgregadosAlPaquete) !=0) {
				while ($row = mysqli_fetch_assoc($estudiosAgregadosAlPaquete)) {
					$data[] = $row;
				}
			}
			echo $json_info = json_encode($data);
		break;
		
		case "estudiosPorAgregarAlPaquete":
			include_once ("cPaquetes.php");
			$paq = new Paquetes();
			$paq->bd->setNombreBD($_SESSION['bd']);
			
			$estudiosPorAgregarAlPaquete = $paq->estudiosPorAgregarAlPaquete($_GET['idPaquete']);
	
			$data = array();
			if (mysqli_num_rows($estudiosPorAgregarAlPaquete) !=0) {
				while ($row = mysqli_fetch_assoc($estudiosPorAgregarAlPaquete)) {
					$data[] = $row;
				}
			}
			echo $json_info = json_encode($data);
		break;
		
		case "agregarEstudioAlPaquete":
			include_once ("cPaquetes.php");
			$paq = new Paquetes();
			$paq->bd->setNombreBD($_SESSION['bd']);
			
			$paq->agregarEstudioAlPaquete($_POST['idPaquete'],$_POST['idEstudio']);
			
			if ($_POST['agregarEstudioIndividual']) {
				echo "<script> $('#dlgAgregarEstudiosAlPaquete').dialog('close'); </script>";
			}
			$paq->bd->cerrarBD();
		break;
		
		case "borrarEstudioDelPaquete":
			include_once ("cPaquetes.php");
			$paq = new Paquetes();
			$paq->bd->setNombreBD($_SESSION['bd']);
			
			$paq->borrarEstudioDelPaquete($_POST['idPaquete'],$_POST['idEstudio']);
			
			$url = "http://" . $_SERVER['SERVER_NAME'] . "/main.php?mod=paquetes";
			
			if ($paq->getMsj() != "") {
				echo $paq->getMsj() . "<script> $('#dlgAgregarEstudiosAlPaquete').dialog('close'); </script>";
			} else {
				echo "<script> $('#dlgAgregarEstudiosAlPaquete').dialog('close'); </script>";
			}
			$paq->bd->cerrarBD();
		break;
		
		/********* ORDEN DE ESTUDIO *********/
		
		case "ordenesDeEstudios":
			include_once ("cOrdenDeEstudio.php");
			$ods = new OrdenDeEstudio();
			$ods->bd->setNombreBD($_SESSION['bd']);
			
			$ods->setIdPerfil($_SESSION['idPerfil']);
			$ods->setIdUsuario($_SESSION['idUsuario']);
			
			$fehcaInicial = $_GET['fechaInicial'];
			$fechaFinal = $_GET['fechaFinal'];
			
			$ordenesDeEstudios = $ods->ordenesDeEstudios($fehcaInicial,$fechaFinal);
	
			$data = array();
			if (mysqli_num_rows($ordenesDeEstudios) !=0) {
				while ($row = mysqli_fetch_assoc($ordenesDeEstudios)) {
					$data[] = $row;
				}
			}
			echo $json_info = json_encode($data);
		break;
		
		case "orden":
			include_once ("cOrdenDeEstudio.php");
			$ods = new OrdenDeEstudio();
			$ods->bd->setNombreBD($_SESSION['bd']);
			
			// $orden = $ods->orden($_GET['folioDocto']);
			$orden = $ods->orden($_GET['cte'], $_GET['folio']);
			// $orden = $ods->orden($_GET['folio']);
			
			$data = array();
			if (mysqli_num_rows($orden) !=0) {
				while ($row = mysqli_fetch_assoc($orden)) {
					$data[] = $row;
				}
			}
			echo $json_info = json_encode($data);
		break;
		
		case "ods_estudios":
			include_once ("cOrdenDeEstudio.php");
			$ods = new OrdenDeEstudio();
			$ods->bd->setNombreBD($_SESSION['bd']);
			
			$ods_estudios = $ods->ods_estudios($_GET['idCliente']);
	
			$data = array();
			if (mysqli_num_rows($ods_estudios) !=0) {
				while ($row = mysqli_fetch_assoc($ods_estudios)) {
					$data[] = $row;
				}
			}
			echo $json_info = json_encode($data);
		break;
		
		case "ods_paquetes":
			include_once ("cOrdenDeEstudio.php");
			$ods = new OrdenDeEstudio();
			$ods->bd->setNombreBD($_SESSION['bd']);
			
			$ods_paquetes = $ods->ods_paquetes($_GET['idCliente']);
	
			$data = array();
			if (mysqli_num_rows($ods_paquetes) !=0) {
				while ($row = mysqli_fetch_assoc($ods_paquetes)) {
					$data[] = $row;
				}
			}
			echo $json_info = json_encode($data);
		break;
		
		case "agregarEstudioAOrden":
			include_once ("cOrdenDeEstudio.php");
			$ods = new OrdenDeEstudio();
			$ods->bd->setNombreBD($_SESSION['bd']);
			
			// $ods->setFolioDocto($_POST['folioDocto']);
			$ods->setFolioCte($_POST['folioCte']);
			$ods->setIdPrecio($_POST['idPrecio']);
			$ods->setIdCliente($_POST['idCliente']);
			$ods->setIdEstudio($_POST['idEstudio']);
			$ods->setCveEstudio($_POST['cveEstudio']);
			$ods->setNombreEstudio($_POST['nombreEstudio']);
			$ods->setLimiteInferiorEstudio($_POST['limiteInferiorEstudio']);
			$ods->setLimiteSuperiorEstudio($_POST['limiteSuperiorEstudio']);
			$ods->setUnidadDeMedida($_POST['unidadDeMedida']);
			$ods->setTipoDeParametro($_POST['tipoDeParametro']);
			$ods->setValorDeReferencia($_POST['valorDeReferencia']);
			
			if ($_POST['tipoDeParametro'] == 'limites') {
				$valorDeReferencia = $_POST['limiteInferiorEstudio'] . "-" . $_POST['limiteSuperiorEstudio'] . " " . $_POST['unidadDeMedida'];
				$ods->setValorDeReferencia($valorDeReferencia);
			}
			
			$ods->setIdPaquete($_POST['idPaquete']);
			$ods->setCvePaquete($_POST['cvePaquete']);
			$ods->setNombrePaquete($_POST['nombrePaquete']);
			$ods->setTipoExamen($_POST['tipoExamen']);
			$ods->setPrecio($_POST['precio']);
			
			$ods->agregarEstudioAOrden();
			
			if ($_POST['agregarEstudioIndividual'] == "si") {
				$url = "http://" . $_SERVER['SERVER_NAME'] . "/main.php?mod=ordenDeEstudio&cte=" . $_POST['idCliente'] . "&folio=" . $_POST['folioCte'];
				
				if ($ods->getMsj() != "") {
					echo $ods->getMsj() . "<script> $('#dlgEstudios').dialog('close'); $('#dlgPaquetes').dialog('close'); </script>";
				} else {
					echo "OK! <br /><SCRIPT>window.location='$url';</SCRIPT>";
				}
			}
			$ods->bd->cerrarBD();
		break;
		
		case "partidasDeLaOrden":
			include_once ("cOrdenDeEstudio.php");
			$ods = new OrdenDeEstudio();
			$ods->bd->setNombreBD($_SESSION['bd']);
			
			$partidasDeLaOrden = $ods->partidasDeLaOrden($_GET['cte'], $_GET['folio']);
	
			$data = array();
			if (mysqli_num_rows($partidasDeLaOrden) !=0) {
				while ($row = mysqli_fetch_assoc($partidasDeLaOrden)) {
					$data[] = $row;
				}
			}
			echo $json_info = json_encode($data);
		break;
		
		case "borrarPartidaOrdenDeEstudio":
			include_once ("cOrdenDeEstudio.php");
			$ods = new OrdenDeEstudio();
			$ods->bd->setNombreBD($_SESSION['bd']);
			
			$ods->setFolioCte($_POST['folioCte']);
			$ods->setIdPaquete($_POST['idPaquete']);
			$ods->setIdCliente($_POST['idCliente']);
			$ods->setTipoExamen($_POST['tipoExamen']);
			
			$ods->borrarPartidaOrdenDeEstudio($_POST['idOds_EyP']);
			
			$url = "http://" . $_SERVER['SERVER_NAME'] . "/main.php?mod=ordenDeEstudio&cte=" . $_POST['idCliente'] . "&folio=" . $_POST['folioCte'];
			echo "OK! <br /><SCRIPT>window.location='$url';</SCRIPT>";
			
			$ods->bd->cerrarBD();
		break;
		
		case "guardarPrecioPartida":
			include_once ("cOrdenDeEstudio.php");
			$ods = new OrdenDeEstudio();
			$ods->bd->setNombreBD($_SESSION['bd']);
			
			// $ods->setFolioDocto($_POST['folioDocto']);
			$ods->setFolioCte($_POST['folioCte']);
			$ods->setIdCliente($_POST['idCliente']);
			$ods->setPrecio($_POST['precio']);
			$ods->guardarPrecioPartida($_POST['idOds_EyP']);
			
			$url = "http://" . $_SERVER['SERVER_NAME'] . "/main.php?mod=ordenDeEstudio&cte=" . $_POST['idCliente'] . "&folio=" . $_POST['folioCte'];
			echo "OK! <br /><SCRIPT>window.location='$url';</SCRIPT>";
			$ods->bd->cerrarBD();
		break;
		
		case "guardarObservacionDocto":
			include_once ("cOrdenDeEstudio.php");
			$ods = new OrdenDeEstudio();
			$ods->bd->setNombreBD($_SESSION['bd']);
			
			// $ods->setFolioDocto($_POST['folioDocto']);
			$ods->setFolioCte($_POST['folioCte']);
			$ods->setIdCliente($_POST['idCliente']);
			$observacionDocto = mysqli_real_escape_string($ods->bd->getConexion(),$_POST['observacionDocto']);
			$ods->setObservacionDocto($observacionDocto);
			$ods->guardarObservacionDocto();
			
			$ods->bd->cerrarBD();
		break;
		
		case "nvaOrdenDeEstudio":
			include_once ("cOrdenDeEstudio.php");
			$ods = new OrdenDeEstudio();
			$ods->bd->setNombreBD($_SESSION['bd']);
			
			$ods->setIdPaciente($_POST['idPaciente']);
			$ods->setIdCliente($_POST['idCliente']);
			$ods->setIdUsuario($_SESSION['idUsuario']);
			
			$nvoFolioDocto = $ods->nvaOrdenDeEstudio();
			
			$url = "http://" . $_SERVER['SERVER_NAME'] . "/main.php?mod=ordenDeEstudio&cte=" . $_POST['idCliente'] . "&folio=" . $nvoFolioDocto;
			echo "
				OK! <br />
				<SCRIPT>
					window.location='$url';
				</SCRIPT>
			"; 
		break;
		
		case "borrarFolioDocto":
			include_once ("cOrdenDeEstudio.php");
			$ods = new OrdenDeEstudio();
			$ods->bd->setNombreBD($_SESSION['bd']);
			
			$ods->borrarFolioDocto($_POST['folioCte'], $_POST['idCliente']);
			$url = "http://" . $_SERVER['SERVER_NAME'] . "/main.php?mod=ordenesDeEstudios";
			echo "
				OK! <br />
				<SCRIPT>
					window.location='$url';
				</SCRIPT>
			";
		break;
		
		case "paquetesParaCapturaDeResultados":
			include_once ("cOrdenDeEstudio.php");
			$ods = new OrdenDeEstudio();
			$ods->bd->setNombreBD($_SESSION['bd']);
			
			$ods->setFolioCte($_GET['folio']);
			$ods->setIdCliente($_GET['cte']);
			$paquetesParaCapturaDeResultados= $ods->paquetesParaCapturaDeResultados();
			
			$paquetes = array();
			if (mysqli_num_rows($paquetesParaCapturaDeResultados) !=0) {
				while ($row = mysqli_fetch_assoc($paquetesParaCapturaDeResultados)) {
					$paquetes[] = $row;
				}
			}
			
			$estudios = array();
			for ($i = 0; $i < count($paquetes); $i++) {
			
				$ods->setCvePaquete($paquetes[$i]['cvePaquete']);
				$estudiosParaCapturaDeResultados = $ods->estudiosParaCapturaDeResultados();
				
				if (mysqli_num_rows($estudiosParaCapturaDeResultados) !=0) {
					while ($row = mysqli_fetch_assoc($estudiosParaCapturaDeResultados)) {
						$estudios[] = $row;
					}
				}
				$paquetes[$i] = $paquetes[$i] + array("estudios"=>$estudios);
				$estudios = "";
			}
			echo $info_json = json_encode($paquetes);
		break;
		
		case "guardarResultadoEnTextoLibre":
			include_once ("cOrdenDeEstudio.php");
			$ods = new OrdenDeEstudio();
			$ods->bd->setNombreBD($_SESSION['bd']);
			
			$ods->setIdOds_EyP($_POST['idOds_EyP']);
			$textoLibre = mysqli_real_escape_string($ods->bd->getConexion(),$_POST['textoLibre']);
			$ods->setTextoLibre($textoLibre);
			$ods->guardarResultadoEnTextoLibre();
			$ods->bd->cerrarBD();
		break;
		
		case "guardarResultadoValorDeReferencia":
			include_once ("cOrdenDeEstudio.php");
			$ods = new OrdenDeEstudio();
			$ods->bd->setNombreBD($_SESSION['bd']);
			
			$ods->setIdOds_EyP($_POST['idOds_EyP']);
			$ods->setResultadoValorDeReferencia($_POST['resultadoValorDeReferencia']);
			$ods->guardarResultadoValorDeReferencia();
			$ods->bd->cerrarBD();
		break;
		
		case "publicarResultado":
			include_once ("cOrdenDeEstudio.php");
			$ods = new OrdenDeEstudio();
			$ods->bd->setNombreBD($_SESSION['bd']);
			
			// $ods->setFolioDocto($_POST['folioDocto']);
			$ods->setFolioCte($_POST['folioCte']);
			$ods->setIdCliente($_POST['idCliente']);
			$ods->setPublicarResultado($_POST['publicarResultado']);
			$ods->publicarResultado();
			$ods->bd->cerrarBD();
		break;
		
		case "cambiarEdadDelPaciente":
			include_once ("cOrdenDeEstudio.php");
			$ods = new OrdenDeEstudio();
			$ods->bd->setNombreBD($_SESSION['bd']);
			
			// $ods->setFolioDocto($_POST['folioDocto']);
			$ods->setFolioCte($_POST['folioCte']);
			$ods->setIdCliente($_POST['idCliente']);
			$ods->setEdadDelPaciente($_POST['edadDelPaciente']);
			
			$ods->cambiarEdadDelPaciente();
			$ods->bd->cerrarBD();
		break;
		
		/********* INFO DE LA CLINICA *********/
		
		case "infoClinica":
			include_once ("cClinicas.php");
			$clin = new Clinicas();
			$clin->bd->setNombreBD($_SESSION['bd']);
			
			$idClinica = $_GET['idClinica'];
			$infoClinica = $clin->getInfoClinica($idClinica);
			
			echo $json_info = json_encode($infoClinica);
			$clin->bd->cerrarBD();
		break;
		
		case "guardarDatosDeLaClinica":
			include_once ("cClinicas.php");
			$clin = new Clinicas();
			$clin->bd->setNombreBD($_SESSION['bd']);
			
			if ($_SESSION['idPerfil'] != "1") {
				echo '<script> alert ("Error:\nSolo los usuarios administradores pueden \ncambiar los datos de la clinica."); </script>';
				return false;
			}
			
			$clin->setNombreClinica($_POST['nombreClinica']);
			$clin->setRfcClinica($_POST['rfcClinica']);
			$clin->setDireccionClinica($_POST['direccionClinica']);
			$clin->setColonicaClinica($_POST['coloniaClinica']);
			$clin->setMupioClinica($_POST['mupioClinica']);
			$clin->setEstadoClinica($_POST['estadoClinica']);
			$clin->setPaisClinica($_POST['paisClinica']);
			$clin->setCPClinica($_POST['cpClinica']);
			$clin->setEmailClinica($_POST['emailClinica']);
			$clin->setTel1Clinica($_POST['tel1Clinica']);
			$clin->setResponsableClinica($_POST['responsableClinica']);
			$clin->setCedulaDelResponsable($_POST['cedulaDelResponsable']);
			
			if(isset($_FILES['logoClinica'])){
				$fp = fopen($_FILES['logoClinica']['tmp_name'],"r+b");
				$dataFile = fread($fp, $_FILES['logoClinica']['size']);
				$dataFile = addslashes($dataFile);
				fclose($fp);
				$clin->setLogoClinica($dataFile);
				$clin->agregarLogoClinica($_POST['idClinica']);
			}
			
			if(isset($_FILES['firmaDelResponsable'])){
				$fp = fopen($_FILES['firmaDelResponsable']['tmp_name'],"r+b");
				$dataFile = fread($fp, $_FILES['firmaDelResponsable']['size']);
				$dataFile = addslashes($dataFile);
				fclose($fp);
				$clin->setFirmaDelResponsable($dataFile);
				$clin->agregarFirmaDelResponsable($_POST['idClinica']);
			}
			
			if(isset($_FILES['imgCedulaDelResponsable'])){
				$fp = fopen($_FILES['imgCedulaDelResponsable']['tmp_name'],"r+b");
				$dataFile = fread($fp, $_FILES['imgCedulaDelResponsable']['size']);
				$dataFile = addslashes($dataFile);
				fclose($fp);
				$clin->setImgCedulaDelResponsable($dataFile);
				$clin->agregarImgCedulaDelResponsable($_POST['idClinica']);
			}
			
			$clin->editarClinica($_POST['idClinica']);
			$clin->bd->cerrarBD();
			echo '<script> location.reload(); </script>';
		break;
		
		/********* INFO DEL SERVIDOR SMTP *********/
		
		case "infoSMTP":
			include_once ("cSMTP.php");
			$smtp = new SrvSMTP();
			$smtp->bd->setNombreBD($_SESSION['bd']);
			
			$idSMTP = "1";
			$infoSMTP = $smtp->getInfoSMTP($idSMTP);
			$data = array();
			if (mysqli_num_rows($infoSMTP) !=0) {
				while ($row = mysqli_fetch_assoc($infoSMTP)) {
					$data[] = $row;
				}
			}
			echo $json_info = json_encode($data);
		break;
		
		case "guardarDatosSMTP":
			include_once ("cSMTP.php");
			$smtp = new SrvSMTP();
			$smtp->bd->setNombreBD($_SESSION['bd']);
			
			$idSMTP = "1";
			$smtp->setNombreUsrMail($_POST['nombreUsrMail']); 
			$smtp->setHostSMTP($_POST['hostSMTP']);
			$smtp->setUserEmail($_POST['userEmail']);
			$smtp->setPassEmail($_POST['passEmail']);
			$smtp->setPortSMTP($_POST['portSMTP']);
			$smtp->setAuthSMTP($_POST['authSMTP']);
			$smtp->setEncriptacionSMTP($_POST['encriptacionSMTP']);
			
			$smtp->editarSMTP($idSMTP);
			$smtp->bd->cerrarBD();
		break;
		
		/********* USUARIOS *********/
		
		case "listaUsuarios":
			include_once ("cUsuarios.php");
			$usr = new Usuarios();
			$usr->bd->setNombreBD($_SESSION['bd']);
			
			$usr->setIdPerfil($_COOKIE['idPerfil']);
			$usr->setIdUsuario($_COOKIE['idUsuario']);
			$listaUsuarios = $usr->listaUsuarios();
			
			$data = array();
			if (mysqli_num_rows($listaUsuarios) !=0) {
				while ($row = mysqli_fetch_assoc($listaUsuarios)) {
					$data[] = $row;
				}
			}
			echo $json_info = json_encode($data);
			$usr->bd->cerrarBD();
		break;
		
		case "getInfoUsr":
			include_once ("cUsuarios.php");
			$usr = new Usuarios();
			$usr->bd->setNombreBD($_SESSION['bd']);
			
			if ($_POST['infoCurrentUsr']) {
				$idUsuario = $_POST['infoCurrentUsr'];
			} else { $idUsuario = $_SESSION['idUsuario']; }
			
			$infoUsr = $usr->getInfoUsr($idUsuario);
			$data = array();
			if (mysqli_num_rows($infoUsr) !=0) {
				while ($row = mysqli_fetch_assoc($infoUsr)) {
					$data[] = $row;
				}
			}
			echo $json_info = json_encode($data);
			$usr->bd->cerrarBD();
		break;
		
		case "guardarUsr":
			include_once ("cUsuarios.php");
			$usr = new Usuarios();
			$usr->bd->setNombreBD($_SESSION['bd']);
			
			$usr->setNombreUsr($_POST['nombreUsr']);
			$usr->setPassUsr($_POST['passUsr']);
			$usr->setDireccionUsr($_POST['direccionUsr']);
			$usr->setTel1Usr($_POST['tel1Usr']);
			$usr->setTel2Usr($_POST['tel2Usr']);
			$usr->setEmailUsr($_POST['emailUsr']);
			$usr->setIdPerfil($_SESSION['idPerfil']);
			$usr->setIdPerfilTMP($_POST['idPerfil']);
			$idUsuario = $_POST['idUsuario'];
			
			$usr->guardarUsr($idUsuario);
			
			$url = "http://" . $_SERVER['SERVER_NAME'] . "/main.php?mod=usuarios";
			if ($usr->getMsj() != "") {
				echo $usr->getMsj();
			} else {
				echo "
					<SCRIPT>
						window.location='$url';
					</SCRIPT>
				";
			}
			
			$usr->bd->cerrarBD();
		break;
		
		case "guardarNvoUsr":
			include_once ("cUsuarios.php");
			$usr = new Usuarios();
			$usr->bd->setNombreBD($_SESSION['bd']);
			
			$usr->setCveUsr($_POST['cveUsr']);
			$usr->setNombreUsr($_POST['nombreUsr']);
			$usr->setPassUsr($_POST['passUsr']);
			$usr->setDireccionUsr($_POST['direccionUsr']);
			$usr->setTel1Usr($_POST['tel1Usr']);
			$usr->setTel2Usr($_POST['tel2Usr']);
			$usr->setEmailUsr($_POST['emailUsr']);
			$usr->setIdPerfil($_POST['idPerfil']);
			
			$usr->guardarNvoUsr();
			
			$url = "http://" . $_SERVER['SERVER_NAME'] . "/main.php?mod=usuarios";
			echo "
				OK! <br />
				<SCRIPT>
					window.location='$url';
				</SCRIPT>
			"; 
			
			$usr->bd->cerrarBD();
		break;
		
		case "borrarUsr":
			include_once ("cUsuarios.php");
			$usr = new Usuarios();
			$usr->bd->setNombreBD($_SESSION['bd']);
			
			$idUsuario = $_POST['idUsuario'];
			$usr->setIdUsuario($idUsuario);
			
			$usr->borrarUsr($idUsuario);
			
			$url = "http://" . $_SERVER['SERVER_NAME'] . "/main.php?mod=usuarios";
			if ($usr->getMsj() != "") {
				echo $usr->getMsj() . "<script> $('#dlgBorrarUsuario').dialog('close'); </script>";
			} else {
				echo "
					<SCRIPT>
						window.location='$url';
					</SCRIPT>
				";
			}
			$usr->bd->cerrarBD();
		break;
		
		/********* PORTAL DE PACIENTES *********/
		
		case "buscarResultadoPorClaveWeb":
			include_once ("cOrdenDeEstudio.php");
			$ods = new OrdenDeEstudio();
			$ods->bd->setNombreBD("u462865425_lab");
			
			$ods->buscarResultadoPorClaveWeb($_POST["cveWeb"]);
			if ($ods->getMsj() != "") {
				echo $ods->getMsj();
				echo "<SCRIPT> $('#msjPaciente').show(); </SCRIPT>";
			} else {
				$url = "http://" . $_SERVER['SERVER_NAME'] . "/resultadosEnPDF.php?cveWeb=" . $_POST["cveWeb"];
				echo "
					<SCRIPT> 
						$('#msjPaciente').hide();
						window.location='$url'; 
					</SCRIPT>
				";
			}
		break;
	
		case "loginPaciente":
			include_once ("cConectaBD.php");
			$bd = new ConectaBD();
			$bd->setNombreBD("u462865425_lab");
			
			$txtCvePaciente = $_POST['txtCvePaciente'];
			$txtPassPaciente = $_POST['txtPassPaciente'];
			$txtCvePaciente = stripslashes($txtCvePaciente);
			$txtPassPaciente = stripslashes($txtPassPaciente);
			
			$sql = "SELECT * FROM pacientes 
				WHERE cvePaciente = '$txtCvePaciente' AND passPaciente LIKE BINARY '$txtPassPaciente'";
			$query = $bd->consulta($sql);
			
			if (mysqli_num_rows($query) > 0) {
				while ($row = mysqli_fetch_assoc($query)) {
					$idPaciente = $row['idPaciente'];
					$nombreCompletoPaciente = $row['nombreCompletoPaciente'];
					$cvePaciente = $row['cvePaciente'];
					$passPaciente = $row['passPaciente'];
					$gereno = $row['genero'];
					$fechaDeNacimiento = $row['fechaDeNacimiento'];
					$idCliente = $row['idCliente'];
					$noIMSS = $row['noIMSS'];
					$emailPaciente = $row['emailPaciente'];
				}
				session_start();
				$_SESSION['idPaciente'] = $idPaciente;
				$_SESSION['nombreCompletoPaciente'] = $nombreCompletoPaciente;
				$_SESSION['cvePaciente'] = $cvePaciente;
				$_SESSION['passPaciente'] = $passPaciente;
				$_SESSION['gereno'] = $genero;
				$_SESSION['noIMSS'] = $noIMSS;
				$_SESSION['emailPaciente'] = $emailPaciente;
				$_SESSION['bd'] = "laboratorio_lister";
				$url = "http://" . $_SERVER['SERVER_NAME'] . "/mainPacientes.php";
				echo "
					<SCRIPT>
						$('#msjPaciente').hide();
						window.location='$url';
					</SCRIPT>
				"; 
			} else {
				echo "
					<span class='ui-icon ui-icon-alert'></span><strong>Error: </strong>
					La clave y/o contraseña es incorrecta, favor de verificar.
					<br />Si no conoces tu clave y/o contraseña solicita al laboratorio.
					<script> $('#msjPaciente').show(); </script>
				";
			}
		break;
		
		case "cerrarSesionPaciente":
			session_destroy();
			$url = "http://" . $_SERVER['SERVER_NAME'] . "/pacientes.php";
			echo $url;
			echo "<SCRIPT>window.location='$url'</SCRIPT>";
		break;
		
		case "infoPaciente":
			include_once ("cPacientes.php");
			$pte = new Pacientes();
			$pte->bd->setNombreBD($_SESSION['bd']);
			
			$cvePaciente = $_SESSION['cvePaciente'];
			$filtroPaciente = "cvePaciente";
			$infoPaciente = $pte->getInfoPaciente($cvePaciente,$filtroPaciente);
	
			$data = array();
			if (mysqli_num_rows($infoPaciente) !=0) {
				while ($row = mysqli_fetch_assoc($infoPaciente)) {
					$data[] = $row;
				}
			}
			echo $json_info = json_encode($data);
			$pte->bd->cerrarBD();
		break;
		
		case "opcionesDelPaciente":
			include_once ("cPacientes.php");
			$pte = new Pacientes();
			$pte->bd->setNombreBD($_SESSION['bd']);
			
			$pte->setIdPaciente($_POST['idPaciente']);
			$pte->setPassPaciente($_POST['passPaciente']);
			$pte->setEmailPaciente($_POST['emailPaciente']);
			
			$pte->cambiarOpcionesDelPaciente();
			
			$url = "http://" . $_SERVER['SERVER_NAME'] . "/mainPacientes.php";
			echo "
				<SCRIPT>
					window.location='$url';
				</SCRIPT>
			";
			$pte->bd->cerrarBD();
		break;
		
		case "historialDeEstudiosDelPaciente":
			include_once ("cPacientes.php");
			$pte = new Pacientes();
			$pte->bd->setNombreBD($_SESSION['bd']);
			
			$idPaciente = $_GET['idPaciente'];
			// $fHistorialDeEstudiosMes = $_GET['mes'];
			// $fHistorialDeEstudiosYear = $_GET['year'];
			
			$historialDeEstudiosDelPaciente = $pte->historialDeEstudiosDelPaciente($idPaciente);
			//$historialDeEstudiosDelPaciente = $pte->historialDeEstudiosDelPaciente($idPaciente,$fHistorialDeEstudiosMes,$fHistorialDeEstudiosYear);
	
			$data = array();
			if (mysqli_num_rows($historialDeEstudiosDelPaciente) !=0) {
				while ($row = mysqli_fetch_assoc($historialDeEstudiosDelPaciente)) {
					$data[] = $row;
				}
			}
			echo $json_info = json_encode($data);
			$pte->bd->cerrarBD();
		break;
	}
?>