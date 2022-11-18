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

    function inputoai(PDO $cnx){
        //todo
    }
}

?>