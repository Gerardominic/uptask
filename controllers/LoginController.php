<?php 

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {

    
    public static function login(Router $router){

        //Instanciar el modelo usuario (para el autocompletado)
        $auth = new Usuario;

        //Alertas para que no de error al inicio
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Se instancia el objeto con los datos que se envie en el formulario con $_POST
            $auth = new Usuario($_POST);
            
            //Se valida el login
            $alertas = $auth->validarLogin();

            //Si no hay alertas
            if(empty($alertas)){
                //Verificar que el usuario exista
                $usuario = Usuario::where('email', $auth->email);
                
                //Si no existe el usuario / es null
                if(!$usuario || !$usuario->confirmado){
                    Usuario::setAlerta('error', 'El Usuario no existe o no está confirmado');
                }else {
                    //El usuario existe y está confirmado

                    //Validar password con el que se pone al formulario con lo que está en la base de datos
                    //Retornara true o false
                    if(password_verify($auth->password, $usuario->password)){
                        //Si la contraseña es correcta
                        
                        //Iniciar la sesión del usuario
                        session_start();

                        //Darle valores a la $_SESSION
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //Redireccionar
                        header('Location: /dashboard');

                    } else {
                        //Si la contraseña es incorrecta
                        Usuario::setAlerta('error', 'La Contraseña es Incorrecta');
                    }
                }                
            }
        }

        //Obtener las alertas en caso de errores
        $alertas = Usuario::getAlertas();

        //Render a la vista
        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesión',
            'auth' => $auth,
            'alertas' => $alertas
        ]);
    }

    public static function logout(){
        session_start();
        //Eliminar todos los valores / cerrar la sesión
        $_SESSION = [];       
        
        //Dirigirlo a la pagina principal
        header('Location: /');
    }

    public static function crear(Router $router){
        
        $alertas = [];
        //Instanciar el modelo Usuario
        $usuario = new Usuario;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
           
            //Si no hay alertas
            if(empty($alertas)){

                 //Se busca si existe un usuario igual al crear la cuenta
                $existeUsuario = Usuario::where('email', $usuario->email);

                //Si existe el usuario
                if($existeUsuario){
                    Usuario::setAlerta('error', 'El Usuario ya está registrado');
                    $alertas = Usuario::getAlertas();
                } else {

                    //Hashear el password
                    $usuario->hashPassword();

                    //Eliminar password2
                    unset($usuario->password2);

                    //Generar el Token
                    $usuario->crearToken();

                    //Crear un nuevo usuario
                    $resultado = $usuario->guardar();

                    //Enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    if($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }

        }

        //Render a la vista
        $router->render('auth/crear', [
            'titulo' => 'Crea tu Cuenta en UpTask',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function olvide(Router $router){
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Instanciar el Usuario
            $usuario = new Usuario($_POST);

            //Validar el correo
            $alertas = $usuario->validarEmail();

            //Si no hay alertas
            if(empty($alertas)){
                //Buscar el usuario
                $usuario = Usuario::where('email', $usuario->email);

                if($usuario && $usuario->confirmado){
                    //Encontró al usuario y está confirmado
                    
                    //Generar un nuevo token
                    $usuario->crearToken();
                    unset($usuario->password2);

                    //Actualizar el usuario
                    $usuario->guardar();

                    //Enviar el mail
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    //Imprimir la alerta
                    Usuario::setAlerta('exito', 'Hemos enviado las instrucciones a tu Email');
                    
                } else {
                    //No Encontró al Usuario
                    Usuario::setAlerta('error', 'El Usuario no existe o no está confirmado');                    
                }
            }
        }

        $alertas = Usuario::getAlertas();

        //Render a la vista
        $router->render('auth/olvide', [
            'titulo' => 'Olvidé mi Contraseña',
            'alertas' => $alertas
        ]);

    }

    public static function reestablecer(Router $router){

        //Obtener el token por el enlace
        $token = s($_GET['token']);
        //mostrar sera true mientras exista el token y así mostrar el formulario
        $mostrar = true;

        //Si no hay un token, enviarlo a la página principal
        if(!$token) header('Location: /');

        //Identificar el usuario con el token
        $usuario = Usuario::where('token', $token);

        //Si está vacio el objeto de usuario
        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token No Válido');
            $mostrar = false; //false para no mostrar el formulario
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            //Añadir el nuevo password
            $usuario->sincronizar($_POST);

            //Validar el password
            $alertas = $usuario->validarPassword();

            //Si no hay alertas
            if(empty($alertas)){
                //Hashear el nuevo password
                $usuario->hashPassword();

                //Eliminar el token
                $usuario->token = null;

                //Guardar los cambios del usuario en la BD
                $resultado = $usuario->guardar();

                //Redireccionar
                if($resultado){
                    //Si se guardaron bien los cambios

                    //Crear mensaje de exito
                    Usuario::setAlerta('exito', 'Contraseña nueva guardada correctamente, se le enviara la pagina principal');

                    // Redireccionar al login tras 3 segundos
                    header('Refresh: 3; url=/');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        //Render a la vista
        $router->render('auth/reestablecer', [
            'titulo' => 'Reestablecer Contraseña',
            'alertas' => $alertas,
            'mostrar' => $mostrar
        ]);
    }

    public static function mensaje(Router $router){
        //Render a la vista
        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta Creada Exitosamente'
        ]);    
    }

    public static function confirmar(Router $router){

        //Leer el token del enlace
        $token = s($_GET['token']);

        //Si no tiene token, enviarlo a la pagina principal
        if(!$token) header('Location: /');

        //Encontrar al usuario con su token
        $usuario = Usuario::where('token', $token);

        //Si no exise el usuario por su token
        if(empty($usuario)){
            // Si el usuario está vacio, es decir, que no se encontró. Mostrar el mensaje de error
            Usuario::setAlerta('error', 'Token No Válido');
        } else {
            // Si no está vacio, modificar a usuario confirmado
            // Confirmar al usuario de 0 a 1
            $usuario->confirmado = 1;

            //Quitar token del usuario
            $usuario->token = null;

            //Quitar el password2 del objeto usuario
            unset($usuario->password2);

            //Guardar los cambios en la BD
            $usuario->guardar();

            Usuario::setAlerta('exito', 'Cuenta Comprobada Correctamente');
        }

        $alertas = Usuario::getAlertas();

        //Render a la vista
        $router->render('auth/confirmar', [
            'titulo' => 'Confirma tu cuenta UpTask',
            'alertas' => $alertas
        ]);            
    }
}