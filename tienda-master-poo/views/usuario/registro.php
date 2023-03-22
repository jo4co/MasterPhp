<h1>Registrarse</h1>

<form action="<?= base_url ?>usuario/save" method="POST">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" required>

    <label for="apellido">Apellidos</label>
    <input type="text" name="apellido" required>

    <label for="email">Email</label>
    <input type="email" name="email" required>

    <label for="password">Contraseña</label>
    <input type="password" name="password" required>

    <input type="submit" value="Registrarse">
</form>

<?php if (isset($_SESSION['register']) && $_SESSION['register'] && $_SESSION['register'] == 'complete') : ?>
    </br>
    <center><strong class="alert_green"> ¡Registro Completado Correctamente!</strong></center>
<?php elseif (isset($_SESSION['register']) && $_SESSION['register'] && $_SESSION['register'] == 'failed') : ?>
    </br>
    <center><strong class="alert_red"> ¡ ¡ Registro Fallido, verifica los datos ! ! <?= $_SESSION['mysql_error'] ?> </strong></center>
<?php endif; ?>
<?php Utils::deleteSesion('register') ?>
<?php Utils::deleteSesion('mysql_error') ?>

<?php
