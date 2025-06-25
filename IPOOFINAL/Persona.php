<?php
include_once "BaseDatos.php";
Class Persona{

    private $idpersona;
    private $nombre;
    private $apellido;
    private $mensajeOperacion;

    public function __construct()
    {
        $this->nombre = "";
        $this->apellido = "";
        $this->idpersona = 0;
        $this->mensajeOperacion = "";
    }

    public function cargar($unNombre, $unApellido){
        $this->setNombre($unNombre);
        $this->setApellido($unApellido);
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getApellido(){
        return $this->apellido;
    }

    public function getIdPersona(){
        return $this->idpersona;
    }

    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    public function setNombre($unNombre){
        $this->nombre = $unNombre;
    }

    public function setApellido($unApellido){
        $this->apellido = $unApellido;
    }

    public function setIdPersona($unId){
        $this->idpersona = $unId;
    }

    public function setMensajeOperacion($unMensaje){
        $this->mensajeOperacion = $unMensaje;
    }

    public function __toString()
    {
        return $this->getNombre() . " " . $this->getApellido();
    }

    public function insertar(){
        $baseDatos=new BaseDatos();
        $respuesta=false;

        if ($baseDatos->Iniciar()) {
            $consultaInsertar="INSERT INTO persona(nombre, apellido) 
            VALUES('".$this->getNombre()."', '".$this->getApellido()."')";
            $id=$baseDatos->devuelveIDInsercion($consultaInsertar);
            if ($id!=null) {
                $this->setIdPersona($id);
                $respuesta=true;
            }else {
                $this->setMensajeOperacion($baseDatos->getError());
            }
        }else {
            $this->setMensajeOperacion($baseDatos->getError());
        }
        return $respuesta;
    }

    public function modificar(){
        $baseDatos=new BaseDatos();
        $respuesta=false;
        
        if ($baseDatos->Iniciar()) {
            $consultaModificar="UPDATE persona SET nombre= '".$this->getNombre()."', apellido= '".$this->getApellido().
                "' WHERE idPersona = ".$this->getIdPersona();
            if ($baseDatos->Ejecutar($consultaModificar)) {
                $respuesta=true;
            }else {
                $this->setMensajeOperacion($baseDatos->getError());
            }
        }else {
            $this->setMensajeOperacion($baseDatos->getError());
        }
        return $respuesta;
    }

    public function eliminar(){
        $baseDatos=new BaseDatos();
        $respuesta=false;

        if ($baseDatos->Iniciar()) {
            $consultaEliminar="DELETE FROM persona WHERE idPersona=".$this->getIdPersona();
            if ($baseDatos->Ejecutar($consultaEliminar)) {
                $respuesta=true;
            }else {
                $this->setMensajeOperacion($baseDatos->getError());
            }
        }else {
            $this->setMensajeOperacion($baseDatos->getError());
        }
        return $respuesta;
    }

    public function listar(){
        $baseDatos=new BaseDatos();
        $coleccionPersona=[];
        $consulta="SELECT * FROM persona";

        if ($baseDatos->Iniciar()) {
            if ($baseDatos->Ejecutar($consulta)) {
                while ($fila=$baseDatos->Registro()) {
                    
                    $persona = new Persona();
                    $persona->cargar($fila['nombre'],$fila['apellido']);
                    $persona->setIdPersona($fila['idpersona']);
                    $coleccionPersona[]=$persona;
                }
            }else {
                $this->setMensajeOperacion($baseDatos->getError());
            }
        }else {
            $this->setMensajeOperacion($baseDatos->getError());
        }
        return $coleccionPersona;
    }
}

?>