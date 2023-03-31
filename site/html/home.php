


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/home.css">
    <title>Document</title>
</head>
<body>
    <div class="form">
        <form action="" method="get">
            <br>
            effectué une recherche par :
            <div class="type_recherche">
            </div> 
            <input type="search" name="search" id="" autocomplete="off" placeholder="faire une recherche">
            <br>
            <input type="submit" value="Rechercher">

        </form>
    </div>
    <div>
    <?php
        require_once('../php_func/select_these.php');
        selectBySearch();   // affiche les résultats de la recherche par titre
        selectByAuthor();   // affiche les résultats de la recherche par auteur

    ?>
    </div>

    <footer>
        <a href="https://github.com/antho77m/thesesviz">lien du projet</a> <br>
        <a href="../../reporting.txt"> reporting</a>
    </footer>

</body>
</html>