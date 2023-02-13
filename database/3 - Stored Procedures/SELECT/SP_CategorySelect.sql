DELIMITER //
DROP PROCEDURE IF EXISTS SP_CategorySelect //
CREATE PROCEDURE SP_CategorySelect(v_category_slug VARCHAR(128))
BEGIN

    SELECT cat.idCat, cat.category_name, cat.slug
    FROM category AS cat
    WHERE LOWER(cat.slug) = v_category_slug;

END //