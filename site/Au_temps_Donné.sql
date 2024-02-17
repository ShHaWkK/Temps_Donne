
------------------------------------------------------------------------------------------------

CREATE TABLE Utilisateurs (
    ID_Utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(255),
    Prenom VARCHAR(255),
    Email VARCHAR(255) UNIQUE,
    Mot_de_passe VARCHAR(255),
    Role VARCHAR(255), -- 'Benevole', 'Beneficiaire'
    Adresse TEXT,
    Telephone VARCHAR(20),
    Date_de_naissance DATE,
    Langues TEXT,
    Nationalite TEXT,
    Date_d_inscription DATE,
    Statut BOOLEAN,
    Situation TEXT,
    Besoins_specifiques TEXT
);
ALTER TABLE Utilisateurs ADD COLUMN Photo_Profil TEXT;
ALTER TABLE Utilisateurs ADD COLUMN Date_Derniere_Connexion DATE;
ALTER TABLE Utilisateurs ADD COLUMN Statut_Connexion BOOLEAN;

CREATE TABLE Roles (
    ID_Role INT AUTO_INCREMENT PRIMARY KEY,
    Nom_Role VARCHAR(255)
);

CREATE TABLE UtilisateursRoles (
    ID_Utilisateur INT,
    ID_Role INT,
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur),
    FOREIGN KEY (ID_Role) REFERENCES Roles(ID_Role),
    PRIMARY KEY (ID_Utilisateur, ID_Role)
);


CREATE TABLE  Administrateurs (
    ID_Administrateur INT AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(255),
    Prenom VARCHAR(255),
    Email VARCHAR(255) UNIQUE,
    Mot_de_passe VARCHAR(255),
    Role VARCHAR(255) -- 'Administrateur'
);
ALTER TABLE Administrateurs ADD COLUMN Photo_Profil VARCHAR(255);

CREATE TABLE Services (
    ID_Service INT AUTO_INCREMENT PRIMARY KEY,
    Nom_du_service VARCHAR(255),
    Description TEXT,
    Horaire TIME,
    Lieu VARCHAR(255),
    ID_Administrateur INT,
    FOREIGN KEY (ID_Administrateur) REFERENCES Utilisateurs(ID_Utilisateur)
);
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
CREATE TABLE Inscriptions_Formations (
    ID_Inscription INT AUTO_INCREMENT PRIMARY KEY,
    ID_Utilisateur INT,
    ID_Formation INT,
    Date_Inscription DATE,
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur),
    FOREIGN KEY (ID_Formation) REFERENCES Formations(ID_Formation)
);

CREATE TABLE ChatMessages (
    ID_Message INT AUTO_INCREMENT PRIMARY KEY,
    ID_Expediteur_Utilisateur INT, -- ID de l'utilisateur expéditeur
    ID_Expediteur_Administrateur INT, -- ID de l'administrateur expéditeur
    ID_Destinataire_Utilisateur INT, -- ID de l'utilisateur destinataire
    ID_Destinataire_Administrateur INT, -- ID de l'administrateur destinataire
    Message TEXT,
    Timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    Lu BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (ID_Expediteur_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur),
    FOREIGN KEY (ID_Expediteur_Administrateur) REFERENCES Administrateurs(ID_Administrateur),
    FOREIGN KEY (ID_Destinataire_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur),
    FOREIGN KEY (ID_Destinataire_Administrateur) REFERENCES Administrateurs(ID_Administrateur)
);


CREATE TABLE Feedbacks (
    ID_Feedback INT AUTO_INCREMENT PRIMARY KEY,
    ID_Utilisateur INT,
    Type VARCHAR(50), -- 'Service', 'Evenement', 'Formation'
    ID_Reference INT, -- ID du service, événement, ou formation concerné
    Commentaire TEXT,
    Date_Creation DATE,
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur)
);

CREATE TABLE SourcesDons (
    ID_Source INT AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(255),
    Type_source VARCHAR(255),
    Contact TEXT
);
CREATE TABLE Dons (
    ID_Don INT AUTO_INCREMENT PRIMARY KEY,
    Montant DECIMAL(10,2),
    Type_don VARCHAR(255),
    Date_Don DATE,
    ID_Donateur INT,
    Commentaires TEXT,
    FOREIGN KEY (ID_Donateur) REFERENCES Utilisateurs(ID_Utilisateur)
);

