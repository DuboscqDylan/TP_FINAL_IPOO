<?php
include_once "BaseDatos.php";
class Responsable{
    private $numeroEmpleado;
    private $numeroLicencia;
    private $nombre;
    private $apellido;
    private $mensajeOperacion;

    //Metodo Constructor
    public function __construct()
    {
        $this->numeroEmpleado=0;
        $this->numeroLicencia=0;
        $this->nombre="";
        $this->apellido="";
    }

    public function cargar($unaLicencia, $unNombre, $unApellido){
        $this->numeroLicencia = $unaLicencia;
        $this->nombre = $unNombre;
        $this->apellido = $unApellido;
    }

    //Getters
    public function getNumeroEmpleado(){
        return $this->numeroEmpleado;
    }
    public function getNumeroLicencia(){
        return $this->numeroLicencia;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getApellido(){
        return $this->apellido;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    //Setters
    public function setNumeroEmpleado($numeroEmpleado){
        $this->numeroEmpleado=$numeroEmpleado;
    }
    public function setNumeroLicencia($numeroLicencia){
        $this->numeroLicencia=$numeroLicencia;
    }
    public function setNombre($nombre){
        $this->nombre=$nombre;
    }
    public function setApellido($apellido){
        $this->apellido=$apellido;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion=$mensajeOperacion;
    }

    //Metodo toString
    public function __toString()
    {
        return
        "Numero de Empleado: ".$this->getNumeroEmpleado()."\n".
        "Numero de Licencia: ".$this->getNumeroLicencia()."\n".
        "Nombre: ".$this->getNombre()."\n".
        "Apellido: ".$this->getApellido()."\n";
    }


     public function buscar($numeroEmpleado){
        $baseDatos=new BaseDatos();
        $responsable=null;
        $consulta="Select * from responsable where rnumeroempleado= ".$numeroEmpleado;
        if ($baseDatos->Iniciar()) {
            if ($baseDatos->Ejecutar($consulta)) {
                if($fila=$baseDatos->Registro()){					
                    $responsable=new Responsable($fila['rnumerolicencia'],$fila['rnombre'],$fila['rapellido']);
				    $responsable->setNumeroEmpleado($fila['rnumeroempleado']);
				}else {
                    $this->setMensajeOperacion($baseDatos->getError());
                }
            }else {
                $this->setMensajeOperacion($baseDatos->getError());
            }
        }else {
            $this->setMensajeOperacion($baseDatos->getError());
        }
        return $responsable;
    }
    
    public function insertar(){
        $baseDatos=new BaseDatos();
        $respuesta=false;

        if ($baseDatos->Iniciar()) {
            $consultaInsertar="INSERT INTO responsable(rnumerolicencia,rnombre, rapellido) 
            VALUES('".$this->getNumeroLicencia()."', '".$this->getNombre()."', '".$this->getApellido()."')";
            $id=$baseDatos->devuelveIDInsercion($consultaInsertar);
            if ($id!=null) {
                $this->setNumeroEmpleado($id);
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
            $consultaModificar="UPDATE responsable SET rnumerolicencia= ".$this->getNumeroLicencia().", rnombre= '".$this->getNombre().
            "', rapellido= '".$this->getApellido()."'".
            " WHERE rnumeroempleado= ".$this->getNumeroEmpleado();
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
            $consultaEliminar="DELETE FROM responsable WHERE rnumeroempleado=".$this->getNumeroEmpleado();
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
        $coleccionResponsable=[];
        $consulta="SELECT * FROM responsable";

        if ($baseDatos->Iniciar()) {
            if ($baseDatos->Ejecutar($consulta)) {
                while ($fila=$baseDatos->Registro()) {
                    $responsable=new Responsable($fila['rnumerolicencia'],$fila['rnombre'],$fila['rapellido']);
                    $responsable->setNumeroEmpleado($fila['rnumeroempleado']);
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