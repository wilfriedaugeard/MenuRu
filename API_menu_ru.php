<?php

    /**
     * API_menu_ru.php
     *
     * Create menu_ru.json from http://www.crous-bordeaux.fr/restaurant/resto-u-n1/
     *
     * PHP Version 5.6.40
     *
     * @author     Willou <waugeard@gmail.com>
     * @copyright  2019 Willou
     * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
     * @version    1.0.0-beta
     */
 
    //Extract source code and save menu code
    $src = file_get_contents("http://www.crous-bordeaux.fr/restaurant/resto-u-n1/");
    $result=preg_replace('!^.*<div id="menu-repas">(.+)<footer id="footer">.*$!isU','$1',$src);
    
    //RegEx
    preg_match_all('!<h3>(.+)</h3>!isU',$result, $dates_parsed); 
    preg_match_all('!<h4>(.+)</h4>!isU',$result, $services_parsed); 
    preg_match_all('!<div class="content-repas">(.+)</div>!isU',$result, $chains_by_services_parsed); 
    preg_match_all('!<span class="name">(.+)</span>!isU',$result, $chains_name_parsed);
    preg_match_all('!<ul class="liste-plats">(.+)</ul>!isU',$result, $menu_parsed);
    
    //Count variables
    $nb_days = count($dates_parsed[1]);
    $nb_services = count($services_parsed[1]);
    $nb_chains_for_all_days = count($chains_by_services_parsed[1]);



    //put chains on $chain_array
    $chain_array = array();
    for($i=0; $i<$nb_services; $i++){
        $name = preg_replace('!^.*<span class="name">(.+)</span>.*$!isU','$0',$chains_by_services_parsed[0][$i]);
        preg_match_all('!<span class="name">(.+)</span>!isU',$name, $chains_name_parsed);
        $chain_array[$i] = $chains_name_parsed[1];
    }
        


    //get menu without tags and put it in $menu_of_the_chain_tmp
    $menu_of_the_chain_tmp = array();
    for($i=0; $i<count($menu_parsed[1]); $i++){
        $data = explode("<li>",$menu_parsed[1][$i]);
        $data = str_replace("</li>","",$data);
        array_shift($data);                   
        
        array_push($menu_of_the_chain_tmp,$data);
        
    }
        

    
    //Add and class label Entree, Plat, Dessert
    $menu_of_the_chain = array();
    for($i=0; $i<count($menu_of_the_chain_tmp); $i++){
        if(count($menu_of_the_chain_tmp[$i]) > 1){
            $entree = array();
            $plat = array();
            $dessert = array();
            $next = 0; //next meal step
            for($j=0; $j<count($menu_of_the_chain_tmp[$i]); $j++){
                if($menu_of_the_chain_tmp[$i][$j]==""){
                    if($menu_of_the_chain_tmp[$i][$j+1]!=""){
                        $next++;   
                    }
                }else{
                    switch ($next) {
                        case 0:
                            array_push($entree, $menu_of_the_chain_tmp[$i][$j]);
                            break;
                        case 1:
                            array_push($plat, $menu_of_the_chain_tmp[$i][$j]);
                            break;
                        case 2:
                            array_push($dessert, $menu_of_the_chain_tmp[$i][$j]);
                            break;
                        default:
                            break;
                    }
                }
            }
            $menu_of_the_chain[$i]['Entrée'] = $entree;
            $menu_of_the_chain[$i]['Plat'] = $plat;
            $menu_of_the_chain[$i]['Dessert'] = $dessert;
            
        }else{
            array_push($menu_of_the_chain,$menu_of_the_chain_tmp[$i][0]);
        }
    }

    
    //Add all meals in their chains and put them in $menu_of_the_day
    $current_pos = 0;
    $num_service = 0;
    $menu_of_the_day = array();
    while($num_service<$nb_services){
        $service_name = $services_parsed[1][$num_service];
        for($i=0; $i<count($chain_array[$num_service]); $i++){
            if($chain_array[$num_service][$i]=="Pas de service"){
                $menu_of_the_day[$num_service][$chain_array[$num_service][$i]] = [];
            }else{
                $menu_of_the_day[$num_service][$chain_array[$num_service][$i]]= $menu_of_the_chain[$current_pos];
                $current_pos++;
            } 
        }
        $num_service++;   
    }        
    

    //Add dates, clean them and add the corresponding menu with their services
    $dates = array();
    $num = 0;
    for($i = 0 ; $i<$nb_days; $i++){
        $date_name = $dates_parsed[1][$i];
        $date_name = str_replace("Menu du ","",$date_name);
        $date_name = strstr($date_name," ");
        $date_name = substr($date_name,1);
        $day = array();
        for($j=0; $j<3; $j++){
            $service_name = $services_parsed[1][$num];
            $dates[$date_name][$service_name] = $menu_of_the_day[$j+($i*3)];
            $num++;
        }
    }

    //Create the main array $all_menu and put all information 
    $all_menu = array();
    $all_menu['nb_days'] = $nb_days;
    $all_menu['date'] = $dates;

    //Encode json content
    $contenu_json = json_encode($all_menu, JSON_PRETTY_PRINT);

    //Create and write in json file
    $file_name = "menu_ru.json";
    $file = fopen($file_name, 'w+');
    fwrite($file, $contenu_json);
    fclose($file);

?>













