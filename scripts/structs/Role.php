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
        $req = $cnx->prepare("SELECT libelle FROM role WHERE libelle = :libelle");
        $req->bindParam(':libelle',$this->libelle);
        $req->execute();
        if($req->rowCount() == 0){
            $req = $cnx->prepare("INSERT INTO role (libelle) VALUES (:libelle)");
            $req->bindParam(':libelle',$this->libelle);
            $req->execute();
        }
        return $this->libelle;

    }
}

?>