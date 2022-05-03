<?php 

final class MyCuentaDAO extends BaseDao{

    function __construct()
    {
        
        parent::setTable("cuentas");
        parent::setPrimaryKey("idcuenta");
    }

}