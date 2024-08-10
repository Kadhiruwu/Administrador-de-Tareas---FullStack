<div class="contenedor reestablecer">

    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Registra una nueva contraseña</p>
        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

        <?php if($mostrar){ ?> <!--Para q no se muestre el formulario en caso no sea token valido-->

       
        <form class="formulario" method="POST">
            <div class="campo">
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Ingresa tu Password" name="password">
            </div>

            <input type="submit" class="boton" value="Guardar Password">
        </form>
            <?php  } ?>
        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? Inicia Sesion</a>    
            <a href="/olvide">¿Olvidaste tu password? Recuperalo aquí</a>
        </div>
    </div> <!--contenedor-sm-->
</div>