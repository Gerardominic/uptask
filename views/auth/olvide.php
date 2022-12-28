<!-- Inicia contenedor -->
<div class="contenedor olvide">
    
    <?php include_once __DIR__  . '/../templates/nombre-sitio.php'; ?>

    <!-- Inicia .contenedor-sm -->
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Recupera tu  Acceso UpTask</p>

        <?php include_once __DIR__  . '/../templates/alertas.php'; ?>
        
        <!-- Inicia formulario -->
        <form action="/olvide" method="POST" class="formulario" novalidate>
            
            <!-- Inicia campo -->
            <div class="campo">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    placeholder="Tu Email"
                    name="email"
                />
            </div>
            <!-- Termina campo -->

            <input type="submit" class="boton" value="Enviar Instrucciones">
        </form>
        <!-- Termina formulario -->

        <!-- Inicia acciones -->
        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? Iniciar Sesión</a>
            <a href="/">¿Aún no tienes una cuenta? Obtener una</a>
        </div>
        <!-- Termina acciones -->
    </div>
    <!-- Termina .contenedor-sm -->
</div>
<!-- Termina contenedor -->