DELIMITER //
DROP PROCEDURE IF EXISTS SP_CategoryUpdate //
CREATE PROCEDURE SP_CategoryUpdate (v_category_id INT, v_category VARCHAR(128), v_category_slug VARCHAR(128))
BEGIN

    DECLARE duplicate SMALLINT DEFAULT 0;
    DECLARE message VARCHAR(512);

    SELECT COUNT(cat.idCat)
    INTO duplicate
    FROM category AS cat
    WHERE LOWER(cat.category_name) = LOWER(v_category)
    AND cat.idCat <> v_category_id;

    IF (duplicate > 0) THEN

        SET message = CONCAT('Une autre catégorie ', v_category, ' existe déjà');

    ELSE

        UPDATE category AS cat
        SET cat.category_name = v_category,
            cat.slug = v_category_slug
        WHERE cat.idCat = v_category_id;

        SET message = CONCAT ('La catégorie ', v_category, ' a bien été modifiée');

    END IF;

    SELECT message;

END //