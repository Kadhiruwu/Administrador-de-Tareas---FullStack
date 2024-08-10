<div class="contenedor crear">

    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crea tu cuenta en UpTask</p>

        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

        <form action="/crear" class="formulario" method="POST">

            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" placeholder="Ingresa tu nombre" name="nombre" value="<?php echo $usuario->nombre;?>">
            </div>
            <div class="campo">
                <label for="email">E-Mail</label>
                <input type="email" id="email" placeholder="Ingresa tu Email" name="email" value="<?php echo $usuario->email;?>">
            </div>
            <div class="campo">
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Ingresa tu Password" name="password">
            </div>
            <div class="campo">
                <label for="password2">Confirmar Password</label>
                <input type="password" id="password2" placeholder="Ingresa tu Password nuevamente" name="password2">
            </div>

            <input type="submit" class="boton" value="Crear Cuenta">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? Inicia Sesion</a>
            <a href="/olvide">¿Olvidaste tu password? Recuperalo aquí</a>
        </div>
    </div> <!--contenedor-sm-->
</div>