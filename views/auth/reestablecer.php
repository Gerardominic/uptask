<!-- Inicia contenedor -->
<div class="contenedor reestablecer">

    <?php include_once __DIR__  . '/../templates/nombre-sitio.php'; ?>

    <!-- Inicia .contenedor-sm -->
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Coloca tu nueva contraseña</p>

        <?php include_once __DIR__  . '/../templates/alertas.php'; ?>

        <?php if($mostrar) { ?>
        <!-- Inicia formulario -->
        <form method="POST" class="formulario">

            <!-- Inicia campo -->
            <div class="campo">
                <label for="password">Contraseña</label>
                <input
                    type="password"
                    id="password"
                    placeholder="Tu nueva Contraseña"
                    name="password"
                />
            </div>
            <!-- Termina campo -->

            <input type="submit" class="boton" value="Guardar Contraseña">
        </form>
        <!-- Termina formulario -->

        <?php } ?>

        <!-- Inicia acciones -->
        <div class="acciones">
            <a href="/crear">¿Aún no tienes una cuenta? Obtener una</a>
            <a href="/olvide">¿Olvidaste tu Contraseña?</a>
        </div>
        <!-- Termina acciones -->
    </div>
    <!-- Termina .contenedor-sm -->
</div>
<!-- Termina contenedor -->