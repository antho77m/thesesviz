<?php
    function printTheseSawById($id,PDO $cnx){
        
        $req = $cnx->prepare("SELECT * FROM these NATURAL JOIN participe NATURAL JOIN Personnes WHERE id_these = :id AND libelle = 'auteurs'");
        $req->bindParam(':id',$id);
        $req->execute();
        $result = $req->fetchAll();

        foreach($result as $row){
            echo '<div class="these">';
            echo '<h3>'.$row['titre'].'</h3>';
            echo '<p class="resume">'.$row['resume'].'</p>';
            echo '<p class="autheur"> These écrite par '.$row['nom'].' '.$row['prenom'].'</p>';
            echo '</div>';
        }

    }


    function selectBySearch(){
        if(isset($_GET['search'])){
            require_once('../../cnx.inc.php');
            $search = $_GET['search'];
            
            $req = $cnx->prepare("SELECT id_these FROM these WHERE titre LIKE '%$search%'");
            $req->execute();
            $result = $req->fetchAll();
            echo '<div class="entete"> resultat de la recherche : '.$search.'<br>';
            echo 'nombre de résultat : '.count($result).'<br></div>';
            if($result){
                
                foreach($result as $row){
                    printTheseSawById( $row['id_these'],$cnx);
                }
            }else{
                echo 'aucun resultat';
            }
        }
    }

    function selectByAuthor(){
        if(isset($_GET['nom']) && isset($_GET['prenom'])){
            require_once('../../cnx.inc.php');
            $nom = $_GET['nom'];
            $prenom = $_GET['prenom'];
            $req = $cnx->prepare("SELECT id FROM Personnes WHERE nom = :nom AND prenom = :prenom");
            $req->bindParam(':nom',$nom);
            $req->bindParam(':prenom',$prenom);
            $req->execute();
            if($req->rowCount() == 0){
                echo 'aucun resultat';
            }else{
                $id = $req->fetch()[0]; // recupere l'id de la personne
                $req = $cnx->prepare("SELECT id_these FROM participe WHERE id = :id AND libelle = 'auteurs'");
                $req->bindParam(':id',$id);
                $req->execute();
                if($req->rowCount() == 0){
                    echo 'aucun resultat';
                }else{
                    $id_theses = $req->fetchAll(); // recupere l'id des theses dont l'auteur est la personne
                    echo '<div class="entete">resultat de la recherche : '.$nom.' '.$prenom.'<br>';
                    echo 'nombre de résultat : '.count($id_theses).'<br></div>';


                    if($id_theses){
                        foreach($id_theses as $id_these){   // on affiche les theses
                            printTheseSawById($id_these[0],$cnx);
                            
                        }   
                    }else{
                        echo 'aucun resultat';
                    }

                }
            }
            

        }

    }

?>