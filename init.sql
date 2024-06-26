
CREATE TABLE Utilisateurs (
                              ID_Utilisateur INT AUTO_INCREMENT PRIMARY KEY,
                              Nom VARCHAR(255) NOT NULL,
                              Prenom VARCHAR(255) NOT NULL,
                              Genre ENUM('Homme', 'Femme', 'Autre') NOT NULL ,
                              Email VARCHAR(255) UNIQUE NOT NULL,
                              Mot_de_passe VARCHAR(500),
                              Role ENUM('Benevole', 'Beneficiaire', 'Administrateur') NOT NULL , -- 'Benevole', 'Beneficiaire', 'Administrateur'
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
                              Code_Verification VARCHAR(255),
                              Type_Permis VARCHAR(50),
                              Statut ENUM('Pending', 'Granted', 'Denied')
);


-- Tables Services
CREATE TABLE ServiceType(
                            ID_ServiceType INT AUTO_INCREMENT PRIMARY KEY,
                            Nom_Type_Service VARCHAR(100)
);

INSERT INTO ServiceType ( Nom_Type_Service) VALUES
                                                ('Distribution alimentaire'),
                                                ('Services administratifs'),
                                                ('Navettes pour rendez-vous eloignes'),
                                                ('Cours d alphabetisation pour adulte'),
                                                ('Recolte de fonds'),
                                                ('Visite et activites avec personnes agees');

CREATE TABLE Services (
                          ID_Service INT AUTO_INCREMENT PRIMARY KEY,
                          Nom_du_service VARCHAR(255),
                          Description TEXT,
                          Horaire TIME,
                          Lieu VARCHAR(255),
                          NFC_Tag_Data TEXT,
                          Date_Debut DATE,
                          Date_Fin DATE,
                          ID_ServiceType INT,
                          FOREIGN KEY (ID_ServiceType) REFERENCES ServiceType(ID_ServiceType)
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
ALTER TABLE Inscriptions_Formations
    ADD COLUMN Attended BOOLEAN NOT NULL DEFAULT FALSE;

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




CREATE TABLE IF NOT EXISTS Produits (
                                        ID_Produit INT AUTO_INCREMENT PRIMARY KEY,
                                        Nom_Produit VARCHAR(100) NOT NULL,
                                        Description TEXT,
                                        Prix FLOAT NOT NULL,
                                        Volume FLOAT,
                                        Poids FLOAT
);

CREATE TABLE IF NOT EXISTS Entrepots (
                                         ID_Entrepot INT AUTO_INCREMENT PRIMARY KEY,
                                         Nom VARCHAR(255) NOT NULL,
                                         Adresse VARCHAR(255) NOT NULL,
                                         Volume_Total DECIMAL(10, 2) NOT NULL,
                                         Volume_Utilise DECIMAL(10, 2) NOT NULL DEFAULT 0.00
);

CREATE TABLE IF NOT EXISTS Stocks (
                                      ID_Stock INT AUTO_INCREMENT PRIMARY KEY,
                                      ID_Entrepots INT,
                                      ID_Produit INT,
                                      Quantite INT,
                                      Poids_Total FLOAT,
                                      Volume_Total FLOAT,
                                      Date_de_reception DATE,
                                      Statut ENUM('en_stock', 'en_route', 'retire') NOT NULL DEFAULT 'en_route',
                                      QR_Code TEXT,
                                      Date_de_peremption DATE,
                                      FOREIGN KEY (ID_Entrepots) REFERENCES Entrepots(ID_Entrepot),
                                      FOREIGN KEY (ID_Produit) REFERENCES Produits(ID_Produit)
);

CREATE TABLE IF NOT EXISTS Stocks_Entrepot (
                                               ID_Stock_Entrepot INT AUTO_INCREMENT PRIMARY KEY,
                                               ID_Entrepot INT,
                                               ID_Stock INT,
                                               FOREIGN KEY (ID_Entrepot) REFERENCES Entrepots(ID_Entrepot),
                                               FOREIGN KEY (ID_Stock) REFERENCES Stocks(ID_Stock)
);



CREATE TABLE Camions (
                         ID_Camion INT AUTO_INCREMENT PRIMARY KEY,
                         Immatriculation VARCHAR(255) NOT NULL UNIQUE,
                         Modele VARCHAR(255),
                         ID_Entrepot INT,
                         Type ENUM('Porteur', 'Semi-remorque', 'Tracteur'),
                         Statut ENUM('En service', 'En panne', 'En maintenance'),
                         Capacite_Max DECIMAL(10, 2),
                         FOREIGN KEY (ID_Entrepot) REFERENCES Entrepots(ID_Entrepot) ON DELETE SET NULL
);

CREATE TABLE Commercants (
                             ID_Commercant INT AUTO_INCREMENT PRIMARY KEY,
                             Nom VARCHAR(255) NOT NULL,
                             Adresse VARCHAR(255) NOT NULL,
                             Contrat TEXT
);

CREATE TABLE Trajets (
                         ID_Trajet INT AUTO_INCREMENT PRIMARY KEY,
                         Nom VARCHAR(255) NOT NULL,
                         Description TEXT,
                         ID_Camion INT,
                         ID_Entrepot INT,
                         Horaires_Debut DATETIME,
                         Horaires_Fin DATETIME,
                         Type ENUM('Maraude', 'Livraison', 'Collecte') NOT NULL,
                         Plan TEXT,
                         Statut ENUM('Planifié', 'En Cours', 'Completé', 'Annulé') NOT NULL DEFAULT 'Planifié',
                         FOREIGN KEY (ID_Camion) REFERENCES Camions(ID_Camion) ON DELETE SET NULL,
                         FOREIGN KEY (ID_Entrepot) REFERENCES Entrepots(ID_Entrepot) ON DELETE SET NULL
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

-- Ajout d'une table session
CREATE TABLE Session (
                         ID_Session INT AUTO_INCREMENT PRIMARY KEY,
                         ID_Utilisateur INT NOT NULL,
                         Session_Token VARCHAR(64) NOT NULL,
                         Creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                         Expiration TIMESTAMP,
                         INDEX idx_session_token (Session_Token),
                         INDEX idx_user_id (ID_Utilisateur),
                         FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur) ON DELETE CASCADE
);



-- Ajout d'un événement pour suprimer automatiquement les sessions expirées
CREATE EVENT deleteExpiredSessions
    ON SCHEDULE EVERY 1 HOUR
    DO
    DELETE FROM Session WHERE Expiration <= NOW();
