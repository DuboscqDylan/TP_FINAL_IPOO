<?php
include_once "BaseDatos.php";
class Viaje{
    private $idViaje;
    private $destino;
    private $cantMaxPasajeros;
    private $objEmpresa;
    private $objResponsable;
    private $importe;
    private $mensajeOperacion;

    //Metodod Constructor
    public function __construct($objEmpresa=null,$objResponsable=null)
    {
        $this->idViaje=0;
        $this->destino="";
        $this->cantMaxPasajeros=0;
        $this->objEmpresa=$objEmpresa;
        $this->objResponsable=$objResponsable;
        $this->importe=0;
        $this->mensajeOperacion="";
    }

    public function cargar($unDestino, $unaCant, $unaEmpresa, $unResponsable, $unImporte){
        $this->setDestino($unDestino);
        $this->setCantMaxPasajeros($unaCant);
        $this->setEmpresa($unaEmpresa);
        $this->setResponsable($unResponsable);
        $this->setImporte($unImporte);
    }

    //Getters
    public function getIdViaje(){
        return $this->idViaje;
    }
    public function getDestino(){
        return $this->destino;
    }
    public function getCantMaxPasajeros(){
        return $this->cantMaxPasajeros;
    }
    public function getEmpresa(){
        return $this->objEmpresa;
    }
    public function getResponsable(){
        return $this->objResponsable;
    }
    public function getImporte(){
        return $this->importe;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    //Setters
    public function setIdViaje($idviaje){
        $this->idViaje=$idviaje;
    }
    public function setDestino($destino){
        $this->destino=$destino;
    }
    public function setCantMaxPasajeros($cantmaxpasajeros){
        $this->cantMaxPasajeros=$cantmaxpasajeros;
    }
    public function setEmpresa($objEmpresa){
        $this->objEmpresa=$objEmpresa;
    }
    public function setResponsable($objResponsable){
        $this->objResponsable=$objResponsable;
    }
    public function setImporte($importe){
        $this->importe=$importe;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion=$mensajeOperacion;
    }

    //Metodo toString
    public function __toString()
    {
        return
        "ID Viaje: ".$this->getIdViaje()."\n".
        "Empresa: ".$this->getEmpresa()->getIdEmpresa()."\n".
        "Destino: ".$this->getDestino()."\n".
        "Cantidad Maxima de Pasajeros: ".$this->getCantMaxPasajeros()."\n".
        "Responsable: ".$this->getResponsable()->getNombre()." ".$this->getResponsable()->getApellido()."\n".
        "Importe: ".$this->getImporte()."\n";
    }

     public function buscar($idviaje){
        $baseDatos=new BaseDatos();
        $respuesta=false;
        $consulta="Select * from viaje where idviaje= ".$idviaje;
        if ($baseDatos->Iniciar()) {
            if ($baseDatos->Ejecutar($consulta)) {
                if($fila=$baseDatos->Registro()){
                    $empresa = new Empresa();
                    $empresa->buscar($fila['idempresa']);

                    $responsable = new Responsable();
                    $responsable->buscar($fila['rnumeroempleado']);

                    $this->setIdViaje($fila['idviaje']);
                    $this->setDestino($fila['vdestino']);
                    $this->setCantMaxPasajeros($fila['vcantmaxpasajeros']);
                    $this->setEmpresa($empresa);
                    $this->setResponsable($responsable);
                    $this->setImporte($fila['vimporte']);
                    $respuesta = true;
				}else {
                    $this->setMensajeOperacion("No existe viaje con ese ID.");
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
       
        if ($baseDatos->Iniciar()) {
            $consultaInsertar="INSERT INTO viaje(vdestino,vcantmaxpasajeros, idempresa, rnumeroempleado,vimporte) 
            VALUES('".$this->getDestino()."', '".$this->getCantMaxPasajeros()."', ".$this->getEmpresa()->getIdEmpresa().", ".$this->getResponsable()->getNumeroEmpleado().", '".$this->getImporte()."')";
            $id = $baseDatos->devuelveIDInsercion($consultaInsertar);
            if ($id != null) {
                $this->setIdViaje($id);
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
            $consultaModificar="UPDATE viaje SET vdestino= '".$this->getDestino()."', vcantmaxpasajeros= ".$this->getCantMaxPasajeros().
            ", idempresa= ".$this->getEmpresa()->getIdEmpresa().", rnumeroempleado= ".$this->getResponsable()->getNumeroEmpleado().", vimporte= ".$this->getImporte().
            " WHERE idviaje= ".$this->getIdViaje();
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
            $consultaEliminar="DELETE FROM viaje WHERE idviaje=".$this->getIdViaje();
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
        $coleccionViajes=[];
        $consulta="SELECT * FROM viaje";

        if ($baseDatos->Iniciar()) {
            if ($baseDatos->Ejecutar($consulta)) {
                while ($fila=$baseDatos->Registro()) {
                    $empresa=new Empresa();
                    $empresa->buscar($fila['idempresa']);
                    $responsable=new Responsable();
                    $responsable->buscar($fila['rnumeroempleado']);

                    $viaje= new Viaje();
                    $viaje->cargar(
                        $fila['vdestino'],
                        $fila['vcantmaxpasajeros'],
                        $empresa,
                        $responsable,
                        $fila['vimporte']);
                        $viaje->setIdViaje($fila['idviaje']);
                    $coleccionViajes[]=$viaje;
                }
            }else {
                $this->setMensajeOperacion($baseDatos->getError());
            }
        }else {
            $this->setMensajeOperacion($baseDatos->getError());
        }
        return $coleccionViajes;
    }
}