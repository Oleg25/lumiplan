<?php
#namespace lumi\write;

/*spl_autoload_extensions('.php, .rosa');
spl_autoload_register(function($class_name){
 $class_name = "classes";        
     require_once (__DIR__.DIRECTORY_SEPARATOR.$class_name);
            
    if (!file_exists($class_name)){
       return false;                 
        }
      }    
   );
*/
   
interface Lumi {

 public static function get_data($url); 
 public static function to_file($filename, $data);
    
}

abstract class Base_Lumi implements Lumi {
     
  public static function __callStatic($name, $args){
    
	return false;
   
   }  
		 
		
    static function get_data($url){
      
      $ch = curl_init();
      
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_TIMEOUT, 30);
      $data = curl_exec($ch);
      curl_close($ch);
      
      return $data;
            
  }

  
  static function to_file($filename ,$data){
      
      if (file_exists($filename)){ 
           
        $fh = fopen($filename, 'w');
        flock($fh, LOCK_EX); 
        fwrite($fh, pack("CCC",0xef,0xbb,0xbf));
        fputs($fh, $data);        
	flock($fh, LOCK_UN);
        fclose($fh);
	clearstatcache();
      }
      else  throw new Exception("файла ".$filename."не существует");
  }
} 

 class Lumi_Controller extends Base_Lumi {
      
    public $xml;	
    private static $inst = null;
            
    private function __construct() {
        
        parent::get_data("http://localhost/feed2/?wr");
        $xml = simplexml_load_string(parent::get_data('http://localhost/feed2/feed.xml'));
        $xml->registerXPathNamespace('rh', 'uri:roza_khutor_resort');		
			
        $this->xml = $xml;
                                                   
     }
    
    public static function get_inst(){
         
       if (! isset(static::$inst) ){
           
           static::$inst = new self(); 
           
       }  
       return self::$inst;    
         
     }


public static function convert_to_Lumi(array $data){
        
     $txt = implode(';', $data);
     trim($txt);            
     preg_match_all('/(.*)/i', $txt,$out);
         
     return $out;
    
}

public static function write($file, $data) {
	  	  
      	  
	 parent::to_file($file , $data);
         
   }
}
?>