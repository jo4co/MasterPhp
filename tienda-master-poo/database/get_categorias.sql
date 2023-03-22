USE `tienda_master`;
DROP procedure IF EXISTS `get_categorias`;

USE `tienda_master`;
DROP procedure IF EXISTS `tienda_master`.`get_categorias`;
;

DELIMITER $$
USE `tienda_master`$$
CREATE DEFINER=`user`@`%` PROCEDURE `get_categorias`(in in_id varchar(50))
BEGIN
   	DECLARE id_ varchar(50) default '';
    SET id_ = in_id;
    
    IF (id_ is null OR id_ = '') THEN    
		Select * from categorias order by 1 desc;
    ELSE 
			Select * from categorias where id = id_ order by 1 desc;
    END IF; 

END$$

DELIMITER ;
;