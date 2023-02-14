DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticleManageUpdate //
CREATE PROCEDURE SP_ArticleManageUpdate (v_article_slug VARCHAR(128), v_status_id INT)
BEGIN

    UPDATE article AS art
    SET art.status_id = v_status_id
    WHERE art.slug = v_article_slug;

END //