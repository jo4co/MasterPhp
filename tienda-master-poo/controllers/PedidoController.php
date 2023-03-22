<?php
require_once 'models/pedido.php';
class pedidoController
{
    public function hacer()
    {
        require_once 'views/pedidos/hacer.php';
    }

    public function add()
    {
        if (isset($_SESSION['identity'])) {
            $usuario_id = $_SESSION['identity']->id;
            $provincia = isset($_POST['provincia']) ? $_POST['provincia'] : false;
            $localidad = isset($_POST['localidad']) ? $_POST['localidad'] : false;
            $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : false;

            $stats = Utils::statsCarrito();
            $coste = $stats['total'];

            if ($provincia && $localidad && $direccion) {
                // Guardar datos en BD
                $pedido = new Pedido();
                $pedido->setUsuario_id($usuario_id);
                $pedido->setProvincia($provincia);
                $pedido->setLocalidad($localidad);
                $pedido->setDireccion($direccion);
                $pedido->setCoste($coste);

                $save = $pedido->save();

                // guardar linea pedido
                $save_linea = $pedido->save_linea();

                if ($save && $save_linea) {
                    $_SESSION['pedido'] = "complete";
                } else {
                    $_SESSION['pedido'] = "failed";
                }
            } else {
                $_SESSION['pedido'] = "failed by data";
            }

            header("Location:" . base_url . 'pedido/confirmado');
        } else {
            // redirigir al index
            header("Location:" . base_url);
        }
    }

    public function confirmado()
    {
        if (isset($_SESSION['identity'])) {
            $identity = $_SESSION['identity'];
            $pedido = new Pedido();
            $pedido->setUsuario_id($identity->id);
            $pedido = $pedido->getOneByUser();

            $pedido_productos = new Pedido();
            $productos = $pedido_productos->getProductsByPedido($pedido->id);
        }
        require_once 'views/pedidos/confirmado.php';
    }

    public function mispedidos()
    {
        Utils::isIdentity();
        $usuario_id = $_SESSION['identity']->id;
        $pedido = new Pedido();
        //sacar los pedidos del usuario
        $pedido->setUsuario_id($usuario_id);
        $pedidos = $pedido->getAllByUser();

        require_once 'views/pedidos/mispedidos.php';
    }

    public function detalle()
    {
        Utils::isIdentity();
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            //Sacar el pedido
            $pedido = new Pedido();
            $pedido->setId($id);
            $pedido = $pedido->getOne();

            //Sacar los productos
            $pedido_productos = new Pedido();
            $productos = $pedido_productos->getProductsByPedido($id);
            require_once 'views/pedidos/detalle.php';
        } else {
            header('Location:' . base_url . 'pedido/mispedidos');
        }
    }

    public function gestion()
    {
        Utils::isAdmin();
        $gestion = true;
        $pedido = new Pedido();

        //sacar los pedidos del usuario
        $pedidos = $pedido->getAll();

        require_once 'views/pedidos/mispedidos.php';
    }

    public function estado()
    {
        Utils::isAdmin();
        if (isset($_POST['pedido_id']) && isset($_POST['estado'])) {
            // Recojo los datos del formulario
            $id = $_POST['pedido_id'];
            $estado = $_POST['estado'];
            // Update pedido

            $pedido = new Pedido;
            $pedido->setId($id);
            $pedido->setEstado($estado);
            $pedido->edit();
            header("Location:" . base_url . 'pedido/detalle/' . $id);
        } else {
            header("Location:" . base_url);
        }
    }
}
