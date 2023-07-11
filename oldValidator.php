<?php

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

    public function int($key, int $min, int $max, string $message): self{
        $options = ["options" => ["min_range" => $min , "max_range"=> $max]];
        if (!filter_var($this->params[$key], FILTER_VALIDATE_INT, $options)) {
            $this->errors[$key] = $message;
          }
          return $this;
    }

    public function intNoRequired($key, int $min, int $max, string $message): self{
        $options = ["options" => ["min_range" => $min , "max_range"=> $max]];
        if(strlen($this->params[$key]) == 0){
        return $this;
        }elseif(!filter_var($this->params[$key], FILTER_VALIDATE_INT, $options)) {
        $this->errors[$key] = $message;
        }
        return $this;
    }

    public function intMix($key, int $min, int $max, int $required, string $message): self{
        $options = ["options" => ["min_range" => $min , "max_range"=> $max]];
        if($required == 0 and strlen($this->params[$key]) == 0){
        return $this;
        }elseif(!filter_var($this->params[$key], FILTER_VALIDATE_INT, $options)) {
        $this->errors[$key] = $message;
        }
        return $this;
    }

    public function float($key, int $min, int $max, $message):self{
        $options = ["options" => ["min_range" => $min , "max_range"=> $max]];
        if (!filter_var($this->params[$key], FILTER_VALIDATE_FLOAT, $options)) {
            $this->errors[$key] = $message;
          }
          return $this;
    }



    public function floatNoRequired($key, int $min, int $max, string $message):self{
        $options = ["options" => ["min_range" => $min , "max_range"=> $max]];
        if(strlen($this->params[$key]) == 0){
            return $this;
            }elseif(!filter_var($this->params[$key], FILTER_VALIDATE_FLOAT, $options)) {
            $this->errors[$key] = $message;
            }
        return $this;
    }


    public function ip($key, string $message):self{
        if (!filter_var($this->params[$key], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $this->errors[$key] = $message;
          }
          return $this;
    }

    public function ipNoRequired($key, string $message):self{
       
        if(strlen($this->params[$key]) == 0){
            return $this;
        }elseif (!filter_var($this->params[$key], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $this->errors[$key] = $message;
          }
          return $this;
    }

    public function mac($key, string $message):self{
        if (!filter_var($this->params[$key], FILTER_VALIDATE_MAC)) {
            $this->errors[$key] = $message;
          }
          return $this;
    }

    public function macNoRequired($key, string $message):self{
        if(strlen($this->params[$key]) == 0){
            return $this;
        }elseif (!filter_var($this->params[$key], FILTER_VALIDATE_MAC)) {
            $this->errors[$key] = $message;
          }
          return $this;
    }

    public function excluded(string $key, int $min, int $max, string $message):self{
        $pattern = '#^[^,?{}\'*@~µ$"<>:()ù$/\*.&-=+%]{' . $min . ',' . $max . '}$#';
        if(!preg_match($pattern, $this->params[$key])){
            $this->errors[$key] = $message;
        }
        return $this;
    }
    //pour des informations tels que non d'utilisateur ou mot de passe
    public function excludedNoRequired(string $key, int $min, int $max, string $message):self{
        $pattern = '#^[^,?{}\'*@~µ$"<>:()ù$/\*.&-=+%]{' . $min . ',' . $max . '}$#';
        if(strlen($this->params[$key]) == 0){
            return $this;   
        }elseif(!preg_match($pattern, $this->params[$key] )){
            $this->errors[$key] = $message;
        }
        return $this;
    }

    public function alphaNumeric(string $key, int $min, int $max, string $message):self{
        $pattern = '#^[a-zA-Z0-9&éèçà]{' . $min . ',' . $max . '}$#';
        if(!preg_match($pattern, $this->params[$key])){
            $this->errors[$key] = $message;
        }
        return $this;
    }

    // pour les saisie libres, tels que le texte
    public function alphaNumericNoRequired(string $key, int $min, int $max, string $message):self{
        $pattern = '#^[a-zA-Z0-9éè_çà$%@!]{' . $min . ',' . $max . '}$#';
        if(strlen($this->params[$key]) == 0){
            return $this;
        }elseif(!preg_match($pattern, $this->params[$key])){
            $this->errors[$key] = $message;
        }
        return $this;
    }


    public function email($key, string $message): self{
        // $patternEmail = "/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,4}$/";
    if (!filter_var($this->params[$key], FILTER_VALIDATE_EMAIL)) {
        $this->errors[$key] = $message;
      }
      return $this;
  
    }

    public function emailNoRequired($key, string $message): self{
        // $patternEmail = "/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,4}$/";
   
   if(strlen($this->params[$key]) == 0){
       return $this;
   }elseif (!filter_var($this->params[$key], FILTER_VALIDATE_EMAIL)) {
        $this->errors[$key] = $message;
      }
      return $this;
  
    }

    //vérifie qu'une information n'éxiste pas déja en base de données
    public function unique($key, $table, string $message): self{
        
        return $this;
    }

    //verifie les correspondances de valeur entre deux champs
    public function confirmed($key1, $key2, string $message):self{
        
        return $this;
    }

    public function url($key, string $message): self{
        $pattern = '/^(http|https|ftp|ssh):\/\/([A-Z0-9][A-Z0-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?\/?/i';
        if (!preg_match($pattern, $this->params[$key])) {
                $this->errors[$key] = $message;
              }

        // if (!filter_var($this->params[$key], FILTER_VALIDATE_URL)) {
        //     $this->errors[$key] = "le champ $key contient des caractères non valides";
        //   }
          return $this;
    }

    public function urlNoRequired($key, string $message): self{
        $pattern = '/^(http|https|ftp|ssh):\/\/([A-Z0-9][A-Z0-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?\/?/i';
        
        if(strlen($this->params[$key]) == 0){
            return $this;
        }elseif (!preg_match($pattern, $this->params[$key])) {
                $this->errors[$key] = $message;
              }

        // if (!filter_var($this->params[$key], FILTER_VALIDATE_URL)) {
        //     $this->errors[$key] = "le champ $key contient des caractères non valides";
        //   }
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



