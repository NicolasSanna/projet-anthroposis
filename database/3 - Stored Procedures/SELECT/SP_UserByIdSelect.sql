DELIMITER //
DROP PROCEDURE IF EXISTS SP_UserByIdSelect //
CREATE PROCEDURE SP_UserByIdSelect (v_user_id INT)
BEGIN

    SELECT u.idUser, u.firstname, u.lastname, u.pseudo, u.email
    FROM user AS u
    WHERE u.idUser = v_user_id
    AND idUser <> 1;

END //