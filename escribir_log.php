<?php

    class Logger {

        private static $log_file;

        

        public static function setLogFile($file){
          self::$log_file = $file;
        }

       /**
         * Recibe un mensaje e imprime en un archivo log la información recibida con fecha y hora
         * @args : $message : string --> mensaje que se desa imprimir en el log
         * return : void 
         */

        public static function logError($message){
          if (isset(self::$log_file)){
              $dateTime = date("Y-m-d H:i:s");

              //Formateamos el mensaje que deseamos llevar al archivo :

              file_put_contents(self::$log_file,"[$dateTime] $message" . PHP_EOL,FILE_APPEND);
          }else{
            error_log("Error: Archivo de registro no encontrado ");
          }
        }
    }
    
?>