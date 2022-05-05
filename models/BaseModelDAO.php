<?php 
require_once "./database/conexionSingleton.php";
require_once "./models/ICrudDAO.php";

abstract class BaseDao implements ICrudDAO{
    private $con;
    protected string $table="";
    protected string $primaryKey;
    protected string $orderBy="";
    protected string $exclude="";

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

    public function setOrderBy(string $orderBy){
        $this->orderBy=$orderBy;
    }
   
    public function getOrdeBy():string{ 
        return $this->orderBy;
    }

    public function setExclude(string $exclude){ 
        $this->exclude=$exclude;
    }


    //Recibimos un array asociativo con los nombres de los camps
    //y sus respectivos valores
    public function Create($obj):int{
        try {
            $this->con=DBConnection::connect();
            $sqlInsert="INSERT INTO $this->table(";
            $sqlValues=" VALUES(";
            
            $valores=array();
            //Leer lista de campos del Array
            foreach($obj as $key=>$valor){
                if($key!==$this->exclude){
                    $valor= filter_var($valor,FILTER_SANITIZE_ADD_SLASHES);
                    $sqlInsert.="$key,";
                    $valores[]=$valor;
                    $sqlValues.="?,";
                }
            }
            //Quitar última coma de las cadenas y cerrarlas con parentesis
         
            $sqlInsert=substr($sqlInsert, 0, -1).") \n";
            $sqlValues=substr($sqlValues, 0, -1).") ";
            $smt=$this->con->prepare($sqlInsert.$sqlValues);
            $smt->execute($valores);
            return $smt->rowCount();
         
        } catch(Exception $e){
            $this->con=null;
            throw new Exception($e->getMessage(),$e->getCode());           
        }
        
    }

    public function Update($obj):int{
        try{
            $this->con=DBConnection::connect();
            $sqlUpdate="UPDATE $this->table SET ";
            
            $valores=array();
        
            //Leer lista de campos del Array
            
                foreach($obj as $key=>$valor){
                    if($key!==$this->exclude){        
                    $valor=$obj[$key];
                    $valor= filter_var($valor, FILTER_SANITIZE_ADD_SLASHES);
                
                    
                    //Si no es el campo clave actualizar
                    if($key!=$this->primaryKey){
                        //Construir el values a partir del tipo de dato
                        //Si es string lo encerrara entre comillas simples
                        $sqlUpdate.="$key=";
                        $valores[]=$valor;
                        $sqlUpdate.="?,"; 
                    }
                }   
            }
            $sqlUpdate=substr($sqlUpdate, 0, -1);
            $sqlUpdate.= " WHERE $this->primaryKey=".$obj[$this->primaryKey];
            
            $stmt=$this->con->prepare($sqlUpdate);
            return $stmt->execute($valores);

        }catch(Exception $e){
            $this->con=null;
            throw new Exception($e->getMessage(), 23000);
        }
    }

    public function FindAll():array{
        $this->con=DBConnection::connect();
        $sql="SELECT * FROM ".$this->table;
        if($this->orderBy!==""){
            $sql.=" ORDER BY ".$this->orderBy;
        }
        $stmt = $this->con->query($sql);
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function FindById($id):array{
        $this->con=DBConnection::connect();
    
        $stmt=$this->con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $stmt = $this->con->prepare("SELECT * FROM $this->table WHERE $this->primaryKey = ?");
        $stmt->execute(array($id));
    
        return $stmt->fetch();
    }

    public function Destroy($id):int{
        $this->con=DBConnection::connect();
        $stmt = $this->con->prepare("DELETE FROM $this->table WHERE $this->primaryKey=$id");
        return $stmt->execute();
    }
}
