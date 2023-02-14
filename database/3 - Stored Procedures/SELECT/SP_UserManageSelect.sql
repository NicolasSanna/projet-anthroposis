DELIMITER //
DROP PROCEDURE IF EXISTS SP_UserManageSelect //
CREATE PROCEDURE SP_UserManageSelect ()
BEGIN

    SELECT u.idUser, u.firstname, u.lastname, u.pseudo, u.email, DATE_FORMAT(u.created_at, 'Le %d/%m/%Y à %H:%i') AS date_fr, r.role_label, COUNT(art.idArt) AS number_articles
    FROM user AS u
    INNER JOIN role AS r ON u.role_id = r.idRole
    LEFT JOIN article art ON u.idUser = art.user_id
    WHERE u.idUser <> 1
    AND u.role_id <> 1
    GROUP BY u.idUser
    ORDER BY u.created_at DESC;

END //