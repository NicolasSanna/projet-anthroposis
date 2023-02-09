USE anthroposis;

START TRANSACTION;

    INSERT INTO role (idRole, role_label)
    VALUES
    (1, 'Administrateur'),
    (2, 'Auteur'),
    (3, 'Inscrit');

    INSERT INTO category (idCat, category_name, slug)
    VALUES
    (1, 'Non classé', 'non-classe');

    INSERT INTO user (idUser, firstname, lastname, pseudo, email, password, created_at, user_role_label, role_id)
    VALUES (1, 'Anonyme', 'Anonyme', 'Anonyme', 'Anonyme', 'Anonyme', NOW(), "['ROLE_NEW_USER']", 3);

    INSERT INTO status (idSta, status_label)
    VALUES
    (1, "En attente d'approbation"),
    (2, "Approuvé");

COMMIT;