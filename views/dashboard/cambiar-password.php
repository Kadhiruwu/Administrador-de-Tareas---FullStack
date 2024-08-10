<?php  include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php' ?>
    <a href="/perfil" class="enlace">Volver al Perfil</a>
    <form action="/cambiar-password" class="formulario" method="POST">
        <div class="campo">
            <label for="password_actual">Passoword Actual:</label>
            <input type="password" name="password_actual" placeholder="Ingresa tu password actual">
        </div>

        <div class="campo">
            <label for="password_nuevo">Password Nuevo:</label>
            <input type="password" name="password_nuevo" placeholder="Confirma tu password">
        </div>

        <input type="submit" class="boton" value="Guardar Cambios">
    </form>
</div>

<?php  include_once __DIR__ . '/footer-dashboard.php'; ?>