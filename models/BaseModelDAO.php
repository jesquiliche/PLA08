<?php 
require_once "./database/conexion.php";
require_once "./models/ICrudDAO.php";

abstract class BaseDao implements ICrudDAO{
    private $con;
    protected $table="";
    protected $primaryKey;

    public function setTable(string $table){
        $this->table=$table;
    }

    public function getTable(string $table):string {
        return $this->table=$table;
    }
    
    public function setPrimaryKey(string $primaryKey){
        $this->primaryKey=$primaryKey;
    }

    public function getPrimaryKey():string{
        return $this->primaryKey;
    }
   


    //Recibimos un array asociativo con los nombres de los camps
    //y sus respectivos valores
    public function Create($obj){
        try {
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
           

        } catch(Exception $e){
            $this->con=null;
            throw new Exception($e->getMessage(), 1);
                       
        }
        
    }

    public function Update($obj){
        try{
                $this->con=DBConnection::connect();
            $sqlUpdate="UPDATE $this->table SET ";
            $sqlValues=" VALUES(";
            
        
            //Leer lista de campos del Array
            foreach($obj as $key=>$valor){
            
                    
                    
                    $valor=$obj[$key];
                    $tipo=gettype($valor);
                    
                    //Si no es el campo clave actualizar
                    if($key!=$this->primaryKey){
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
            $sqlUpdate.= " WHERE $this->primaryKey=".$obj[$this->primaryKey];
            $this->con->exec($sqlUpdate);
            print $sqlUpdate;
        }catch(Exception $e){
            $this->con=null;
            throw new Exception($e->getMessage(), 1);
        }
        
       
    }

    public function FindAll():array{
        $this->con=DBConnection::connect();
        $stmt = $this->con->query("SELECT * FROM ".$this->table);
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function FindById($id):array{
        $this->con=DBConnection::connect();
    
        $stmt=$this->con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $stmt = $this->con->prepare("SELECT * FROM $this->table WHERE $this->primaryKey = ?");
        $stmt->execute(array($id));
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      
    }

    public function Destroy($id){
        $this->con=DBConnection::connect();
        $stmt = $this->con->query("DELETE FROM $this->table WHERE $this->primaryKey=$id");
    }
    
    


}
