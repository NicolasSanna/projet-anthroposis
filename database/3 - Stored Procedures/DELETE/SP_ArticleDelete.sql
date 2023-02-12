DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticleDelete //
CREATE PROCEDURE SP_ArticleDelete (v_user_id INT, v_article_slug VARCHAR(128))
BEGIN

    DELETE
    FROM article AS art
    WHERE LOWER(art.slug) = LOWER(v_article_slug)
    AND art.user_id = v_user_id;

END //