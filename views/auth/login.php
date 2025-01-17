<div class="contenedor login">
    
<?php  include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar Sesión</p>

<?php  include_once __DIR__ . '/../templates/alertas.php'; ?>

        <form action="/" class="formulario" method="POST" novalidate>
            <div class="campo">
                <label for="email">E-Mail</label>
                <input type="email" id="email" placeholder="Ingresa tu Email" name="email">
            </div>
            <div class="campo">
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Ingresa tu Password" name="password">
            </div>

            <input type="submit" class="boton" value="Iniciar Sesión">
        </form>

        <div class="acciones">
            <a href="/crear">¿Áun no tienes una cuenta? crea una aquí</a>
            <a href="/olvide">¿Olvidaste tu password? Recuperalo aquí</a>
        </div>
    </div> <!--contenedor-sm-->
</div>