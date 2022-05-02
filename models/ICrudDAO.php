<?php

interface ICrudDAO {


    public function Create(array $obj);
   

    public function Update(array $obj,string $keyID);
    

    public function FindAll():array; 
    public function FindById($id):array;

    public function Destroy($id);
   
    
    


}
