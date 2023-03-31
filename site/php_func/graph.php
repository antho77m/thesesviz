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
?>