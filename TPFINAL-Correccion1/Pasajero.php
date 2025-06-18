<?php
include_once "BaseDatos.php";
class Pasajero{
    private $idPasajero;
    private $documento;
    private $nombre;
    private $apellido;
    private $telefono;
    private $objViaje;
    private $mensajeOperacion;
    //Metodo Constructor
    public function __construct()
    {
        $this->idPasajero=0;
        $this->nombre="";
        $this->apellido="";
        $this->documento="";
        $this->telefono="";
    }

    public function cargar($unNombre, $unApellido, $unDocumento, $unTelefono, $unViaje){
        $this->nombre = $unNombre;
        $this->apellido = $unApellido;
        $this->documento = $unDocumento;
        $this->telefono = $unTelefono;        
        $this->objViaje = $unViaje;
    }

    //Getters
    public function getIdPasajero(){
        return $this->idPasajero;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getApellido(){
        return $this->apellido;
    }
    public function getNumeroDocumento(){
        return $this->documento;
    }
    public function getTelefono(){
        return $this->telefono;
    }
    public function getObjViaje(){
        return $this->objViaje;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    //Setters
    public function setIdPasajero($idPasajero){
        $this->idPasajero=$idPasajero;
    }
    public function setNombre($nombre){
        $this->nombre=$nombre;
    }
    public function setApellido($apellido){
        $this->apellido=$apellido;
    }
    public function setNumeroDocumento($numeroDocumento){
        $this->documento=$numeroDocumento;
    }
    public function setTelefono($telefono){
        $this->telefono=$telefono;
    }
    public function setObjViaje($objViaje){
        $this->objViaje=$objViaje;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion=$mensajeOperacion;
    }

    //Metodo toString
    public function __toString()
    {
        if ($this->getObjViaje()==null) {
            $id="Todavia no se le asigna viaje.";
        }else {
            $id=$this->getObjViaje()->getIdViaje();
        }
        return
        "ID Pasajero: ".$this->getIdPasajero()."\n".
        "Nombre: ".$this->getNombre()."\n".
        "Apellido: ".$this->getApellido()."\n".
        "Numero de Documento: ".$this->getNumeroDocumento()."\n".
        "Telefono: ".$this->getTelefono()."\n".
        "ID Viaje: ".$id."\n";
    }


    public function buscar($idPasajero){
        $baseDatos=new BaseDatos();
        $respuesta=false;
        $consulta="Select * from pasajero where idpasajero= ".$idPasajero;
        if ($baseDatos->Iniciar()) {
            if ($baseDatos->Ejecutar($consulta)) {
                if($fila=$baseDatos->Registro()){					
                    $objViaje = new Viaje();
                    $objViaje->buscar($fila['idviaje']);
                    
                    $this->setIdPasajero($fila['idpasajero']);
                    $this->setNombre($fila['pnombre']);
                    $this->setApellido($fila['papellido']);
                    $this->setNumeroDocumento($fila['pdocumento']);
                    $this->setTelefono($fila['ptelefono']);
                    $this->setObjViaje($objViaje);
                    $respuesta=true;
				}else {
                    $this->setMensajeOperacion($baseDatos->getError());
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
        $viaje=$this->getObjViaje();
        if ($viaje->puedeAgregarPasajero()) {
            if ($baseDatos->Iniciar()) {
                $consultaInsertar="INSERT INTO pasajero(pdocumento,pnombre, papellido, ptelefono,idviaje) 
                VALUES('".$this->getNumeroDocumento()."', '".$this->getNombre()."', '".$this->getApellido()."', ".$this->getTelefono().", ".$this->getObjViaje()->getIdViaje().")";
                $id=$baseDatos->devuelveIDInsercion($consultaInsertar);
                if ($id!=null) {
                    $this->setIdPasajero($id);
                    $respuesta=true;
                }else {
                    $this->setMensajeOperacion($baseDatos->getError());
                }
            }else {
                $this->setMensajeOperacion($baseDatos->getError());
            }
        } else {
            $this->setMensajeOperacion("Se alcanzo la capacidad maxima de pasajeros para el viaje.");
        }
        return $respuesta;
    }

    public function modificar(){
        $baseDatos=new BaseDatos();
        $respuesta=false;
        
        if ($baseDatos->Iniciar()) {
            $consultaModificar="UPDATE pasajero SET pdocumento= '".$this->getNumeroDocumento()."', pnombre= '".$this->getNombre().
            "', papellido= '".$this->getApellido()."', ptelefono= ".$this->getTelefono().", idviaje= ".$this->getObjViaje()->getIdViaje().
            " WHERE idpasajero= ".$this->getIdPasajero();
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
            $consultaEliminar="DELETE FROM pasajero WHERE idpasajero=".$this->getIdPasajero();
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
        $coleccionPasajeros=[];
        $consulta="SELECT * FROM pasajero";

        if ($baseDatos->Iniciar()) {
            if ($baseDatos->Ejecutar($consulta)) {
                while ($fila=$baseDatos->Registro()) {
                    $objViaje = new Viaje();
                    $objViaje->buscar($fila['idviaje']);
                    $pasajero = new Pasajero($fila['pnombre'], $fila['papellido'], $fila['pdocumento'], $fila['ptelefono'], $objViaje);
                    $pasajero->setIdPasajero($fila['idpasajero']);
                    $coleccionPasajeros[]=$pasajero;
                }
            }else {
                $this->setMensajeOperacion($baseDatos->getError());
            }
        }else {
            $this->setMensajeOperacion($baseDatos->getError());
        }
        return $coleccionPasajeros;
    }
}