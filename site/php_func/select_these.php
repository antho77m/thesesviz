<?php
    function printTheseById($id,PDO $cnx){
        
        $req = $cnx->prepare("SELECT * FROM these NATURAL JOIN participe NATURAL JOIN Personnes WHERE id_these = :id AND libelle = 'auteurs'");
        $req->bindParam(':id',$id);
        $req->execute();
        $result = $req->fetchAll();

        foreach($result as $row){
            echo '<div class="these">';
            echo '<h3>'.$row['titre'].'</h3>';
            echo '<p class="resume">'.$row['resume'].'</p>';
            echo '<p class="auteur"><a href="https://www.theses.fr/'.$row['nnt'].'"> These écrite par '.$row['nom'].' '.$row['prenom'].'</a></p>';
            echo '</div>';
        }

    }


    function selectBySearch($cnx){

        if(isset($_GET['search'])&& !empty($_GET['search'])){

            $search = $_GET['search'];
        

            //$req = $cnx->prepare("SELECT id_these FROM these WHERE titre LIKE '%$search%'");
             
            // SELECT DISTINCT id_these ,MATCH(prenom,nom) AGAINST (":search") AS score_personne,MATCH(titre) AGAINST (":search") AS score_titre ,MATCH(resume) AGAINST (":search") AS score_resume FROM these NATURAL JOIN participe NATURAL JOIN Personnes Roles WHERE MATCH(prenom,nom) AGAINST (":search") OR MATCH(titre) AGAINST (":search") OR MATCH(resume) AGAINST (":search") ORDER BY (score_personne*5+score_titre*5+score_resume*1) DESC LIMIT 10
            /*$req = $cnx->prepare("SELECT DISTINCT id_these   
                                    FROM these NATURAL JOIN participe 
                                        NATURAL JOIN personnes 
                                        NATURAL JOIN parle
                                        NATURAL JOIN sujet
                                            WHERE MATCH(prenom,nom) AGAINST (:search) 
                                                OR MATCH(titre) AGAINST (:search)
                                                OR MATCH(sujet.libelle) AGAINST (:search) 
                                                    LIMIT 10");*/
            $req = $cnx->prepare("SELECT DISTINCT nnt,discipline,langue,embargo,id_these,en_ligne,date_soutenance   
            FROM these NATURAL JOIN participe 
                NATURAL JOIN personnes 
                    WHERE (MATCH(prenom,nom) AGAINST (:search) AND libelle = 'auteur') 
                        OR MATCH(titre) AGAINST (:search) ");
            $req->bindParam(':search',$search);
            $req->execute();
            $result = $req->fetchAll();
            return $result;
        }else{
            $req = $cnx->prepare("SELECT DISTINCT nnt,discipline,langue,embargo,id_these,en_ligne,date_soutenance   
            FROM these;");
            $req->execute();
            $result = $req->fetchAll();
            return $result;
        }      
    }

    

    
    

?>