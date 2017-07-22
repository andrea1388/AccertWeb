use my_policeapps;


DROP TABLE Accertamento;
DROP TABLE Log;
DROP TABLE Persona;
DROP TABLE PersonaAccertamento;
DROP TABLE Documento;
DROP TABLE Attivita;

CREATE TABLE Accertamento
( 
	`idAccertamento`     integer  NOT NULL  AUTO_INCREMENT ,
	`numero`             integer  NOT NULL ,
	`anno`               integer  NOT NULL ,
	`targa`              nchar(15)  NULL ,
	`luogo`              nvarchar(200)  NOT NULL ,
	`data`               datetime(3)  NOT NULL ,
	`descrizione`        nvarchar(200)  NOT NULL ,
	`descrizione_estesa` longtext  NULL ,
	`eliminato`          tinyint  NOT NULL ,
	`NumNdR`             integer  NULL ,
    PRIMARY KEY (idAccertamento)
);

ALTER TABLE `Accertamento`
	ADD CONSTRAINT `uniconumacc` UNIQUE (`anno`  ,`numero`   );


CREATE TABLE Attivita
( 
	`idAttivita`         integer  NOT NULL  AUTO_INCREMENT ,
	`descrizione`        nvarchar(50)  NOT NULL ,
	`completata`         tinyint  NOT NULL ,
	`idAccertamento`     integer  NOT NULL ,
	`data`               datetime(3)  NULL ,
    PRIMARY KEY (idAttivita)
);



CREATE TABLE Documento
( 
	`idDocumento`        integer  NOT NULL  AUTO_INCREMENT ,
	`File`               longblob  NOT NULL ,
	`idAccertamento`     integer  NOT NULL ,
	`filename`           nvarchar(100)  NOT NULL ,
	`dataDocumento`      datetime(3)  NOT NULL ,
	`tipo`               integer  NOT NULL ,
	`descrizione`        nvarchar(1000)  NULL ,
    PRIMARY KEY (idDocumento)
);


CREATE TABLE Log
( 
	`idLog`              integer  NOT NULL  AUTO_INCREMENT ,
	`dataora`            datetime(3)  NULL ,
	`operazione`         nvarchar(50)  NULL ,
	`idPersona`          integer  NOT NULL ,
	`idAccertamento`     integer  NOT NULL ,
    PRIMARY KEY (idLog)
);


CREATE TABLE Persona
( 
	`idPersona`          integer  NOT NULL  AUTO_INCREMENT ,
	`nome`               nvarchar(50)  NOT NULL ,
	`dataNascita`        datetime(3)  NULL ,
	`luogoNascita`       nvarchar(50)  NULL ,
	`residenza`          nvarchar(50)  NULL ,
	`tel`                nvarchar(50)  NULL ,
	`mail`               nvarchar(50)  NULL ,
	`documento`          nvarchar(50)  NULL ,
	`indirizzo`          nvarchar(50)  NULL ,
	`tipo`               smallint  NOT NULL ,
	`winUN`              nvarchar(50)  NULL ,
	`login`              nvarchar(20)  NULL ,
	`password`           nvarchar(20)  NULL ,
	`permessi`           nvarchar(20)  NULL ,
    PRIMARY KEY (idPersona)
);

CREATE TABLE PersonaAccertamento
( 
	`idPersona`          integer  NOT NULL ,
	`idAccertamento`     integer  NOT NULL ,
	`ruolo`              smallint  NOT NULL ,
	`idPersonaAccertamento` integer  NOT NULL  AUTO_INCREMENT ,
	`notificato`         tinyint  NULL ,
     PRIMARY KEY   (idPersonaAccertamento)
);

ALTER TABLE `PersonaAccertamento`
	ADD CONSTRAINT `XAK1PersonaAccertamento` UNIQUE (`idPersona`  ,`idAccertamento`  ,`ruolo`  );



ALTER TABLE `Attivita`
	ADD CONSTRAINT `R_13` FOREIGN KEY (`idAccertamento`) REFERENCES Accertamento(`idAccertamento`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION;


ALTER TABLE `Documento`
	ADD CONSTRAINT `AccDoc` FOREIGN KEY (`idAccertamento`) REFERENCES Accertamento(`idAccertamento`)
		ON DELETE CASCADE
		ON UPDATE NO ACTION;


ALTER TABLE `Log`
	ADD CONSTRAINT `R_11` FOREIGN KEY (`idPersona`) REFERENCES Persona(`idPersona`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION;

ALTER TABLE `Log`
	ADD CONSTRAINT `R_12` FOREIGN KEY (`idAccertamento`) REFERENCES Accertamento(`idAccertamento`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION;


ALTER TABLE `PersonaAccertamento`
	ADD CONSTRAINT `PersAccPers` FOREIGN KEY (`idPersona`) REFERENCES Persona(`idPersona`)
		ON UPDATE NO ACTION;

ALTER TABLE `PersonaAccertamento`
	ADD CONSTRAINT `AccPersAcc` FOREIGN KEY (`idAccertamento`) REFERENCES Accertamento(`idAccertamento`)
		ON DELETE CASCADE
		ON UPDATE NO ACTION;
        
insert into persona (nome, login, password, permessi, tipo) values ('root','root','root','HP',0);

