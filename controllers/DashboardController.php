<?php

namespace Controllers;

use Model\Proyecto;
use Model\Usuario;
use MVC\Router;

class DashboardController {

    public static function index(Router $router){

        //Iniciar la sesión
        session_start();

        //Proteger la ruta - autenticar el usuario
        isAuth();

        //Obtener la id del usuario
        $id = $_SESSION['id'];

        //Obteniendo los Proyectos del Usuario
        $proyectos = Proyecto::belongsTo('propietarioId', $id);

        //Render a la vista
        $router->render('dashboard/index', [
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos
        ]);
    }

    public static function crear_proyecto(Router $router){
        //Iniciar la sesión
        session_start();

        //Proteger la ruta - autenticar el usuario
        isAuth();

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Instanciar el modelo del proyecto
            $proyecto = new Proyecto($_POST);

            //Validación
            $alertas = $proyecto->validarProyecto();

            //Si no hay alertas
            if(empty($alertas)){
                //Generar una URL Única
                $hash = md5(uniqid());
                $proyecto->url = $hash;

                //Almacenar ID del creador del proyecto
                $proyecto->propietarioId = $_SESSION['id'];

                //Guardar el proyecto
                $proyecto->guardar();

                //Redireccionar
                header('Location: /proyecto?id=' . $proyecto->url);
            }
        }

        //Render a la vista
        $router->render('dashboard/crear-proyecto', [
            'titulo' => 'Crear Proyecto',
            'alertas' => $alertas
        ]);
    }

    public static function proyecto(Router $router){

        //Iniciar la sesión
        session_start();

        //Proteger la ruta - autenticar el usuario
        isAuth();

        $token = $_GET['id'];
        
        //Si no hay un token
        if(!$token){
            //Redirigirlo
            header('Location: /dashboard');
        }

        //Revisar que la persona que visita el proyecto, es quien lo creo
        $proyecto = Proyecto::where('url', $token);

        //Si no es el propietario del proyecto
        if($proyecto->propietarioId !== $_SESSION['id']){
            //Redirigir al Dashboard
            header('Location: /dashboard');
        }

        //Render a la vista
        $router->render('dashboard/proyecto', [
            'titulo' => $proyecto->proyecto
        ]);
    }

    public static function perfil(Router $router){
        //Iniciar la sesión
        session_start();

        //Proteger la ruta - autenticar el usuario
        isAuth();

        //Alertas para la vista
        $alertas = [];

        //Pasar el usuario
        //Buscar el usuario por su id con los datos del login $_SESSION y obtener el resultado
        $usuario = Usuario::find($_SESSION['id']);

        //Cuando se hace el action POST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $usuario->sincronizar($_POST);

            //Validar los datos en el formulario de perfil
            $alertas = $usuario->validar_perfil();

            //Si no hay alertas, es decir, si todo está correcto
            if(empty($alertas)){

                //Verificar que el email que se está colocando no exista en otro usuario
                $existeUsuario = Usuario::where('email', $usuario->email);
                
                //Si ya existe el usuario con el correo colocado al querer guardar cambios
                //y
                //es diferente al que está autenticado (si se refiere a otro usuario que uno no conoce)
                if($existeUsuario && $existeUsuario->id !== $usuario->id){
                    //Mostrar mensaje de error
                    Usuario::setAlerta('error', 'Email no válido, ya pertenece a otra cuenta');
                    $alertas = $usuario->getAlertas();

                } else {
                    //Si no existe el usuario -> Guardar los cambios registrados

                    //Guardar los cambios del usuario
                    $usuario->guardar();
    
                    //Alerta después de guardar los cambios
                    Usuario::setAlerta('exito', 'Guardado Correctamente');
                    $alertas = $usuario->getAlertas();
    
                    //Modificar los valores de SESSION
                    //Nombre nuevo
                    $_SESSION['nombre'] = $usuario->nombre;
                    //Correo nuevo
                    $_SESSION['email'] = $usuario->email;
                }

            }
        }

        //Render a la vista
        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function cambiarPassword(Router $router){

        //Iniciar la sesión
        session_start();

        //Proteger la ruta - autenticar el usuario
        isAuth();

        //Alertas para la vista
        $alertas = [];

        //Al recibir el metodo POST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Encontrar al usuario por su ID
            $usuario = Usuario::find(($_SESSION['id']));

            //Sincronizar con los datos del usuario que se envien en post
            $usuario->sincronizar($_POST);

            //Validar passwords -> obtener alertas
            $alertas = $usuario->nuevo_password();

            //Si no hay alertas -> validación correcta
            if(empty($alertas)) {
                //  Comprobar que el password es correcto -> se obtiene true o false
                $resultado = $usuario->comprobarPassword();

                //Si el password es correcto / comprobado correctamente
                if($resultado){        
                    //Asignar el nuevo password
                    //Guardar valor del password con el password nuevo en el modelo del usuario
                    $usuario->password = $usuario->password_nuevo;

                    //Eliminar campo no necesario -> password_actual
                    unset($usuario->password_actual);
                    //Eliminar campo no necesario -> password_actual
                    unset($usuario->password_nuevo);

                    //Hashear el nuevo password
                    $usuario->hashPassword();

                    //Guardar cambios de la nueva contraseña y guardar el resultado
                    $resultado = $usuario->guardar();

                    //Si el resultado fue correcto -> si se guardó correctamente
                    if($resultado) {
                        Usuario::setAlerta('exito', 'Contraseña Guardada Correctamente');
                        $alertas = $usuario->getAlertas();
                    }

                } else {
                    //Si no es la contraseña actual correcta
                    Usuario::setAlerta('error', 'Contraseña Incorrecta');
                    $alertas = $usuario->getAlertas();
                }
            }
        }

        //Render a la vista
        $router->render('dashboard/cambiar-password', [
            'titulo' => 'Cambiar Contraseña',
            'alertas' => $alertas
        ]);
    }
}