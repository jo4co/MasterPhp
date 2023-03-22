<?php if (isset($product)) : ?>
    <h1> <?= $product->nombre; ?></h1>

    <div id="detail-product">
        <div class="image">
            <?php if ($product->imagen != null || $product->imagen != '') : ?>
                <img src="<?= base_url ?>uploads/images/<?= $product->imagen ?>" alt="Camiseta" />
            <?php else : ?>
                <img src="<?= base_url ?>assets/img/camiseta.png" alt="Camiseta" />
            <?php endif; ?>
        </div>
        <div class="data">
            <p class="description"><?= $product->descripcion ?></p>
            <p class="price"><?= $product->precio ?>$</p>
            <a href="<?= base_url ?>carrito/add/<?= $product->id ?>" class="button">Comprar</a>
        </div>
    </div>

<?php else : ?>
    <h1>El producto no existe</h1>
<?php endif; ?>