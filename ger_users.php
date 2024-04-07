<?php
    require 'vendor/autoload.php';
    include_once 'leer_configuracion.php';

    if(isset ($_POST['nombre_usuario']) && isset ($_POST['email'])){

        //Extraer desde POST la información recibida para la solicitud al servidor
        $nombre_usuario_solicitud = $_POST['nombre_usuario'];
        $email_solicitud = $_POST['email'];
        //Inicializar una lista para almacenar resultados
        $resultados = array(
            "status" => "0k"
        );

        try{
            //Elaborar la consulta SQL que nos permite traer los registros que coinciden con el criterio de consulta
            $consultaPreparada = $conexion->prepare("SELECT * FROM user WHERE email = ? AND userName = ?");
            $consultaPreparada->bind_param("ss",$email_solicitud,$nombre_usuario_solicitud);
            $consultaPreparada->execute();

            $consultaPreparada->bind_result($Id,$name,$userName,$email);

            while($consultaPreparada->fetch()){
                $registro =array(
                    "Id" => $Id,
                    "name" => $name,
                    "userName" => $userName,
                    "email" => $email
                );
                
                $resultados[] = $registro;
            }

            //Cerrar conexiones
            $consultaPreparada->close();
            $conexion->close();

        }catch(Exception $ex){
            $errorMessage = "Ocurrió un error al intentar consultar la información en BD" . $ex->getMessage() ;
            logger::logError($errorMessage);
        
        }
        //Codificando en formato JSON los resultados almacenados en el vector resultados
        $jsonInformacion = json_encode($resultados);
        echo $jsonInformacion;
  }



?>