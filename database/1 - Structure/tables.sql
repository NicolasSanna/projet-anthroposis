-- On indique quelle base de données va recevoir les tables.
USE 

-- Sur MySQL Workbench, cette fonction permet de ne pas tenir compte des clés étrangères. Mais il faut les réactiver à la fin.
-- SET foreign_key_checks = 0;

-- On commence la création des tables ici.
DROP TABLE IF EXISTS ;
CREATE TABLE 
(
    id INT NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (id)
) ENGINE = InnoDB;