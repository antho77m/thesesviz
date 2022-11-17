<?php

class These {
    private $discipline;
    private $these_sur_travaux;
    private $date_soutenance;
    private $embargo;
    private $langue="fr";
    private $en_ligne;
    private $nnt;
    private $resume;
    private $soutenue;
    private $titre;

    public function __construct(){

    }

    public function insertThese($cnx){
        
    }
    
    // Getters and setters

    public function setDiscipline($discipline){
        $this->discipline = $discipline;
    }

    public function setTheseSurTravaux($these_sur_travaux){
        $this->these_sur_travaux = $these_sur_travaux;
    }

    public function setDateSoutenance($date_soutenance){
        $this->date_soutenance = $date_soutenance;
    }

    public function setEmbargo($embargo){
        $this->embargo = $embargo;
    }

    public function setLangue($langue){
        $this->langue = $langue;
    }

    public function setEnLigne($en_ligne){
        $this->en_ligne = $en_ligne;
    }

    public function setNnt($nnt){
        $this->nnt = $nnt;
    }

    public function setResume($resume){
        $this->resume = $resume;
    }

    public function setSoutenue($soutenue){
        $this->soutenue = $soutenue;
    }

    public function setTitre($titre){
        $this->titre = $titre;
    }

    public function getDiscipline(){
        return $this->discipline;
    }

    public function getTheseSurTravaux(){
        return $this->these_sur_travaux;
    }

    public function getDateSoutenance(){
        return $this->date_soutenance;
    }

    public function getEmbargo(){
        return $this->embargo;
    }

    public function getLangue(){
        return $this->langue;
    }

    public function getEnLigne(){
        return $this->en_ligne;
    }

    public function getNnt(){
        return $this->nnt;
    }

    public function getResume(){
        return $this->resume;
    }

    public function getSoutenue(){
        return $this->soutenue;
    }

    public function getTitre(){
        return $this->titre;
    }

    public function printThese(){
        echo "These :<br>";
        echo "Titre: $this->titre <br>";
        echo "Discipline: $this->discipline <br>";
        echo "Sur travaux: $this->these_sur_travaux <br>";
        echo "Date de soutenance: $this->date_soutenance <br>";
        echo "Embargo: ".($this->embargo? "Oui":"Non")."<br>";
        echo "Langue: $this->langue <br>";
        echo "En ligne: $this->en_ligne <br>";
        echo "NNT: $this->nnt <br>";
        echo "Résumé: $this->resume <br>";
        echo "Soutenue: ".($this->soutenue?"oui":"non")."<br>";
    }

}


?>