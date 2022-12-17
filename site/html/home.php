


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="get">
        <input type="search" name="search" id="">
    </form>
    <div>
    <?php
        if(isset($_GET['search'])){
            require_once('../../scripts/cnx.inc.php');
            $search = $_GET['search'];
            $req = $cnx->prepare("SELECT * FROM these WHERE titre LIKE '%$search%'");
            $req->execute();
            $result = $req->fetchAll();
            foreach($result as $row){
                echo '<div class="these">';
                echo '<h3>'.$row['titre'].'</h3>';
                echo '<p>'.$row['resume'].'</p>';
                echo '<p>'.$row['date'].'</p>';
                echo '<p>'.$row['auteur'].'</p>';
                echo '</div>';
            } 
        }


    ?>
    </div>
</body>
</html>