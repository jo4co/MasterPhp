<h1>Carrito de la compra</h1>

<?php if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) >= 1) : ?>
    <table class="">
        <tr>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Unidades</th>
            <th>Eliminar</th>
        </tr>
        <?php
        foreach ($carrito as $indice => $elemento) :
            $producto = $elemento['producto'];
        ?>
            <tr>
                <td>
                    <?php if ($producto->imagen != null || $producto->imagen != '') : ?>
                        <img src="<?= base_url ?>uploads/images/<?= $producto->imagen ?>" alt="Camiseta" class="img_carrito" />
                    <?php else : ?>
                        <img src="<?= base_url ?>assets/img/camiseta.png" alt="Camiseta" class="img_carrito" />
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= base_url ?>producto/ver/<?= $producto->id; ?>"><?= $producto->nombre; ?></a>
                </td>
                <td>
                    <?= $producto->precio; ?>
                </td>
                <td>
                    <?= $elemento['unidades']; ?>
                    <div class="updown-unidades">
                        <a href=" <?= base_url ?>carrito/up/<?= $indice ?>" class="button "><i class="fa fa-plus"></i></a>
                        <a href=" <?= base_url ?>carrito/down/<?= $indice ?>" class="button button-minus "><i class="fa fa-minus"></i></a>
                    </div>
                </td>
                <td>
                    <a href=" <?= base_url ?>carrito/delete/<?= $indice ?>" class="button button-tabla-pedidos button-red "><i class="fa fa-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table><br>

    <div class="delete-carrito">
        <a href=" <?= base_url ?>carrito/deleteAll" class="button button-delete button-red">Vaciar carrito</a>
    </div>
    <div class="total-carrito">
        <?php $stats = Utils::statsCarrito(); ?>
        <h3>Precio total: <?= $stats['total'] ?>$</h3>

        <a href="<?= base_url ?>pedido/hacer" class="button button-pedidos">Hacer pedido</a>
    </div>

<?php else : ?>
    <p>El carrito está vacio, añade algun producto</p>

<?php endif; ?>