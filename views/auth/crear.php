<!-- Inicia contenedor -->
<div class="contenedor crear">
    
    <?php include_once __DIR__  . '/../templates/nombre-sitio.php'; ?>

    <!-- Inicia .contenedor-sm -->
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crea tu cuenta en UpTask</p>
        <?php include_once __DIR__  . '/../templates/alertas.php'; ?>
        <!-- Inicia formulario -->
        <form action="/crear" method="POST" class="formulario">
            <!-- Inicia campo -->
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input
                    type="text"
                    id="nombre"
                    placeholder="Tu Nombre"
                    name="nombre"
                    value="<?php echo $usuario->nombre; ?>"
                />
            </div>
            <!-- Termina campo -->

            <!-- Inicia campo -->
            <div class="campo">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    placeholder="Tu Email"
                    name="email"
                    value="<?php echo $usuario->email; ?>"
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
                />
            </div>
            <!-- Termina campo -->

            <!-- Inicia campo -->
            <div class="campo">
                <label for="password2">Repetir Contraseña</label>
                <input
                    type="password"
                    id="password2"
                    placeholder="Repite tu Contraseña"
                    name="password2"
                />
            </div>
            <!-- Termina campo -->

            <input type="submit" class="boton" value="Crear Cuenta">
        </form>
        <!-- Termina formulario -->

        <!-- Inicia acciones -->
        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? Iniciar Sesión</a>
        </div>
        <!-- Termina acciones -->
    </div>
    <!-- Termina .contenedor-sm -->
</div>
<!-- Termina contenedor -->