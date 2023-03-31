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
    <div class="graphes">
       

        <div id="theses_en_ligne" style="width:40%; height:400px;"></div>

        <div id="theses_par_ans" style="width:40%; height:400px;"></div>
        
        <div id="theses_par_ans" style="width:80%; height:400px;"></div>


    </div>
    
    <div>
    <?php
        require_once('../../cnx.inc.php');
        require_once('../php_func/select_these.php');

        $result = selectBySearch($cnx);   // affiche les résultats de la recherche par titre
        
        echo '<div class="entete">';
        if(isset($_GET['search']) && !empty($_GET['search'])){
            echo 'resultat de la recherche : '.htmlspecialchars($_GET['search']).'<br>';
        }
        echo 'nombre de theses : '.count($result).'<br></div>';
        if($result){
            
            include_once('../php_func/graph.php'); 
            $total = count($result);
            $online = countOnline($result);
            $onlineByYear = countOnlineByYear($result);
            $thesesByYear = countByYear($result);

            
            for($i=0;$i<count($result);$i++){
                if($i==10){
                    break;
                }
                printTheseSawById( $result[$i]['id_these'],$cnx);

            } 
        }else{
            echo 'aucun resultat';
        }
    ?>
    </div>

    <footer>
        <a href="https://github.com/antho77m/thesesviz">lien du projet</a> <br>
        <a href="../../reporting.txt"> reporting</a>
    </footer>

    <script src="https://code.highcharts.com/highcharts.js"></script>

    <script>
        <?php

        if($result){

            ?>
            Highcharts.chart('theses_en_ligne', {
          chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
          },
          title: {
            text: 'Theses en ligne',
            align: 'center'
          },
          tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          accessibility: {
            point: {
              valueSuffix: '%'
            }
          },
          plotOptions: {
            pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
              }
            }
          },
          series: [{
            name: 'Theses',
            colorByPoint: true,
            data: [{
              name: 'En ligne',
              y: <?php echo $online; ?>,
              
            }, {
              name: 'Non en ligne',
              y: <?php echo $total-$online; ?>,
              
            },]
          }]
        });


        var dates = ['2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020'];
        var number = [100, 200, 300, 400, 500, 600, 700, 800, 900, 1000, 1100, 1200,1300,1400,1500];



        Highcharts.chart('theses_par_ans', {

        title: {
            text: 'Diagramme d\'évolution des theses en ligne',
            align: 'center'
        },


        
        yAxis: {
        min: 0,
        max: <?php echo $total; ?>,
        title: {
            text: 'Nombre de theses'
        }
    },

    xAxis: {
        categories: [
            <?php
            foreach ($onlineByYear as $year => $online) {
                echo "'" . $year . "',";
            }
            ?>
        ],
        labels: {
            rotation: -45
        }
    },

          
        

        series: [{
            name: 'Nombre de theses en ligne',
            data: [
              <?php
                $sum = 0;
                foreach($onlineByYear as $online){

                  $sum += $online;
                  echo $sum.',';
                }
              ?>
            ]
            
        }, {
            name: 'Nombre de theses',
            data: [
              <?php
                $sum = 0;
                foreach($thesesByYear as $theses){

                  $sum += $theses;
                  echo $sum.',';
                }
              ?>
            ]
          }
      ],

        

        });



            </script>
            <?php
        }
        ?>
</body>
</html>