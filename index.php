<?php

function update($req){
    
 $curl = curl_init();
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_URL, $req);			
	curl_setopt($curl, CURLOPT_TIMEOUT, 2);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, false);	
	$send = curl_exec($curl);
	curl_close($curl);
        return $send;
}

if (isset($_GET['get'])) {
    
    update("http://172.17.6.97/lumi/model_lumi.php");
    $get = $_GET['get'];
    
    switch ($get) {
                
        case "c_data1.mto":          
        header("Location: http://172.17.6.97/lumi/current/c_data1.mto");          
        break;
        
        case "c_data2.mto":
        header("Location: http://172.17.6.97/lumi/current/c_data2.mto");    
        break;
    
        case "rosa_pik.mto":
        header("Location: http://172.17.6.97/lumi/forecast/rosa_pik.mto");    
        break;
        
        case "rosa_1600.mto":
        header("Location: http://172.17.6.97/lumi/forecast/rosa_1600.mto");    
        break;
    
        case "rosa_plato.mto":
        header("Location: http://172.17.6.97/lumi/forecast/rosa_plato.mto");    
        break;
    
    }
}
?>