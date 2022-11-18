

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
"president_jury";
if ($data["president_jury"]) {
    $president = new Personne($data["president_jury"]["nom"], $data["president_jury"]["prenom"], new Role("president_jury"));
}
$roles = array("directeurs_these","membres_jury","auteurs");
    $personnes = array();
    foreach($roles as $role){
        if(isset($data[$role])){
            
            if (is_array($data[$role])){
                
                foreach($data[$role] as $personne){
                    $p = new Personne($personne["nom"],$personne["prenom"]?$personne["prenom"]:"",new Role($role));
                    if(isset($personne["idref"])){
                        $p->setIdref($personne["idref"]);
                    }
                    $p->printPersonne();
                    $personnes[] = $p;
                    
                }

            }else{
                $personne = $data[$role];
                $p = new Personne($personne["nom"],$personne["prenom"],new Role($role));
                if(isset($personne["idref"])){
                    $p->setIdref($personne["idref"]);
                }
                $p->printPersonne();
                $personnes[] = $p;
                
            }
        }
            
        }
    return $personnes;
}



$jsondata = file_get_contents ('extract_theses.json');
$data = json_decode($jsondata, true);
foreach($data as $theseData){
    echo "Personne dans la these:<br>";
    $personnes = getPersonnes($theseData);
    //echo "These:<br>";
    //$these = MakeThese($theseData);
    

    echo "<br><br><br><br>";

}


?>