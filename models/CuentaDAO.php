<?php 
require_once "./database/conexion.php";
require_once "./models/ICrudDAO.php";

final class CuentaDao implements ICrudDAO{
    private $con;
    private $table="cuentas";

    //Recibimos un array asociativo con los nombres de los camps
    //y sus respectivos valores
    public function Create($obj){
        $this->con=DBConnection::connect();
        $sqlInsert="INSERT INTO $this->table(";
        $sqlValues=" VALUES(";
    
        //Leer lista de campos del Array
        foreach($obj as $key=>$valor){
        
                $sqlInsert.="$key,";
                $valor=$obj[$key];
                $tipo=gettype($valor);
                            
                //Construir el values a partir del tipo de dato
                //Si es string lo encerrara entre comillas simples
                switch($tipo){
                    case "string";
                        $valor= filter_var($valor, FILTER_SANITIZE_ADD_SLASHES);
                        $sqlValues.="'$valor',";
                        break;
                    case "integer";
                        $valor=(int)$valor;
                        $sqlValues.="$valor,";
                        break;
                    case "double";
                        $valor=floatval($valor);
                        $sqlValues.="$valor,";
                        break;
                    default;
                        $sqlValues.="'$valor',";
                        break;      
                 }
                
        }
        //Quitar última coma de las cadenas y cerrarlas con parentesis
        $sqlInsert=substr($sqlInsert, 0, -1).") \n";
        $sqlValues=substr($sqlValues, 0, -1).") ";
        $this->con->exec($sqlInsert.$sqlValues);
        
        print $sqlInsert;
        print $sqlValues."\n";
        
       // print_r($obj);
        
    }

    public function Update($obj,$idKey){
        $this->con=DBConnection::connect();
        $sqlUpdate="UPDATE $this->table SET ";
        $sqlValues=" VALUES(";
        
    
        //Leer lista de campos del Array
        foreach($obj as $key=>$valor){
        
                
                 
                $valor=$obj[$key];
                $tipo=gettype($valor);
                
                //Si no es el campo clave actualizar
                if($key!=$idKey){
                    //Construir el values a partir del tipo de dato
                    //Si es string lo encerrara entre comillas simples
                    $sqlUpdate.="$key";
                    switch($tipo){
                        case "string";
                            $valor= filter_var($valor, FILTER_SANITIZE_ADD_SLASHES);
                            $sqlUpdate.="='$valor', ";
                            break;
                        case "integer";
                            $valor=(int)$valor;
                            $sqlUpdate.="=$valor, ";;
                            break;
                        case "double";
                            $valor=floatval($valor);
                            $sqlUpdate.="=$valor, ";                        
                            break;
                        default;
                            $sqlUpdate.="=$valor, ";
                            break;      
                    }
                }
                
        }
        $sqlUpdate=substr($sqlUpdate, 0, -2);
        $sqlUpdate.= " WHERE $idKey=$obj[$idKey]";
        $this->con->exec($sqlUpdate);
        print $sqlUpdate;
    }

    public function FindAll():array{
        $this->con=DBConnection::connect();
        $stmt = $this->con->query("SELECT * FROM $this->table");
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function FindById($id):array{
        $this->con=DBConnection::connect();
    
        $stmt=$this->con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $stmt = $this->con->prepare("SELECT * FROM $this->table WHERE idcuenta = ?");
        $stmt->execute(array($id));
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      
    }

    public function Destroy($id){
        $this->con=DBConnection::connect();
        echo "Destroy <br/>";
    }
    
    


}
