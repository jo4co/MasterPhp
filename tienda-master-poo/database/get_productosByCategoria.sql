USE `tienda_master`;
DROP procedure IF EXISTS `get_productosByCategoria`;

USE `tienda_master`;
DROP procedure IF EXISTS `tienda_master`.`get_productosByCategoria`;
;

DELIMITER $$
USE `tienda_master`$$
CREATE DEFINER=`user`@`%` PROCEDURE `get_productosByCategoria`(in in_id varchar(50))
BEGIN
	DECLARE id_ varchar(50) default '';
    SET id_ = in_id;
    
    IF (id_ is null OR id_ = '') THEN    
		        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El producto no existe';
    ELSE 
			SELECT p.*, c.nombre AS 'CatNombre'
			FROM productos p
			INNER JOIN categorias c on c.id = p.categoria_id 
			where p.categoria_id = id_
            order by id desc;
    END IF;
END$$

DELIMITER ;
;

