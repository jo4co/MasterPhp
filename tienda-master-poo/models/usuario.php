<?php

class Usuario
{
    private $id;
    private $nombre;
    private $apellidos;
    private $email;
    private $password;
    private $rol;
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
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $this->db->real_escape_string($nombre);
    }

    public function getApellidos()
    {
        return $this->apellidos;
    }

    public function setApellidos($apellidos)
    {
        $this->apellidos = $this->db->real_escape_string($apellidos);
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $this->db->real_escape_string($email);
    }

    public function getPassword()
    {
        return MD5($this->db->real_escape_string($this->password));
        // Se encripta de manera simple por pruebas, se comenta una mejor encriptacion
        //return password_hash($this->db->real_escape_string($this->password),PASSWORD_BCRYPT,['cost'=>4]);
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getRol()
    {
        return $this->rol;
    }

    public function setRol($rol)
    {
        $this->rol = $this->db->real_escape_string($rol);
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }

    public function save()
    {
        $result = false;
        if ($this->db) {
            try {
                $sql = "INSERT INTO usuarios 
                    VALUES (NULL,
                    '{$this->getNombre()}',
                    '{$this->getApellidos()}',
                    '{$this->getEmail()}',
                    '{$this->getPassword()}',
                    'user',
                    null)";
                $save = $this->db->query($sql);
                if ($save) {
                    $result = true;
                }
            } catch (mysqli_sql_exception $e) {
                $_SESSION['mysql_error'] = utils::mysqlerrores($e->getMessage()) . $this->getEmail();
                $this->db->close();
                return false;
            }
            $this->db->close();
        }
        return $result;
    }

    public function login()
    {
        $result = false;
        $email = $this->email;
        $password = $this->password;
        // Existe el usuario
        $sql = "SELECT * FROM usuarios WHERE email = '$email'";
        $login = $this->db->query($sql);

        if ($login && $login->num_rows == 1) {
            $usuario = $login->fetch_object();

            // verifico la contraseña

            $verify = md5($password) == $usuario->password ? true : false;
            //$verify = password_verify($password, $usuario->password);
            if ($verify) {
                $result = $usuario;
            }
        }
        return $result;
    }
}
