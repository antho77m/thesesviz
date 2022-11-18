

<?php
require_once("structs/These.php");
require_once("structs/Personne.php");
require_once("structs/Role.php");
require_once("structs/Etablissement.php");

function MakeThese($data){
    $these = new These();
    if(isset($data["discipline"]["fr"])){
        $these->setDiscipline($data["discipline"]["fr"]);
    }
    $these->setTheseSurTravaux($data["these_sur_travaux"]);
    $these->setDateSoutenance($data["date_soutenance"]);
    $these->setEmbargo($data["embargo"]);
    $these->setLangue($data["langue"]);
    $these->setEnLigne($data["accessible"]);
    $these->setNnt($data["nnt"]);
    if (isset($data["resumes"]["fr"])) {
        $these->setResume($data["resumes"]["fr"]);
    }
    $these->setSoutenue($data["status"]?1:0);
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
    $roles = array("directeurs_these","membres_jury","auteurs"); 
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
    foreach($data["sujets"] as $sujet){
        $sujets[] = new Sujet($sujet["libelle"]);
    }
    return $sujets;
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
foreach($data as $theseData){
    $these = MakeThese($theseData);
    $personnes = getPersonnes($theseData);
    $etablissements = getEtablissements($theseData);
    $sujets = getSujet($theseData);


    echo "<br><br><br><br>";

}


?>