<?php

include_once './Empresa.php';
include_once './Responsable.php';
include_once './Pasajero.php';
include_once './Viaje.php';

$empresaV = new Empresa();
$empresaV->cargar("Empresa Vuelo", "San Martin 123");
$empresaA = new Empresa();
$empresaA->cargar("Empresa Aterrizaje", "Mitre 456");

$empresaV->insertar();
$empresaA->insertar();
/*
$colEmpresas = $empresaV->listar();
foreach($colEmpresas as $empresa){
    echo $empresa . "\n";
    echo "*-------------------------------------------------* \n";
}*/

$responsableUno = new Responsable();
$responsableUno->cargar("Juan", "Juanales",1);

$responsableDos = new Responsable();
$responsableDos->cargar("Martina","Martinez",2);

$responsableTres = new Responsable();
$responsableTres->cargar("Pedro", "Piedrita",3);

$responsableUno->insertar();
$responsableDos->insertar();
$responsableTres->insertar();
/*
$colResponsables = $responsableUno->listar();
foreach($colResponsables as $responsable){
    echo $responsable . "\n";
    echo "*-------------------------------------------------* \n";
}*/

$viajeA = new Viaje();
$viajeA->cargar("Seychelles", 3, $empresaV->getId(), $responsableUno->getNumeroEmpleado(),150000);
$viajeB = new Viaje();
$viajeB->cargar("Bahamas",100,$empresaV->getId(),$responsableUno->getNumeroEmpleado(), 130000);
$viajeC = new Viaje();
$viajeC->cargar("Manila",90,$empresaV->getId(),$responsableDos->getNumeroEmpleado(),165000);
$viajeD = new Viaje();
$viajeD->cargar("Buenos Aires", 95, $empresaA->getId(), $responsableTres->getNumeroEmpleado(),85000);
$viajeE = new Viaje();
$viajeE->cargar("Neuquen", 70, $empresaA->getId(),$responsableTres->getNumeroEmpleado(),60000);
$viajeF = new Viaje();
$viajeF->cargar("Ushuaia", 65, $empresaA->getId(),$responsableTres->getNumeroEmpleado(),70000);

$viajeA->insertar();
$viajeB->insertar();
$viajeC->insertar();
$viajeD->insertar();
$viajeE->insertar();
$viajeF->insertar();

/*
$colViajes = $viajeA->listar();
foreach($colViajes as $viaje){
    echo $viaje . "\n";
    echo "*-------------------------------------------------* \n";
}*/

$pasajeroUno = new Pasajero();
$pasajeroUno->cargar("Carmen","Carmín",27797393, 2991231234,$viajeA->getId());
$pasajeroDos = new Pasajero();
$pasajeroDos->cargar("Luis", "Lucero", 38868451,2984569871,$viajeB->getId());
$pasajeroTres = new Pasajero();
$pasajeroTres->cargar("Isabel", "Velero", 18479361,2991002003,$viajeC->getId());
$pasajeroCuatro = new Pasajero();
$pasajeroCuatro->cargar("Laura", "Laurel", 43589741,2995558883 ,$viajeA->getId());
$pasajeroCinco = new Pasajero();
$pasajeroCinco->cargar("Pablo", "Clavo", 20341123, 2985156669, $viajeA->getId());

$pasajeroUno->insertar();
$pasajeroDos->insertar();
$pasajeroTres->insertar();
$pasajeroCuatro->insertar();
$pasajeroCinco->insertar();
/*
$colPasajeros = $pasajeroUno->listar();
foreach($colPasajeros as $pasajero){
    echo $pasajero . "\n";
    echo "*-------------------------------------------------* \n";
}*/

