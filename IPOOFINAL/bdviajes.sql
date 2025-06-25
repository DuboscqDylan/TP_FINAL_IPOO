CREATE TABLE persona(
    idpersona bigint AUTO_INCREMENT,
    nombre varchar(150),
    apellido varchar(150),
    PRIMARY KEY(idpersona)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE empresa(
    idempresa bigint AUTO_INCREMENT,
    enombre varchar(150),
    edireccion varchar(150),
    PRIMARY KEY (idempresa)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE responsable (
    idpersona bigint AUTO_INCREMENT,
    numerolicencia bigint,
	nombre varchar(150), 
    apellido  varchar(150), 
    PRIMARY KEY (idpersona),
    FOREIGN KEY (idpersona) REFERENCES persona (idpersona)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
	
CREATE TABLE viaje (
    idviaje bigint AUTO_INCREMENT, /*codigo de viaje*/
	vdestino varchar(150),
    vcantmaxpasajeros int,
	idempresa bigint,
    idpersona bigint,
    vimporte float,
    PRIMARY KEY (idviaje),
    FOREIGN KEY (idempresa) REFERENCES empresa (idempresa),
	FOREIGN KEY (idpersona) REFERENCES responsable (idpersona)
    ON UPDATE CASCADE
    ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1;
	
CREATE TABLE pasajero (
    idpersona bigint AUTO_INCREMENT,
    documento varchar(15),
    nombre varchar(150), 
    apellido varchar(150), 
	telefono int, 
    PRIMARY KEY (idpersona),
    FOREIGN KEY (idpersona) REFERENCES persona (idpersona)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1; 
 
  CREATE TABLE viaje_pasajero (
    idviaje bigint,
    idpersona bigint,
    PRIMARY KEY (idviaje, idpersona),
    FOREIGN KEY (idviaje) REFERENCES viaje(idviaje),
    FOREIGN KEY (idpersona) REFERENCES pasajero(idpersona)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
