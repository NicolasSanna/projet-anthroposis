DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticleUserAllSelect //
CREATE PROCEDURE SP_ArticleUserAllSelect (v_user_id INT)
BEGIN 

    SELECT art.title, art.description, art.slug, DATE_FORMAT(art.created_at, 'Le %d/%m/%Y à %H:%i') AS date_fr, cat.category_name, sta.status_label
    FROM article AS art
    INNER JOIN category AS cat ON art.category_id = cat.idCat
    INNER JOIN status AS sta ON art.status_id = sta.idSta
    WHERE art.user_id = v_user_id
    ORDER BY art.created_at DESC;

END //