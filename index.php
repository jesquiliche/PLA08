<?php

	require_once "./models/BaseModelDAO.php";
	require_once "./models/MyPersonaDAO.php";
	require_once "./utils/utils.php";
	require_once "./funciones/funciones.php";
	//inicializar variables

	$idpersona="";
	$nif="";
	$nombre="";
	$apellidos="";
	$direccion="";
	$telefono="";
	$email="";
	$mensaje="";
	$errores=array();

	function limpiar(){
		global $idpersona;
		global $nif;
		global $nombre;
		global $apellidos;
		global $direccion;
		global $telefono;
		global $email;
		global $mensaje;
		global $errores;
		
		$idpersona="";
		$nif="";
		$nombre="";
		$apellidos="";
		$direccion="";
		$telefono="";
		$email="";
		$mensaje="";
		$errores=array();
	
	}
	
	
	//Construimos el objeto de acceso a datos
	//Patrón de diseño DAO
	$persona=new MyPersonaDAO();

	if(isset($_POST['alta'])){
		alta();
	}

	if(isset($_POST['modificacion'])){
		modificacion();
	}

	if(isset($_POST['consulta'])){
		consulta();
	}

	if(isset($_POST['baja'])){
		baja();
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
			    <label for="nif" 
					class="col-sm-2 col-form-label"
					>NIF</label>
			    <div class="col-sm-10">
			      <input type="text"
				  maxlength="9" 
				  value='<?=$nif?>'
				  required
				  class="form-control" id="nif" name='nif'>
			    </div>
			</div>
			<div class="row mb-3">
			    <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
			    <div class="col-sm-10">
			      <input type="text" 
				  value='<?=$nombre?>'
				  maxlength="40"
				  required
				  class="form-control" id="nombre" name="nombre">
			    </div>
			</div>
			<div class="row mb-3">
			    <label for="apellidos" class="col-sm-2 col-form-label">Apellidos</label>
			    <div class="col-sm-10">
			      <input type="text" 
				  value='<?=$apellidos?>'
				  maxlength="80"
				  required 
				  class="form-control" id="apellidos" name="apellidos">
			    </div>
			</div>
			<div class="row mb-3">
			    <label for="direccion" class="col-sm-2 col-form-label">Dirección</label>
			    <div class="col-sm-10">
			      <input type="text" 
				  value='<?=$direccion?>'
				  maxlength="120"
				  required
				  class="form-control" id="direccion" name="direccion">
			    </div>
			</div>
			<div class="row mb-3">
			    <label for="telefono" class="col-sm-2 col-form-label">Teléfono</label>
			    <div class="col-sm-10">
			      <input type="text" 
				  maxlength="9"
				  value='<?=$telefono?>'
				  class="form-control" id="telefono" name="telefono">
			    </div>
			</div>
			<div class="row mb-3">
			    <label for="email" class="col-sm-2 col-form-label">Email</label>
			    <div class="col-sm-10">
			      
				<input type="email"
					maxlength="80" 
					value='<?=$email?>'
					required
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
	  if(count($personas)>0){
		foreach($personas as $row) {
			echo "<tr data-id=$row[idpersona]>";
			echo "<td>$row[nif]</td>";
			echo "<td>$row[nombre]</td>";
			echo "<td>$row[apellidos]</td>";
			echo "</tr>";
		  }
		} else {
			
			$mensaje="No hay datos";
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