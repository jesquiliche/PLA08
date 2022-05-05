<?php

//Función que valida el Email develovera True o false, dependiendo si el valor
// es correcto o no
function validateEmail($email)
{
    $valor= filter_var($email, FILTER_SANITIZE_ADD_SLASHES);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    
        return true;
    } else {
        return false;
    }
}

//Función para determinar si el valor es nulo o esta vacio.
function isEmpty($valor)
{
    if (empty(trim($valor)) || $valor == "") {
        return true;
    }

    return false;
}

//Funcion para deterninar si $value esta comprendio en un determinado rango
// de valores.
function isNumber($value, $minValue, $maxValue)
{
    $value = floatval($value);
    if ($value > $maxValue || $value < $minValue) {
        echo "${value} no esta comprendido entre ${minValue} y ${maxValue}";
    } else {
        echo null;
    }

}

//Muestre un Array de errores en un DIV dentro del formulario
function showErrors(&$errores)
{

    try {
        // Solo dibujar el Div si existen errores
        if (count($errores) > 0) {
            echo "<div class='card col-lg-10 mx-auto py-3 mt-2'>";
            echo "  <div class='card-title mx-auto'>";
            echo "      <b><b>Errores de validación</b>";
            echo "  </div>";
            for ($x = 0; $x < count($errores); $x++) {
                echo "      <div>";
                echo "          <i class='fa fa-times-circle px-2' style='color: red' ></i> " . $errores[$x] . "<br>";
                echo "      </div>";
            }
            echo "</div>";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
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
    global $telefono;
    
    $idpersona=$datos["idpersona"];
    $telefono=$datos["telefono"];
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







