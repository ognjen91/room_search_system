<?php


class Sql {

    //sljedeci edit counter je uveden zbog slucaja update-a kada updatujem vise podataka (slika) kroz petlju i tada affected rows vraca 0
    private $edit_counter = 0; 
    
    
    
//    ---------OSNOVNI QUERY METHOD-----------
    //vraca set rezultata iz baze
    protected function query_to_db($query){
        global $connection;
        try {
             $result_set = mysqli_query($connection->connection, $query);
             if (!$result_set){
                 throw new Exception("Problem sa egzekucijom query-a");
             }
        } catch (Exception $e){
            echo "Greska! " . $e->getMessage();
        }
       
        return $result_set;
        
    }
    
    
    
//    -----CREATE QUERY-----------
    //ulazni podaci su ime tabele i array-a iz kojeg ubacujemo podatke
        public function create($table, $array_for_insert){
       $query = "INSERT INTO " . static::$db_table . " (" . implode(", ", array_keys($array_for_insert)) . ") ";
       $query .= "VALUES ('". implode("','", array_values($array_for_insert)) ."')";
//        var_dump($query);
        try {
            $result = $this->query_to_db($query);
            if (!$result){
                throw new Exception ("Problem sa kreiranjem novog unosa u bazu.");
            }
        } catch (Exception $e){
            die ("Greska! " . $e->getMessage());
        }
       
        return $result? true : false;
//        return $query;

   }
    
    
    
    
    
    
//    -----------UPDATE & DELETE QUERY---------
    //za update i delete jer provjerava affected rows
    //vraca affected rows (=number)
      protected function update_query_to_db($query){
        global $connection;
        try {
             $result_set = mysqli_query($connection->connection, $query);
             $this->edit_counter ++;
             $affected_rows = mysqli_affected_rows($connection->connection);
             if($affected_rows == -1){ 
                 throw new Exception("Problem sa egzekucijom UPDATE query-a");
             }
        } catch (Exception $e){
            echo "Greska! " . $e->getMessage();
        }
       
          
//          var_dump($affected_rows);
        return ($affected_rows && $this->edit_counter)? true : false;
        
    }
    
    
    
    
//    -----ESCAPE-OVANJE PODATAKA-----------
    
    //za escapeovanje stringa
    public function escape_string($string){
        global $connection;
        
        $escaped = mysqli_real_escape_string ($connection->connection, $string);
        
        return $escaped;
    }
    
    //escapeovanje arraya
    public function escape_array($array){
        global $connection;
        $escaped = array();
        
        foreach($array as $string){
            $escaped[] = mysqli_real_escape_string ($connection->connection, $string);
        }
        
        return $array;
    }
    
    
 
    
    
    
    
        
    
    

    
    
}
?>