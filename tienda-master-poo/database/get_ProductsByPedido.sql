USE `tienda_master`;
DROP procedure IF EXISTS `get_ProductsByPedido`;

USE `tienda_master`;
DROP procedure IF EXISTS `tienda_master`.`get_ProductsByPedido`;
;

DELIMITER $$
USE `tienda_master`$$
CREATE DEFINER=`user`@`%` PROCEDURE `get_ProductsByPedido`(in in_id varchar(50))
BEGIN
	DECLARE id_ varchar(50) default '';
    SET id_ = in_id;
    
    IF (id_ is null OR id_ = '') THEN    
		Select 'Empty result';
    ELSE 
		SELECT pr.*, lp.unidades
        FROM productos pr
        INNER JOIN lineas_pedidos lp on pr.id = lp.producto_id
        WHERE lp.pedido_id = in_id;
        
    END IF;
END$$

DELIMITER ;
;

