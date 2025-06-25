<?php
include_once "BaseDatos.php";
Class Pasajero extends Persona{
    private $idpersona;
    private $documento;
    private $nombre;
    private $apellido;
    private $telefono;
    private $mensajeOperacion;
    //Metodo Constructor
    public function __construct()
    {
        parent::__construct();
        $this->documento="";
        $this->telefono="";
    }

    public function cargarPasajero($unNombre, $unApellido,$unDocumento,  $unTelefono){
        parent::cargar($unNombre,$unApellido);
        $this->setNumeroDocumento($unDocumento);
        $this->setTelefono($unTelefono);
    }

    //Getters
    public function getIdPasajero(){
        parent::getIdPersona();
    }

    public function getNombre(){
        return parent::getNombre();
    }

    public function getApellido(){
        return parent::getApellido();
    }

    public function getNumeroDocumento(){
        return $this->documento;
    }

    public function getTelefono(){
        return $this->telefono;
    }

    public function getMensajeOperacion(){
        return parent::getMensajeOperacion();
    }

    //Setters
    public function setIdPasajero($idPasajero){
        parent::setIdPersona($idPasajero);
    }

    public function setNombre($unNombre){
        parent::setNombre($unNombre);
    } 

    public function setApellido($unApellido){
        parent::setApellido($unApellido);
    }

    public function setNumeroDocumento($numeroDocumento){
        $this->documento=$numeroDocumento;
    }

    public function setTelefono($telefono){
        $this->telefono=$telefono;
    }

    public function setMensajeOperacion($unMensaje){
        parent::setMensajeOperacion($unMensaje);
    }

    //Metodo toString
    public function __toString()
    {
        return
        "ID Pasajero: ".$this->getIdPasajero()."\n".
        "Nombre: ".$this->getNombre()."\n".
        "Apellido: ".$this->getApellido()."\n".
        "Numero de Documento: ".$this->getNumeroDocumento()."\n".
        "Telefono: ".$this->getTelefono()."\n";
    }


    public function buscar($idPasajero){
        $baseDatos=new BaseDatos();
        $respuesta=false;
        $consulta="Select * from pasajero where idpersona= ".$idPasajero;
        if ($baseDatos->Iniciar()) {
            if ($baseDatos->Ejecutar($consulta)) {
                if($fila=$baseDatos->Registro()){
                    
                    $this->setIdPasajero($fila['idpersona']);
                    $this->setNombre($fila['nombre']);
                    $this->setApellido($fila['apellido']);
                    $this->setNumeroDocumento($fila['documento']);
                    $this->setTelefono($fila['telefono']);
                    $respuesta=true;
				}else {
                    $this->setMensajeOperacion("No existe Pasajero con ese ID.");
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
            $consultaInsertar="INSERT INTO pasajero(idpersona,documento, nombre, apellido, telefono) 
            VALUES('".$this->getIdPersona()."','".$this->getNumeroDocumento()."', '".$this->getNombre()."', '".$this->getApellido()."', ".$this->getTelefono().")";
          /*  $id=$baseDatos->devuelveIDInsercion($consultaInsertar);
            if ($id!=null) {
                $this->setIdPasajero($this->getIdPersona());
                $respuesta=true;
            }else {
                $this->setMensajeOperacion($baseDatos->getError());
            } */
            if($baseDatos->Ejecutar($consultaInsertar)){
                $this->setIdPasajero($this->getIdPersona());
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
                $consultaModificar="UPDATE pasajero SET documento= '".$this->getNumeroDocumento()."', nombre= '".$this->getNombre().
                "', apellido= '".$this->getApellido()."', telefono= ".$this->getTelefono().
                " WHERE idpersona= ".$this->getIdPasajero();
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
                $consultaEliminar="DELETE FROM pasajero WHERE idpersona=".$this->getIdPersona();
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
        $coleccionPasajeros=[];
        $consulta="SELECT * FROM pasajero";

        if ($baseDatos->Iniciar()) {
            if ($baseDatos->Ejecutar($consulta)) {
                while ($fila=$baseDatos->Registro()) {
                    $pasajero=new Pasajero();
                    $pasajero->cargar(
                        $fila['documento'], 
                        $fila['nombre'], 
                        $fila['apellido'], 
                        $fila['telefono']
                    );
                    $pasajero->setIdPasajero($fila['idpersona']);
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
