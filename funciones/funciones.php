<?php 
require_once "./models/MyPersonaDAO.php";

function alta(){
    $persona=new MyPersonaDao();
    global $mensaje;
    global $errores;
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
	
function modificacion(){
    $persona=new MyPersonaDAO();
    global $mensaje;
    global $errores;
    try {
        if(!is_null($_POST['idpersona']) && $_POST['idpersona']!="")
        { 
            if(validarDatos($_POST)){
                $modificaciones=$persona->IsModifiedRecord($_POST['idpersona'],$_POST,$nif2);
                if(!$modificaciones){
                    $mensaje="persona no modificada";
                } else {
                    $persona->setExclude('modificacion');
                    if($datos=$persona->Update($_POST)>0)
                        $mensaje="Datos modificados";
                    else
                        $mensaje="Esta persona ya no se encuentra en la BB.DD";
                    limpiar();
                    $mensaje="Datos de la persona modificados";
                } 
            } 
        } else {
            $mensaje="Se debe seleccionar una persona valida.";
        }
    } catch(Exception $e){
        if($e->getCode()==23000)
        array_push($errores,"El nif ya existe en la Base de datos");
    }
}

function consulta(){
    $persona=new MyPersonaDAO();
    $persona->setExclude('consulta');
    $datos=$persona->FindById($_POST['consulta']);
    cargaDatos($datos);
}

function baja(){
    $persona=new MyPersonaDAO();
    global $mensaje;
    global $errores;
    try{
        if(!is_null($_POST['idpersona']) && $_POST['idpersona']!="")
        {
            $persona->setPrimaryKey('idpersona');	
            if($persona->Destroy($_POST['idpersona'])>0)
                $mensaje="Persona dada de baja";
            else
                $mensaje="Esta persona ya no se encuentre en la BB.DD";
        } else {
            $mensaje="Se debe seleccionar una persona valida.";
        }
        
    } catch(Exception $e){
        if($e->getCode()==23000)
            array_push($errores,"Esta persona no se puede borrar de la base de datos. \nTiene cuentas asociadas");
            cargaDatos($_POST);
    }
}

