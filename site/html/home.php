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
            
            include_once('../php_func/count.php'); 
            $countTheses = countAllTheses($cnx); // nombre de theses total
            $countEtablissement = countAllEtablissement($cnx); // nombre d'établissement total 
            $countOnline = countAllOnlineTheses($cnx); // nombre de theses en ligne
            $countDirecteur = countAllDirecteur($cnx); // nombre de directeur

            // on récupère les données qui vont servir par rapport a la recherche de l'utilisateur
            $total = count($result); // nombre de theses  (theses soutenue)
            $online = countOnline($result); 
            $onlineByYear = countOnlineByYear($result);
            $thesesByYear = countByYear($result);
            $onlineByMonth = countOnlineByMonth($result);
            $embargo = countEmbargo($result);
            $languages = countLanguage($result);
            $disciplines = countDiscipline($result);
            $sujets = countSujet($cnx,$result);
        }

            
            
    ?>
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
      
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/wordcloud.js"></script>

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
      
    </div>
    <div class="graphes">
      
       

        <div class="diag"id="theses_en_ligne"  ></div>

        <div class="diag"id="theses_par_ans" ></div>
        
        
        <div class="diag"id="theses_par_mois" ></div>
        
        <div class="diag"id="theses_embargo" ></div>

        <div class="diag"id="theses_par_langue" ></div>

        <div class="diag"id="theses_par_discipline" ></div>

        <div class="diag"id="nuage_de_sujet" ></div>

    </div>
    
    <div>
      <?
      if($result){
        for($i=0;$i<count($result);$i++){
          if($i==10){
              break;
          }
          printTheseById( $result[$i]['id_these'],$cnx);

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
        },
        //masque les abscisses
        visible: false
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

    Highcharts.chart('theses_par_mois', {
      chart: {
          type: 'column'
      },
      title: {
          text: 'Nombre de theses par mois'
      },
      xAxis: {
          categories: [
              'Janvier',
              'Fevrier',
              'Mars',
              'Avril',
              'Mai',
              'Juin',
              'Juillet',
              'Aout',
              'Septembre',
              'Octobre',
              'Novembre',
              'Decembre'
          ],
          crosshair: true
      },
      yAxis: {
          min: 0,
          title: {
              text: 'Nombre de theses'
          }
      },
      tooltip: {
          headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
          pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
              '<td style="padding:0"><b>{point.y:.f} </b></td></tr>',
          footerFormat: '</table>',
          shared: true,
          useHTML: true
      },
      plotOptions: {
          column: {
              pointPadding: 0.2,
              borderWidth: 0
          }
      },
      series: [{
          name: 'These soutenues',
          data: [<?php
              ;
              foreach($onlineByMonth as $month => $online){
                echo $online.',';
              }
              ?>]

      }]
  });


  Highcharts.chart('theses_embargo', {
          chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
          },
          title: {
            text: 'Theses sous embargo',
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
              name: 'Sous embargo',
              y: <?php echo $embargo; ?>,
              
            }, {
              name: 'Non en ligne',
              y: <?php echo $total-$embargo; ?>,
              
            },]
          }]
        });


        Highcharts.chart('theses_par_langue', {
          chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
          },
          title: {
            text: 'Theses par langue',
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
            data: [
              <?php
              foreach($languages as $langue => $theses){
                echo "{name: '".$langue."', y: ".$theses."},";
              }
              ?>
            ],
          }]
        });

        Highcharts.chart('theses_par_discipline', {
          chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
          },
          title: {
            text: 'Disciplines les plus représentées',
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
            data: [
              <?php
              $count = 0;
              foreach($disciplines as $discipline => $theses){
                echo "{name: '".htmlspecialchars($discipline)."', y: ".$theses."},";
                $count++;
                if($count == 50){
                  break;
                }
              }
              
              ?>
            ],
          }]
        });

        Highcharts.chart('nuage_de_sujet', {
        
        series: [{
          type: 'wordcloud',
          data:[
            <?php
            $i = 0;
            foreach($sujets as $sujet => $occurrences){
              echo "{name: '".htmlspecialchars($sujet)."', weight: ".$occurrences."},";
              $i++;
              if($i == 100){
                break;
              }
              
            }
            ?>
          ],
          name: 'Occurrences'
        }],
        title: {
          text: 'Nuage de sujets',
          align: 'center'
        },
        tooltip: {
          headerFormat: '<span style="font-size: 16px"><b>{point.key}</b></span><br>'
        }
      });
            </script>
            <?php
        }
        ?>
        <br><br><br>
</body>
</html>