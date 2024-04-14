-- Création de la table `Utilisateurs`
/*
Explication : 
    Table Utilisateurs : Stocke les informations des utilisateurs.
    Table Roles : Contient les rôles possibles des utilisateurs dans le système.
    Table UtilisateursRoles : Une table de jonction qui relie les utilisateurs à leurs rôles, permettant 
    une relation many-to-many où un utilisateur peut avoir plusieurs rôles et un rôle peut être attribué à plusieurs utilisateurs.
*/


CREATE TABLE Utilisateurs (
    ID_Utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(255) NOT NULL,
    Prenom VARCHAR(255) NOT NULL,
    Email VARCHAR(255) UNIQUE NOT NULL,
    Mot_de_passe VARCHAR(255) NOT NULL,
    Adresse TEXT,
    Telephone VARCHAR(20),
    Date_de_naissance DATE,
    Langues TEXT,
    Nationalite VARCHAR(255),
    Date_d_inscription DATE,
    Statut BOOLEAN DEFAULT TRUE,
    Situation VARCHAR(255),
    Besoins_specifiques TEXT,
    Photo_Profil TEXT,
    Emploi VARCHAR(255),
    Societe VARCHAR(255),
    Est_Verifie BOOLEAN DEFAULT FALSE,
    Code_Verification VARCHAR(255),
    Type_Permis VARCHAR(50),
    Date_Derniere_Connexion DATE,
    Statut_Connexion BOOLEAN,
    Statut_Benevole VARCHAR(255) DEFAULT 'En attente de validation'
) ENGINE=InnoDB;

-- Création de la table `Roles`
CREATE TABLE Roles (
    ID_Role INT AUTO_INCREMENT PRIMARY KEY,
    Nom_Role ENUM('Benevole', 'Beneficiaire', 'Administrateur')
) ENGINE=InnoDB;

-- Insérer des rôles de base
INSERT INTO Roles (Nom_Role) VALUES ('Benevole'), ('Beneficiaire'), ('Administrateur');

-- Création de la table `UtilisateursRoles`
CREATE TABLE UtilisateursRoles (
    ID_Utilisateur INT,
    ID_Role INT,
    Statut VARCHAR(255) DEFAULT 'En attente',
    PRIMARY KEY (ID_Utilisateur, ID_Role),
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur) ON DELETE CASCADE,
    FOREIGN KEY (ID_Role) REFERENCES Roles(ID_Role) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Mise à jour du statut dans `UtilisateursRoles`
UPDATE UtilisateursRoles SET Statut = 'Validé' WHERE ID_Utilisateur = 1 AND ID_Role = 3;