CREATE TABLE Visites (
    ID_Visite INT AUTO_INCREMENT PRIMARY KEY,
    ID_Benevole INT,
    ID_Personne_Agee INT, -- ou ID_Beneficiaire si les personnes âgées sont enregistrées en tant que bénéficiaires
    Date_Visite DATE,
    Heure_Visite TIME,
    NFC_Tag_Data TEXT, -- Données récupérées du jeton NFC
    Commentaires TEXT,
    FOREIGN KEY (ID_Benevole) REFERENCES Utilisateurs(ID_Utilisateur),
    FOREIGN KEY (ID_Personne_Agee) REFERENCES Utilisateurs(ID_Utilisateur) -- ou REFERENCES Beneficiaires(ID_Beneficiaire)
);

CREATE TABLE Stocks (
    ID_Stock INT AUTO_INCREMENT PRIMARY KEY,
    Type_article VARCHAR(255),
    Quantite INT,
    Date_de_peremption DATE,
    Emplacement VARCHAR(255),
    Urgence BOOLEAN,
    Date_de_reception DATE,
    ID_Don INT,
    FOREIGN KEY (ID_Don) REFERENCES Dons(ID_Don)
);

CREATE TABLE Evenements (
    ID_Evenement INT AUTO_INCREMENT PRIMARY KEY,
    Nom_Evenement VARCHAR(255),
    Description TEXT,
    Date_Evenement DATE,
    Lieu VARCHAR(255),
    Budget DECIMAL(10,2),
    Sponsor VARCHAR(255),
    Organisateur INT,
    FOREIGN KEY (Organisateur) REFERENCES Utilisateurs(ID_Utilisateur)
);

CREATE TABLE Participations (
    ID_Participation INT AUTO_INCREMENT PRIMARY KEY,
    ID_Utilisateur INT,
    ID_Evenement INT,
    Role VARCHAR(50), -- 'Organisateur', 'Participant'
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur),
    FOREIGN KEY (ID_Evenement) REFERENCES Evenements(ID_Evenement)
);

CREATE TABLE Vehicules (
    ID_Vehicule INT AUTO_INCREMENT PRIMARY KEY,
    Marque VARCHAR(255),
    Modele VARCHAR(255),
    Plaque_Immatriculation VARCHAR(50),
    Statut VARCHAR(100),
    Localisation_Actuelle TEXT
);

CREATE TABLE Affectations_Vehicules (
    ID_Affectation INT AUTO_INCREMENT PRIMARY KEY,
    ID_Vehicule INT,
    ID_Utilisateur INT,
    Date_Debut DATE,
    Date_Fin DATE,
    FOREIGN KEY (ID_Vehicule) REFERENCES Vehicules(ID_Vehicule),
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur)
);
CREATE TABLE Materiels (
    ID_Materiel INT AUTO_INCREMENT PRIMARY KEY,
    Type_Materiel VARCHAR(255),
    Description TEXT,
    Etat VARCHAR(100),
    Emplacement VARCHAR(255)
);
CREATE TABLE Tickets (
    ID_Ticket INT AUTO_INCREMENT PRIMARY KEY,
    Titre VARCHAR(255),
    Description TEXT,
    Date_Creation DATE,
    Statut VARCHAR(50), -- Par exemple, 'Ouvert', 'En cours', 'Fermé'
    Priorite VARCHAR(50), -- Par exemple, 'Bas', 'Moyen', 'Haut'
    ID_Utilisateur INT, 
    ID_Assignee INT, -- L'utilisateur ou l'administrateur assigné au ticket
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur),
    FOREIGN KEY (ID_Assignee) REFERENCES Utilisateurs(ID_Utilisateur)
);

