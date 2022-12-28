<!-- Inicia aside.sidebar -->
<aside class="sidebar">
    <!-- Inicia .contenedor-sidebar -->
    <div class="contenedor-sidebar">
        <h2>UpTask</h2>

        <!-- Inicia cerrar-menu -->
        <div class="cerrar-menu">
            <img id="cerrar-menu" src="/build/img/cerrar.svg" alt="imagen cerrar menu">
        </div>
        <!-- Termina cerrar-menu -->
    </div>
    <!-- Termina .contenedor-sidebar -->

    <!-- Inicia nav.sidebar-nav -->
    <nav class="sidebar-nav">
        <a class="<?php echo ($titulo === 'Proyectos') ? 'activo' : '';?>" href="/dashboard">Proyectos</a>
        <a class="<?php echo ($titulo === 'Crear Proyecto') ? 'activo' : '';?>" href="/crear-proyecto">Crear Proyecto</a>
        <a class="<?php echo ($titulo === 'Perfil') ? 'activo' : '';?>" href="/perfil">Perfil</a>
    </nav>
    <!-- Termina nav.sidebar-nav -->

    <!-- Inicia .cerrar-sesion-mobile -->
    <div class="cerrar-sesion-mobile">
        <a href="/logout" class="cerrar-sesion">Cerrar Sesión</a>
    </div>
    <!-- Termina .cerrar-sesion-mobile -->
</aside>
<!-- Termina aside.sidebar -->