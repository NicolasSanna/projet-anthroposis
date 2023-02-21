DELIMITER //
DROP PROCEDURE IF EXISTS SP_CategoryAllSelect //
CREATE PROCEDURE SP_CategoryAllSelect ()
BEGIN

    SELECT cat.idCat, cat.category_name, cat.slug
    FROM category AS cat
    WHERE cat.idCat <> 1
    ORDER BY cat.category_name DESC;

END //