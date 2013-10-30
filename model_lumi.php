<?php 
require_once("main_contrl.php");
//use lumi\write as L;
 $inst2 = Lumi_Controller::get_inst();

 $items = array();
        foreach ($inst2->xml->xpath('//rh:current/rh:station') as $station) {
          $t1 = $station->temp_now;   	    
	  #$t2 = $station->temp_afternoon;
		  
		  $items[] = "\n".$station->attributes()->name;	
		  $items[] = "";
                  $items[] = $station->snow;
                  
                  $items[] = $station->wind_speed;
                  $items[] = $station->wind_dir->attributes()->lat;
                  $items[] = $station->sky->attributes()->id;
                  $items[] = "";
                  $items[] = "";
                  $items[] = "";
                  $items[] = "";
		  $items[] = $t1;
		 
        }


    $items2 = array();
    
      foreach ($inst2->xml->xpath('//rh:forecast/rh:station') as $station2) {
          $t11 = $station2->period[0]->temp_mon;   	    
	  #$t2 = $station->temp_afternoon;
		  
		  $items2[] = "\n".$station2->attributes()->name."-D+1";
                  
		  $items2[] = "";
                  $items2[] = "";
                  
                  $items2[] = $station2->period[0]->wind_speed;
                  $items2[] = $station2->period[0]->wind_dir->attributes()->lat;
                  $items2[] = $station2->period[0]->sky->attributes()->id;
                  $items2[] = "";
                  $items2[] = "";
                  $items2[] = "";
                  $items2[] = "";
		  $items2[] = $t11;
                  
                  $items2[] = "\n".$station2->attributes()->name."-D+2";
                  
		  $items2[] = "";
                  $items2[] = "";
                  
                  $items2[] = $station2->period[1]->wind_speed;
                  $items2[] = $station2->period[1]->wind_dir->attributes()->lat;
                  $items2[] = $station2->period[1]->sky->attributes()->id;
                  $items2[] = "";
                  $items2[] = "";
                  $items2[] = "";
                  $items2[] = "";
		  $items2[] = $t11;
		 
        }
   
    $r1 = Lumi_Controller::convert_to_Lumi($items);
    $r2 = Lumi_Controller::convert_to_Lumi($items2);
    
     $foo = implode(';', $items);
     trim($foo);
    
   try {
    $c_data1 = trim(preg_replace('/'.$r1[0][5].'/', "", $foo));
    $c_data1_cut = substr($c_data1, 0, strlen($c_data1)-1);
    //echo $vq;
    
    $c_data2 = trim(preg_replace('/'.$r1[0][1].'/', "", $foo));
    
    $f_rosa_1600 = $r2[0][1]."\n".$r2[0][3];
    $f_rosa_1600_cut = substr($f_rosa_1600, 0, strlen($f_rosa_1600)-1);
    
    $f_rosa_pik = $r2[0][5]."\n".$r2[0][7];
    $f_rosa_pik_cut = substr($f_rosa_pik, 0, strlen($f_rosa_pik)-1);
    
    $f_rosa_plato = $r2[0][9]."\n".$r2[0][11];
    
    Lumi_Controller::write("current/c_data1.mto",$c_data1_cut);
    Lumi_Controller::write("current/c_data2.mto",$c_data2);
    
    sleep(1);
    
    Lumi_Controller::write("forecast/rosa_pik.mto",$f_rosa_pik_cut);
    Lumi_Controller::write("forecast/rosa_1600.mto",$f_rosa_1600_cut);
    Lumi_Controller::write("forecast/rosa_plato.mto",$f_rosa_plato);
    
    echo "All files was created";
  } catch (Exception $e){
      
      throw new Exception("Error ".$e->getMessage());
      
  }
    
#header("Content-Type: application/octet-stream");
#header('Content-Disposition: attachment; filename="w_data.mto"');
?>