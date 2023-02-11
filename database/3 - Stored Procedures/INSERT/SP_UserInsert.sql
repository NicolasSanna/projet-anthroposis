DELIMITER //
DROP PROCEDURE IF EXISTS SP_UserInsert //
CREATE PROCEDURE SP_UserInsert (v_firstname VARCHAR(50), v_lastname VARCHAR(50), v_pseudo VARCHAR(50), v_email VARCHAR(50), v_password VARCHAR(255), v_role_new_user_string VARCHAR(50), v_role_new_user_id INT)
BEGIN

    DECLARE message VARCHAR(512);
    DECLARE existEmail SMALLINT DEFAULT 0;
    DECLARE existPseudo SMALLINT DEFAULT 0;

    SELECT COUNT(idUser)
    INTO existEmail
    FROM user
    WHERE LOWER(email) = LOWER(v_email);

    SELECT COUNT(idUser)
    INTO existPseudo
    FROM user
    WHERE LOWER(pseudo) = LOwER(v_pseudo);

    IF (existEmail > 0) THEN

        SET message = "Un autre utilisateur avec cet email existe déjà.";

    END IF;

    IF (existPseudo > 0) THEN

        SET message = "Un autre utilisateur avec ce pseudo existe déjà.";
    
    END IF;

    IF (existEmail > 0 AND existPseudo > 0) THEN

        SET message = "Un autre utilisateur avec cet email et ce pseudo existe déjà.";

    END IF;

    IF (existEmail = 0 AND existPseudo = 0) THEN

        INSERT INTO user (firstname, lastname, pseudo, email, password, created_at, user_role_label, role_id)
        VALUES
        (v_firstname, v_lastname, v_pseudo, v_email, v_password, NOW(), v_role_new_user_string, v_role_new_user_id);

        SET message = "Vous êtes bien enregistré, vous pouvez vous connecter";

    END IF;

    SELECT message;

END //