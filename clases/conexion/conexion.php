<?php 

class conexion {

 private $server;
 private $user;
 private $pswd;
 private $database;
 private $port;
 private $conexion;

 function __construct(){
     $listaDatos = $this->datosConexion();
     foreach($listaDatos as $key=> $value){
        $this->server = $value['server'];
        $this->user = $value['user'];
        $this->pwsd = $value['password'];
        $this->database =$value['database'];
        $this->port =$value['port'];

     }
     $this->conexion = new mysqli($this->server,$this->user,$this->pwsd,$this->database,$this->port);
     if( $this->conexion ->connect_errno){
         echo "woooow! algo va mal con la base de datos";
         die();
     }
 }


 private function datosConexion(){
    $direccion = dirname(__FILE__);
    $jsondata = file_get_contents($direccion .'/'.'config.json'); 
    $toarray = json_decode($jsondata, true);
    return $toarray;
 }

 public function nonQuery($sqlstr){
    $result = $this->conexion->query($sqlstr);
    return $this->conexion -> affected_rows;
 }


 //solo utilizar para insert ya que esta retorna el Id insertado o cero en caso de fallar
 public function nonQueryId($sqlstr){
    $result = $this->conexion->query($sqlstr);
    $filas = $this->conexion -> affected_rows;
    if($filas >= 1){
        return $this->conexion->insert_id;
    }else{
        return 0;
    }

 }


 function obtenerDatos($sqlstr){
    $result = $this->conexion->query($sqlstr);
    $resultArray  = array();
    foreach( $result  as $registros ){
        $resultArray[] = $registros;
    }
    return $this->convertirUTF8($resultArray);
 }

 public function convertirUTF8($array){
    array_walk_recursive($array,function(&$item,$key){
        if(!mb_detect_encoding($item,'utf-8', true)){
            $item = utf8_encode( $item);
        }
    });
    return  $array;
 }
 
 public function Encriptar($texto){
    $texto = md5($texto);
    return $texto;
 }


 public  function sanatizeItem($var, $type)
 {
     $flags = NULL;
     switch($type)
     {
         case 'url':
             $filter = FILTER_SANITIZE_URL;
         break;
         case 'int':
             $filter = FILTER_SANITIZE_NUMBER_INT;
         break;
         case 'float':
             $filter = FILTER_SANITIZE_NUMBER_FLOAT;
             $flags = FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_THOUSAND;
         break;
         case 'email':
             $var = substr($var, 0, 254);
             $filter = FILTER_SANITIZE_EMAIL;
         break;
         case 'string':
         default:
             $filter = FILTER_SANITIZE_STRING;
             $flags = FILTER_FLAG_NO_ENCODE_QUOTES;
         break;
     }
     $output = filter_var($var, $filter, $flags);        
     return($output);
 }



    
}

?>