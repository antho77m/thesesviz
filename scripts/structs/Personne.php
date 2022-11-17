<?php
class Personne{
    private $idref;
    private $nom;
    private $prenom;
    private $roles;    

    public function __construct($nom, $prenom, $roles){
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->roles = $roles;
    }

    public function printPersonne(){
        echo "Personne: <br>";
        echo "Nom: ".$this->nom;
        echo "Prenom: ".$this->prenom;
        echo "Roles: ".$this->roles;
    }

    public function insertPersonne($cnx){
        $this->roles->insertRoles($cnx);

    }

    public function getIdref(){
        return $this->idref;
    }

    public function setIdref($idref){
        $this->idref = $idref;
    }

}


?>