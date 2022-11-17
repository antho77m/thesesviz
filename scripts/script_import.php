

<?php
include("structs/These.php");
include("structs/Personne.php");
include("structs/Role.php");
include("structs/Etablissement.php");

function MakeThese($data){
    $these = new These();
    $these->setDiscipline($data["discipline"]["fr"]);
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



function printThese($data){
    $these = MakeThese($data);
    $these->printThese();
};

$jsondata = file_get_contents ('extract_theses.json');
$data = json_decode($jsondata, true);
foreach($data as $these){
    printThese($these);
    echo "<br><br><br><br>";

}


?>