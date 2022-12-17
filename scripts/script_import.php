<?php
global $cnx;
require_once("structs/These.php");
require_once("structs/Personne.php");
require_once("structs/Role.php");
require_once("structs/Etablissement.php");
require_once("structs/Sujet.php");
require_once("structs/oai.php");
require_once("cnx.inc.php");

function MakeThese($data){
    $these = new These();
    if(isset($data["discipline"]["fr"])){
        $these->setDiscipline($data["discipline"]["fr"]);
    }
    $these->setTheseSurTravaux($data["these_sur_travaux"]=="oui"?1:0);
    $these->setDateSoutenance($data["date_soutenance"]);
    $these->setEmbargo($data["embargo"]);
    $these->setLangue($data["langue"]);
    $these->setEnLigne($data["accessible"]=="oui"?1:0);
    $these->setNnt($data["nnt"]);
    if (isset($data["resumes"]["fr"])) {
        $these->setResume($data["resumes"]["fr"]);
    }
    $these->setSoutenue($data["status"]=="soutenue"?1:0);
    if (isset($data["titre"]["fr"])) {
        $these->setTitre($data["titres"]["fr"]);
    }
    return $these;
       
}



function getPersonnes($data){
    $personnes = array();
    

    if ($data["president_jury"]) {
        $prenom = $data["president_jury"]["prenom"]?$data["president_jury"]["prenom"]:"";
        $president = new Personne($data["president_jury"]["nom"],$prenom, new Role("president_jury"));
        if (isset($data["president_jury"]["idref"])) {
            $president->setIdref($data["president_jury"]["idref"]);
        }
        $personnes[] = $president;
    }

    //gestion des roles pouvant avoir plusieurs personnes
    $roles = array("directeurs_these","membres_jury","auteurs","rapporteurs"); 
    foreach($roles as $role){
        if(isset($data[$role])){
        
            foreach($data[$role] as $personne){
                $prenom =$personne["prenom"]?$personne["prenom"]:""; //gestion des personnes sans prenom
                $p = new Personne($personne["nom"],$prenom,new Role($role));
                if(isset($personne["idref"])){
                    $p->setIdref($personne["idref"]);
                }
                $personnes[] = $p;                
            }

        }
            
    }
    return $personnes;
}

function getEtablissements($data){
    $etablissements = array();
    foreach($data["etablissements_soutenance"] as $etablissement){
        $eta = new Etablissement($etablissement["nom"]);
        if(isset($etablissement["idref"])){
            $eta->setIdref($etablissement["idref"]);
        }
        $etablissements[] = $eta;
    }
    return $etablissements;
}

function getSujets($data){
    $sujets = array();
    if (isset($data["sujets"]["fr"])) {
        foreach($data["sujets"]["fr"] as $sujet){
            $sujets[] = new Sujet($sujet);
        }
    }
    return $sujets;
}

function getoais($data){
    $oais = array();
    if (isset($data["oai_set_specs"])) {
        foreach($data["oai_set_specs"] as $oai){
            $oais[] = new oai($oai);
        }
    }
    return $oais;
}


if(!file_exists('extract_theses.json')){
    exit("File not found");
}
try {
    $jsondata = file_get_contents ('extract_theses.json');
    $data = json_decode($jsondata, true);
    
} catch (Exception $e) {
    exit("Error while reading file");
}

$cnx->exec("ALTER TABLE these AUTO_INCREMENT = 1");
$cnx->exec("ALTER TABLE personnes AUTO_INCREMENT = 1");
echo "Import lancé a : ".date("H:i:s")."<br>";
$cnx->exec("BEGIN");
foreach($data as $theseData){
    $these = MakeThese($theseData);
    $personnes = getPersonnes($theseData);
    $etablissements = getEtablissements($theseData);
    $sujets = getSujets($theseData);
    $oais = getoais($theseData);

    $theseId= intval($these->insertThese($cnx));

    foreach($oais as $oai){
        $oai->insertOai($cnx,$theseId);
    }
    foreach($sujets as $sujet){
        $sujet->insertSujet($cnx,$theseId);
    }
    foreach($etablissements as $etablissement){
        $etablissement->insertEtablissement($cnx,$theseId);
    }
    foreach($personnes as $personne){
        $personne->insertPersonne($cnx,$theseId);
    }
}

$cnx->exec("COMMIT");
echo "Import terminé a : ".date("H:i:s")."<br>";
?>