USE `tienda_master`;
DROP procedure IF EXISTS `get_pedidosByUser`;

USE `tienda_master`;
DROP procedure IF EXISTS `tienda_master`.`get_pedidosByUser`;
;

DELIMITER $$
USE `tienda_master`$$
CREATE DEFINER=`user`@`%` PROCEDURE `get_pedidosByUser`(in in_id varchar(50))
BEGIN
	DECLARE id_ varchar(50) default '';
    SET id_ = in_id;
    
    IF (id_ is null OR id_ = '') THEN    
		Select 'Empty result';
    ELSE 
		SELECT p.id, p.coste
		FROM pedidos as p
		INNER JOIN lineas_pedidos as lpe on lpe.pedido_id = p.id
		WHERE usuario_id = id_
        ORDER BY id DESC LIMIT 1;
        
    END IF;
END$$

DELIMITER ;
;