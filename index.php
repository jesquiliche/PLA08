<?php

    //require_once "./database/conexion.php";
    require_once "./models/CuentaDAO.php";

    $conexion=DBConnection::connect();
    $cuenta=new CuentaDao();

    $obj=[
            "entidad" => "0001",
            "oficina" => "0201",
            "dc" => "10",
            "cuenta" => "020012000",
            "saldo" => 45000.00,
            "idpersona" => 80
    ];
    $cuenta->Create($obj);
    //$cuenta->Update($obj);
    //print_r($cuenta->FindAll());
    //print_r($cuenta->FindById(5));
    //$cuenta->Update();


