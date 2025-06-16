<?php

include_once './BaseDatos.php';

Class Empresa{


    private $idempresa;
    private $enombre;
    private $edireccion;
    private $mensajeoperacion;

    public function _construct(){
        $this->idempresa = 0;
        $this->enombre = "";
        $this->edireccion = "";
        $this->mensajeoperacion = "";
    }

    public function cargar($unNombre, $unaDireccion){
        $this->setNombre($unNombre);
        $this->setDireccion($unaDireccion);
    }

    public function getId(){
        return $this->idempresa;
    }

    public function getNombre(){
        return $this->enombre;
    }

    public function getDireccion(){
        return $this->edireccion;
    }

    public function getMensajeOperacion(){
        return $this->mensajeoperacion;
    }

    public function setId($unId){
        $this->idempresa = $unId;
    }

    public function setNombre($unNombre){
        $this->enombre = $unNombre;
    }

    public function setDireccion($unaDireccion){
        $this->edireccion = $unaDireccion;
    }

    public function setMensajeOperacion($unMensaje){
        $this->mensajeoperacion  = $unMensaje;
    }

    public function __toString()
    {
        return "Id " . $this->getId() . ": " . $this->getNombre() . ", " . $this->getDireccion();
    }
    
    public function insertar(){
    
        $base = new BaseDatos();
        $resultado = false;
        $consultaInsertar = "INSERT INTO empresa(enombre, edireccion) VALUES ('" . $this->getNombre() . "','" . $this->getDireccion() . "')";
        
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
        
        $base = new BaseDatos();
        $consultaEmpresa = "SELECT * FROM empresa ";

        if($condicion!=""){
            $consultaEmpresa = $consultaEmpresa . "WHERE " . $condicion;
        }
        $consultaEmpresa = $consultaEmpresa . "ORDER BY idempresa";

        if($base->Iniciar()){
            if($base->Ejecutar($consultaEmpresa)){
                $arregloEmpresa = array();
                while($row2 = $base->Registro()){
                    $unNombre = $row2['enombre'];
                    $unaDireccion = $row2['edireccion'];
                    $unId = $row2['idempresa'];

                    $unaEmpresa = new Empresa();
                    $unaEmpresa->cargar($unId, $unNombre, $unaDireccion);
                    array_push($arregloEmpresa, $unaEmpresa);
                }
            }else{
                $this->setMensajeOperacion($base->getError());
            }
        }else{
            $this->setMensajeOperacion($base->getError());
        }

        return $arregloEmpresa;
    }

    public function buscar($unId){
        
        $base = new BaseDatos();
        $consultaEmpresa = "SELECT * FROM empresa WHERE idempresa=".$unId;
        $resultado = false;

        if($base->Iniciar()){
          
            if($base->Ejecutar($consultaEmpresa)){
                if($row=$base->Registro()){
                 
                    $this->setId($unId);
                    $this->setNombre($row['enombre']);
                    $this->setDireccion($row['edireccion']);
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
        $consultaModificar = "UPDATE empresa SET enombre='" . $this->getNombre() ."',edireccion='" . $this->getDireccion() . "' WHERE idempresa=" . $this->getId();
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
           
            $consultaEliminar = "DELETE FROM empresa WHERE idempresa='" . $this->getId() . "'";
           
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