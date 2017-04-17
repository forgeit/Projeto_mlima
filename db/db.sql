CREATE database semnomedb;

--Auxiliares
CREATE TABLE semnomedb.arquivo (
	id 			INTEGER 		PRIMARY KEY 	AUTO_INCREMENT,
	nome 		VARCHAR(255) 	NOT NULL,
	caminho 	VARCHAR(255) 	NOT NULL,
	tipo 		VARCHAR(50) 	NOT NULL,
	modulo 		VARCHAR(20)
) ENGINE = INNODB;

CREATE TABLE semnomedb.tipo_anuncio (
	id 			INTEGER 		PRIMARY KEY 	AUTO_INCREMENT,
	nome 		VARCHAR(255),
	altura		INTEGER,
	largura		INTEGER
) ENGINE = INNODB;

CREATE TABLE semnomedb.tipo_quadra (
	id 			INTEGER 		PRIMARY KEY 	AUTO_INCREMENT,
	nome 		VARCHAR(255),
	valor		DECIMAL(9,2)	
) ENGINE = INNODB;

CREATE TABLE semnomedb.esporte (
	id 			INTEGER 		PRIMARY KEY 	AUTO_INCREMENT,
	nome 		VARCHAR(255)
) ENGINE = INNODB;

CREATE TABLE semnomedb.tipo_local (
	id 			INTEGER 		PRIMARY KEY 	AUTO_INCREMENT,
	nome 		VARCHAR(255)
) ENGINE = INNODB;


--Normais

CREATE TABLE semnomedb.usuario (
	id 			INTEGER 		PRIMARY KEY 	AUTO_INCREMENT,
) ENGINE = INNODB;

CREATE TABLE semnomedb.cliente (
	id 				INTEGER 	PRIMARY KEY 	AUTO_INCREMENT,
	email 			TEXT 		NOT NULL 		UNIQUE,
	razao_social	TEXT		NOT NULL,
	nome_fantasia	TEXT,
	logo			INTEGER		NOT NULL 		REFERENCES arquivo(id),
	tel				VARCHAR(14),
	cel 			VARCHAR(15),
	cpf_cnpj		VARCHAR(18) NOT NULL,
	endereco		TEXT		NOT NULL,
	latitude		VARCHAR(20),
	longitude		VARCHAR(20),
	url_facebook 	TEXT	
) ENGINE = INNODB;

CREATE TABLE semnomedb.anuncio (
	id 				INTEGER 		PRIMARY KEY 	AUTO_INCREMENT,
	id_cliente		INTEGER			NOT NULL 		REFERENCES cliente(id),
	id_tipo_anuncio INTEGER			NOT NULL		REFERENCES tipo_anuncio(id),
	titulo			VARCHAR(255)	NOT NULL,
	data_inicial	DATE 			NOT NULL,
	data_final		DATE 			NOT NULL,
	valor			DECIMAL(9,2)	NOT NULL,
	situacao		BOOLEAN			NOT NULL,
	imagem			INTEGER 		NOT NULL 		REFERENCES arquivo(id)
) ENGINE = INNODB;

CREATE TABLE semnomedb.quadra (
	id 				INTEGER 		PRIMARY KEY 	AUTO_INCREMENT,
	id_cliente		INTEGER			NOT NULL 		REFERENCES cliente(id),
	id_tipo_quadra	INTEGER			NOT NULL		REFERENCES tipo_quadra(id),
	imagem			INTEGER 		NOT NULL		REFERENCES arquivo(id),
	valor_bola		DECIMAL(9,2),
	titulo			VARCHAR(255),
	flag_marcacao_mensal	BOOLEAN NOT NULL,
	descricao		TEXT			NOT NULL,
	largura			DECIMAL(9,2),
	comprimento		DECIMAL(9,2),
	flag_tamanho_oficial	BOOLEAN NOT NULL,
	id_tipo_local	INTEGER 		NOT NULL		REFERENCES tipo_local(id),
	flag_dia_chuva	BOOLEAN			NOT NULL,
	situacao		BOOLEAN			NOT NULL
) ENGINE = INNODB;

CREATE TABLE semnomedb.quadra_imagem (
	id 				INTEGER 		PRIMARY KEY 	AUTO_INCREMENT,
	id_quadra 		INTEGER			NOT NULL 		REFERENCES quadra(id),
	id_arquivo 		INTEGER			NOT NULL 		REFERENCES arquivo(id)
) ENGINE = INNODB;

CREATE TABLE semnomedb.quadra_esporte (
	id 				INTEGER 		PRIMARY KEY 	AUTO_INCREMENT,
	id_quadra 		INTEGER			NOT NULL 		REFERENCES quadra(id),
	id_esporte 		INTEGER			NOT NULL 		REFERENCES esporte(id)
) ENGINE = INNODB;

CREATE TABLE semnomedb.horario (
	id 				INTEGER 		PRIMARY KEY 	AUTO_INCREMENT,
	id_cliente		INTEGER			NOT NULL 		REFERENCES cliente(id),
	id_quadra 		INTEGER			NOT NULL 		REFERENCES quadra(id),
	dia_semana		INTEGER			NOT NULL,
	hora_inicial	TIME			NOT NULL,
	hora_final		TIME			NOT NULL,
	valor 			DECIMAL(9,2)	NOT NULL
) ENGINE = INNODB;

CREATE TABLE semnomedb.horario_excecao (
	id 				INTEGER 		PRIMARY KEY 	AUTO_INCREMENT,
	id_cliente		INTEGER			NOT NULL 		REFERENCES cliente(id),
	id_quadra 		INTEGER			NOT NULL 		REFERENCES quadra(id),
	data_hora_inicial	DATETIME 		NOT NULL,
	data_hora_final		DATETIME		NOT NULL,	
	valor 			DECIMAL(9,2)	NOT NULL
) ENGINE = INNODB;

CREATE TABLE semnomedb.reserva (
	id 				INTEGER 		PRIMARY KEY 	AUTO_INCREMENT,
	id_cliente		INTEGER			NOT NULL 		REFERENCES cliente(id),
	id_quadra 		INTEGER			NOT NULL 		REFERENCES quadra(id),
	data_hora 		DATETIME		NOT NULL,
	id_usuario		INTEGER			NOT NULL		REFERENCES usuario(id) 			
) ENGINE = INNODB;