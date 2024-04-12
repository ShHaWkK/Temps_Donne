-- File : Au_temps_Donné.sql

-- Table Utilisateurs
CREATE TABLE Utilisateurs (
    ID_Utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(255),
    Prenom VARCHAR(255),
    Email VARCHAR(255) UNIQUE,
    Mot_de_passe VARCHAR(255),
    Role VARCHAR(255), -- 'Benevole', 'Beneficiaire', 'Administrateur'
    Adresse TEXT,
    Telephone VARCHAR(20),
    Date_de_naissance DATE,
    Langues TEXT,
    Nationalite TEXT,
    Date_d_inscription DATE,
    Situation TEXT,
    Besoins_specifiques TEXT,
    Photo_Profil TEXT,
    Date_Derniere_Connexion DATE,
    Statut_Connexion BOOLEAN,
    Emploi VARCHAR(255),
    Societe VARCHAR(255),
    Est_Verifie BOOLEAN DEFAULT FALSE,
    Code_Verification VARCHAR(255),
    Type_Permis VARCHAR(50),
    statut ENUM('En attente', 'Accordé', 'Refusé')
);

ALTER TABLE Utilisateurs
ADD Statut_Benevole VARCHAR(255) DEFAULT 'En attente de validation';

-- Table Roles
CREATE TABLE Roles (
    ID_Role INT AUTO_INCREMENT PRIMARY KEY,
    Nom_Role ENUM('Bénévole', 'Bénéficiaire', 'Administrateur')
);
INSERT INTO Roles (Nom_Role) VALUES ('Benevole'), ('Beneficiaire'), ('Administrateur');

-- Table UtilisateursRoles
CREATE TABLE UtilisateursRoles (
    ID_Utilisateur INT,
    ID_Role INT, 
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur),
    FOREIGN KEY (ID_Role) REFERENCES Roles(ID_Role),
    PRIMARY KEY (ID_Utilisateur, ID_Role)
);
ALTER TABLE UtilisateursRoles
ADD statut VARCHAR(255) DEFAULT 'En attente';

UPDATE UtilisateursRoles
SET statut = 'Validé'
WHERE id_utilisateur = 1 AND id_role = 3;

SELECT u.Nom, r.Nom_Role, ur.statut
FROM Utilisateurs u
JOIN UtilisateursRoles ur ON u.ID_Utilisateur = ur.ID_Utilisateur
JOIN Roles r ON ur.ID_Role = r.ID_Role;
WHERE u.ID_Utilisateur = 1;

-- Table Services
CREATE TABLE Services (
    ID_Service INT AUTO_INCREMENT PRIMARY KEY,
    Nom_du_service VARCHAR(255),
    Description TEXT,
    Horaire TIME,
    Lieu VARCHAR(255),
    ID_Utilisateur INT,
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur),
    NFC_Tag_Data TEXT,
    Type_Service VARCHAR(255),
    Date_Debut DATE,
    Date_Fin DATE
);

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
);

-- Table Inscriptions_Formations
CREATE TABLE Inscriptions_Formations (
    ID_Inscription INT AUTO_INCREMENT PRIMARY KEY,
    ID_Utilisateur INT,
    ID_Formation INT,
    Date_Inscription DATE,
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur),
    FOREIGN KEY (ID_Formation) REFERENCES Formations(ID_Formation)
);

-- Table ChatMessages
CREATE TABLE ChatMessages (
    ID_Message INT AUTO_INCREMENT PRIMARY KEY,
    ID_Expediteur_Utilisateur INT,
    ID_Destinataire_Utilisateur INT,
    Message TEXT,
    Timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    Lu BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (ID_Expediteur_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur),
    FOREIGN KEY (ID_Destinataire_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur)
);

-- Table Feedbacks
CREATE TABLE Feedbacks (
    ID_Feedback INT AUTO_INCREMENT PRIMARY KEY,
    ID_Utilisateur INT,
    Type VARCHAR(50), -- 'Service', 'Evenement', 'Formation'
    ID_Reference INT, -- ID du service, événement, ou formation concerné
    Commentaire TEXT,
    Date_Creation DATE,
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur)
);

-- Table SourcesDons
CREATE TABLE SourcesDons (
    ID_Source INT AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(255),
    Type_source VARCHAR(255),
    Contact TEXT
);

-- Table Dons
CREATE TABLE Dons (
    ID_Don INT AUTO_INCREMENT PRIMARY KEY,
    Montant DECIMAL(10,2),
    Type_don VARCHAR(255),
    Date_Don DATE,
    ID_Donateur INT,
    Commentaires TEXT,
    ID_Source INT,
    FOREIGN KEY (ID_Donateur) REFERENCES Utilisateurs(ID_Utilisateur),
    FOREIGN KEY (ID_Source) REFERENCES SourcesDons(ID_Source)
);

