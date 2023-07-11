<?php
class Strink{
    //le nombre doit étre compris entre $min et $max
    public static function validNumber($number, $min, $max){
        if(is_numeric($number) and ($number >= $min and $number <= $max)){
            return true;
        }else{
            return false;
        }
    }
//la chaine doit etre comprise entre $min et $max caractères et exclure les caractères du tableau;
    public static function validString($string, $min, $max){
        $tring = trim($string);
        $length = strlen($string);
        $tbstring = str_split($string);
        $nb = count($tbstring);
        $excluded = array('\\', '\'', '"', ',', '?', '*', '(', ')', '{', '}', '%', ';', 'µ', '[', ']', '#', '-', '_', '!', ':', ';', '@', '%', '$', '+', '.', '<', '>');
        
        if($length >= $min and $length <= $max){
            
        for ($i = 0; $i <= $nb; $i++) {
            if (@in_array($tbstring[$i], $excluded)) {
                $test = false;
                break;
            } 
                
        }

        if(isset($test) and $test == false){
            return false;
        }else{
            return true;
        }
        }else{
            return false;
        }
       
    }


    public static function Hash($password){
        $hash = password_hash($password, PASSWORD_BCRYPT);
        return $hash;

    }

    public static function Verify($password, $hash){
        if(password_verify($password, $hash)){
            return true;
        }else{
            return false;
        }

    }


    public static function Upper($string){
        return strtoupper($string);
       
    }
    
}




?>

