create database chiama2;
use chiama2;

create table giocatori
(
	acronimo VARCHAR(6),
	cognome VARCHAR(30),
	nome VARCHAR(30),
	disattivato CHAR, /* S-N */
	dataDisattivazione VARCHAR(10),
	PRIMARY KEY (acronimo)
);

create table partita
(
	dataPartita VARCHAR(10),
	mano INT,
	cartaChiamata VARCHAR(11),
	quotaVittoria VARCHAR(3),
	seme VARCHAR(6),
	puntiMano INT, /* punti totalizzati nella mano considerata */
	PRIMARY KEY (dataPartita, mano)
);

create table chiama2
(
	acronimoGiocatore VARCHAR(6),
	dataPartita VARCHAR(10),
	mano INT,
	chiamante CHAR, /* Il giocatore è chiamante nella mano che si sta considerando? [S/N] */
	socio CHAR, /* Il giocatore è socio nella mano che si sta considerando? [S/N] */
	punti INT,
	PRIMARY KEY (acronimoGiocatore, dataPartita, mano),
	FOREIGN KEY (acronimoGiocatore) REFERENCES giocatori(acronimo),
	FOREIGN KEY (dataPartita) REFERENCES partita(dataPartita)
);

create table posizioni
(
	dataPartita VARCHAR(10),
	acronimoGiocatore VARCHAR(6),
	posizione INT, /* posizione in classifica (nei confronti degli altri giocatori) per quanto riguarda una data partita */
	puntiClassifica FLOAT,
	PRIMARY KEY (dataPartita, acronimoGiocatore),
	FOREIGN KEY (dataPartita) REFERENCES partita(dataPartita),
	FOREIGN KEY (acronimoGiocatore) REFERENCES giocatori(acronimo)
);

/*create table puntiPremio
(
	numRecord INT, /* è un campo che conterrà il numero progressivo di ogni record della tabella: mi serve unicamente per defnire un campo chiave
	dataPartita VARCHAR(10),
	posizioneClassificato INT, /* posizione in classifica per una data partita in base alla quale attribuire i punti premio definiti nel campo seguente 
	puntiPremio INT,
	PRIMARY KEY(numRecord)
); --> questa tabella di fatto non serve, quindi la sua creazione la commento, così non perdo lo storico del fatto che era stata originariamente creata; cancellata con un comando: 'DROP TABLE puntiPremio' */

create table totpuntipartita
(
	dataPartita VARCHAR(10),
	acronimoGiocatore VARCHAR(6),
	totPunti INT,
	PRIMARY KEY (dataPartita, acronimoGiocatore),
	FOREIGN KEY (dataPartita) REFERENCES partita(dataPartita),
	FOREIGN KEY (acronimoGiocatore) REFERENCES giocatori(acronimo)
);

create table medie
(
	acronimoGiocatore VARCHAR(6),
	media FLOAT,
	PRIMARY KEY (acronimoGiocatore),
	FOREIGN KEY (acronimoGiocatore) REFERENCES giocatori(acronimo)
);


ALTER TABLE `giocatori` CHANGE `dataDisattivazione` `dataDisattivazione` VARCHAR( 10 ) NULL DEFAULT NULL;
ALTER TABLE `giocatori` ADD `dataRiattivazione` VARCHAR( 10 ) NULL ;
ALTER TABLE `chiama2` ADD `morto` CHAR( 1 ) NOT NULL AFTER `socio` ;
ALTER TABLE `chiama2` CHANGE `punti` `punti` INT( 11 ) NULL DEFAULT '0';
ALTER TABLE `giocatori` ADD `PuntiTotali` FLOAT NOT NULL DEFAULT '0', ADD `Giornate` INT NOT NULL DEFAULT '0' COMMENT 'Numero totale di partite giocate';
ALTER TABLE `partita` ADD `cappotto` CHAR( 1 ) NOT NULL ; /* S/N */