-- Table Stocks
CREATE TABLE Stocks (
    ID_Stock INT AUTO_INCREMENT PRIMARY KEY,
    Type_article VARCHAR(255),
    Quantite INT,
    Date_de_peremption DATE,
    Emplacement VARCHAR(255),
    Urgence BOOLEAN,
    Date_de_reception DATE,
    ID_Don INT,
    QR_Code TEXT,
    FOREIGN KEY (ID_Don) REFERENCES Dons(ID_Don)
);

-- Table Evenements
CREATE TABLE Evenements (
    ID_Evenement INT AUTO_INCREMENT PRIMARY KEY,
    Nom_Evenement VARCHAR(255),
    Description TEXT,
    Date_Debut DATE,          
    Date_Fin DATE,             
    Lieu VARCHAR(255),
    Budget DECIMAL(10,2),
    Sponsor VARCHAR(255),
    Type VARCHAR(255),         
    Organisateur INT,
    FOREIGN KEY (Organisateur) REFERENCES Utilisateurs(ID_Utilisateur)
);


-- Table Participations
CREATE TABLE Participations (
    ID_Participation INT AUTO_INCREMENT PRIMARY KEY,
    ID_Utilisateur INT,
    ID_Evenement INT,
    Role VARCHAR(50), -- 'Organisateur', 'Participant'
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur),
    FOREIGN KEY (ID_Evenement) REFERENCES Evenements(ID_Evenement)
);

-- Table Vehicules

CREATE TABLE Vehicules (
    ID_Vehicule INT AUTO_INCREMENT PRIMARY KEY,
    Marque VARCHAR(255),
    Modele VARCHAR(255),
    Plaque_Immatriculation VARCHAR(50),
    Statut VARCHAR(100),
    Localisation_Actuelle TEXT
);

-- Table Affectations_Vehicules

CREATE TABLE Affectations_Vehicules (
    ID_Affectation INT AUTO_INCREMENT PRIMARY KEY,
    ID_Vehicule INT,
    ID_Utilisateur INT,
    Date_Debut DATE,
    Date_Fin DATE,
    FOREIGN KEY (ID_Vehicule) REFERENCES Vehicules(ID_Vehicule),
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur)
);

-- Table Materiels

CREATE TABLE Materiels (
    ID_Materiel INT AUTO_INCREMENT PRIMARY KEY,
    Type_Materiel VARCHAR(255),
    Description TEXT,
    Etat VARCHAR(100),
    Emplacement VARCHAR(255),
    ID_Evenement INT,
    FOREIGN KEY (ID_Evenement) REFERENCES Evenements(ID_Evenement)
);

-- Table Tickets

CREATE TABLE Tickets (
    ID_Ticket INT AUTO_INCREMENT PRIMARY KEY,
    Titre VARCHAR(255),
    Description TEXT,
    Date_Creation DATE,
    Statut VARCHAR(50), -- 'Ouvert', 'En cours', 'Fermé'
    Priorite VARCHAR(50), -- 'Bas', 'Moyen', 'Haut'
    ID_Utilisateur INT,
    ID_Assignee INT, -- L'utilisateur ou l'administrateur assigné au ticket
    Date_Modification DATE,
    ID_Modificateur INT,
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur),
    FOREIGN KEY (ID_Assignee) REFERENCES Utilisateurs(ID_Utilisateur),
    FOREIGN KEY (ID_Modificateur) REFERENCES Utilisateurs(ID_Utilisateur)
);

-- Table Langues

CREATE TABLE Langues (
    ID_Langue INT AUTO_INCREMENT PRIMARY KEY,
    Code_Langue VARCHAR(10), -- Par exemple 'FR', 'EN', etc.
    Nom_Langue VARCHAR(255)
);

-- Table Traductions

CREATE TABLE Traductions (
    ID_Traduction INT AUTO_INCREMENT PRIMARY KEY,
    ID_Reference INT,
    Type_Reference VARCHAR(50),
    ID_Langue INT,
    Texte_Traduit TEXT,
    FOREIGN KEY (ID_Langue) REFERENCES Langues(ID_Langue)
);

-- Table Historique_Activites

CREATE TABLE Historique_Activites (
    ID_Activite INT AUTO_INCREMENT PRIMARY KEY,
    ID_Utilisateur INT,
    Type_Activite VARCHAR(50), -- 'Service', 'Evenement', 'Visite', etc.
    ID_Reference INT, -- ID du service, événement, visite, etc.
    Date_Activite DATE,
    Description TEXT,
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur)
);

-- Table UtilisationMateriels

CREATE TABLE UtilisationMateriels (
    ID_Utilisation INT AUTO_INCREMENT PRIMARY KEY,
    ID_Materiel INT,
    ID_Evenement INT,
    Date_Utilisation DATE,
    FOREIGN KEY (ID_Materiel) REFERENCES Materiels(ID_Materiel),
    FOREIGN KEY (ID_Evenement) REFERENCES Evenements(ID_Evenement)
);

