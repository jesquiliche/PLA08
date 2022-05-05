<?php

final class MyPersonaDAO extends BaseDao{
    
    function __construct()
    {
        parent::setOrderBy("nombre,apellidos ASC");
        parent::setTable("personas");
        parent::setPrimaryKey("idpersona");
    }

    //Comprobar si ya existe el nif
    public function FindByNif(string $nif):int {
        $this->con=DBConnection::connect();
        $sql="SELECT * FROM ".$this->table. " WHERE nif=?";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(array($nif));
        return $stmt->rowCount();
    }

    public function IsModifiedRecord(int $id,$datosOrigin,&$nif):bool{
        $this->con=DBConnection::connect();
        $sql="SELECT * FROM ".$this->table. " WHERE ".$this->primaryKey."=?";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(array($id));
        $datos=$stmt->fetch(PDO::FETCH_ASSOC);
        $nif=null;
        foreach($datos as $key=>$valor){
            if($key!==$this->exclude && $key!=="timestamp"){
             //   $valor= filter_var($valor,FILTER_SANITIZE_ADD_SLASHES);
                if($valor!=$datosOrigin[$key]){
                    if($datos['nif']!=$datosOrigin['nif']) $nif2=$datos['nif'];
                    return true;
                }
            }
        }
        return false;
    }
}