<?php


class Db_object extends Sql{
    
    
    //kod select query-a, vraca array sa objektima
    public static function get_queries_object_array($query){
        $result_set = static::query_to_db($query);
        $result_array = array();
        while ($row = mysqli_fetch_assoc($result_set)){
           $result_array[] = static::instantiation($row);

        }

        return $result_array;
        
    }
    

      //vraca objekat napravljen od dijela resuts set-a
    protected static function instantiation($the_record){
        
        $calling_class = get_called_class();
        $the_object = new $calling_class;

        foreach($the_record as $key=>$value){
          if (static::object_has_property($the_object, $key)){
              $the_object->$key = $value;
         }
         
        }

        return $the_object;
        
        
    }
    
    //provjerava da li objekat sadrzi property
    protected static function object_has_property($object, $property){
       $properties_of_current_object = get_object_vars($object);
        return array_key_exists($property, $properties_of_current_object);

    }
    

    
//    -------DRUGE FJE--------
    //FIND FUNKCIJA ZA VISE REZULTATA
    //vraca array sa objektima koji zadovoljavaju uslove 
      protected static function find_all_no_cond(){
          $query = "SELECT * FROM " . static::$db_table;
          
//          var_dump($query);
          $resultArray = static:: get_queries_object_array($query);
          return $resultArray;
      }
    
    
    
    //FIND FUNKCIJA ZA VISE REZULTATA
    //vraca array sa objektima koji zadovoljavaju uslove 
      protected static function find_all($conditionString){
          $query = "SELECT * FROM " . static::$db_table;
          $query .= " WHERE " . $conditionString;
//          var_dump($query);
          $resultArray = static:: get_queries_object_array($query);
          return $resultArray;
      }  
    
    //FIND FUNKCIJA kod koje pisem cijeli uslov
      protected static function find_all_full_query($query){
        
//          var_dump($query);
          $resultArray = static:: get_queries_object_array($query);
          return $resultArray;
      } 
    
    //FIND FUNKCIJA ZA JEDAN REZULTAT
    //vraca objekat
     protected static function find_specific($conditionString){
          $query = "SELECT * FROM " . static::$db_table;
          $query .= " WHERE " . $conditionString;
          $resultArray = static:: get_queries_object_array($query);
          
          return array_shift($resultArray);
      }
    
      //FIND FUNKCIJA ZA JEDAN REZULTAT
    //vraca objekat
     protected static function find_specific_full_query($query){
           $resultArray = static::get_queries_object_array($query);
          
          return array_shift($resultArray);
      }
    
    
    //PROVJERA DA LI SE UNOS NALAZI U BAZI
    //staticna metoda za provjeru da li unos vec postoji u bazi
    //ulazna vrijednost je uslov, npr "user='Neko'";
    protected static function if_already_exists($db_table, $conditionString){
        $query = "SELECT * FROM " . $db_table . " WHERE " . $conditionString; 
        $result = (new self)->get_queries_object_array($query);
        return !empty($result);
//        return $query;
    }
        
    
    
  //NIZ U OBJECT PROPS
     //za proizvoljan niz provjerava da li su keyevi propsi objekta i ako jesu, dodjeljuje vrijednosti ualue-a objektu.
    public static function array_vars_to_obj_props($input_array, $object){
        foreach ($input_array as $key=>$value){
            if (static::object_has_property($object, $key)){
                $object->$key = $value;
        }
    }
    
    }
    
    //VRIJEDNOSTI DB TABLE FIELDS 
      //vraca array sa vrijendostima db_table_fields, tj vrijednostima object propsa koji su u nizu db_table_fields
    protected function object_props(){
        $properties = array();
        foreach (static::$db_table_fields as $table_field){
            if (property_exists($this, $table_field)){
                $properties[$table_field] = $this->$table_field;
            }
        }
        
        return $properties;
    }
    
    
    
    
    

    
}










?>