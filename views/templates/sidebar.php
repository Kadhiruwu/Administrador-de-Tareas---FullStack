<aside class="sidebar">
    <div class="contenedor-sidebar">
        <h2>Uptask</h2>
        <div class="cerrar-menu">
            <img id="cerrar-menu" src="build/img/cerrarbarra.png" alt="imagen cerrar Menu">
        </div>
    </div>


    <nav class="sidebar-nav"> 
        <a class="<?php echo ($titulo === 'Proyectos') ? 'activo' : ''; ?>" href="/dashboard">Proyectos</a>
        <a class="<?php echo ($titulo === 'Crear un Proyecto') ? 'activo' : ''; ?>" href="/crear-proyecto">Crear Proyectos</a>
        <a class="<?php echo ($titulo === 'Perfil') ? 'activo' : ''; ?>" href="/perfil">Perfil</a>
    </nav>

    <div class="cerrar-sesion-mobile">
        <a href="/logout" class="cerrar-sesion">Cerrar Sesión</a>
    </div>
</aside>