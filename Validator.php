<?php
require_once('Model.php');
class Validator{   
    private $params;
    private $errors = [];
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function required(string ...$keys): self{
        foreach($keys as $key){
            if(!array_key_exists($key, $this->params)){
                $this->errors[$key] = "le champ $key est requis";
            }
        }
        return $this;
    }

    public function integer($key, int $min, int $max, int $required, string $message): self{
        $options = ["options" => ["min_range" => $min , "max_range"=> $max]];
        if($required == 0 and strlen($this->params[$key]) == 0){
        return $this;
        }elseif(!filter_var($this->params[$key], FILTER_VALIDATE_INT, $options)) {
        $this->errors[$key] = $message;
        }
        return $this;
    }

    public function float($key, int $min, int $max, int $required, string $message):self{
        $options = ["options" => ["min_range" => $min , "max_range"=> $max]];
        if($required == 0 and strlen($this->params[$key]) == 0){
            return $this;
            }elseif(!filter_var($this->params[$key], FILTER_VALIDATE_FLOAT, $options)) {
            $this->errors[$key] = $message;
            }
        return $this;
    }

    public function ip($key, int $required, string $message):self{
       
        if(strlen($required == 0 and $this->params[$key]) == 0){
            return $this;
        }elseif (!filter_var($this->params[$key], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $this->errors[$key] = $message;
          }
        return $this;
    }

    public function mac($key, int $required, string $message):self{
        if($required == 0 and strlen($this->params[$key]) == 0){
            return $this;
        }elseif (!filter_var($this->params[$key], FILTER_VALIDATE_MAC)) {
            $this->errors[$key] = $message;
          }
          return $this;
    }

    //pour des informations tels que non d'utilisateur ou mot de passe
     public function excluded(string $key, int $min, int $max, int $required, string $message):self{
        $pattern = '#^[^,?{}\'*@~µ$"<>:()ù$/\*.&-=+%]{' . $min . ',' . $max . '}$#';
        if($required == 0 and strlen($this->params[$key]) == 0){
            return $this;   
        }elseif(!preg_match($pattern, $this->params[$key])){
            $this->errors[$key] = $message;
        }
        return $this;
    }

    // pour les saisie libres, tels que le texte
    public function alphaNumeric(string $key, int $min, int $max, int $required, string $message):self{
        $pattern = '#^[a-zA-Z0-9éè_çà$%@!]{' . $min . ',' . $max . '}$#';
        if($required == 0 and strlen($this->params[$key]) == 0){
            return $this;
        }elseif(!preg_match($pattern, $this->params[$key])){
            $this->errors[$key] = $message;
        }
        return $this;
    }

    public function email($key, int $required, string $message): self{
    // $patternEmail = "/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,4}$/";
    if($required == 0 and strlen($this->params[$key]) == 0){
       return $this;
    }elseif (!filter_var($this->params[$key], FILTER_VALIDATE_EMAIL)) {
        $this->errors[$key] = $message;
      }
      return $this;
  
    }

    //vérifie qu'une information n'éxiste pas déja en base de données
    public function unique(string $key, string $tab, string $col, string $message): self{
        $query = 'SELECT * FROM :tab WHERE :col = :valeur LIMIT 1';
        $stmt = Model::getConnetion()->prepare($query);
        $stmt->bindValue(':tab', $tab, PDO::PARAM_STR);
        $stmt ->bindValue(':col', $col, PDO::PARAM_STR);
        $stmt->bindValue(':valeur', $this->params[$key], PDO::PARAM_STR);
        if($stmt->execute() == null){
            $this->errors[$key] == $message;
        }else{
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            if($result !== null){
                $this->errors[$key] = $message;
            }else{
                return $this;
            }
        }

        return $this;
    }

    public function exist(string $key, string $message): self{
        $query = 'SELECT * FROM user WHERE login = :valeur LIMIT 1';
        $stmt = Model::getConnetion()->prepare($query);
        // $stmt ->bindValue(':col', $col, PDO::PARAM_STR);
        $stmt->bindValue(':valeur', $this->params[$key], PDO::PARAM_STR);
        $ok = $stmt->execute();
         if(!$ok){
                $this->errors[$key] = 'erreur déxécution';
            }else{
                $data = $stmt->fetch(PDO::FETCH_OBJ);
                if($data !== false){
                    $this->errors[$key] = $message;
                }
            }
        return $this;
    }

    //verifie les correspondances de valeur entre deux champs
    public function same($key1, $key2):self{
       if($this->params[$key1] != $this->params[$key2]){
           $this->errors['different'] = 'les champs ' . $key1 . ' et ' . $key2 . ' doivent etre identique';
       } 

        return $this;
    }

    public function url($key, int $required, string $message): self{
        $pattern = '/^(http|https|ftp|ssh):\/\/([A-Z0-9][A-Z0-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?\/?/i';  
        if($required == 0 and strlen($this->params[$key]) == 0){
            return $this;
        }elseif (!preg_match($pattern, $this->params[$key])) {
                $this->errors[$key] = $message;
              }

          return $this;
    }

   public function dateTime(string $key, string $format = 'Y-m-d H:i:s', string $message): self{
    $value = $this->params[$key];
    $date = DateTime::createFromFormat($format, $value);
    $errors = DateTime::getLastErrors();
    if($errors['error_count'] > 0 || $errors['warning_count'] > 0 || $date === false){
        $this->errors[$key] = $message;
    }
    return $this;
   }

   public function isValid(){
       return empty($this->errors);
   }

   public function getErrors(): array {
    return $this->errors;
    }
}



  // à résoudre les problèmes de caractères accentués  



