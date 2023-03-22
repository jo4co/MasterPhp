USE `tienda_master`;
DROP procedure IF EXISTS `get_RandomProductos`;

USE `tienda_master`;
DROP procedure IF EXISTS `tienda_master`.`get_RandomProductos`;
;

DELIMITER $$
USE `tienda_master`$$
CREATE DEFINER=`user`@`%` PROCEDURE `get_RandomProductos`(in in_limit varchar(5))
BEGIN
    DECLARE limit_ INT DEFAULT 10;
    SET limit_ = CAST(in_limit AS UNSIGNED);

	SELECT * FROM productos ORDER BY RAND() LIMIT limit_;

END$$

DELIMITER ;
;