CREATE TABLE Langues (
    ID_Langue INT AUTO_INCREMENT PRIMARY KEY,
    Code_Langue VARCHAR(10), -- Par exemple 'FR', 'EN', etc.
    Nom_Langue VARCHAR(255)
);
CREATE TABLE Traductions (
    ID_Traduction INT AUTO_INCREMENT PRIMARY KEY,
    ID_Reference INT, 
    Type_Reference VARCHAR(50), 
    ID_Langue INT,
    Texte_Traduit TEXT,
    FOREIGN KEY (ID_Langue) REFERENCES Langues(ID_Langue)
);
CREATE TABLE Historique_Activites (
    ID_Activite INT AUTO_INCREMENT PRIMARY KEY,
    ID_Utilisateur INT,
    Type_Activite VARCHAR(50), -- 'Service', 'Evenement', 'Visite', etc.
    ID_Reference INT, -- ID du service, événement, visite, etc.
    Date_Activite DATE,
    Description TEXT,
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur)
);

CREATE TABLE UtilisationMateriels (
    ID_Utilisation INT AUTO_INCREMENT PRIMARY KEY,
    ID_Materiel INT,
    ID_Evenement INT,  
    Date_Utilisation DATE,
    FOREIGN KEY (ID_Materiel) REFERENCES Materiels(ID_Materiel),
    FOREIGN KEY (ID_Evenement) REFERENCES Evenements(ID_Evenement) 
);

CREATE TABLE AffectationRessources (
    ID_Affectation INT AUTO_INCREMENT PRIMARY KEY,
    ID_Ressource INT,
    ID_Evenement INT,  
    Date_Affectation DATE,
    FOREIGN KEY (ID_Ressource) REFERENCES Ressources(ID_Ressource),
    FOREIGN KEY (ID_Evenement) REFERENCES Evenements(ID_Evenement) 
);

CREATE TABLE Ressources (
    ID_Ressource INT AUTO_INCREMENT PRIMARY KEY,
    Type_Ressource VARCHAR(255), -- 'Salle', 'Equipement', etc.
    Description TEXT,
    Disponibilite BOOLEAN
);

CREATE TABLE UtilisateursLangues (
    ID_Utilisateur INT,
    ID_Langue INT,
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur),
    FOREIGN KEY (ID_Langue) REFERENCES Langues(ID_Langue),
    PRIMARY KEY (ID_Utilisateur, ID_Langue)
);

CREATE TABLE Captchas (
    ID_Captcha INT AUTO_INCREMENT PRIMARY KEY,
    Image_Path VARCHAR(255) NOT NULL,
    Answer VARCHAR(255) NOT NULL,
    Created_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Status ENUM('active', 'solved', 'inactive') DEFAULT 'active',
    ID_Administrateur INT, 
    FOREIGN KEY (ID_Administrateur) REFERENCES Administrateurs(ID_Administrateur)
);


ALTER TABLE Stocks ADD COLUMN QR_Code TEXT;

ALTER TABLE Utilisateurs ADD COLUMN Est_Verifie BOOLEAN DEFAULT FALSE;
ALTER TABLE Utilisateurs ADD COLUMN Code_Verification VARCHAR(255);
ALTER TABLE Utilisateurs ADD COLUMN Type_Permis VARCHAR(50);


ALTER TABLE Dons ADD COLUMN ID_Source INT;
ALTER TABLE Dons ADD FOREIGN KEY (ID_Source) REFERENCES SourcesDons(ID_Source);

ALTER TABLE Materiels ADD COLUMN ID_Evenement INT;
ALTER TABLE Materiels ADD FOREIGN KEY (ID_Evenement) REFERENCES Evenements(ID_Evenement);


ALTER TABLE Evenements ADD COLUMN ID_Administrateur INT;
ALTER TABLE Evenements ADD FOREIGN KEY (ID_Administrateur) REFERENCES Administrateurs(ID_Administrateur);


ALTER TABLE Ressources ADD COLUMN ID_Administrateur INT;
ALTER TABLE Ressources ADD FOREIGN KEY (ID_Administrateur) REFERENCES Administrateurs(ID_Administrateur);
ALTER TABLE Ressources ADD COLUMN ID_Activite INT;
ALTER TABLE Ressources ADD FOREIGN KEY (ID_Activite) REFERENCES Activites(ID_Activite);

ALTER TABLE Tickets ADD COLUMN Date_Modification DATE;
ALTER TABLE Tickets ADD COLUMN ID_Modificateur INT;
ALTER TABLE Tickets ADD FOREIGN KEY (ID_Modificateur) REFERENCES Utilisateurs(ID_Utilisateur);

