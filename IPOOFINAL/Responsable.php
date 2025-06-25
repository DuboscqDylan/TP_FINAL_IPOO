<?php
include_once "BaseDatos.php";
class Responsable extends Persona{
    private $idPersona;
    private $numeroLicencia;
    private $nombre;
    private $apellido;
    private $mensajeOperacion;

    //Metodo Constructor
    public function __construct()
    {
        parent::__construct();
        $this->numeroLicencia=0;
    }

    public function cargarResponsable($unaLicencia, $unNombre, $unApellido){
        parent::cargar($unNombre, $unApellido);
        $this->setNumeroLicencia($unaLicencia);
    }

    //Getters

    public function getIdResponsable(){
        parent::getIdPersona();
    }

    public function getNumeroLicencia(){
        return $this->numeroLicencia;
    }
    public function getNombre(){
        parent::getNombre();
    }
    public function getApellido(){
        parent::getApellido();
    }
    public function getMensajeOperacion(){
        parent::getMensajeOperacion();
    }

    //Setters

    public function setNumeroLicencia($numeroLicencia){
        $this->numeroLicencia=$numeroLicencia;
    }
    public function setNombre($unNombre){
        parent::setNombre($unNombre);
    }
    public function setApellido($unApellido){
        parent::setApellido($unApellido);
    }
    public function setMensajeOperacion($unMensaje){
        parent::setMensajeOperacion($unMensaje);
    }
    public function setIdResponsable($unId){
        parent::setIdPersona($unId);
    }

    //Metodo toString
    public function __toString()
    {
        return
        "Numero de Licencia: ".$this->getNumeroLicencia()."\n".
        "Nombre: ".$this->getNombre()."\n".
        "Apellido: ".$this->getApellido()."\n";
    }


     public function buscar($idPersona){
        $baseDatos=new BaseDatos();
        $respuesta=false;

        $consulta="Select * from responsable where idpersona= ".$idPersona;
        if ($baseDatos->Iniciar()) {
            if ($baseDatos->Ejecutar($consulta)) {
                if($fila=$baseDatos->Registro()){
                    $this->cargarResponsable($fila['numerolicencia'],$fila['nombre'],$fila['apellido']);
                    $respuesta=true;
				}else {
                    $this->setMensajeOperacion("No existe Responsable con ese ID.");
                }
            }else {
                $this->setMensajeOperacion($baseDatos->getError());
            }
        }else {
            $this->setMensajeOperacion($baseDatos->getError());
        }
        return $respuesta;
    }
    
    public function insertar(){
        $baseDatos=new BaseDatos();
        $respuesta=false;

        if(parent::insertar()){
            if ($baseDatos->Iniciar()) {
                $consultaInsertar="INSERT INTO responsable(idpersona,numerolicencia, nombre, apellido) 
                VALUES('". $this->getIdPersona()."','".$this->getNumeroLicencia()."', '".$this->getNombre()."', '".$this->getApellido()."')";
            /*    $id=$baseDatos->devuelveIDInsercion($consultaInsertar);
                if ($id!=null) {
                    $this->setIdResponsable($this->getIdPersona());
                    $respuesta=true;
                }else {
                    $this->setMensajeOperacion($baseDatos->getError());
                } */
            if($baseDatos->Ejecutar($consultaInsertar)){
                $this->setIdResponsable($this->getIdPersona());
                $respuesta = true;
            }else{
                $this->setMensajeOperacion($baseDatos->getError());
            }
            }else {
                $this->setMensajeOperacion($baseDatos->getError());
            }
        }else{
            $this->setMensajeOperacion(parent::getMensajeOperacion());
        }
        return $respuesta;
    }

    public function modificar(){
        $baseDatos=new BaseDatos();
        $respuesta=false;
        
            if ($baseDatos->Iniciar()) {
                $consultaModificar="UPDATE responsable SET numerolicencia= '".$this->getNumeroLicencia()."', nombre= '".$this->getNombre().
                "', apellido= '".$this->getApellido()."' WHERE idpersona = ".$this->getIdResponsable();
                if ($baseDatos->Ejecutar($consultaModificar)) {
                    if(parent::modificar()){
                        $respuesta=true;
                    }else{
                        $this->setMensajeOperacion(parent::getMensajeOperacion());
                    }
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
                $consultaEliminar="DELETE FROM responsable WHERE idpersona=".$this->getIdPersona();
                if ($baseDatos->Ejecutar($consultaEliminar)) {
                    if(parent::eliminar()){
                    $respuesta=true;
                    }else{
                        $this->setMensajeOperacion(parent::getMensajeOperacion());
                    }
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
        $coleccionResponsable=[];
        $consulta="SELECT * FROM responsable";

        if ($baseDatos->Iniciar()) {
            if ($baseDatos->Ejecutar($consulta)) {
                while ($fila=$baseDatos->Registro()) {
                    
                    $responsable=new Responsable();
                    $responsable->cargarResponsable($fila['numerolicencia'],$fila['nombre'],$fila['apellido']);
                    $coleccionResponsable[]=$responsable;
                }
            }else {
                $this->setMensajeOperacion($baseDatos->getError());
            }
        }else {
            $this->setMensajeOperacion($baseDatos->getError());
        }
        return $coleccionResponsable;
    }
}