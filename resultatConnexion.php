<?php
    if (isset($_POST['login']) && isset($_POST['mdp'])) {

                
        $user =  $_POST['login'];
        $pass =  $_POST['mdp'];
        try {
            $cnx = new PDO("mysql:host=localhost;dbname=Test", $user, $pass);
            echo "Connexion réussie";
        }
        catch (PDOException $e) {
            echo "ERREUR : La connexion a échouée";

        /* Utiliser l'instruction suivante pour afficher le détail de erreur sur la
        * page html. Attention c'est utile pour débugger mais cela affiche des
        * informations potentiellement confidentielles donc éviter de le faire pour un
        * site en production.*/
            echo "Error: " . $e;

        }

    }else{
        echo "ERREUR : information manquante";
    
        //header('Location: connexion.html');
        exit();
    }


?>
