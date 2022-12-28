<!-- Inicia contenedor -->
<div class="contenedor login">

    <?php include_once __DIR__  . '/../templates/nombre-sitio.php'; ?>

    <!-- Inicia .contenedor-sm -->
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar Sesión</p>

        <?php include_once __DIR__  . '/../templates/alertas.php'; ?>

        <!-- Inicia formulario -->
        <form action="/" method="POST" class="formulario" novalidate>
            <!-- Inicia campo -->
            <div class="campo">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    placeholder="Tu Email"
                    name="email"
                    value="<?php echo $auth->email; ?>"
                />
            </div>
            <!-- Termina campo -->

            <!-- Inicia campo -->
            <div class="campo">
                <label for="password">Contraseña</label>
                <input
                    type="password"
                    id="password"
                    placeholder="Tu Contraseña"
                    name="password"
                    value="<?php echo $auth->password ?>"
                />
            </div>
            <!-- Termina campo -->

            <input type="submit" class="boton" value="Iniciar Sesión">
        </form>
        <!-- Termina formulario -->

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