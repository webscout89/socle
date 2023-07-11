<?php

class DataBase{
    private $name;
    private $host;
    private $port;
    private $user;
    private $password;
    private $pdo;

    public function __construct(string $host = 'localhost', int $port = 3308, string $name = 'katniss',  string $user = 'root', string $password = '')
    {
        $this->db_name = $name;
        $this->db_host = $host;
        $this->db_port = $port;
        $this->db_user = $user;
        $this->db_pass = $password;
    }

    private function getPDO(){
        if($this->pdo === null){
            try{
                $pdo = new PDO("mysql:dbname=$this->db_name;host=$this->db_host;port=$this->db_port" , $this->db_user, $this->db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //$pdo->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
            }catch(PDOException $e) {
                $error = $e->getMessage();
            }

            if(isset($error)){
                //repport de l'érreur $error dans les log
                die('Echec de la connexion: ' . $error);
             }else{
                $this->pdo = $pdo;
             }           
        }       
        return $this->pdo;
    }

    public function prepare($statement){
        $data = $this->getPDO()->prepare($statement);
        return $data;
    }

    public function lastInsertId(){
        $data = $this->getPDO()->lastInsertId();
        return $data;
    }
}



class Base{
    const HOST = 'localhost';
    const PORT = 3308;
    const NAME = 'katniss';
    const USER = 'root';
    const PASSWORD = '';  

    private static $base;

    public static function getCon(){
        if(self::$base === null){
        self::$base = new DataBase(self::HOST, self::PORT, self::NAME, self::USER, self::PASSWORD);
        return self::$base;
    }
    return self::$base;
    }
}

//var_dump(Base::getCon());

?>