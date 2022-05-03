<?php

final class MyPersonaDAO extends BaseDao{
    
    function __construct()
    {
        parent::setOrderBy("nif ASC");
        parent::setTable("personas");
        parent::setPrimaryKey("idpersona");
    }
}