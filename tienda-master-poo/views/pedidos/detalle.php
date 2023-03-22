<h1>Detalle del pedido</h1>

<?php if (isset($pedido)) :  ?>
    <?php if (isset($_SESSION['admin'])) :  ?>
        <h3>Cambiar estado del pedido</h3>
        <?php $estado = Utils::showStatus($pedido->estado); ?>
        <form action="<?= base_url ?>pedido/estado" method="POST">
            <input type="hidden" value="<?= $pedido->id ?>" name="pedido_id" />
            <select name="estado" id="">
                <option value="confirm" <?= $pedido->estado == 'confirm' ? 'selected' : ''; ?>>Pendiente</option>
                <option value="preparation" <?= $pedido->estado == 'preparation' ? 'selected' : ''; ?>>En preparación</option>
                <option value="ready" <?= $pedido->estado == 'ready' ? 'selected' : ''; ?>>Preparado para enviar</option>
                <option value="sended" <?= $pedido->estado == 'sended' ? 'selected' : ''; ?>>Enviado</option>
            </select>

            <input type="submit" value="Cambiar estado" />
        </form>
        <br>
    <?php endif;  ?>

    <h3>Dirección de envio</h3>
    Provincia: <?= $pedido->provincia  ?> <br>
    Ciudad: <?= $pedido->localidad ?><br>
    Direccion: <?= $pedido->direccion ?><br><br>

    <h3>Datos del pedido</h3>

    Estado: <?= Utils::showStatus($pedido->estado) ?><br>
    Número de pedido: <?= $pedido->id ?> <br>
    Total a pagar: <?= $pedido->coste ?> $<br>
    Productos:
    <table>
        <tr>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Unidades</th>
        </tr>
        <?php while ($producto = $productos->fetch_object()) : ?>
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
                    <?= $producto->unidades; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php endif; ?>