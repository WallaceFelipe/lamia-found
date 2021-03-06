CREATE TABLE usuario(
id INT PRIMARY KEY AUTO_INCREMENT,
login VARCHAR(30) UNIQUE, 
senha VARCHAR(30) NOT NULL,
nome VARCHAR(50) NOT NULL,
cpf CHAR(11) NOT NULL,
datanascimento DATE NOT NULL,
email VARCHAR(50) UNIQUE,
tipo SET('gestordeprojeto','avaliadordeprojeto','financiadoracademico') NOT NULL,
pais VARCHAR(35) NOT NULL,
estado VARCHAR(35) NOT NULL,
cidade VARCHAR(35) NOT NULL,
endereco VARCHAR(255) NOT NULL,
ativo BOOL DEFAULT '1');

CREATE TABLE avaliadordeprojetos(
idusuario INT AUTO_INCREMENT,
categoria ENUM('pesquisa','competicaotecnologica','inovacaoensino','manutencaoreforma','pequenasobras') UNIQUE,
FOREIGN KEY(idusuario) REFERENCES usuario(id),
PRIMARY KEY(idusuario)); 


CREATE TABLE projeto(
id INT PRIMARY KEY AUTO_INCREMENT,
nome VARCHAR(30) NOT NULL,
codigo CHAR(6) UNIQUE,
categoria SET('pesquisa','competicaotecnologica','inovacaoensino','manutencaoreforma','pequenasobras') NOT NULL,
status SET('candidato','aprovado','reprovado','finalizado') DEFAULT 'candidato',
duracaoprevista varchar(10) NOT NULL,
valor DOUBLE NOT NULL,
prazomaximo DATE,
valorminimo DOUBLE,
valormaximo DOUBLE);

CREATE TABLE criteriodeavaliacao(
id INT PRIMARY KEY AUTO_INCREMENT,
categoria SET('pesquisa','competicaotecnologica','inovacaoensino','manutencaoreforma','pequenasobras') NOT NULL,
descricao VARCHAR(100) NOT NULL,
status BOOL DEFAULT '1',
peso INT NOT NULL);

CREATE TABLE recompensa(
id INT AUTO_INCREMENT,
idprojeto INT,
descricao VARCHAR(200) NOT NULL,
valorminimo DOUBLE NOT NULL,
valormaximo DOUBLE,
limite INT,
FOREIGN KEY(idprojeto) REFERENCES projeto(id),
PRIMARY KEY(id,idprojeto));

CREATE TABLE repassefinanceiro(
id INT PRIMARY KEY AUTO_INCREMENT,
idprojeto INT,
data DATE NOT NULL,
valor DOUBLE NOT NULL,
status ENUM('quitado','naoquitado') DEFAULT 'naoquitado',
FOREIGN KEY(idprojeto) REFERENCES projeto(id));

CREATE TABLE cotafinanciamento(
id INT PRIMARY KEY AUTO_INCREMENT,
idusuario INT,
idprojeto INT,
valortotal DOUBLE NOT NULL,
valorcota DOUBLE NOT NULL,
datarepasse DATE NOT NULL,
FOREIGN KEY(idusuario) REFERENCES usuario(id),
FOREIGN KEY(idprojeto) REFERENCES projeto(id));

CREATE TABLE financiar(
id INT PRIMARY KEY AUTO_INCREMENT,
idusuario INT,
idprojeto INT,
tipo ENUM('modulo','integral') NOT NULL,
valor DOUBLE NOT NULL,
formapagamento SET('boletobancario','cartaocredito','cartaodebito','cheque','transferenciabancaria') NOT NULL, 
FOREIGN KEY(idusuario) REFERENCES usuario(id),
FOREIGN KEY(idprojeto) REFERENCES projeto(id));

CREATE TABLE edital(
id INT PRIMARY KEY AUTO_INCREMENT,
idusuario INT,
nome varchar(30) NOT NULL,
datatermino DATE NOT NULL,
valordisponiel DOUBLE NOT NULL,
valorminimo DOUBLE NOT NULL,
valormaximo DOUBLE NOT NULL,
patharquivo varchar(45) NOT NULL,
FOREIGN KEY(idusuario) REFERENCES usuario(id));


