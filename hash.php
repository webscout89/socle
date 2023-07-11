<?php
class Hash{
    public static function make(string $string){
        if(password_hash($string, PASSWORD_BCRYPT) === false){
            return false;
        }else{
            return password_hash($string, PASSWORD_BCRYPT);
        }
    }

    public static function verify($string, $hash){
        if(password_verify($string, $hash)){
            return true;
        }else{
            return false;
        }
    }
}


