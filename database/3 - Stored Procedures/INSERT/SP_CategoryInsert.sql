DELIMITER //
DROP PROCEDURE IF EXISTS SP_CategoryInsert //
CREATE PROCEDURE SP_CategoryInsert (v_category VARCHAR(128), v_category_slug VARCHAR(128))
BEGIN

    DECLARE message VARCHAR(512);
    DECLARE existCategory SMALLINT DEFAULT 0;

    SELECT COUNT(idCat)
    INTO existCategory
    FROM category
    WHERE LOWER(category_name) = LOWER(v_category);

    IF (existCategory > 0) THEN

        SET message = CONCAT('La catégorie ', v_category, ' existe déjà');

    ELSE

        INSERT INTO category (category_name, slug)
        VALUES
        (v_category, v_category_slug);

        SET message = CONCAT('La catégorie ', v_category, ' a bien été ajoutée');

    END IF;

    SELECT message;

END //