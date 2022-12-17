<?php
class Sujet{
    private string $libelle;

    public function __construct(string $libelle){
        $this->libelle = $libelle;
    }

    public function printSujet(){
        echo "Sujets: <br>";
        echo "Libelle: ".$this->libelle;
    }

    public function insertSujet(PDO $cnx, int $theseId){
        $prep = $cnx->prepare("SELECT * FROM Sujet WHERE libelle = :libelle");
        $prep->bindParam(':libelle', $this->libelle);
        $prep->execute();

        if($prep->rowCount() == 0){
            $req = $cnx->prepare("INSERT INTO Sujet VALUES (:libelle)");
            $req -> bindParam(':libelle', $this->libelle);
            $req->execute();

            
        } 

        $prep =$cnx->prepare("SELECT * FROM parle WHERE libelle = :libelle AND id_these = :theseId");
        $prep->bindParam(':libelle', $this->libelle);
        $prep->bindParam(':theseId', $theseId);
        $prep->execute();


        if($prep->rowCount() > 0){
            return;
        }else{
            $req = $cnx->prepare("INSERT INTO parle VALUES (:id_these,:libelle)");
            $req->bindParam(":id_these",$theseId);
            $req->bindParam(":libelle",$this->libelle);
            $req->execute();
            
            
        }

    }
}

?>