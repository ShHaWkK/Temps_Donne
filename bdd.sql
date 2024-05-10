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
                              Permis_B BOOLEAN,
                              Permis_Poids_Lourds BOOLEAN,
                              CACES BOOLEAN,
                              Statut ENUM('Pending', 'Granted', 'Denied')
);

-- Ajout d'un admin lors de la création de la BDD
INSERT INTO Utilisateurs (Nom, Prenom, Genre, Email, Mot_de_passe, Role, Adresse, Telephone, Date_de_naissance, Langues, Nationalite, Date_d_inscription, Situation, Besoins_specifiques, Photo_Profil, Date_Derniere_Connexion, Statut_Connexion, Emploi, Societe, Code_Verification, Permis_B, Permis_Poids_Lourds, CACES, Statut)
VALUES ('admin', 'admin', 'Homme', 'admin@admin.com', '75216c44a46bfff78f692d1fe695c02a407a2136625dcc17ca6cf3141e0c4c72', 'Administrateur', 'Adresse Admin', '+330123456789', '1980-01-01', 'Français', 'Française', '2024-05-09', 'Célibataire', 'Aucun', NULL, '2024-05-09', TRUE, NULL, NULL, NULL, FALSE, FALSE, FALSE, 'Granted'),
       ('Dupont', 'Jean', 'Homme', 'jean.dupont@example.com', '75216c44a46bfff78f692d1fe695c02a407a2136625dcc17ca6cf3141e0c4c72', 'Benevole', '10 Rue de la Paix, Paris, France', '+33123456789', '1980-06-15', 'Français', 'Française', '2024-05-09', 'Marié', 'Aucun', NULL, '2024-05-09', TRUE, 'Ingénieur', 'Entreprise A', NULL, TRUE, FALSE, FALSE, 'Granted'),
       ('Leclerc', 'Marie', 'Femme', 'marie.leclerc@example.com', '75216c44a46bfff78f692d1fe695c02a407a2136625dcc17ca6cf3141e0c4c72', 'Beneficiaire', '20 Avenue des Fleurs, Lyon, France', '+33456789012', '1995-02-20', 'Français', 'Française', '2024-05-09', 'Célibataire', 'Aucun', NULL, '2024-05-09', TRUE, NULL, NULL, NULL, FALSE, FALSE, FALSE, 'Granted'),
       ('Moreau', 'Thomas', 'Homme', 'thomas.moreau@example.com', '75216c44a46bfff78f692d1fe695c02a407a2136625dcc17ca6cf3141e0c4c72', 'Administrateur', '30 Rue du Commerce, Marseille, France', '+33765432109', '1978-12-10', 'Français', 'Française', '2024-05-09', 'Marié', 'Aucun', NULL, '2024-05-09', TRUE, 'Directeur', 'Entreprise B', NULL, TRUE, TRUE, FALSE, 'Granted'),
       ('Lefevre', 'Sophie', 'Femme', 'sophie.lefevre@example.com', '75216c44a46bfff78f692d1fe695c02a407a2136625dcc17ca6cf3141e0c4c72', 'Benevole', '40 Avenue de la République, Lille, France', '+33987654321', '1988-04-25', 'Français', 'Française', '2024-05-09', 'Célibataire', 'Aucun', NULL, '2024-05-09', TRUE, 'Enseignant', 'Université C', NULL, FALSE, FALSE, FALSE, 'Granted'),
       ('Bertrand', 'David', 'Homme', 'david.bertrand@example.com', '75216c44a46bfff78f692d1fe695c02a407a2136625dcc17ca6cf3141e0c4c72', 'Benevole', '50 Rue des Ecoles, Bordeaux, France', '+33123456789', '1970-09-30', 'Français', 'Française', '2024-05-09', 'Marié', 'Aucun', NULL, '2024-05-09', TRUE, 'Médecin', 'Hôpital D', NULL, TRUE, FALSE, FALSE, 'Granted'),
       ('Roux', 'Anne', 'Femme', 'anne.roux@example.com', '75216c44a46bfff78f692d1fe695c02a407a2136625dcc17ca6cf3141e0c4c72', 'Beneficiaire', '60 Boulevard des Roses, Toulouse, France', '+33456789012', '1992-07-18', 'Français', 'Française', '2024-05-09', 'Célibataire', 'Aucun', NULL, '2024-05-09', TRUE, NULL, NULL, NULL, FALSE, FALSE, FALSE, 'Granted'),
       ('Fournier', 'Nicolas', 'Homme', 'nicolas.fournier@example.com', '75216c44a46bfff78f692d1fe695c02a407a2136625dcc17ca6cf3141e0c4c72', 'Benevole', '70 Rue du Paradis, Nice, France', '+33765432109', '1985-03-05', 'Français', 'Française', '2024-05-09', 'Célibataire', 'Aucun', NULL, '2024-05-09', TRUE, 'Avocat', 'Cabinet E', NULL, FALSE, TRUE, FALSE, 'Granted');

