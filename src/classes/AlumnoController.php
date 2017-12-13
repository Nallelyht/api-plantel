<?php
require "Alumno.php";
/**
 *  Controlador para gestionar los datos de los invitados.
 *  
 *  Se entiende como "invitado" a un miembro de la tabla TWCLIENTES al que se le ha enviado una invitación vía correo electrónico a un evento
 *  o un cliente que registró su asistencia a un evento de Netmedia comprando un boleto vía Eventbrite.
 */
class AlumnoController {
    
    private $conn;
    
     /** 
     *  Constructor de la clase
     *  @param PDO $conn La conexión a base de datos
     */
    function __construct($conn){
        $this->conn = $conn;
    }
    
    /**
     *  Obtiene los datos de un invitado
     *  @param int $id El ID_CLI de un invitado
     *  @return \Invitado $invitado Datos del invitado
     */ 
    function getAlumnoById($id){
        $resultado = "";
         $sql = "select * from alumno where id = ".$id;
        foreach ($this->conn->query($sql) as $row) {
            $invitado =new Alumno($row);
            $resultado = $invitado->toString();
        }
        return $invitado;
    }
    
    
    function getAlumnos(){
                $respuesta = new stdClass();

         $resultado = array();
         $sql = "select * from alumno ";
        foreach ($this->conn->query($sql) as $row) {
            $invitado =new Alumno($row);
            $resultados[] = $invitado;
        }
         $respuesta->code=200;
        $respuesta->resultado=$resultados;
        return $respuesta;
    }
    
    
    
     function validarCorreo($correo, $id){
        $respuesta = new stdClass();
        $existe = 0;
        $sql = "SELECT count(*) as EXISTE FROM alumno WHERE email = :correo AND id <> :id";
        $sentencia = $this->conn->prepare($sql);
        $sentencia->bindParam(":correo", $correo);
        $sentencia->bindParam(":id", $id);
        $res = $sentencia->execute();
        if($sentencia->execute()){
            while($fila = $sentencia->fetch()){
                $existe = $fila['EXISTE'];
            }
            if($existe > 0){
                $respuesta->code = 500;
                $respuesta->message = "El correo ya está en uso, favor de verificar.";
            } else {
                $respuesta->code = 200;
                $respuesta->message = "Validación Correo: ok";
            }
            $sentencia->closeCursor();
            $sentencia = null;
            return $respuesta;
        } else {
            $respuesta->code=300;
            $respuesta->message="Error";
            $sentencia = null;
            return $respuesta;
        }
    }

    
     /**
     *  Actualiza los datos de un invitado en la base de datos.
     *  @param \Invitado $item Los datos del Invitado
     *  @return Object $respuesta Resultado de la consulta
     */
    function actualizarAlumno($item){
        $respuesta = new stdClass();

        try {
            
            $sql = "UPDATE alumno SET 
            nombre = :nombre, 
            paterno = :paterno,
            materno = :materno,
            grupo = :grupo,
            sexo = :sexo,
            curp = :curp,
            email = :email, 
            fechaNacimiento = :fechaNacimiento
            WHERE id = :id";
            $sentencia = $this->conn->prepare($sql);
            $sentencia->bindParam(":nombre", $item->nombre);
            $sentencia->bindParam(":paterno", $item->paterno);
            $sentencia->bindParam(":materno", $item->materno);
            $sentencia->bindParam(":grupo", $item->grupo);
            $sentencia->bindParam(":sexo", $item->sexo);
            $sentencia->bindParam(":curp", $item->curp);
            $sentencia->bindParam(":email", $item->email);
            $sentencia->bindParam(":fechaNacimiento", $item->fechaNacimiento);
            $sentencia->bindParam(":id", $item->id);
            $res = $sentencia->execute();
            if($res){
                
               
                $respuesta->code=200;
                $respuesta->message="OK";
            } else {
                $respuesta->code=300;
                $respuesta->message="Error";
            }
            $sentencia = null;
            return $respuesta;
            
        } catch (PDOException $e) {
            $respuesta->code=500;
            $respuesta->message = $e->getMessage();
            $sentencia = null;
            return $respuesta;
            exit;
        }
    }
    
