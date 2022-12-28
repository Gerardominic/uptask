<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<!-- Inicia contenedor-sm -->
<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <a href="/cambiar-password" class="enlace">Cambiar Contraseña</a>

    <!-- Inicia formulario -->
    <form action="/perfil" class="formulario" method="POST" novalidate>
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input 
                type="text"
                value="<?php echo $usuario->nombre; ?>"
                name="nombre"
                placeholder="Tu Nombre"
            >
        </div>

        <div class="campo">
            <label for="nombre">Email</label>
            <input 
                type="email"
                value="<?php echo $usuario->email; ?>"
                name="email"
                placeholder="Tu Correo"
            >
        </div>

        <input type="submit" value="Guardar Cambios">
    </form>
    <!-- Termina formulario -->
</div>
<!-- Termina contenedor-sm -->


<?php include_once __DIR__ . '/footer-dashboard.php'; ?>