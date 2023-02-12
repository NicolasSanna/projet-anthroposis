DELIMITER //
DROP PROCEDURE IF EXISTS SP_CategoryAllSelect //
CREATE PROCEDURE SP_CategoryAllSelect ()
BEGIN

    SELECT cat.idCat, cat.category_name
    FROM category AS cat;

END //