-- Création de la table `Services`
CREATE TABLE Services (
    ID_Service INT AUTO_INCREMENT PRIMARY KEY,
    Nom_Service VARCHAR(255) NOT NULL,
    Description TEXT,
    Date_Debut DATE,
    Date_Fin DATE,
    Lieu VARCHAR(255),
    ID_Organisateur INT,
    FOREIGN KEY (ID_Organisateur) REFERENCES Utilisateurs(ID_Utilisateur) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Création de la table `Donations`
CREATE TABLE Donations (
    ID_Donation INT AUTO_INCREMENT PRIMARY KEY,
    Montant DECIMAL(10, 2),
    Description TEXT,
    Date_Donation DATE,
    ID_Donateur INT,
    FOREIGN KEY (ID_Donateur) REFERENCES Utilisateurs(ID_Utilisateur) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Création de la table `Stocks`
CREATE TABLE Stocks (
    ID_Stock INT AUTO_INCREMENT PRIMARY KEY,
    Type_Article VARCHAR(255) NOT NULL,
    Quantite INT DEFAULT 0,
    Date_Peremption DATE,
    Emplacement VARCHAR(255),
    Urgence BOOLEAN DEFAULT FALSE,
    Date_Reception DATE,
    ID_Donation INT,
    FOREIGN KEY (ID_Donation) REFERENCES Donations(ID_Donation) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Création de la table `Evenements`
CREATE TABLE Evenements (
    ID_Evenement INT AUTO_INCREMENT PRIMARY KEY,
    Nom_Evenement VARCHAR(255) NOT NULL,
    Description TEXT,
    Date_Debut DATE,
    Date_Fin DATE,
    Lieu VARCHAR(255),
    Budget DECIMAL(10,2),
    Organisateur INT,
    FOREIGN KEY (Organisateur) REFERENCES Utilisateurs(ID_Utilisateur) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Création de la table `Inscriptions`
CREATE TABLE Inscriptions (
    ID_Inscription INT AUTO_INCREMENT PRIMARY KEY,
    ID_Utilisateur INT,
    ID_Evenement INT,
    Date_Inscription DATE,
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur) ON DELETE CASCADE,
    FOREIGN KEY (ID_Evenement) REFERENCES Evenements(ID_Evenement) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Création de la table `ChatMessages`
CREATE TABLE ChatMessages (
    ID_Message INT AUTO_INCREMENT PRIMARY KEY,
    ID_Expediteur INT,
    ID_Destinataire INT,
    Message TEXT,
    Timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    Lu BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (ID_Expediteur) REFERENCES Utilisateurs(ID_Utilisateur) ON DELETE SET NULL,
    FOREIGN KEY (ID_Destinataire) REFERENCES Utilisateurs(ID_Utilisateur) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Création de la table `Feedbacks`
CREATE TABLE Feedbacks (
    ID_Feedback INT AUTO_INCREMENT PRIMARY KEY,
    ID_Utilisateur INT,
    Type VARCHAR(50), -- 'Service', 'Evenement', 'Formation'
    ID_Reference INT,
    Commentaire TEXT,
    Date_Creation DATE,
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Création de la table `Vehicules`
CREATE TABLE Vehicules (
    ID_Vehicule INT AUTO_INCREMENT PRIMARY KEY,
    Marque VARCHAR(255),
    Modele VARCHAR(255),
    Plaque_Immatriculation VARCHAR(50),
    Statut VARCHAR(100), -- 'Disponible', 'En service'
    Localisation_Actuelle TEXT
) ENGINE=InnoDB;

-- Création de la table `AffectationsVehicules`
CREATE TABLE AffectationsVehicules (
    ID_Affectation INT AUTO_INCREMENT PRIMARY KEY,
    ID_Vehicule INT,
    ID_Utilisateur INT,
    Date_Debut DATE,
    Date_Fin DATE,
    FOREIGN KEY (ID_Vehicule) REFERENCES Vehicules(ID_Vehicule),
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur)
) ENGINE=InnoDB;

-- Table Formations
CREATE TABLE Formations (
    ID_Formation INT AUTO_INCREMENT PRIMARY KEY,
    Titre VARCHAR(255),
    Description TEXT,
    Date_Formation DATE,
    Duree TIME,
    Lieu VARCHAR(255),
    ID_Organisateur INT,
    FOREIGN KEY (ID_Organisateur) REFERENCES Utilisateurs(ID_Utilisateur)
) ENGINE=InnoDB;

-- Table Inscriptions_Formations
CREATE TABLE Inscriptions_Formations (
    ID_Inscription INT AUTO_INCREMENT PRIMARY KEY,
    ID_Utilisateur INT,
    ID_Formation INT,
    Date_Inscription DATE,
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur),
    FOREIGN KEY (ID_Formation) REFERENCES Formations(ID_Formation)
) ENGINE=InnoDB;

-- Table Materiels
CREATE TABLE Materiels (
    ID_Materiel INT AUTO_INCREMENT PRIMARY KEY,
    Type_Materiel VARCHAR(255),
    Description TEXT,
    Etat VARCHAR(100), -- 'Bon', 'Usé', 'Défectueux'
    Emplacement VARCHAR(255),
    ID_Evenement INT,
    FOREIGN KEY (ID_Evenement) REFERENCES Evenements(ID_Evenement) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Table Tickets
CREATE TABLE Tickets (
    ID_Ticket INT AUTO_INCREMENT PRIMARY KEY,
    Titre VARCHAR(255),
    Description TEXT,
    Date_Creation DATE,
    Statut VARCHAR(50), -- 'Ouvert', 'En cours', 'Fermé'
    Priorite VARCHAR(50), -- 'Bas', 'Moyen', 'Haut'
    ID_Utilisateur INT,
    ID_Assignee INT,
    Date_Modification DATE,
    ID_Modificateur INT,
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur),
    FOREIGN KEY (ID_Assignee) REFERENCES Utilisateurs(ID_Utilisateur),
    FOREIGN KEY (ID_Modificateur) REFERENCES Utilisateurs(ID_Utilisateur)
) ENGINE=InnoDB;

-- Table Langues
CREATE TABLE Langues (
    ID_Langue INT AUTO_INCREMENT PRIMARY KEY,
    Code_Langue VARCHAR(10),
    Nom_Langue VARCHAR(255)
) ENGINE=InnoDB;

-- Table Traductions
CREATE TABLE Traductions (
    ID_Traduction INT AUTO_INCREMENT PRIMARY KEY,
    ID_Reference INT,
    Type_Reference VARCHAR(50), -- 'Document', 'Page web', etc.
    ID_Langue INT,
    Texte_Traduit TEXT,
    FOREIGN KEY (ID_Langue) REFERENCES Langues(ID_Langue)
) ENGINE=InnoDB;

-- Table Historique_Activites
CREATE TABLE Historique_Activites (
    ID_Activite INT AUTO_INCREMENT PRIMARY KEY,
    ID_Utilisateur INT,
    Type_Activite VARCHAR(50), -- 'Service', 'Evenement', 'Visite'
    ID_Reference INT, -- ID du service, événement, visite, etc.
    Date_Activite DATE,
    Description TEXT,
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur)
) ENGINE=InnoDB;

-- Table UtilisationMateriels
CREATE TABLE UtilisationMateriels (
    ID_Utilisation INT AUTO_INCREMENT PRIMARY KEY,
    ID_Materiel INT,
    ID_Evenement INT,
    Date_Utilisation DATE,
    FOREIGN KEY (ID_Materiel) REFERENCES Materiels(ID_Materiel),
    FOREIGN KEY (ID_Evenement) REFERENCES Evenements(ID_Evenement)
) ENGINE=InnoDB;

-- Table Ressources
CREATE TABLE Ressources (
    ID_Ressource INT AUTO_INCREMENT PRIMARY KEY,
    Type_Ressource VARCHAR(255), -- 'Salle', 'Equipement', etc.
    Description TEXT,
    Disponibilite BOOLEAN,
    ID_Utilisateur INT,
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur)
) ENGINE=InnoDB;

-- Table AffectationRessources
CREATE TABLE AffectationRessources (
    ID_Affectation INT AUTO_INCREMENT PRIMARY KEY,
    ID_Ressource INT,
    ID_Evenement INT,
    Date_Affectation DATE,
    FOREIGN KEY (ID_Ressource) REFERENCES Ressources(ID_Ressource),
    FOREIGN KEY (ID_Evenement) REFERENCES Evenements(ID_Evenement)
) ENGINE=InnoDB;

-- Table UtilisateursLangues
CREATE TABLE UtilisateursLangues (
    ID_Utilisateur INT,
    ID_Langue INT,
    PRIMARY KEY (ID_Utilisateur, ID_Langue),
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur),
    FOREIGN KEY (ID_Langue) REFERENCES Langues(ID_Langue)
) ENGINE=InnoDB;

-- Table Captchas
CREATE TABLE Captchas (
    ID_Captcha INT AUTO_INCREMENT PRIMARY KEY,
    Image_Path VARCHAR(255) NOT NULL,
    Answer VARCHAR(255) NOT NULL,
    Created_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Status ENUM('active', 'solved', 'inactive') DEFAULT 'active',
    ID_Utilisateur INT,
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur)
) ENGINE=InnoDB;

