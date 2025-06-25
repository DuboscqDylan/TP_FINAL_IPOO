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
        return "ID Viaje: ".$this->getObjViaje()->getIdViaje()." - Destino: ".$this->getObjViaje()->getDestino()."\n".
        "ID Pasajero: ".$this->getObjPasajero()->getIdPersona()." - DNI: ".$this->getObjPasajero()->getNumeroDocumento()."\n";
    }

    public function insertar(){
        $baseDatos=new BaseDatos();
        $respuesta=false;
        $idViaje=$this->getObjViaje()->getIdViaje();
        $idPersona=$this->getObjPasajero()->getIdPersona();

        if ($baseDatos->Iniciar()) {
            $consultaInsertar="INSERT INTO viaje_pasajero(idviaje, idpersona) VALUES('".$idViaje."','".$idPersona."')";
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
        $condicion= "WHERE idpersona = $id";
    }

    $consulta = "SELECT * FROM viaje_pasajero $condicion";

    if ($baseDatos->Iniciar()) {
        if ($baseDatos->Ejecutar($consulta)) {
            while ($fila = $baseDatos->Registro()) {
                $viaje = new Viaje();
                $viaje->buscar($fila['idviaje']);

                $pasajero = new Pasajero();
                $pasajero->buscar($fila['idpersona']);

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
        $idPasajero=$this->getObjPasajero()->getIdPersona();
        if ($baseDatos->Iniciar()) {
            $consultaEliminar="DELETE FROM viaje_pasajero WHERE idviaje=".$idViaje." AND idpersona=".$idPasajero;
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