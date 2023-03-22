<?php

class Producto
{
    private $id;
    private $categoria_id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $stock;
    private $oferta;
    private $fecha;
    private $imagen;
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

    public function getCategoria_id()
    {
        return $this->categoria_id;
    }

    public function setCategoria_id($categoria_id)
    {
        $this->categoria_id = $categoria_id;

        return $this;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $this->db->real_escape_string($nombre);

        return $this;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $this->db->real_escape_string($descripcion);

        return $this;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function setPrecio($precio)
    {
        $this->precio = $this->db->real_escape_string($precio);
        return $this;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function setStock($stock)
    {
        $this->stock = $this->db->real_escape_string($stock);
        return $this;
    }

    public function getOferta()
    {
        return $this->oferta;
    }

    public function setOferta($oferta)
    {
        $this->oferta = $this->db->real_escape_string($oferta);

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

    public function getImagen()
    {
        return $this->imagen;
    }

    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
        return $this;
    }

    public function getAll()
    {
        $productos = $this->db->query("CALL get_productos('')");
        return $productos;
    }

    public function getAllCategory()
    {
        $productos = $this->db->query("CALL get_productosByCategoria('{$this->getCategoria_id()}')");
        return $productos;
    }

    public function getRandom($limit)
    {
        $productos = $this->db->query("CALL get_RandomProductos('{$limit}')");
        return $productos;
    }

    public function getOne()
    {
        $productos = $this->db->query("CALL get_productos({$this->getId()})");
        return $productos->fetch_object();
    }

    public function save()
    {
        $result = false;

        if ($this->db) {
            try {
                $sql = "INSERT INTO productos 
                    VALUES (NULL,
                    '{$this->getCategoria_id()}',
                    '{$this->getNombre()}',
                    '{$this->getdescripcion()}',
                    {$this->getPrecio()},
                    {$this->getStock()},
                    NULL,
                    CURDATE(),
                    '{$this->getImagen()}')";
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

    public function edit()
    {
        $result = false;

        if ($this->db) {
            try {
                $sql = "UPDATE productos 
                    SET nombre='{$this->getNombre()}',
                    descripcion='{$this->getdescripcion()}',
                    precio='{$this->getPrecio()}',
                    categoria_id='{$this->getCategoria_id()}',
                    stock='{$this->getStock()}' ";

                if ($this->getImagen() != null) {
                    $sql .= ",imagen = '{$this->getImagen()}' ";
                }

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

    public function delete()
    {
        $sql = "DELETE FROM PRODUCTOS WHERE id={$this->id}";
        $delete = $this->db->query($sql);

        $result = false;
        if ($delete) {
            $result = true;
        }
        return $result;
    }
}
