<?php
class User{
    private $id;
    private $login;
    private $password;
    private $firstName;
    private $lastName;
    private $telephote;
    private $email;
    private $idPermission;
    private $idRole;
    private $status;
    private $type;
    private $creationDate;
    private $lastUpdate;
    
    public function getId(){
        return $this->id;
    }

    public function getLogin(){
        return $this->login;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getFirstName(){
        return $this->firstName;
    }

    public function getlastName(){
        return $this->lastName;
    }

    public function getTelephone(){
        return $this->telephone;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getIdpermission(){
        return $this->idPermission;
    }

    public function getIdRole(){
        return $this->idRole;
    }

    public function getType(){
        return $this->type;
    }

    public function getStatus(){
        return $this->status;
    }

    public function getcreattionDate($creationDate){
        return $this->creationDate;
    }

    public function getlastUpdate(){
        return $this->lastUpdate;
    }

    public function setLogin(string $login){
        $this->login = $login;
        return $this;
    }

    public function setPassword(string $password){
        $this->password = $password;
        return $this;
    }

    public function setFirstName($firstName){
        $this->firstName = $firstName;
        return $this;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function setEmail($email){
        $this->email = $email;
        return $this;
    }

    public function setIdPermission($idPermission){
        $this->idPermission = $idPermission;
        return $this;
    }

    public function setIdRole($idRole){
        $this->idRole = $idRole;
        return $this;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    public function setLastUpdate($lastUpdate){
        $this->lastUpdate = $lastUpdate;
        return $this;
    }

}