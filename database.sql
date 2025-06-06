CREATE DATABASE IF NOT EXISTS GioliLavanderia;

USE GioliLavanderia;

CREATE TABLE Utenti(
    id_utente INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    pwd VARCHAR(80) NOT NULL,
    ruolo ENUM('Amministratore', 'Semplice') NOT NULL DEFAULT 'Semplice',
    UNIQUE(username)
);

CREATE TABLE Clienti(
    CF VARCHAR(16) PRIMARY KEY,
    nominativo VARCHAR(20),
    email VARCHAR(50),
    id_utente INT,
    FOREIGN KEY (id_utente) REFERENCES Utenti(id_utente) ON DELETE CASCADE
);

CREATE TABLE Indumenti(
    id_indumento INT PRIMARY KEY AUTO_INCREMENT,
    descrizione VARCHAR(50),
    cliente VARCHAR(16),
    FOREIGN KEY (cliente) REFERENCES Clienti(CF)
);

--PASSWORD USER ADMIN
--$2y$10$y9MRS3u62TqmP8jeKWIuxeYBGDg8h4MJLvhtocv5XeHq.Wkxije0m

/*
INSERT INTO Utenti (username,pwd,ruolo) VALUES("admin","$2y$10$y9MRS3u62TqmP8jeKWIuxeYBGDg8h4MJLvhtocv5XeHq.Wkxije0m","Amministratore")
*/