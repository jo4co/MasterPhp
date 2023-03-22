<?php

class Pedido
{
    private $id;
    private $usuario_id;
    private $provincia;
    private $localidad;
    private $direccion;
    private $coste;
    private $estado;
    private $fecha;
    private $hora;

    private $db;

    public function __construct()
    {
        $this->db = Database::conectar();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getUsuario_id()
    {
        return $this->usuario_id;
    }

    public function setUsuario_id($usuario_id)
    {
        $this->usuario_id = $usuario_id;

        return $this;
    }

    public function getProvincia()
    {
        return $this->provincia;
    }

    public function setProvincia($provincia)
    {
        $this->provincia = $this->db->real_escape_string($provincia);

        return $this;
    }

    public function getLocalidad()
    {
        return $this->localidad;
    }

    public function setLocalidad($localidad)
    {
        $this->localidad = $this->db->real_escape_string($localidad);

        return $this;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function setDireccion($direccion)
    {
        $this->direccion = $this->db->real_escape_string($direccion);

        return $this;
    }

    public function getCoste()
    {
        return $this->coste;
    }

    public function setCoste($coste)
    {
        $this->coste = $coste;

        return $this;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getHora()
    {
        return $this->hora;
    }

    public function setHora($hora)
    {
        $this->hora = $hora;
        return $this;
    }


    public function getAll()
    {
        $productos = $this->db->query("CALL get_pedidos('')");
        return $productos;
    }

    public function getOne()
    {
        $productos = $this->db->query("CALL get_pedidos({$this->getId()})");
        return $productos->fetch_object();
    }

    public function getProductsByPedido($id)
    {
        $productos = $this->db->query("CALL get_ProductsByPedido({$id})");
        return $productos;
    }

    public function getAllByUser()
    {
        $pedido = $this->db->query("CALL get_allPedidosByUser({$this->getUsuario_id()})");
        return $pedido;
    }

    public function getOneByUser()
    {
        $pedido = $this->db->query("CALL get_pedidosByUser({$this->getUsuario_id()})");
        return $pedido->fetch_object();
    }

    public function save()
    {
        $result = false;

        if ($this->db) {
            try {
                $sql = "INSERT INTO pedidos 
                    VALUES (NULL,
                    '{$this->getUsuario_id()}',
                    '{$this->getprovincia()}',
                    '{$this->getLocalidad()}',
                    '{$this->getDireccion()}',
                    {$this->getCoste()},
                    'Confirm',
                    CURDATE(),
                    CURTIME())";

                $save = $this->db->query($sql);

                if ($save) {
                    $result = true;
                }
            } catch (mysqli_sql_exception $e) {
                $_SESSION['mysql_error'] = utils::mysqlerrores($e->getMessage());
                $this->db->close();
                return false;
            }
            //$this->db->close();
        }
        return $result;
    }

    public function save_linea()
    {
        $result = false;
        $sql = "SELECT LAST_INSERT_ID() as 'pedido';";

        if ($this->db) {
            try {
                $query = $this->db->query($sql);
                $pedido_id = $query->fetch_object()->pedido;

                foreach ($_SESSION['carrito'] as $elemento) {
                    $producto = $elemento['producto'];
                    $insert = "INSERT INTO lineas_pedidos 
                                VALUES(null,
                                {$pedido_id},
                                {$producto->id},
                                {$elemento['unidades']},
                                {$elemento['precio']})";
                    $save = $this->db->query($insert);
                }
                if ($save) {
                    $result = true;
                }
            } catch (mysqli_sql_exception $e) {
                $_SESSION['mysql_error'] = utils::mysqlerrores($e->getMessage());
                $this->db->close();
                return false;
            }
            $this->db->close();
        }
        return $result;
    }

    public function edit()
    {
        $result = false;

        if ($this->db) {
            try {
                $sql = "UPDATE pedidos 
                    SET estado='{$this->getEstado()}' ";
                $sql .= "WHERE id='{$this->getId()}';";
                $save = $this->db->query($sql);

                if ($save) {
                    $result = true;
                }
            } catch (mysqli_sql_exception $e) {
                $_SESSION['mysql_error'] = utils::mysqlerrores($e->getMessage());
                $this->db->close();
                return false;
            }
            $this->db->close();
        }
        return $result;
    }
}
