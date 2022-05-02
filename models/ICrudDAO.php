<?php

interface ICrudDAO {


    public function Create(array $obj);
   

    public function Update(array $obj);
    

    public function FindAll():array; 
    public function FindById(string $id):array;

    public function Destroy(int $id);
   
    
    


}
