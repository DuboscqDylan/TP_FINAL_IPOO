<?php
include_once 'Empresa.php';
include_once 'Viaje.php';
include_once 'Pasajero.php';
include_once 'ResponsableV.php';


$empresa1 = null;
$responsable1 = null;
$viaje1 = null;
function mostrarMenu() {
    echo "\n========= MENÚ DE OPCIONES =========\n";
    echo "1. Insertar Empresa\n";
    echo "2. Insertar Responsable\n";
    echo "3. Insertar Viaje\n";
    echo "4. Insertar Pasajero\n";
    echo "5. Modificar Destino del Viaje\n";
    echo "6. Modificar Dirección de la Empresa\n";
    echo "7. Mostrar Viaje\n";
    echo "8. Salir\n";
    echo "\nSeleccione una opción: ";
}

do {
    mostrarMenu();
    $opcion = trim(fgets(STDIN));

    switch ($opcion) {
        case 1:
			echo "Ingrese Nombre: ";
			$nombre=trim(fgets(STDIN));
			echo "Ingrese Direccion: ";
			$direccion=trim(fgets(STDIN));
            $empresa1 = new Empresa($nombre,$direccion);
            if ($empresa1->insertar()) {
                echo "\nEmpresa insertada:\n".$empresa1."\n";
            } else {
                echo "Error al insertar Empresa: ".$empresa1->getMensajeOperacion()."\n";
            }
            break;

        case 2:
			echo "Ingrese Numero de Licencia:";
			$numeroLicencia=trim(fgets(STDIN));
			echo "Ingrese Nombre: ";
			$nombreR=trim(fgets(STDIN));
			echo "Ingrese Apellido: ";
			$apellidoR=trim(fgets(STDIN));
            $responsable1 = new Responsable($numeroLicencia,$nombreR,$apellidoR);
            if ($responsable1->insertar()) {
                echo "\nResponsable Insertado:\n".$responsable1."\n";
            } else {
                echo "Error al insertar Responsable: ".$responsable1->getMensajeOperacion()."\n";
            }
            break;

        case 3:
            if ($empresa1 && $responsable1) {
				echo "Ingrese Destino: ";
				$destino=trim(fgets(STDIN));
				echo "Ingrese Importe: ";
				$importe=trim(fgets(STDIN));
                $viaje1 = new Viaje($destino, 2, $empresa1, $responsable1, $importe);
                if ($viaje1->insertar()) {
                    echo "\nViaje Insertado:\n".$viaje1."\n";
                } else {
                    echo "\nError al insertar el Viaje: ".$viaje1->getMensajeOperacion()."\n";
                }
            } else {
                echo "Debe insertar Empresa y Responsable primero.\n";
            }
            break;

        case 4:
            if ($viaje1) {
                echo "Ingrese nombre del pasajero: ";
                $nombreP=trim(fgets(STDIN));
                echo "Ingrese apellido del pasajero: ";
                $apellidoP=trim(fgets(STDIN));
                echo "Ingrese documento del pasajero: ";
                $documentoP=trim(fgets(STDIN));
                echo "Ingrese teléfono del pasajero: ";
                $telefonoP=trim(fgets(STDIN));

                $pasajero= new Pasajero($nombreP, $apellidoP, $documentoP, $telefonoP, $viaje1);
                if ($pasajero->insertar()) {
                    echo "\nPasajero Insertado:\n".$pasajero."\n";
                } else {
                    echo "\nError al insertar pasajero: ".$pasajero->getMensajeOperacion()."\n";
                }
            } else {
                echo "\nDebe insertar un viaje primero.\n";
            }
            break;

        case 5:
            if ($viaje1) {
                echo "Ingrese nuevo destino: ";
                $nuevoDestino=trim(fgets(STDIN));
                $viaje1->setDestino($nuevoDestino);
                if ($viaje1->modificar()) {
                    echo "\nDestino del viaje con destino modificado:\n";
                } else {
                    echo "\nError al modificar destino de viaje: ".$viaje1->getMensajeOperacion()."\n";
                }
            } else {
                echo "\nDebe insertar un viaje primero.\n";
            }
            break;

        case 6:
            if ($empresa1) {
                echo "Ingrese nueva dirección para la empresa: ";
                $nuevaDireccion=trim(fgets(STDIN));
                $empresa1->setDireccion($nuevaDireccion);
                if ($empresa1->modificar()) {
                    echo "\nEmpresa con la dirección modificada:\n".$empresa1."\n";
                } else {
                    echo "\nError al modificar dirección de la empresa: ".$empresa1->getMensajeOperacion()."\n";
                }
            } else {
                echo "Debe insertar una empresa primero.\n";
            }
            break;

        case 7:
            if ($viaje1) {
				$viaje1->cargarPasajeros();
                echo "--------- Información del viaje ---------\n";
                echo $viaje1."\n";
            } else {
                echo "No hay un viaje registrado aún.\n";
            }
            break;

        case 8:
            echo "";
            break;

        default:
            echo "Opción inválida. Intente de nuevo.\n";
            break;
    }

} while ($opcion != 8);
?>