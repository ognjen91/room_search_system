<?php


    
    
class Connection {
    
    public $connection;
    const USER = "root";
    const PASS = "";
    const DB = "pocetna";
    const HOST = "localhost";
    
    public function __construct(){
        $this->connect_to_db();
    }
    
    protected function connect_to_db(){
        
     try{$this->connection = mysqli_connect(self::HOST, self::USER, self::PASS, self::DB);
         if (!$this->connection){
           throw new Exception('<h3>Nije moguce uspostaviti konekciju</h3>');  
           
           }
       } catch (Exception $e){
            echo "<h1>Greska!</h1> " . $e->getMessage();
        }
    } 
    
    
   
    
}












?>