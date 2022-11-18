<?php
class Personne{
    private string $idref;
    private string $nom;
    private string $prenom;
    private Role $role;    

    public function __construct(string $nom,string $prenom,Role $role){
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->role = $role;
    }

    public function printPersonne(){
        echo "Personne: <br>";
        echo "Nom: ".$this->nom."<br>";
        echo "Prenom: ".$this->prenom."<br>";
        $this->role->printRoles();
    }

    public function insertPersonne(PDO $cnx){
        $this->roles->insertRoles($cnx);
        //TODO
    }

    public function getIdref(){
        return $this->idref;
    }

    public function setIdref($idref){
        $this->idref = $idref;
    }

}


?>