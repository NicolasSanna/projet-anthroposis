DELIMITER //
DROP PROCEDURE IF EXISTS SP_CategoryWithoutArticlesDelete //
CREATE PROCEDURE SP_CategoryWithoutArticlesDelete (v_category_id INT)
BEGIN 

    UPDATE article AS art
    SET art.category_id = 1
    WHERE art.category_id = v_category_id;

    DELETE
    FROM category AS cat
    WHERE cat.idCat = v_category_id;

END //