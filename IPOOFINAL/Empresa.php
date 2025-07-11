<?php 
include_once "./BaseDatos.php";
class Empresa{
    private $idempresa;
    private $nombre;
    private $direccion;
    private $mensajeOperacion;

    //Metodo Constructor
    public function __construct()
    {
        $this->idempresa=0;
        $this->nombre="";
        $this->direccion="";
        $this->mensajeOperacion="";
    }

    public function cargar($unNombre, $unaDireccion){
        $this->setNombre($unNombre);
        $this->setDireccion($unaDireccion);
    }

    //Getters
    public function getIdEmpresa(){
        return $this->idempresa;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getDireccion(){
        return $this->direccion;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    //Setters
    public function setIdEmpresa($idempresa){
        $this->idempresa=$idempresa;
    }
    public function setNombre($enombre){
        $this->nombre=$enombre;
    }
    public function setDireccion($edireccion){
        $this->direccion=$edireccion;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion=$mensajeOperacion;
    }

    //Metodo toString
    public function __toString()
    {
        return
        "ID Empresa: ".$this->getIdEmpresa()."\n".
        "Nombre: ".$this->getNombre()."\n".
        "Direccion: ".$this->getDireccion()."\n"; 
    }

    public function buscar($idEmpresa){
        $baseDatos=new BaseDatos();
        $respuesta=false;
        
        $consulta="Select * from empresa where idempresa= ".$idEmpresa;
        if ($baseDatos->Iniciar()) {
            if ($baseDatos->Ejecutar($consulta)) {
                if($fila=$baseDatos->Registro()){					
				    $this->setIdEmpresa($fila['idempresa']);
                    $this->setNombre($fila['enombre']);
                    $this->setDireccion($fila['edireccion']);
                    $respuesta=true;
				}else {
                    $this->setMensajeOperacion("No existe empresa con ese ID.");
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
            $consultaInsertar="INSERT INTO empresa(enombre, edireccion) 
            VALUES('".$this->getNombre()."', '".$this->getDireccion()."')";
            $id=$baseDatos->devuelveIDInsercion($consultaInsertar);
            if ($id!=null) {
                $this->setIdEmpresa($id);
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
            $consultaModificar="UPDATE empresa SET enombre='".$this->getNombre()."',edireccion='".$this->getDireccion().
            "' WHERE idempresa=".$this->getIdEmpresa();
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
            $consultaEliminar="DELETE FROM empresa WHERE idempresa=" . $this->getIdEmpresa() ;
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