-- =============================================
-- Base de données : Opération Tranquillité Vacances
-- TP9b - BTS SIO - Lycée Algoud-Laffemas
-- =============================================

CREATE DATABASE IF NOT EXISTS tranquillite_vacances
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE tranquillite_vacances;

-- Table UTILISATEUR
CREATE TABLE IF NOT EXISTS utilisateur (
    id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    adresse VARCHAR(200) NOT NULL,
    telephone VARCHAR(10) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- Table DEMANDE
CREATE TABLE IF NOT EXISTS demande (
    id_demande INT AUTO_INCREMENT PRIMARY KEY,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    contact_nom VARCHAR(100) NOT NULL,
    contact_telephone VARCHAR(10) NOT NULL,
    id_utilisateur INT NOT NULL,
    CONSTRAINT fk_demande_utilisateur
        FOREIGN KEY (id_utilisateur)
        REFERENCES utilisateur(id_utilisateur)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table AGENT (ajout pour TP9b question 5)
CREATE TABLE IF NOT EXISTS agent (
    id_agent INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    matricule VARCHAR(20) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- Table AFFECTATION (ajout pour TP9b question 5)
CREATE TABLE IF NOT EXISTS affectation (
    id_affectation INT AUTO_INCREMENT PRIMARY KEY,
    date_passage DATE NOT NULL,
    id_demande INT NOT NULL,
    id_agent INT NOT NULL,
    commentaire TEXT,
    CONSTRAINT fk_affectation_demande
        FOREIGN KEY (id_demande)
        REFERENCES demande(id_demande)
        ON DELETE CASCADE,
    CONSTRAINT fk_affectation_agent
        FOREIGN KEY (id_agent)
        REFERENCES agent(id_agent)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table ADMIN
CREATE TABLE IF NOT EXISTS admin (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- Insertion de l'administrateur (login: admin, mot de passe: 1234)
INSERT INTO admin (login, mot_de_passe) VALUES
    ('admin', '$2y$10$J1JbDC8fmfV5RV2SEhNOmec7UWPIBGvu7NrdmBUILbKRZdAfp2RHO');

-- Quelques agents pour tester
INSERT INTO agent (nom, prenom, matricule) VALUES
    ('Dupont', 'Jean', 'AG001'),
    ('Martin', 'Sophie', 'AG002'),
    ('Durand', 'Pierre', 'AG003');