-- Tables Services
CREATE TABLE ServiceType(
                            ID_ServiceType INT AUTO_INCREMENT PRIMARY KEY,
                            Nom_Type_Service VARCHAR(100),
                            Description VARCHAR(200)
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
                          Nom_du_service VARCHAR(255) NOT NULL ,
                          Description TEXT,
#                           Horaire TIME,
                          Lieu VARCHAR(255) NOT NULL ,
                          Date DATE NOT NULL ,
                          ID_ServiceType INT NOT NULL ,
                          startTime TIME NOT NULL ,
                          endTime TIME NOT NULL ,
                          FOREIGN KEY (ID_ServiceType) REFERENCES ServiceType(ID_ServiceType)
);
# ALTER TABLE Services ADD COLUMN startTime TIME;
# ALTER TABLE Services ADD COLUMN endTime TIME;

-- Table Planning (la table planning permet d'assigner une activité à un utilisateur)

CREATE TABLE Planning (
#                           ID_Planning INT AUTO_INCREMENT PRIMARY KEY,
                          ID_Utilisateur INT NOT NULL,
                          ID_Service INT NOT NULL, -- On ajoute la clé étrangère du service
                          Description TEXT,
                          FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur) ON DELETE CASCADE ,
                          FOREIGN KEY (ID_Service) REFERENCES Services(ID_Service) ON DELETE CASCADE,
                          PRIMARY KEY (ID_Utilisateur, ID_Service)
) ENGINE=InnoDB;
/*
ALTER TABLE Planning ADD COLUMN activity VARCHAR(255) NOT NULL;
ALTER TABLE Planning ADD COLUMN startTime TIME;
ALTER TABLE Planning ADD COLUMN endTime TIME;
*/

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
                           FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur) ON DELETE SET NULL
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

INSERT INTO Produits (Nom_Produit, Description, Prix, Volume, Poids) VALUES
                                                                         ('Pain', 'Pain traditionnel français', 1.50, 0.5, 0.3),
                                                                         ('Lait', 'Lait demi-écrémé en bouteille', 1.20, 1, 1.2),
                                                                         ('Fromage', 'Fromage de chèvre bio', 3.50, 0.2, 0.15),
                                                                         ('Jambon', 'Jambon blanc découenné dégraissé', 2.80, 0.3, 0.25),
                                                                         ('Fruits', 'Assortiment de fruits frais', 4.00, 2, 1.5),
                                                                         ('Légumes', 'Assortiment de légumes bio', 3.50, 2.5, 2),
                                                                         ('Eau', 'Eau minérale naturelle en bouteille', 0.80, 0.5, 0.6),
                                                                         ('Vin', 'Vin rouge de Bordeaux', 8.50, 0.75, 0.9),
                                                                         ('Chocolat', 'Tablette de chocolat noir 70%', 2.00, 0.1, 0.1),
                                                                         ('Café', 'Café moulu arabica', 4.50, 0.25, 0.2);


CREATE TABLE IF NOT EXISTS Entrepots (
                                         ID_Entrepot INT AUTO_INCREMENT PRIMARY KEY,
                                         Nom VARCHAR(255) NOT NULL,
                                         Adresse VARCHAR(255) NOT NULL,
                                         Volume_Total DECIMAL(10, 2) NOT NULL,
                                         Volume_Utilise DECIMAL(10, 2) NOT NULL DEFAULT 0.00
);

INSERT INTO Entrepots (Nom, Adresse, Volume_Total, Volume_Utilise) VALUES
                                                                       ('Laon', '15 Boulevard Saint-Michel, Laon, France', 380, 20.00),
                                                                       ('Saint-Quentin', '6 Boulevard Gambetta, Saint-Quentin, France',  250.00, 30.00);


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