-- Table Planning
CREATE TABLE Planning (
    ID_Planning INT AUTO_INCREMENT PRIMARY KEY,
    ID_Utilisateur INT,
    Date DATE,
    Horaire TIME,
    Description TEXT,
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur)
) ENGINE=InnoDB;

-- Table tentatives_connexion
CREATE TABLE tentatives_connexion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_adresse VARCHAR(50),
    tentative_count INT DEFAULT 0,
    last_attempt TIMESTAMP
) ENGINE=InnoDB;

-- Table AffectationsServices
CREATE TABLE AffectationsServices (
    ID_Affectation INT AUTO_INCREMENT PRIMARY KEY,
    ID_Service INT,
    ID_Utilisateur INT,
    Horaire TIME,
    Lieu VARCHAR(255),
    FOREIGN KEY (ID_Service) REFERENCES Services(ID_Service),
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur)
) ENGINE=InnoDB;

-- Création de la table Competences
CREATE TABLE Competences (
    ID_Competence INT AUTO_INCREMENT PRIMARY KEY,
    Nom_Competence VARCHAR(255),
    Description TEXT
) ENGINE=InnoDB;

-- Table associative UtilisateursCompetences
CREATE TABLE UtilisateursCompetences (
    ID_Utilisateur INT,
    ID_Competence INT,
    PRIMARY KEY (ID_Utilisateur, ID_Competence),
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur),
    FOREIGN KEY (ID_Competence) REFERENCES Competences(ID_Competence)
) ENGINE=InnoDB;

