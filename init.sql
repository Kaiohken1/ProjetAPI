CREATE TABLE appartement (
    id serial PRIMARY KEY,
    superficie int,
    personnes int,
    adresse varchar(255),
    disponibilite boolean,
    prix int,
    proprietaireId int REFERENCES utilisateur(id) 
);

CREATE TABLE reservation (
    id serial PRIMARY KEY,
    appartementId int REFERENCES appartement(id),
    dateDebut date,
    dateFin date,
    clientUserId int REFERENCES utilisateur(id),
    prix int
);

CREATE TABLE utilisateur (
    id serial PRIMARY KEY,
    nom varchar(255), 
    role varchar(255)
);
