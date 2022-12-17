


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="get">
        rechercher via le titre d'une these
        <input type="search" name="search" id="">
        <br>
        <input type="submit" value="Rechercher">
    
    </form>
    <form action="" method="get">
        rechercher via l'auteur d'une these
        <br>
        
        nom :<input type="text" name="nom" require autocomplete="off" autocapitalize="on" require>
        prenom :<input type="text" name="prenom" id="" autocomplete="off" autocapitalize="on" require>
        
        
        <input type="submit" value="Rechercher">
    </form>
    <div>
    <?php
        require_once('../php_func/select_these.php');
        selectBySearch();   // affiche les résultats de la recherche par titre
        selectByAuthor();   // affiche les résultats de la recherche par auteur

    ?>
    </div>

    <footer>
        <a href="https://github.com/antho77m/thesesviz">lien du projet</a>
    </footer>

</body>
</html>