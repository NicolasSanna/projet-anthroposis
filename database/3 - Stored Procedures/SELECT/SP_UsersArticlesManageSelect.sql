DELIMITER //
DROP PROCEDURE IF EXISTS SP_UsersArticlesManageSelect //
CREATE PROCEDURE SP_UsersArticlesManageSelect (v_role_id INT)
BEGIN

    SELECT art.title, art.description, art.slug, DATE_FORMAT(art.created_at, 'Le %d/%m/%Y à %H:%i') AS date_fr, u.pseudo, sta.status_label
    FROM article AS art
    INNER JOIN user AS u ON art.user_id = u.idUser
    INNER JOIN status sta ON art.status_id = sta.idSta
    WHERE sta.idSta = v_role_id
    ORDER BY art.created_at DESC;

END //