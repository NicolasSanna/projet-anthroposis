DELIMITER //
DROP PROCEDURE IF EXISTS SP_UserUpdate //
CREATE PROCEDURE SP_UserUpdate(v_user_id INT, v_firstname VARCHAR(50), v_lastname VARCHAR(50), v_pseudo VARCHAR(50), v_email VARCHAR(50))
BEGIN

    DECLARE message VARCHAR(512);
    DECLARE existEmail SMALLINT DEFAULT 0;
    DECLARE existPseudo SMALLINT DEFAULT 0;

    SELECT COUNT(idUser)
    INTO existEmail
    FROM user
    WHERE LOWER(email) = LOWER(v_email)
    AND idUser <> v_user_id;

    SELECT COUNT(idUser)
    INTO existPseudo
    FROM user
    WHERE LOWER(pseudo) = LOwER(v_pseudo)
    AND idUser <> v_user_id;

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

        UPDATE user AS u
        SET u.lastname = v_lastname,
            u.firstname = v_firstname,
            u.pseudo = v_pseudo,
            u.email = v_email
        WHERE u.idUser = v_user_id;

        SET message = "Vos informations ont bien été modifiées.";

    END IF;

    SELECT message;

END //