DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticlesAllByCategorySelect //
CREATE PROCEDURE SP_ArticlesAllByCategorySelect (v_category_slug VARCHAR(128), v_status_id INT)
BEGIN 

    SELECT art.idArt, art.title, art.description, art.content, art.image, art.slug AS article_slug, art.category_id, DATE_FORMAT(art.created_at, 'Le %d/%m/%Y à %H:%i') AS date_fr, cat.category_name, cat.slug AS category_slug, u.pseudo
    FROM article AS art
    INNER JOIN user AS u ON art.user_id = u.idUser
    INNER JOIN category AS cat ON art.category_id = cat.idCat
    INNER JOIN status AS sta ON art.status_id = sta.idSta
    WHERE LOWER(cat.slug) = LOWER(v_category_slug)
    AND art.status_id = v_status_id
    ORDER BY art.created_at DESC;

END //