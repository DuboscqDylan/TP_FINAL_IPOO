<?php

Class Viaje{

    private $idviaje;
    private $vdestino;
    private $vcantmaxpasajeros;
    private $idempresa;
    private $rnumeroempleado;
    private $vimporte;
    private $mensajeoperacion;

    public function __construct()
    {
        $this->idviaje = 0;
        $this->vdestino = "";
        $this->vcantmaxpasajeros = 0;
        $this->idempresa = 0;
        $this->rnumeroempleado = 0;
        $this->vimporte = 0;
        $this->mensajeoperacion = "";
    }

    public function cargar($unDestino, $unaCant, $unaIdEmpresa, $unNroEmpleado, $unImporte){
        $this->setDestino($unDestino);
        $this->setCantMaxPasajeros($unaCant);
        $this->setIdEmpresa($unaIdEmpresa);
        $this->setNroEmpleado($unNroEmpleado);
        $this->setImporte($unImporte);
    }

    public function getId(){
        return $this->idviaje;
    }

    public function getDestino(){
        return $this->vdestino;
    }

    public function getCantMaxPasajeros(){
        return $this->vcantmaxpasajeros;
    }

    public function getIdEmpresa(){
        return $this->idempresa;
    }

    public function getNroEmpleado(){
        return $this->rnumeroempleado;
    }

    public function getImporte(){
        return $this->vimporte;
    }

    public function getMensajeOperacion(){
        return $this->mensajeoperacion;
    }

    public function setId($unId){
        $this->idviaje = $unId;
    }

    public function setDestino($unDestino){
        $this->vdestino = $unDestino;
    }

    public function setCantMaxPasajeros($unaCant){
        $this->vcantmaxpasajeros = $unaCant;
    }

    public function setIdEmpresa($unaIdEmpresa){
        $this->idempresa = $unaIdEmpresa;
    }

    public function setNroEmpleado($unNroEmpleado){
        $this->rnumeroempleado = $unNroEmpleado;
    }

    public function setImporte($unImporte){
        $this->vimporte = $unImporte;
    }

    public function setMensajeOperacion($unMensaje){
        $this->mensajeoperacion = $unMensaje;
    }

    public function __toString(){
        return "Viaje " . $this->getId() . ": " . $this->getDestino() . " || Importe: " . $this->getImporte() . " || Cantidad maxima de pasajeros: " . $this->getCantMaxPasajeros() . " || Id de la empresa: " . $this->getIdEmpresa() . " || Nro. del responsable: " . $this->getNroEmpleado() ;
    }
    

    public function insertar(){
    
        $base = new BaseDatos();
        $resultado = false;
        $consultaInsertar = "INSERT INTO viaje(vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte) VALUES ('" . $this->getDestino() . "','" . $this->getCantMaxPasajeros() . "','" . $this->getIdEmpresa() . "','" . $this->getNroEmpleado() . "','" . $this->getImporte() . "')";
        
        if($base->Iniciar()){
            if($id = $base->devuelveIDInsercion($consultaInsertar)){
                $this->setId($id);
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
        
        $arregloViaje = null;
        $base = new BaseDatos();
        $consultaViaje = "SELECT * FROM viaje ";

        if($condicion!=""){
            $consultaViaje = $consultaViaje . " WHERE " . $condicion;
        }
        $consultaViaje = $consultaViaje . "ORDER BY idviaje";

        if($base->Iniciar()){
            if($base->Ejecutar($consultaViaje)){
                $arregloViaje = array();
                while($row = $base->Registro()){
                    $unId = $row['idviaje'];
                    $unDestino = $row['vdestino'];
                    $unaCant = $row['vcantmaxpasajeros'];
                    $unaIdEmpresa = $row['idempresa'];
                    $unNroEmpleado = $row['rnumeroempleado'];
                    $unImporte = $row['vimporte'];

                    $unViaje = new Viaje();
                    $unViaje->cargar($unId,$unDestino,$unaCant,$unaIdEmpresa,$unNroEmpleado, $unImporte);
                    array_push($arregloViaje, $unViaje);
                }
            }else{
                $this->setMensajeOperacion($base->getError());
            }
        }else{
            $this->setMensajeOperacion($base->getError());
        }

        return $arregloViaje;
    }

    public function buscar($unId){
        
        $base = new BaseDatos();
        $consultaViaje = "SELECT * FROM viaje WHERE idviaje=".$unId;
        $resultado = false;

        if($base->Iniciar()){
          
            if($base->Ejecutar($consultaViaje)){
                if($row=$base->Registro()){
                 
                    $this->setId($unId);
                    $this->setDestino($row['vdestino']);
                    $this->setCantMaxPasajeros($row['vcantmaxpasajeros']);
                    $this->setIdEmpresa($row['idempresa']);
                    $this->setNroEmpleado($row['rnumeroempleado']);
                    $this->setImporte($row['vimporte']);
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
        $consultaModificar = "UPDATE viaje SET vdestino='" . $this->getDestino() ."',vcantmaxpasajeros='" . $this->getCantMaxPasajeros() . "',idempresa='" . $this->getIdEmpresa() . "',rnumeroempleado='" . $this->getNroEmpleado() . "',vimporte='" . $this->getImporte() . "' WHERE idviaje=" . $this->getId();
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
           
            $consultaEliminar = "DELETE FROM viaje WHERE idviaje=" . $this->getId();
           
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