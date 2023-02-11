DELIMITER //
DROP PROCEDURE IF EXISTS SP_UserSelect //
CREATE PROCEDURE SP_UserSelect (v_email VARCHAR(50))
BEGIN

    SELECT u.idUser, u.firstname, u.lastname, u.pseudo, u.email, u.password, DATE_FORMAT(u.created_at, 'Le %d/%m/%Y à %H:%i') as created_at_fr, u.user_role_label, u.role_id
    FROM user AS u
    WHERE LOwER(email) = LOWER(v_email)
    AND idUser <> 1;

END //