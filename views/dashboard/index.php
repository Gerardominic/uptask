
<?php include_once __DIR__ . '/header-dashboard.php'; ?>

    <?php if(count($proyectos) === 0){ //Si no hay proyectos?>
        <p class="no-proyectos">No Hay Proyectos aún <a href="/crear-proyecto">Comienza creando uno</a></p>
    <?php } else {?>
        <!-- Inicia .listado-proyectos -->
        <ul class="listado-proyectos">
            <?php foreach($proyectos as $proyecto) { ?>
                <!-- Inicia .proyecto -->
                <li>
                    <a class="proyecto" href="/proyecto?id=<?php echo $proyecto->url; ?>">
                        <?php echo $proyecto->proyecto; ?>
                    </a>
                </li>
                <!-- Termina .proyecto -->
            <?php } ?>
        </ul>
        <!-- Termina .listado-proyectos -->
    <?php } ?>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>