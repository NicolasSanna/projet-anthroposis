DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticleUpdate //
CREATE PROCEDURE SP_ArticleUpdate (v_title VARCHAR(255), v_description VARCHAR(255), v_content LONGTEXT, v_image VARCHAR(128), v_slug VARCHAR(128), v_user_id INT, v_category_id INT, v_status_id INT, v_article_id INT)
BEGIN

    UPDATE article
    SET title = v_title,
        description = v_description,
        content = v_content,
        image = v_image,
        slug = v_slug,
        updated_at = NOW(),
        category_id = v_category_id,
        status_id = v_status_id
    WHERE idArt = v_article_id
    AND user_id = v_user_id;

END //