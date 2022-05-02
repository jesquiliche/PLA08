<?php

    //require_once "./database/conexion.php";
    require_once "./models/CuentaDAO.php";

    $conexion=DBConnection::connect();
    $cuenta=new CuentaDao();

    $obj=[
            "idcuenta"=>3,
            "entidad" => "0001",
            "oficina" => "0201",
            "dc" => "10",
            "cuenta" => "02001203010",
            "saldo" => 99999.00,
            "idpersona" => 80
    ];
    //$cuenta->Create($obj);
    $cuenta->Update($obj,"idcuenta");
    //print_r($cuenta->FindAll());
    //print_r($cuenta->FindById(5));
    //$cuenta->Update();


