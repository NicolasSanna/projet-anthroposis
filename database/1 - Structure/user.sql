-- À la première utilisation d'une base de données, l'utilisateur root possède tous les privilèges, il faut donc le sécuriser et lui assigner un mot de passe.
ALTER USER 'root'@'localhost' IDENTIFIED BY 'TODO';

-- On supprime l'utilisateur que l'on veut créer par sécurité.
DROP USER IF EXISTS '4dm1n'@'localhost';

-- On créé l'utilisateur et on lui donne le vrai mot de passe. Ici, on ne l'indique pas, on met à la place un TODO.
CREATE USER '4dm1n'@'localhost' IDENTIFIED BY 'TODO';

-- Phase de développement : On donne les privilèges nécessaires DDL et DML pendant la phase de création.
GRANT ALL PRIVILEGES
ON anthroposis.*
TO '4dm1n'@'localhost';

FLUSH PRIVILEGES ;

-- Après : Une fois la phase de développée terminée pour mise en production, on retire tous les privilèges sauf ceux nécessaires à l'utilisateur connecté à la base de données. 
REVOKE ALL PRIVILEGES
ON anthroposis.*
FROM '4dm1n'@'localhost';

FLUSH PRIVILEGES ;

GRANT SELECT, INSERT, UPDATE, DELETE, EXECUTE
ON anthroposis.*
TO '4dm1n'@'localhost';

FLUSH PRIVILEGES ;