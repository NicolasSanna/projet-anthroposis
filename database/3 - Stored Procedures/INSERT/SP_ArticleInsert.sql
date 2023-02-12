DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticleInsert //
CREATE PROCEDURE SP_ArticleInsert (v_title VARCHAR(255), v_description VARCHAR(255), v_content LONGTEXT, v_image VARCHAR(128), v_slug VARCHAR(128), v_user_id INT, v_category_id INT, v_status_id INT)
BEGIN

    INSERT INTO article (title, description, content, image, slug, created_at, updated_at, user_id, category_id, status_id)
    VALUES (v_title, v_description, v_content, v_image, v_slug, NOW(), NOW(), v_user_id, v_category_id, v_status_id);

END //