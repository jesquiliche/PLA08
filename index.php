<?php
    require_once "./models/BaseModelDAO.php";
    require_once "./models/MyCuentaDA0.php";

    $cuenta=new MyCuentaDAO();

    $cuenta->setTable("cuentas");
    $cuenta->setPrimaryKey("idcuenta");
    $obj=[
            "idcuenta"=>3,
            "entidad" => "0002",
            "oficina" => "0202",
            "dc" => "10",
            "cuenta" => "02001203300",
            "saldo" => 99999.00,
            "idpersona" => 80
    ];
    
    $cuenta->Update($obj,"idcuenta");
    $cuenta->Destroy(10,"idcuenta");
    $obj=[
        
        "entidad" => "0001",
        "oficina" => "0202",
        "dc" => "10",
        "cuenta" => "02001350",
        "saldo" => 99999.00,
        "idpersona" => 80
        ];

    $cuenta->Create($obj);
    print_r($cuenta->FindAll());

    print_r($cuenta->FindById(5));
    $persona=new MyCuentaDAO();
    $persona->setTable("personas");
    print_r($persona->FindAll());

    //$cuenta->Update();


