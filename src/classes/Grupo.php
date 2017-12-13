<?php
/**
 *  Representación de un registro de invitado en la base de datos PERMANENTE (Registro de TWCLIENTES)
 */
class Grupo{
    public $id;
    public $nombre;
    public $nivel;
  
    
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
        $this->id = $registro["id"];
        $this->nombre = $registro["nombre"];
        $this->nivel = $registro["nivel"];
       
    }
    
 
    /**
     *  Regresa el objeto Invitado en una cadena JSON
     *  @return string Json del objeto.
     */
    
    function toString(){
        return json_encode($this);
    }
    
}


