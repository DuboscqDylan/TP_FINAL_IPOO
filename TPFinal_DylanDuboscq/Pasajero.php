<?php

Class Pasajero{

    private $pdocumento;
    private $pnombre;
    private $papellido;
    private $ptelefono;
    private $idviaje;
    private $mensajeOperacion;

    public function __construct()
    {
        $this->pnombre = "";
        $this->papellido = "";
        $this->pdocumento = "";
        $this->ptelefono = "";
        $this->idviaje = 0;
    }

    public function cargar($unNombre, $unApellido, $unNroD, $unTelefono, $unId){
        $this->setNombre($unNombre);
        $this->setApellido($unApellido);
        $this->setNumeroDocumento($unNroD);
        $this->setTelefono($unTelefono);
        $this->setIdViaje($unId);
    }

    public function getNombre(){
        return $this->pnombre;
    }

    public function getApellido(){
        return $this->papellido;
    }

    public function getNumeroDocumento(){
        return $this->pdocumento;
    }

    public function getTelefono(){
        return $this->ptelefono;
    }

    public function getIdViaje(){
        return $this->idviaje;
    }

    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    public function setNombre($unNombre){
        $this->pnombre = $unNombre;
    }

    public function setApellido($unApellido){
        $this->papellido = $unApellido;
    }

    public function setNumeroDocumento($unNroD){
        $this->pdocumento = $unNroD;
    }

    public function setTelefono($unTelefono){
        $this->ptelefono = $unTelefono;
    }

    public function setIdViaje($unId){
        $this->idviaje = $unId;
    }

    public function setMensajeOperacion($unMensaje){
        $this->mensajeOperacion = $unMensaje;
    }

    public function __toString()
    {
        return $this->getNombre() . " " . $this->getApellido() . " Nro. documento: " . $this->getNumeroDocumento() . "  telefono: " . $this->getTelefono();
    }

    public function insertar(){
    
        $base = new BaseDatos();
        $resultado = false;
        $consultaInsertar = "INSERT INTO pasajero(pdocumento, pnombre, papellido, ptelefono, idviaje) VALUES ('" . $this->getNumeroDocumento() . "','" . $this->getNombre() . "','" . $this->getApellido() . "','" . $this->getTelefono() . "','" . $this->getIdViaje() . "')";
        
        if($base->Iniciar()){
            if($base->Ejecutar($consultaInsertar)){
                $resultado = true;
            }else{
                $this->setMensajeOperacion($base->getError());
            }
        }else{
            $this->setMensajeOperacion($base->getError());
        }

        return $resultado;
    }

    public function listar($condicion=""){
        
        $arregloPasajero = null;
        $base = new BaseDatos();
        $consultaPasajero = "SELECT * FROM pasajero ";

        if($condicion!=""){
            $consultaPasajero = $consultaPasajero . " WHERE " . $condicion;
        }
        $consultaPasajero = $consultaPasajero . "ORDER BY papellido";

        if($base->Iniciar()){
            if($base->Ejecutar($consultaPasajero)){
                $arregloPasajero = array();
                while($row = $base->Registro()){
                    $unNombre = $row['pnombre'];
                    $unApellido = $row['papellido'];
                    $unNroDoc = $row['pdocumento'];
                    $unTelefono = $row['ptelefono'];
                    $unId = $row['idviaje'];

                    $unPasajero = new Pasajero();
                    $unPasajero->cargar($unNombre,$unApellido,$unNroDoc,$unTelefono,$unId);
                    array_push($arregloPasajero, $unPasajero);
                }
            }else{
                $this->setMensajeOperacion($base->getError());
            }
        }else{
            $this->setMensajeOperacion($base->getError());
        }

        return $arregloPasajero;
    }

    public function buscar($unNroDoc){
        
        $base = new BaseDatos();
        $consultaPasajero = "SELECT * FROM pasajero WHERE pdocumento=".$unNroDoc;
        $resultado = false;

        if($base->Iniciar()){
          
            if($base->Ejecutar($consultaPasajero)){
                if($row=$base->Registro()){
                 
                    $this->setNumeroDocumento($unNroDoc);
                    $this->setNombre($row['pnombre']);
                    $this->setApellido($row['papellido']);
                    $this->setTelefono($row['ptelefono']);
                    $this->setIdViaje($row['idviaje']);
                    $resultado = true;
                }
            }else{
                 $this->setMensajeOperacion($base->getError());
            }
        }else{
            $this->setMensajeOperacion($base->getError());
        }

        return $resultado;
    }
    
    public function modificar(){

        $base = new BaseDatos();
        $consultaModificar = "UPDATE pasajero SET pnombre='" . $this->getNombre() .",'papellido='" . $this->getApellido() . ",'ptelefono='" . $this->getTelefono() . ",'idviaje='" . $this->getIdViaje() . " WHERE pdocumento=" . $this->getNumeroDocumento();
        $resultado = false;
        
        if($base->Iniciar()){
            if($base->Ejecutar($consultaModificar)){
                $resultado = true;
            }else{
            $this->setMensajeOperacion($base->getError());
            }
        }else{
            $this->setMensajeOperacion($base->getError());
        }

        return $resultado;
    }

    public function eliminar(){

        $base = new BaseDatos();
        $resultado = false;

        if($base->Iniciar()){
           
            $consultaEliminar = "DELETE FROM pasajero WHERE pdocumento=" . $this->getNumeroDocumento();
           
            if($base->Ejecutar($consultaEliminar)){
                $resultado = true;
            }else{
                 $this->setMensajeOperacion($base->getError());
            }
        }else{
            $this->setMensajeOperacion($base->getError());
        }

        return $resultado;
    }
}

?>