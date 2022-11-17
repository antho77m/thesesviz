<?php
class Role{
    private $libelle;

    public function __construct($libelle){
        $this->libelle = $libelle;
    }

    public function printRoles(){
        echo "Roles: <br>";
        echo "Libelle: ".$this->libelle;
    }
    

    public function insertRoles($cnx){
        
    }
}

?>