<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<!-- Inicia contenedor-sm -->
<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <a href="/perfil" class="enlace">Volver al Perfil</a>

    <!-- Inicia formulario -->
    <form action="/cambiar-password" class="formulario" method="POST" novalidate>
        <div class="campo">
            <label for="password_actual">Contraseña Actual</label>
            <input 
                type="password"
                name="password_actual"
                placeholder="Tu Contraseña Actual"
            >
        </div>

        <div class="campo">
            <label for="password_nuevo">Contraseña Nueva</label>
            <input 
                type="password"
                name="password_nuevo"
                placeholder="Tu Nueva Contraseña"
            >
        </div>

        <input type="submit" value="Guardar Cambios">
    </form>
    <!-- Termina formulario -->
</div>
<!-- Termina contenedor-sm -->


<?php include_once __DIR__ . '/footer-dashboard.php'; ?>