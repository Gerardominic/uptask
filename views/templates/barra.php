<!-- Inicia barra-mobile -->
<div class="barra-mobile">
    <h1>UpTask</h1>

    <!-- Inicia menu -->
    <div class="menu">
        <img id="mobile-menu" src="/build/img/menu.svg" alt="imagen menu">
    </div>
    <!-- Termina menu -->
</div>
<!-- Termina barra-mobile -->

<!-- Inicia barra -->
<div class="barra">
    <p>Hola: <span><?php echo $_SESSION['nombre']; ?></span></p>

    <a href="/logout" class="cerrar-sesion">Cerrar Sesión</a>
</div>
<!-- Termina barra -->