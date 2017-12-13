<?php
/**
 *  Representación de un registro de invitado en la base de datos PERMANENTE (Registro de TWCLIENTES)
 */
class Alumno{
    public $matricula;
    public $nombre;
    public $apellidoPaterno;
    public $apellidoMaterno;
    public $sexo;
    public $grupo;
    public $curp;
    public $correoElectronico;
    public $fechaNacimiento;
  
    
    /**
     *  Constructor de la clase
     *  @param Array $registro Arreglo con una fila de la base de datos.
     */
    function __construct($registro){
        if($registro){
             $this->setData($registro);
        }
    }
    
     
    /**
     *  Mapea un resultado de la consulta de base de datos en el objeto.
     *  @param Array $registro Arreglo con una fila de la base de datos.
     */
    
    function setData($registro){
        $this->matricula = $registro["id"];
        $this->nombre = $registro["nombre"];
        $this->apellidoPaterno = $registro["paterno"];
        $this->apellidoMaterno = $registro["materno"];
        $this->sexo = $registro["sexo"];
        $this->grupo = $registro["grupo"];
        $this->curp = $registro["curp"];
        $this->correoElectronico = $registro["email"];
        $this->fechaNacimiento = $registro["fechaNacimiento"];
    }
    
   
    
    function getMatricula(){
        return $this->matricula;
    }
    
    /**
     *  Regresa el objeto Invitado en una cadena JSON
     *  @return string Json del objeto.
     */
    
    function toString(){
        return json_encode($this);
    }
    
}