-- Table Ressources

CREATE TABLE Ressources (
    ID_Ressource INT AUTO_INCREMENT PRIMARY KEY,
    Type_Ressource VARCHAR(255), -- 'Salle', 'Equipement', etc.
    Description TEXT,
    Disponibilite BOOLEAN,
    ID_Utilisateur INT,
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur)
);

-- Table AffectationRessources

CREATE TABLE AffectationRessources (
    ID_Affectation INT AUTO_INCREMENT PRIMARY KEY,
    ID_Ressource INT,
    ID_Evenement INT,
    Date_Affectation DATE,
    FOREIGN KEY (ID_Ressource) REFERENCES Ressources(ID_Ressource),
    FOREIGN KEY (ID_Evenement) REFERENCES Evenements(ID_Evenement)
);

-- Table UtilisateursLangues

CREATE TABLE UtilisateursLangues (
    ID_Utilisateur INT,
    ID_Langue INT,
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur),
    FOREIGN KEY (ID_Langue) REFERENCES Langues(ID_Langue),
    PRIMARY KEY (ID_Utilisateur, ID_Langue)
);

-- Table Captchas

CREATE TABLE Captchas (
    ID_Captcha INT AUTO_INCREMENT PRIMARY KEY,
    Image_Path VARCHAR(255) NOT NULL,
    Answer VARCHAR(255) NOT NULL,
    Created_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Status ENUM('active', 'solved', 'inactive') DEFAULT 'active',
    ID_Utilisateur INT,
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur)
);

-- Table Planning

CREATE TABLE Planning (
    ID_Planning INT AUTO_INCREMENT PRIMARY KEY,
    ID_Utilisateur INT NOT NULL,
    Date DATE,
    Description TEXT,
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur) ON DELETE NO ACTION
) ENGINE=InnoDB;

ALTER TABLE Planning ADD COLUMN activity VARCHAR(255) NOT NULL;
ALTER TABLE Planning ADD COLUMN startTime TIME;
ALTER TABLE Planning ADD COLUMN endTime TIME;


-- Table tentatives_connexion

CREATE TABLE tentatives_connexion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_adresse VARCHAR(50),
    tentative_count INT DEFAULT 0,
    last_attempt TIMESTAMP
);

-- Table AffectationsServices

CREATE TABLE AffectationsServices (
    ID_Affectation INT AUTO_INCREMENT PRIMARY KEY,
    ID_Service INT,
    ID_Utilisateur INT,
    Horaire TIME,
    Lieu VARCHAR(255),
    FOREIGN KEY (ID_Service) REFERENCES Services(ID_Service),
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur)
);

-- Création de la table Competences

CREATE TABLE Competences (
    ID_Competence INT AUTO_INCREMENT PRIMARY KEY,
    Nom_Competence VARCHAR(255),
    Description TEXT
);

-- Table associative UtilisateursCompetences

CREATE TABLE UtilisateursCompetences (
    ID_Utilisateur INT,
    ID_Competence INT,
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur),
    FOREIGN KEY (ID_Competence) REFERENCES Competences(ID_Competence),
    PRIMARY KEY (ID_Utilisateur, ID_Competence)
);


INSERT INTO Competences (Nom_Competence, Description) VALUES
    ('Français', 'Capacité à parler et comprendre le français'),
    ('Conduite', 'Compétence en conduite de véhicules');

CREATE TABLE Inscriptions (
    ID_Inscription INT AUTO_INCREMENT PRIMARY KEY,
    ID_Utilisateur INT,
    ID_Evenement INT,
    Date_Inscription DATE,
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur),
    FOREIGN KEY (ID_Evenement) REFERENCES Evenements(ID_Evenement)
);

/*Rajouter pour les entrepôts */
CREATE TABLE Circuits (
    ID_Circuit INT AUTO_INCREMENT PRIMARY KEY,
    Date_Circuit DATE NOT NULL,
    Itineraire TEXT,
    ID_Chauffeur INT,
    FOREIGN KEY (ID_Chauffeur) REFERENCES Utilisateurs(ID_Utilisateur)
);

CREATE TABLE PlanRoutes (
    ID_Plan INT AUTO_INCREMENT PRIMARY KEY,
    Description TEXT,
    Date_Plan DATE,
    Itineraire TEXT
);

CREATE TABLE Inventaire (
    ID_Inventaire INT AUTO_INCREMENT PRIMARY KEY,
    ID_Stock INT,
    Quantite_Actuelle INT,
    Date_Mise_a_Jour DATE,
    FOREIGN KEY (ID_Stock) REFERENCES Stocks(ID_Stock)
);