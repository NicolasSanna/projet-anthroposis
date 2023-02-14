DELIMITER //
DROP PROCEDURE IF EXISTS SP_UserManageUpdate //
CREATE PROCEDURE SP_UserManageUpdate (v_user_id INT, v_role_id INT, v_role_label VARCHAR(128))
BEGIN 

    UPDATE user AS u
    SET u.user_role_label = v_role_label,
        u.role_id = v_role_id
    WHERE u.idUser = v_user_id;

END //