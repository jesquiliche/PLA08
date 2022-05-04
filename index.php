<?php

	require_once "./models/BaseModelDAO.php";
	require_once "./models/MyPersonaDAO.php";
	require_once "./utils/utils.php";
	//inicializar variables

	$idpersona="";
	$nif="";
	$nombre="";
	$apellidos="";
	$direccion="";
	$telefono="";
	$email="";
	$mensaje="";
	//if(isset($errores) && $errores>0 ) cargaDatos($_POST);
	$errores=array();
	

	//Construimos el objeto de acceso a datos
	//Patrón de diseño DAO
	$persona=new MyPersonaDAO();

	if(isset($_POST['alta'])){
		if(validarDatos($_POST)){
			try{
				$persona->setExclude('alta');
				if($persona->Create($_POST)>0)
					$mensaje="Persona dada de alta";
			} catch(Exception $e){
				if($e->getCode()==23000)
					array_push($errores,"El nif ya existe en la Base de datos");
			}
		}
	}

	if(isset($_POST['modificacion'])){
		if(validarDatos($_POST)){
			$persona->setExclude('modificacion');
			if($datos=$persona->Update($_POST)>0)
				$mensaje="Datos modificados";
		}
	}

	if(isset($_POST['consulta'])){
		$persona->setExclude('consulta');
		$datos=$persona->FindById($_POST['consulta']);
		cargaDatos($datos);
	}


	if(isset($_POST['baja'])){
		try{
			$persona->setPrimaryKey('idpersona');	
			$persona->Destroy($_POST['idpersona']);
			} catch(Exception $e){
			if($e->getCode()==23000)
				array_push($errores,"Esta persona no se puede borrar de la base de datos. \nTiene cuentas asociadas");
				cargaDatos($_POST);
		}
	}

	function validarDatos($datos){
		global $errores;
		global $nif;
		global $nombre;
		global $apellidos;
		global $direccion;
		global $email;
		global $idpersona;
		
		$idpersona=$datos["idpersona"];
		$nif=$datos["nif"];
		if(!isset($nif) || isEmpty($nif)){
			array_push($errores,"El nif es requerido.");
		}
		$nombre=$datos["nombre"];
		if(!isset($nombre) ||isEmpty($datos["nombre"])){
			array_push($errores,"El nombre es requerido");
		}
		$apellidos=$datos["apellidos"];
		if(!isset($apellidos) || isEmpty($apellidos)){
			array_push($errores,"Los apellidos son requeridos");
		}
		$direccion=$datos["direccion"];
		if(!isset($direccion) || isEmpty($direccion)){
			array_push($errores,"La dirección es requerida");
		}
		$email=$datos["email"];
		if(!isset($email) || !validateEmail($email)){
			array_push($errores,"El email debe tener un formato valido");
		}
		
		error_reporting(E_ALL ^ E_NOTICE);
		if(count($errores)>0)
			return false;
		else
			return true;
	}

	function cargaDatos($datos){
		global $idpersona;
		global $nif;
		global $idpersona;
		global $nombre;
		global $apellidos;
		global $direccion;
		global $telefono;
		global $email;

		$idpersona=$datos['idpersona'];
		$nif=$datos['nif'];
		$nombre=$datos['nombre'];
		$apellidos=$datos['apellidos'];
		$direccion=$datos['direccion'];
		$telefono=$datos['telefono'];
		$email=$datos['email'];
	}
?>

<html>
<head>
	<title>Banco</title>
	<meta charset='UTF-8'>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/App.css">
</head>
<body>
	<div class='container py-3'>
		<div class="card col-lg-12 mx-auto py-3 px-3">
		<form id='formulario' method='post' action='#'>
			<input type='hidden' 
			value='<?=$idpersona?>'
			id='idpersona' name='idpersona'>
			<div class="row mb-3">
			    <label for="nif" class="col-sm-2 col-form-label">NIF</label>
			    <div class="col-sm-10">
			      <input type="text" 
				  value='<?=$nif?>'
				  class="form-control" id="nif" name='nif'>
			    </div>
			</div>
			<div class="row mb-3">
			    <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
			    <div class="col-sm-10">
			      <input type="text" 
				  value='<?=$nombre?>'
				  class="form-control" id="nombre" name="nombre">
			    </div>
			</div>
			<div class="row mb-3">
			    <label for="apellidos" class="col-sm-2 col-form-label">Apellidos</label>
			    <div class="col-sm-10">
			      <input type="text" 
				  value='<?=$apellidos?>' 
				  class="form-control" id="apellidos" name="apellidos">
			    </div>
			</div>
			<div class="row mb-3">
			    <label for="direccion" class="col-sm-2 col-form-label">Dirección</label>
			    <div class="col-sm-10">
			      <input type="text" 
				  value='<?=$direccion?>'
				  class="form-control" id="direccion" name="direccion">
			    </div>
			</div>
			<div class="row mb-3">
			    <label for="telefono" class="col-sm-2 col-form-label">Teléfono</label>
			    <div class="col-sm-10">
			      <input type="text" 
				  value='<?=$telefono?>'
				  class="form-control" id="telefono" name="telefono">
			    </div>
			</div>
			<div class="row mb-3">
			    <label for="email" class="col-sm-2 col-form-label">Email</label>
			    <div class="col-sm-10">
			      
				<input type="email" 
					value='<?=$email?>'
				  class="form-control" id="email" name="email">
			    </div>
			</div>
			<label class="col-sm-2 col-form-label"></label>
			<button type="submit" class="btn btn-success" id='alta' name='alta'>Alta</button>
			<button type="submit" class="btn btn-warning" id='modificacion' name='modificacion'>Modificación</button>
			<button type="submit" class="btn btn-danger" id='baja' name='baja'>Baja</button>
			<button type="reset" class="btn btn-success">Limpiar</button>
			<label class="col-sm-2 col-form-label"></label>
			<p class='mensajes'>
				<?=$mensaje?>
				<?=showErrors($errores)?>
			</p>
		</form><br><br>
	</div>
		<table id='listapersonas' class="table table-striped mt-3">
		<tr>
			<th>Nif</th>
			<th>Nombre</th>
			<th>Apellidos</th>
		</tr>
	
		<?php 
	  $personas=$persona->FindAll();
	  foreach($personas as $row) {
		echo "<tr data-id=$row[idpersona]>";
		echo "<td>$row[nif]</td>";
		echo "<td>$row[nombre]</td>";
		echo "<td>$row[apellidos]</td>";
		echo "</tr>";
	  }
	  ?>
		</table>
	</div>
	<form id='formconsulta' method='post' action='#'>
		<input type='hidden' id='consulta' name='consulta'>
	</form>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script type="text/javascript" src='scripts/script.js'></script>
</body>
</html>