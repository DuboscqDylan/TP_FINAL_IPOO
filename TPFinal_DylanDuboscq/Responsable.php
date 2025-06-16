<?php

Class Responsable{

    private $rnombre;
    private $rapellido;
    private $rnumeroempleado;
    private $rnumerolicencia;
    private $mensajeoperacion;

    public function __construct()
    {
        $this->rnombre = "";
        $this->rapellido = "";
        $this->rnumeroempleado = "";
        $this->rnumerolicencia = "";
        $this->mensajeoperacion = "";
    }

    public function cargar($unNombre, $unApellido, $unNroLicencia){
        $this->setNombre($unNombre);
        $this->setApellido($unApellido);
        $this->setNumeroLicencia($unNroLicencia);
    }

    public function getNombre(){
        return $this->rnombre;
    }

    public function getApellido(){
        return $this->rapellido;
    }

    public function getNumeroEmpleado(){
        return $this->rnumeroempleado;
    }

    public function getNumeroLicencia(){
        return $this->rnumerolicencia;
    }

    public function getMensajeOperacion(){
        return $this->mensajeoperacion;
    }

    public function setNombre($unNombre){
        $this->rnombre = $unNombre;
    }

    public function setApellido($unApellido){
        $this->rapellido = $unApellido;
    }

    public function setNumeroEmpleado($unNroEmpleado){
        $this->rnumeroempleado = $unNroEmpleado;
    }

    public function setNumeroLicencia($unNroLicencia){
        $this->rnumerolicencia = $unNroLicencia;
    }

    public function setMensajeOperacion($unMensaje){
        $this->mensajeoperacion = $unMensaje;
    }

    public function __toString()
    {
        return $this->getNombre(). " " . $this->getApellido() ." || numero de empleado: " . $this->getNumeroEmpleado() . " Licencia: " . $this->getNumeroLicencia();
    }
    
    public function insertar(){
    
        $base = new BaseDatos();
        $resultado = false;
        $consultaInsertar = "INSERT INTO responsable( rnumerolicencia, rnombre, rapellido) VALUES ('" . $this->getNumeroLicencia() . "','" . $this->getNombre() . "','" . $this->getApellido() . "')";
        
        if($base->Iniciar()){
            if($id = $base->devuelveIDInsercion($consultaInsertar)){
                $this->setNumeroEmpleado($id);
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
        
        $arregloResponsable = null;
        $base = new BaseDatos();
        $consultaResponsable = "SELECT * FROM responsable ";

        if($condicion!=""){
            $consultaResponsable = $consultaResponsable . " WHERE " . $condicion;
        }
        $consultaResponsable = $consultaResponsable . " ORDER BY rapellido";

        if($base->Iniciar()){
            if($base->Ejecutar($consultaResponsable)){
                $arregloResponsable = array();
                while($row = $base->Registro()){
                    $unNombre = $row['rnombre'];
                    $unApellido = $row['rapellido'];
                    $unNroResponsable = $row['rnumeroempleado'];
                    $unNroLicencia = $row['rnumerolicencia'];

                    $unResponsable = new Responsable();
                    $unResponsable->cargar($unNombre,$unApellido,$unNroResponsable,$unNroLicencia);
                    array_push($arregloResponsable, $unResponsable);
                }
            }else{
                $this->setMensajeOperacion($base->getError());
            }
        }else{
            $this->setMensajeOperacion($base->getError());
        }

        return $arregloResponsable;
    } 
    
    public function buscar($unNroEmpleado){
        
        $base = new BaseDatos();
        $consultaResponsable = "SELECT * FROM responsable WHERE rnumeroempleado=".$unNroEmpleado;
        $resultado = false;

        if($base->Iniciar()){
          
            if($base->Ejecutar($consultaResponsable)){
                if($row=$base->Registro()){
                 
                    $this->setNumeroEmpleado($unNroEmpleado);
                    $this->setNombre($row['rnombre']);
                    $this->setApellido($row['rapellido']);
                    $this->setNumeroLicencia($row['rnumerolicencia']);
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
        $consultaModificar = "UPDATE responsable SET rnumerolicencia='". $this->getNumeroLicencia() .",'rnombre= '". $this->getNombre() .",'rapellido='" . $this->getApellido() . " WHERE 'rnumeroempleado='" . $this->getNumeroEmpleado();
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
            
            $consultaEliminar = "DELETE FROM responsable WHERE rnumeroempleado=" . $this->getNumeroEmpleado();
            
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