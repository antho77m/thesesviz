<?php
class Personne{
    private string $idref="";
    private string $nom="";
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

    public function insertPersonne(PDO $cnx,$id_these){
        $role = $this->role->insertRoles($cnx);

        $idref = $this->idref!=""?$this->idref:NULL;
        $prenom = $this->prenom!=""?$this->prenom:NULL;
        
        $req = $cnx->prepare("SELECT id FROM personnes WHERE nom=:nom AND idref = :idref AND prenom = :prenom");
        $req->bindParam(':nom',$this->nom);
        $req->bindParam(':prenom',$prenom);
        $req->bindParam(':idref',$idref);
        $req->execute();
        if($req->rowCount() == 0){
            $req = $cnx->prepare("INSERT INTO personnes (nom,prenom,idref) VALUES (:nom,:prenom,:idref)");
            $req->bindParam(':nom',$this->nom);
            $req->bindParam(':prenom',$prenom);
            $req->bindParam(':idref',$idref);
            $req->execute();
            $idPersonne = $cnx->lastInsertId();
        }else{
            $idPersonne = $req->fetch()['id'];
        }

        $req = $cnx->prepare("SELECT * FROM participe WHERE id_these=:these AND id=:id AND libelle=:libelle");
        $req->bindParam(':these',$id_these);
        $req->bindParam(':id',$idPersonne);
        $req->bindParam(':libelle',$role);
        $req->execute();
        if($req->rowCount() == 0){
            $req = $cnx->prepare("INSERT INTO participe (id_these,id,libelle) VALUES (:these,:id,:libelle)");
            $req->bindParam(':these',$id_these);
            $req->bindParam(':id',$idPersonne);
            $req->bindParam(':libelle',$role);
            $req->execute();
        }



    }

    public function getIdref(){
        return $this->idref;
    }

    public function setIdref($idref){
        $this->idref = $idref;
    }

}


?>