-- Insertions initiales pour les compétences
INSERT INTO Competences (Nom_Competence, Description) VALUES
    ('Français', 'Capacité à parler et comprendre le français'),
    ('Conduite', 'Compétence en conduite de véhicules');

-- Insertions initiales pour les langues
INSERT INTO Langues (Code_Langue, Nom_Langue) VALUES
    ('fr', 'Français'),
    ('en', 'Anglais'),
    ('es', 'Espagnol'),
    ('de', 'Allemand');


-- Pour voir quels rôles chaque utilisateur a 
SELECT u.Nom, u.Prenom, r.Nom_Role, ur.Statut
FROM Utilisateurs u
JOIN UtilisateursRoles ur ON u.ID_Utilisateur = ur.ID_Utilisateur
JOIN Roles r ON ur.ID_Role = r.ID_Role;


-- GEstion de changement de statut 
UPDATE UtilisateursRoles
SET Statut = 'Validé'
WHERE ID_Utilisateur = 2 AND ID_Role = 2;  




INSERT INTO Utilisateurs (Nom, Prenom, Email, Mot_de_passe, Adresse, Telephone, Date_de_naissance, Langues, Nationalite, Date_d_inscription, Statut, Situation, Emploi, Societe, Est_Verifie, Code_Verification, Type_Permis, Date_Derniere_Connexion, Statut_Connexion, Statut_Benevole)
VALUES ('Dupont', 'Jean', 'jean.dupont@email.com', 'password123', '123 Rue de Paris', '0123456789', '1980-01-01', 'Français', 'Française', CURDATE(), TRUE, 'Célibataire', 'Ingénieur', 'ABC Inc.', TRUE, 'XYZ123', 'B'),
       ('Martin', 'Alice', 'alice.martin@email.com', 'password123', '124 Rue de Paris', '0123456790', '1990-02-02', 'Français, Anglais', 'Française', CURDATE(), TRUE, 'Mariée', 'Médecin', 'Santé+', TRUE, 'XYZ456', 'B');

INSERT INTO UtilisateursRoles (ID_Utilisateur, ID_Role, Statut)
VALUES (1, 1, 'Validé'),  
       (2, 2, 'En attente'); 

