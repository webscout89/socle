<?php

class Connection{
    private $db_name;
    private $db_host;
    private $db_port;
    private $db_user;
    private $db_pass;
    private $pdo;

    public function __construct($db_host = 'localhost', $db_port = 3308, $db_name = 'socle',  $db_user = 'root', $db_pass = '')
    {
        $this->db_name = $db_name;
        $this->db_host = $db_host;
        $this->db_port = $db_port;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
    }

    private function getPDO(){
        if($this->pdo === null){
            try{
                $pdo = new PDO("mysql:dbname=$this->db_name;host=$this->db_host;port=$this->db_port" , $this->db_user, $this->db_pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                $pdo->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
                $pdo->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
            }catch(PDOException $e) {
                $error = $e->getMessage();
            }

            if(isset($error)){
                $msg = 'Echec de la connexion: ' . $error;
                //à reporter l'érreur dans les fichier log
                //à rediriger aussi le message dans une page dédier
                echo $msg ;
                die;
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



class Model{
    const DB_HOST = 'localhost';
    const DB_PORT = 3308;
    const DB_NAME = 'socle';
    const DB_USER = 'root';
    const DB_PASS = '';  

    private static $base;

    public static function getConnetion(){
        if(!self::$base){
        self::$base = new Connection(self::DB_HOST, self::DB_PORT, self::DB_NAME, self::DB_USER, self::DB_PASS);
        return self::$base;
    }
    return self::$base;
    }
}

// var_dump(Model::getConnetion()->prepare('select * from country'));

?>