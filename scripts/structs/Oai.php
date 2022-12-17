<?php
class Oai {
    private string $id; 

    public function __construct($id) {
        $this->id = $id;
    }

    function printoai() {
        echo "oai: <br>";
        echo $this->id."<br>";
    }

    function insertOai(PDO $cnx,$theseId) {
        $prep = $cnx->prepare("SELECT * FROM oai WHERE id = :id");
        $prep->bindParam(':id', $this->id);
        $prep->execute();


        if($prep->rowCount() == 0){
            $req = $cnx->prepare("INSERT INTO oai VALUES (:id)");
            $req -> bindParam(':id', $this->id);
            $req->execute();

            //echo "insertion de l'oai ".$this->id." dans la base de données <br>";
            
        }
        $prep =$cnx->prepare("SELECT * FROM associe WHERE id = :id AND id_these = :theseId");
        $prep->bindParam(':id', $this->id);
        $prep->bindParam(':theseId', $theseId);
        $prep->execute();
        if($prep->rowCount() > 0){//si l'oai est déjà associé à la thèse
            return;
        }

        $req = $cnx->prepare("INSERT INTO associe VALUES (:id_these,:id_oai)");
        $req->bindParam(":id_these",$theseId);
        $req->bindParam(":id_oai",$this->id);
        $req->execute();
        
        //$this->printoai();
        

    }
}

?>