    /**
     *  Agrega los datos de un invitado en la base de datos.
     *  @param \Invitado $item Los datos del Invitado
     *  @return Object $respuesta Resultado de la consulta
     */
    function addAlumno($item){
        $respuesta = new stdClass();
      
        $res = $this->validarCorreo($item->email, $item->id);
        if($res->code != 200){
            return $res;
            exit;
        }
        try {
            
            
            $sql = "INSERT into alumno(nombre, paterno, materno, curp, email, sexo, grupo, fechaNacimiento) values (:nombre, :paterno, :materno, :curp, :email, :sexo, :grupo, :fechaNacimiento)";
            
            $sentencia = $this->conn->prepare($sql);
            $sentencia->bindParam(":nombre", $item->nombre);
            $sentencia->bindParam(":paterno", $item->paterno);
            $sentencia->bindParam(":materno", $item->materno);
            $sentencia->bindParam(":grupo", $item->grupo);
            $sentencia->bindParam(":sexo", $item->sexo);
            $sentencia->bindParam(":curp", $item->curp);
            $sentencia->bindParam(":email", $item->email);
            $sentencia->bindParam(":fechaNacimiento", $item->fechaNacimiento);
            $res = $sentencia->execute();
            if($res){
                
                while ($fila = $sentencia->fetch()) {
                    $respuesta->id = $fila["ID_CLI"];
                }
                $respuesta->code=200;
                $respuesta->message="OK";
                
            } else {
                $respuesta->code=300;
                $respuesta->message="Error";
            }
            
            
            $sentencia = null;
            return $respuesta;
        } catch (PDOException $e) {
            $respuesta->code=500;
            $respuesta->message = $e->getMessage();
            $sentencia = null;
            return $respuesta;
            exit;
        }
    }
    
    
    
    /**
     *  Busca usuarios por nombre y apellidos o por correo electrónico
     */
    function buscarAlumno($nombre='', $apellido='', $correo=''){
        $respuesta = new stdClass();
        
        if($nombre == '' && $apellido == '' && $correo==''){
            $respuesta->code=300;
            $respuesta->message="Consulta vacía";
            return $respuesta;
        }
        
        $existe = 0;
        $tmpWhere = array();
        $sql = "select * from alumno WHERE ";
        if($nombre != ''){
            $tmpWhere[] = "nombre LIKE ('%' + :nombre+ '%')";
        }
        if($apellido != ''){
            $tmpWhere[] = "(paterno LIKE ('%' + :apellido +'%') OR  materno LIKE ('%' + :apellido +'%') )";
        }
        if($correo != ''){
            $tmpWhere[] = "email LIKE ('%' + :correo + '%')";
        }
        $sql.= implode(" AND ", $tmpWhere);
        $sql.= " ORDER BY paterno, materno, nombre";
        
        try {
            $sentencia = $this->conn->prepare($sql);
            
            if($nombre != ''){
                $sentencia->bindParam(":nombre", $nombre);
            }
            if($apellido != ''){
                $sentencia->bindParam(":apellido", $apellido);
            }
            if($correo != ''){
                $sentencia->bindParam(":correo", $correo);
            }
            
            $res = $sentencia->execute();
            if($sentencia->execute()){
                $resultados = array();
                while($fila = $sentencia->fetch()){
                    $invitado =new Alumno($fila);
                    $resultados[] = $invitado;
                }
                $respuesta->code=200;
                $respuesta->resultado=$resultados;
                $sentencia->closeCursor();
                $sentencia = null;
                return $respuesta;
            } else {
                $respuesta->code=300;
                $respuesta->message="Error";
                $sentencia = null;
                return $respuesta;
            }
        } catch (PDOException $e) {
            $respuesta->code=500;
            $respuesta->message = $e->getMessage();
            $sentencia = null;
            return $respuesta;
            exit;
        }
    }
    
   
    function eliminarAlumno($item){
        $respuesta = new stdClass();

       
        try {
            
            $sql = "DELETE FROM alumno 
            WHERE id=:id";
            $sentencia = $this->conn->prepare($sql);
            $sentencia->bindParam(":id", $item->id);
            $res = $sentencia->execute();
            if($res){
                
               
                $respuesta->code=200;
                $respuesta->message="OK";
            } else {
                $respuesta->code=300;
                $respuesta->message="Error";
            }
            $sentencia = null;
            return $respuesta;
            
        } catch (PDOException $e) {
            $respuesta->code=500;
            $respuesta->message = $e->getMessage();
            $sentencia = null;
            return $respuesta;
            exit;
        }
    }
    
}