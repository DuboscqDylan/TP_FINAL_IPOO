<?php
include_once "BaseDatos.php";
class ViajePasajero{
    private $objViaje;
    private $objPasajero;
    private $mensajeOperacion;

    public function __construct($objViaje=null,$objPasajero=null)
    {
        $this->objViaje=$objViaje;
        $this->objPasajero=$objPasajero;
        $this->mensajeOperacion="";
    }

    public function cargar($objViaje,$objPasajero){
        $this->setObjViaje($objViaje);
        $this->setObjPasajero($objPasajero);
    }

    //Getters
    public function getObjViaje(){
        return $this->objViaje;
    }
    public function getObjPasajero(){
        return $this->objPasajero;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    //Setters
    public function setObjViaje($objViaje){
        $this->objViaje=$objViaje;
    }
    public function setObjPasajero($objPasajero){
        $this->objPasajero=$objPasajero;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion=$mensajeOperacion;
    }

    //Metodo toString
    public function __toString()
    {
        return "ID Viaje: ".$this->getObjViaje()->getIdViaje()."\n".
        "ID Pasajero: ".$this->getObjPasajero()->getIdPasajero()."\n";
    }

    public function insertar(){
        $baseDatos=new BaseDatos();
        $respuesta=false;
        $idViaje=$this->getObjViaje()->getIdViaje();
        $idPasajero=$this->getObjPasajero()->getIdPasajero();

        if ($baseDatos->Iniciar()) {
            $consultaInsertar="INSERT INTO viaje_pasajero(idviaje, idpasajero) VALUES(".$idViaje.",".$idPasajero.")";
            if ($baseDatos->Ejecutar($consultaInsertar)) {
                $respuesta=true;
            }else {
                $this->setMensajeOperacion($baseDatos->getError());
            }
        }else {
            $this->setMensajeOperacion($baseDatos->getError());
        }
        return $respuesta;
    }

    public function listar($tipo="",$id="") {
    $baseDatos=new BaseDatos();
    $coleccion=[];
    $condicion="";

    if ($tipo=="viaje") {
        $condicion= "WHERE idviaje = $id";
    } elseif ($tipo=="pasajero") {
        $condicion= "WHERE idpasajero = $id";
    }

    $consulta = "SELECT * FROM viaje_pasajero $condicion";

    if ($baseDatos->Iniciar()) {
        if ($baseDatos->Ejecutar($consulta)) {
            while ($fila = $baseDatos->Registro()) {
                $viaje = new Viaje();
                $viaje->buscar($fila['idviaje']);

                $pasajero = new Pasajero();
                $pasajero->buscar($fila['idpasajero']);

                $viajePasajero = new ViajePasajero();
                $viajePasajero->cargar($viaje, $pasajero);
                $coleccion[] = $viajePasajero;
            }
        } else {
            $this->setMensajeOperacion($baseDatos->getError());
        }
    } else {
        $this->setMensajeOperacion($baseDatos->getError());
    }

    return $coleccion;
}

    public function eliminar(){
        $baseDatos=new BaseDatos();
        $respuesta=false;
        $idViaje=$this->getObjViaje()->getIdViaje();
        $idPasajero=$this->getObjPasajero()->getIdPasajero();
        if ($baseDatos->Iniciar()) {
            $consultaEliminar="DELETE FROM viaje_pasajero WHERE idviaje=".$idViaje." AND idpasajero=".$idPasajero;
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
}