INSERT INTO Camions (Immatriculation, Modele, ID_Entrepot, Type, Statut, Capacite_Max) VALUES
                                                                                           ('AB-123-CD', 'Camion A', 1, 'Porteur', 'En service', 5000.00),
                                                                                           ('EF-456-GH', 'Camion B', 2, 'Semi-remorque', 'En panne', 10000.00),
                                                                                           ('IJ-789-KL', 'Camion C', 1, 'Tracteur', 'En maintenance', 15000.00),
                                                                                           ('MN-101-OP', 'Camion D', 2, 'Porteur', 'En service', 5000.00),
                                                                                           ('QR-112-ST', 'Camion E', 1, 'Semi-remorque', 'En panne', 10000.00),
                                                                                           ('UV-131-WX', 'Camion F', 2, 'Tracteur', 'En maintenance', 15000.00),
                                                                                           ('YZ-314-AB', 'Camion G', 1, 'Porteur', 'En service', 5000.00),
                                                                                           ('CD-415-EF', 'Camion H', 2, 'Semi-remorque', 'En panne', 10000.00),
                                                                                           ('GH-516-IJ', 'Camion I', 1, 'Tracteur', 'En maintenance', 15000.00);


CREATE TABLE Commercants (
                             ID_Commercant INT AUTO_INCREMENT PRIMARY KEY,
                             Nom VARCHAR(255) NOT NULL,
                             Adresse VARCHAR(255) NOT NULL,
                             Contrat ENUM('en_cours', 'a_renouveler', 'en_attente') NOT NULL,
                             Frequence_Collecte ENUM('quotidienne', 'hebdomadaire', 'mensuelle') NOT NULL,
                             Date_Derniere_Collecte DATE NOT NULL ,
    -- C'est pour connaître les jours de collecte
                             LUNDI BOOLEAN DEFAULT FALSE,
                             MARDI BOOLEAN DEFAULT FALSE,
                             MERCREDI BOOLEAN DEFAULT FALSE,
                             JEUDI BOOLEAN DEFAULT FALSE,
                             VENDREDI BOOLEAN DEFAULT FALSE,
                             SAMEDI BOOLEAN DEFAULT FALSE,
                             DIMANCHE BOOLEAN DEFAULT FALSE
);

INSERT INTO Commercants (Nom, Adresse, Contrat, Frequence_Collecte, Date_Derniere_Collecte, LUNDI, MARDI, MERCREDI, JEUDI, VENDREDI, SAMEDI, DIMANCHE) VALUES
                            ('Supermarché A', '1 Rue de l\'Isle, Saint-Quentin, France', 'en_cours', 'quotidienne', '2024-05-09', TRUE, TRUE, TRUE, TRUE, TRUE, FALSE, FALSE),
                            ('Boulangerie B', '10 Rue des Charpentiers, Saint-Quentin, France', 'a_renouveler', 'hebdomadaire', '2024-05-09', FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE),
                            ('Épicerie C', '25 Rue d\'Isle, Saint-Quentin, France', 'en_attente', 'mensuelle', '2024-05-09', FALSE, FALSE, FALSE, TRUE, FALSE, FALSE, FALSE),
                            ('Pharmacie D', '30 Rue de la République, Saint-Quentin, France', 'en_cours', 'hebdomadaire', '2024-05-09', FALSE, TRUE, FALSE, FALSE, FALSE, FALSE, FALSE),
                            ('Boucherie E', '5 Rue Victor Basch, Saint-Quentin, France', 'en_cours', 'quotidienne', '2024-05-09', TRUE, TRUE, TRUE, TRUE, TRUE, FALSE, FALSE),
                            ('Magasin F', '15 Avenue de Laon, Saint-Quentin, France', 'a_renouveler', 'quotidienne', '2024-05-09', TRUE, TRUE, TRUE, TRUE, TRUE, FALSE, FALSE),
                            ('Café G', '2 Rue des Canonniers, Saint-Quentin, France', 'en_attente', 'mensuelle', '2024-05-09', FALSE, FALSE, FALSE, TRUE, FALSE, FALSE, FALSE),
                            ('Librairie H', '20 Rue des Toiles, Saint-Quentin, France', 'en_cours', 'hebdomadaire', '2024-05-09', FALSE, TRUE, FALSE, FALSE, FALSE, FALSE, FALSE),
                            ('Fleuriste I', '8 Rue de la Sellerie, Saint-Quentin, France', 'a_renouveler', 'quotidienne', '2024-05-09', TRUE, TRUE, TRUE, TRUE, TRUE, FALSE, FALSE),
                            ('Caviste J', '12 Rue de Guise, Saint-Quentin, France', 'en_cours', 'hebdomadaire', '2024-05-09', FALSE, TRUE, FALSE, TRUE, FALSE, FALSE, FALSE);


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

-- Table Disponibilites

