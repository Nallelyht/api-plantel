<?php
require "Grupo.php";
/**
 *  Controlador para gestionar los datos de los invitados.
 *  
 *  Se entiende como "invitado" a un miembro de la tabla TWCLIENTES al que se le ha enviado una invitación vía correo electrónico a un evento
 *  o un cliente que registró su asistencia a un evento de Netmedia comprando un boleto vía Eventbrite.
 */
class GrupoController {
    
    private $conn;
    
     /** 
     *  Constructor de la clase
     *  @param PDO $conn La conexión a base de datos
     */
    function __construct($conn){
        $this->conn = $conn;
    }
  
    
    function getGrupos(){
                $respuesta = new stdClass();

         $resultado = array();
         $sql = "select * from grupo ";
        foreach ($this->conn->query($sql) as $row) {
            $grupo =new Grupo($row);
            $resultados[] = $grupo;
        }
         $respuesta->code=200;
        $respuesta->resultado=$resultados;
        return $respuesta;
    }
    
    
   
}