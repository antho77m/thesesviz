<?php
    function countOnline($theses){
        $online =0;
        foreach($theses as $these){
            if($these['en_ligne'] == 1){
                $online++;
            }
        }
        return $online;
    }

    function countOnlineByYear($theses){
        $online = array();

        foreach($theses as $these){
            if($these['en_ligne'] == 1){
                $date =$these['date_soutenance'];
                $date = date("Y", strtotime($date));  
                if(isset($online[$date])){
                    $online[$date]++;
                }else{
                    $online[$date] = 1;                   
                }
            }
        }
        for($i=1980;$i<=date('Y');$i++){
            if(!isset($online[$i])){
                $online[$i] = 0;
            }
        }
        ksort($online);
        return $online;
    }
    function countByYear($theses){
        $online = array();

        foreach($theses as $these){
            $date =$these['date_soutenance'];
            $date = date("Y", strtotime($date));  
            if(isset($online[$date])){
                $online[$date]++;
            }else{
                $online[$date] = 1;                   
            }
        }
        for($i=1980;$i<=date('Y');$i++){
            if(!isset($online[$i])){
                $online[$i] = 0;
            }
        }
        ksort($online);
        return $online;
    }

    function countOnlineByMonth($theses){
        $online = array();

        foreach($theses as $these){
                $date =$these['date_soutenance'];
                $date = date("m", strtotime($date));  
                
                $date = ltrim($date, '0'); //enleve le 0 devant le mois
                if(isset($online[$date])){
                    $online[$date]++;
                }else{
                    $online[$date] = 1;                   
                }
        }
        
        
        for($i=1;$i<=12;$i++){
            if(!isset($online[$i])){
                $online[$i] = 0;
            }
        }
        ksort($online);
        //print_r($online);
        return $online;

    }

    function countEmbargo($theses){
        $embargo =0;
        foreach($theses as $these){
            if( $these['embargo'] > date('YYYY-mm-dd')){
                $embargo++;
            }
        }
        return $embargo;
    }
    function countLanguage($theses){
        $lang = array();
        foreach($theses as $these){

            for ($i = 0; $i < strlen($these['langue']); $i+=2) { // permet de parcourir la chaine de données par langue
                $langue = substr($these['langue'], $i, 2);
                if(isset($lang[$langue])){
                    $lang[$langue]++;
                }else{
                    $lang[$langue] = 1;                   
                }
            }
            

        }
        return $lang;
    }
    function countDiscipline($theses){
        $disciplines = array();
        foreach($theses as $these){
            if(isset($disciplines[$these['discipline']])){
                $disciplines[$these['discipline']]++;
            }else{
                $disciplines[$these['discipline']] = 1;                   
            }
            
            

        }
        arsort($disciplines);
        return $disciplines;


    }

    function countSujet($cnx,$theses){
        $sujets = array();
        foreach($theses as $these){
            $prep = $cnx->prepare("SELECT libelle,count(*)as nb FROM parle WHERE id_these = :id GROUP BY libelle");
            $prep->bindParam(':id', $these['id_these']);
            $prep->execute();
            $res = $prep->fetchAll();
            foreach($res as $r){
                if(isset($sujets[$r['libelle']])){
                    $sujets[$r['libelle']] += $r['nb'];
                }else{
                    $sujets[$r['libelle']] = $r['nb'];                   
                }
            }
        }
        arsort($sujets);
        return $sujets;

    }

    function countAllEtablissement($cnx){
        $prep = $cnx -> prepare("SELECT count(*) as nb FROM etablissement");
        $prep->execute();
        $res = $prep->fetch();
        return $res['nb'];
    }
    function countAllTheses($cnx){
        $prep = $cnx -> prepare("SELECT count(*) as nb FROM these");
        $prep->execute();
        $res = $prep->fetch();
        return $res['nb'];
    }
    function countAllOnlineTheses($cnx){
        $prep = $cnx -> prepare("SELECT count(*) as nb FROM these WHERE en_ligne = 1");
        $prep->execute();
        $res = $prep->fetch();
        return $res['nb'];
    }
    function countAllDirecteur($cnx){
        $prep = $cnx -> prepare("SELECT count(id) as nb FROM participe WHERE libelle = 'directeurs_these'");
        $prep->execute();
        $res = $prep->fetch();
        return $res['nb'];
    }


?>