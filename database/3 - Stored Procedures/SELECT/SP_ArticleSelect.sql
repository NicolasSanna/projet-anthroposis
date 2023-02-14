DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticleSelect //
CREATE PROCEDURE SP_ArticleSelect (v_article_slug VARCHAR(128))
BEGIN

    SELECT art.idArt, art.title, art.description, art.content, art.image, art.slug AS article_slug, art.category_id, DATE_FORMAT(art.created_at, 'Le %d/%m/%Y à %H:%i') AS date_fr, cat.category_name, cat.slug AS category_slug, u.pseudo
    FROM article AS art
    INNER JOIN user AS u ON art.user_id = u.idUser
    INNER JOIN category cat ON art.category_id = cat.idCat
    WHERE LOWER(art.slug) = LOWER(v_article_slug);

END //