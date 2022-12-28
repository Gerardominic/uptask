<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<!-- Inicia .contenedor-sm -->
<div class="contenedor-sm">
    <?php include_once __DIR__  . '/../templates/alertas.php'; ?>
    
    <!-- Inicia formulario -->
    <form action="/crear-proyecto" class="formulario" method="POST">

        <?php include_once __DIR__ . '/formulario-proyecto.php'; ?>

        <input type="submit" value="Crear Proyecto">
    </form>
    <!-- Termina formulario -->
</div>
<!-- Termina .contenedor-sm -->


<?php include_once __DIR__ . '/footer-dashboard.php'; ?>