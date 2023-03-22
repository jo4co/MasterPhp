USE `tienda_master`;
DROP procedure IF EXISTS `get_allPedidosByUser`;

USE `tienda_master`;
DROP procedure IF EXISTS `tienda_master`.`get_allPedidosByUser`;
;

DELIMITER $$
USE `tienda_master`$$
CREATE DEFINER=`user`@`%` PROCEDURE `get_allPedidosByUser`(in in_id varchar(50))
BEGIN
	DECLARE id_ varchar(50) default '';
    SET id_ = in_id;
    
    IF (id_ is null OR id_ = '') THEN    
		Select 'Empty result';
    ELSE 
		SELECT p.*
		FROM pedidos as p
		WHERE p.usuario_id = id_
        ORDER BY id DESC;
        
    END IF;
END$$

DELIMITER ;
;