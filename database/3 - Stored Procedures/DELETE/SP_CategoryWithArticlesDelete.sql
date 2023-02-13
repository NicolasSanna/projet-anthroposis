DELIMITER //
DROP PROCEDURE IF EXISTS SP_CategoryWithArticlesDelete //
CREATE PROCEDURE SP_CategoryWithArticlesDelete (v_category_id INT)
BEGIN

    DELETE
    FROM article AS art
    WHERE art.category_id = v_category_id;

    DELETE
    FROM category AS cat
    WHERE cat.idCat = v_category_id;

END //