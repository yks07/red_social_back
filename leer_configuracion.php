<?php
  $credenciales_file = 'database.json';
  $log_file = 'error.log';

  // codigo fuente que permite escribir errores en el servidor :
  include_once 'escribir_log.php';
  //indica conde quiero escribir los errores
  Logger::setLogFile($log_file);

  if(file_exists($credenciales_file) && is_readable($credenciales_file)){
    //Decodificar el archivo json y almacenar en una variable PHP.

    $credenciales = json_decode(file_get_contents($credenciales_file,),true);

    if($credenciales !== null){
      //Vector que verifica si existen los minimos para conectarnos a una base de datos

      $claves_requeridas = ['host', 'username','password','database'];

      if(count(array_diff($claves_requeridas,array_keys($credenciales)))===0){ 

        $host = $credenciales['host'];
        $userName = $credenciales['username'];
        $password = $credenciales['password'];
        $database = $credenciales['database'];

        try{
            $conexion = new mysqli($host,$userName,$password,$database);

      }catch(Exception $ex){
        //Captura la excepcion y la trasmite en un archivo de errores .LOG
        $mensajeError = "Error en la conexion con la BD" . $ex->getMessage();
        Logger:: logError($mensajeError);
        //Redireccionar al Ususario a una pagina de error 
        header("Location: server_error_500.html");
      }
    }
  }
  }else{
        $mensajeError = "Error no se han encontrado credenciales oara conectar";
        Logger:: logError($mensajeError);
  }
?>