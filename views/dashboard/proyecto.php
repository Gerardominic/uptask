<?php include_once __DIR__ . '/header-dashboard.php'; ?>

    <!-- Inicia .contenedor-sm -->
    <div class="contenedor-sm">
        <!-- Inicia .cotenedor-nueva-tarea -->
        <div class="cotenedor-nueva-tarea">
            <button
                type="button"
                class="agregar-tarea"
                id="agregar-tarea"
            >&#43; Nueva Tarea</button>
        </div>
        <!-- Termina .cotenedor-nueva-tarea -->

        <!-- Inicia div filtros -->
        <div id="filtros" class="filtros">
            <!-- Inicia filtros-inputs -->
            <div class="filtros-inputs">
                <h2>Filtros:</h2>
                <!-- Inicia campo -->
                <div class="campo">
                    <label for="todas">Todas</label>
                    <input
                        type="radio"
                        id="todas"
                        name="filtro"
                        value=""
                        checked
                    >
                </div>
                <!-- Termina campo -->

                <!-- Inicia campo -->
                <div class="campo">
                    <label for="completadas">Completadas</label>
                    <input
                        type="radio"
                        id="completadas"
                        name="filtro"
                        value="1"
                    >
                </div>
                <!-- Termina campo -->

                <!-- Inicia campo -->
                <div class="campo">
                    <label for="pendientes">Pendientes</label>
                    <input
                        type="radio"
                        id="pendientes"
                        name="filtro"
                        value="0"
                    >
                </div>
                <!-- Termina campo -->
            </div>
            <!-- Termina filtros-inputs -->
        </div>
        <!-- Termina div filtros -->

        <!-- Inicia listado-tareas -->
        <ul id="listado-tareas" class="listado-tareas">

        </ul>
        <!-- Termina listado-tareas -->
    </div>
    <!-- Termina .contenedor-sm -->

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>

<?php 
$script .= '
    <script src="build/js/tareas.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
'
?>