CREATE TABLE Disponibilites(
                               ID_Disponibilite INT AUTO_INCREMENT PRIMARY KEY,
                               ID_Utilisateur INT,
                               DEMI_JOURNEES INT,
                               LUNDI BOOLEAN,
                               MARDI BOOLEAN,
                               MERCREDI BOOLEAN,
                               JEUDI BOOLEAN,
                               VENDREDI BOOLEAN,
                               SAMEDI BOOLEAN,
                               DIMANCHE BOOLEAN,
                               FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur) ON DELETE CASCADE
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
                                                          ('Conduite', 'Compétence en conduite de véhicules'),
                                                          ('Developpement web', 'Competences en developpement web'),
                                                          ('Gestion de projet', 'Formation ou competence dans la gestion de projet'),
                                                          ('Travail social', 'Experience passee et competence en travail social'),
                                                          ('Marketing et communication', 'Marketing et communication');

-- Attribuer des compétences à un utilisateur
INSERT INTO UtilisateursCompetences (ID_Utilisateur, ID_Competence) VALUES
                                                                        (1, 1), -- Utilisateur avec ID 1 possède la compétence 'Français'
                                                                        (2, 2), -- Utilisateur avec ID 2 possède la compétence 'Conduite'
                                                                        (3, 3), -- Utilisateur avec ID 3 possède la compétence 'Developpement web'
                                                                        (4, 4), -- Utilisateur avec ID 4 possède la compétence 'Gestion de projet'
                                                                        (5, 5), -- Utilisateur avec ID 5 possède la compétence 'Travail social'
                                                                        (6, 6); -- Utilisateur avec ID 6 possède la compétence 'Marketing et communication'


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
ALTER TABLE Circuits ADD COLUMN QR_Code TEXT;


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
-- Ajout d'un événement pour attribuer automatiquement une valeur d'expiration de 24h

DELIMITER //

CREATE TRIGGER set_expiration BEFORE INSERT ON Session
    FOR EACH ROW
BEGIN
    DECLARE expiration_date TIMESTAMP;
    SET expiration_date = NOW() + INTERVAL 24 HOUR;
    SET NEW.Expiration = expiration_date;
END;
//

DELIMITER ;

DELIMITER //
-- On vérifie si l'heure de fin d'un service est bien ultérieure à son heure de début

CREATE TRIGGER check_end_date
    BEFORE INSERT ON Services
    FOR EACH ROW
BEGIN
    IF NEW.endTime <= NEW.startTime THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'La date de fin doit être ultérieure à la date de début.';
    END IF;
END //

DELIMITER ;

-- On vérifie si l'entrepot a bien un volume restant suffisant pour y accueilir le stock, sinon one refuse l'insertion de la ligne
DELIMITER //

CREATE TRIGGER check_stock_volume
    BEFORE INSERT ON Stocks
    FOR EACH ROW
BEGIN
    DECLARE volume_entrepot DECIMAL(10, 2);

    -- Calculer le volume restant dans l'entrepôt associé au nouveau stock
    SELECT E.Volume_Total - IFNULL(SUM(S.Volume_Total), 0)
    INTO volume_entrepot
    FROM Entrepots E
             LEFT JOIN Stocks S ON E.ID_Entrepot = S.ID_Entrepots
    WHERE E.ID_Entrepot = NEW.ID_Entrepots
    GROUP BY E.ID_Entrepot;

    -- Vérifier si le volume du stock dépasse le volume restant
    IF NEW.Volume_Total > volume_entrepot THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Le volume du stock dépasse le volume restant dans l''entrepôt.';
    END IF;
END //

DELIMITER ;

-- Ajout d'un événement pour suprimer automatiquement les sessions expirées
CREATE EVENT deleteExpiredSessions
    ON SCHEDULE EVERY 1 HOUR
    DO
    DELETE FROM Session WHERE Expiration <= NOW();


-- Ajout d'une table demandes
-- Bénéfciaire 
CREATE TABLE Demandes (
    ID_Demande INT AUTO_INCREMENT PRIMARY KEY,
    ID_Utilisateur INT,
    ID_Service INT,
    Date_Demande DATE NOT NULL,
    Statut ENUM('En attente', 'Acceptée', 'Refusée') DEFAULT 'En attente',
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur),
    FOREIGN KEY (ID_Service) REFERENCES Services(ID_Service)
);


CREATE TABLE DemandesBenevoles (
    ID_DemandeBenevole INT AUTO_INCREMENT PRIMARY KEY,
    ID_Demande INT,
    ID_Utilisateur INT, 
    FOREIGN KEY (ID_Demande) REFERENCES Demandes(ID_Demande),
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur)
);