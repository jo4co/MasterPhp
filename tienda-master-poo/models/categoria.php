<?php

class Categoria
{
    private $id;
    private $nombre;
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

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $this->db->real_escape_string($nombre);
        return $this;
    }

    public function getAll()
    {
        $categorias = $this->db->query("CALL get_categorias('')");
        return $categorias;
    }

    public function getOne()
    {
        $categorias = $this->db->query("CALL get_categorias({$this->getId()})");
        return $categorias->fetch_object();
    }

    public function save()
    {
        $result = false;
        if ($this->db) {
            try {
                $sql = "INSERT INTO categorias 
                    VALUES (NULL,
                    '{$this->getNombre()}')";
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
