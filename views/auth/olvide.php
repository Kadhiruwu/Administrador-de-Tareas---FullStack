<div class="contenedor olvide">

    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Ingresa el correo Para mandarte las Instrucciones</p>
        <form action="/olvide" class="formulario" method="POST" novalidate>

    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
  
            <div class="campo">
                <label for="email">E-Mail</label>
                <input type="email" id="email" placeholder="Ingresa tu Email" name="email">
            </div>

            <input type="submit" class="boton" value="Enviar Instrucciones">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? Inicia Sesion</a>
            <a href="/crear">¿No tienes una cuenta? Crea una</a>
        </div>
    </div> <!--contenedor-sm-->
</div>