do{
    mostrarMenu();
    $opcion = trim(fgets(STDIN));
    switch($opcion){
        
        case 1:
        
            echo "Ingrese el nombre de la empresa: \n";
            $nombreE = trim(fgets(STDIN));
            echo "Ingrese la direccion de la empresa: \n";
            $direccionE = trim(fgets(STDIN));
            $nuevaEmpresa = new Empresa();
            $nuevaEmpresa->cargar($nombreE, $direccionE);
            if($nuevaEmpresa->insertar()){
                echo "La empresa a sido registrada con exito. \n";
            }else{
                echo $nuevaEmpresa->getMensajeOperacion() . "\n";
            }
        break;
        
        case 2:
        
            echo "Ingrese el id de la empresa cuyos datos desea modificar: \n";
            $idE = trim(fgets(STDIN));
            $empresa = new Empresa();
            if($empresa->buscar($idE)){
                echo "La empresa existe en el sistema. Ingrese los nuevos datos. \n";
                echo "Nuevo nombre: \n";
                $nuevoNombre = trim(fgets(STDIN));
                echo "Nueva direccion: \n";
                $nuevaDireccion = trim(fgets(STDIN));
                $empresa->setNombre($nuevoNombre);
                $empresa->setDireccion($nuevaDireccion);
                $empresa->modificar();
            }else{
                echo $empresa->getMensajeOperacion() . "\n";
            }
        break;
        
        case 3:
        
            echo "Ingrese el id de la empresa cuyos datos desea eliminar: \n";
            $idE = trim(fgets(STDIN));
            $empresa = new Empresa();
            if($empresa->buscar($idE)){
                echo "La empresa existe en el sistema, será eliminada. \n";
                if($empresa->eliminar()){
                    echo "La empresa fue eliminada de la BD con éxito. \n";
                }else{
                    echo $empresa->getMensajeOperacion() . "\n";
                }
            }else{
                $empresa->getMensajeOperacion() . "\n";
            }
        break;
   
        case 4:
       
            echo "Ingrese el destino del viaje: \n";
            $destinoV = trim(fgets(STDIN));
            echo "Ingrese la capacidad máxima de pasajeros: \n";
            $cantMaxP = trim(fgets(STDIN));
            echo "Ingrese el importe: \n";
            $importeV = trim(fgets(STDIN));
            do{
            echo "Ingrese el id de la empresa que proporciona el viaje: \n";
            $idE = trim(fgets(STDIN));
            $empresa = new Empresa();
        
            if($empresa->buscar($idE)){
                $seguir = true;
            }else{
                echo "La empresa que menciona no existe en la BD, intente otra vez. \n";
                $seguir = false;
            }
                
            }while(!$seguir);
            
            do{
            echo "Ingrese el id del Responsable del viaje: \n";
            $idR = trim(fgets(STDIN));
            $responsable = new Responsable();
    
            if($responsable->buscar($idR)){
                $seguir = true;
            }else{
                echo "El responsable que menciona no existe en la BD, intente otra vez \n";
                $seguir = false;
            }
            
            }while(!$seguir);
            
            $viaje = new Viaje();
            $viaje->cargar($destinoV,$cantMaxP,$idE,$idR,$importeV);
            if($viaje->insertar()){
                echo "El viaje ha sido registrado con exito \n";
            }else{
                $viaje->getMensajeOperacion();
            }
        break;
        
        case 5:
            echo "Ingrese el id del viaje cuyos datos quiere modificar: \n";
            $idV = trim(fgets(STDIN));
            $viaje = new Viaje();

            if($viaje->buscar($idV)){
                echo "El viaje existe en la BD, ingrese los nuevos datos. \n";
                echo "Ingrese el destino: \n";
                $destinoV = trim(fgets(STDIN));
                echo "Ingrese la cantidad maxima de pasajeros: \n";
                $cantMaxP = trim(fgets(STDIN));
                echo "Ingrese el importe: \n";
                $importeV = trim(fgets(STDIN));
              
                do{
                    echo "Ingrese el id del Responsable del viaje: \n";
                    $idR = trim(fgets(STDIN));
                    $responsable = new Responsable();
    
                if($responsable->buscar($idR)){
                    $seguir = true;
                }else{
                    echo "El responsable que menciona no existe en la BD, intente otra vez \n";
                    $seguir = false;
                }
                }while(!$seguir);   
                
                do{
                echo "Ingrese el id de la empresa que proporciona el viaje: \n";
                $idE = trim(fgets(STDIN));
                $empresa = new Empresa();
            
                if($empresa->buscar($idE)){
                    $seguir = true;
                }else{
                    echo "La empresa que menciona no existe en la BD, intente otra vez. \n";
                    $seguir = false;
                }
                }while(!$seguir);

                $viaje->setDestino($destinoV);
                $viaje->setCantMaxPasajeros($cantMaxP);
                $viaje->setImporte($importeV);
                $viaje->setIdEmpresa($idE);
                $viaje->setNroEmpleado($idR);
                if($viaje->modificar()){
                    echo "Los datos fueron modificados con éxito. \n";
                }else{
                    echo $viaje->getMensajeOperacion() . "\n";
                }
                    
            }else{
                echo $viaje->getMensajeOperacion();
            }
        break;
        
        case 6:
            echo "Ingrese el id del viaje cuyos datos desea eliminar: \n";
            $idV = trim(fgets(STDIN));
            $viaje = new Viaje();
            if($viaje->buscar($idV)){
                echo "El viaje existe en la BD, será eliminado. \n";
                if($viaje->eliminar()){
                    echo "El viaje fue eliminado con éxito. \n";
                }else{
                    echo $viaje->getMensajeOperacion() . "\n";
                }
            }
        break;

    }
}while($opcion != 0);





function mostrarMenu(){
    
    echo "\n *-------------------------------------------------* \n";
    echo "1) Ingresar datos de una nueva Empresa. \n";
    echo "2) Modificar datos de una Empresa existente. \n";
    echo "3) Eliminar los datos de una Empresa existente. \n";
    echo "*-------------------------------------------------* \n";
    echo "4) Ingresar datos de un nuevo Viaje. \n";
    echo "5) Modificar datos de un Viaje existente. \n";
    echo "6) Eliminar los datos de un Viaje existente. \n";
    echo "*-------------------------------------------------* \n";

}

?>