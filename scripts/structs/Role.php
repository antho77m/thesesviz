<?php
class Role{
    private string $libelle;

    public function __construct(string $libelle){
        $this->libelle = $libelle;
    }

    public function printRoles(){
        echo "Roles: <br>";
        echo "Libelle: ".$this->libelle;
    }
    

    public function insertRoles($cnx){
        //TODO
    }
}

?>