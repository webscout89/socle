<?php

class Session{

    public static function ensureStarted(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
    }

    public static function get(string $key, $default = null){
        self::ensureStarted();
        if(array_key_exists($key, $_SESSION)){
            return $_SESSION[$key];
        }
        return $default; 
    }
    
    public static function set(string $key, $value): void{
        self::ensureStarted();
        $_SESSION[$key] = $value;
    }

    public static function deleteKey(string $key):void{
        self::ensureStarted();
        unset($_SESSION[$key]);
    }

    public static function delete(){
        if(session_status() === PHP_SESSION_NONE){
            unset($_SESSION);
        }
    }
}