-- On indique quelle base de données va recevoir les tables.
USE anthroposis;

ALTER TABLE user DROP CONSTRAINT fk_user_role;
ALTER TABLE article DROP CONSTRAINT fk_article_category;
ALTER TABLE article DROP CONSTRAINT fk_article_user;
ALTER TABLE article DROP CONSTRAINT fk_article_status;
ALTER TABLE comment DROP CONSTRAINT fk_comment_user;
ALTER TABLE comment DROP CONSTRAINT fk_comment_status;
ALTER TABLE comment DROP CONSTRAINT fk_comment_article;

START TRANSACTION;

    DROP TABLE IF EXISTS role;
    CREATE TABLE role 
    (
        idRole INT UNSIGNED NOT NULL AUTO_INCREMENT,
        role_label VARCHAR(50) NOT NULL,
        PRIMARY KEY (idRole)
    ) ENGINE = InnoDB;

    DROP TABLE IF EXISTS status;
    CREATE TABLE status
    (
        idSta INT UNSIGNED NOT NULL AUTO_INCREMENT,
        status_label VARCHAR(50) NOT NULL,
        PRIMARY KEY (idSta)
    ) ENGINE = InnoDB;

    DROP TABLE IF EXISTS category;
    CREATE TABLE category
    (
        idCat INT UNSIGNED NOT NULL AUTO_INCREMENT,
        category_name VARCHAR(128) NOT NULL,
        slug VARCHAR(128) NOT NULL,
        PRIMARY KEY (idCat)
    ) ENGINE = InnoDB;

    DROP TABLE IF EXISTS user;
    CREATE TABLE user
    (
        idUser INT UNSIGNED NOT NULL AUTO_INCREMENT,
        firstname VARCHAR(50) NOT NULL,
        lastname VARCHAR(50) NOT NULL,
        pseudo VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at DATETIME NOT NULL,
        user_role_label VARCHAR(50) NOT NULL,
        role_id INT UNSIGNED NOT NULL,
        PRIMARY KEY (idUser),
            CONSTRAINT fk_user_role
            FOREIGN KEY (role_id)
                REFERENCES role (idRole) ON UPDATE CASCADE
    ) ENGINE = InnoDB;

    DROP TABLE IF EXISTS article;
    CREATE TABLE article
    (
        idArt INT UNSIGNED NOT NULL AUTO_INCREMENT,
        title VARCHAR(255) NOT NULL,
        description VARCHAR(255) NOT NULL,
        content LONGTEXT NOT NULL,
        image VARCHAR(255) NULL,
        slug VARCHAR(128) NOT NULL,
        created_at DATETIME NOT NULL,
        updated_at DATETIME NULL,
        user_id INT UNSIGNED NOT NULL,
        category_id INT UNSIGNED NOT NULL,
        status_id INT UNSIGNED NOT NULL,
        PRIMARY KEY (idArt),
            CONSTRAINT fk_article_user
            FOREIGN KEY (user_id)
                REFERENCES user (idUser) ON UPDATE CASCADE,
            CONSTRAINT fk_article_category
            FOREIGN KEY (category_id)
                REFERENCES category (idCat) ON UPDATE CASCADE,
            CONSTRAINT fk_article_status
                FOREIGN KEY (status_id)
                REFERENCES status (idSta) ON UPDATE CASCADE
    ) ENGINE = InnoDB;

    DROP TABLE IF EXISTS comment;
    CREATE TABLE comment
    (
        idCom INT UNSIGNED NOT NULL AUTO_INCREMENT,
        content TEXT NOT NULL,
        created_at DATETIME NOT NULL,
        user_id INT UNSIGNED NOT NULL,
        article_id INT UNSIGNED NOT NULL,
        status_id INT UNSIGNED NOT NULL,
        PRIMARY KEY (idCom),
            CONSTRAINT fk_comment_user
            FOREIGN KEY (user_id)
                REFERENCES user (idUser) ON UPDATE CASCADE ON DELETE CASCADE,
            CONSTRAINT fk_comment_article
            FOREIGN KEY (article_id)
                REFERENCES article (idArt) ON UPDATE CASCADE ON DELETE CASCADE,
            CONSTRAINT fk_comment_status
                FOREIGN KEY (status_id)
                REFERENCES status (idSta) ON UPDATE CASCADE ON DELETE CASCADE
    ) ENGINE = InnoDB;

COMMIT;