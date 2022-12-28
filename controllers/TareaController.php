<?php 

namespace Controllers;

use Model\Tarea;
use Model\Proyecto;

class TareaController {

    public static function index(){

        
        //Obtener el id con GET por la url
        $proyectoId = $_GET['id'];
        
        //Si no hay un proyectoId en la url
        if(!$proyectoId){
            //Redireccionar al usuario
            header('Location: /dashboard');
            return; //Para que no se ejecute el resto del codigo
        }
        
        //Buscar el resultado del proyecto seleccionado por medio de su token/id
        $proyecto = Proyecto::where('url', $proyectoId);
        
        //Iniciar la sesión
        session_start();

        //Si no existe el proyecto por medio de la busqueda su url
        //O
        //El propietario del proyecto es diferente del usuario que inició sesión
        if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
            //Redigirirlo al 404
            header('Location: /404');
        }

        //Buscar los registros de todas las tareas de acuerdo al proyecto seleccionado/id del proyecto 
        $tareas = Tarea::belongsTo('proyectoId', $proyecto->id);

        //Transformarlo a JSON
        //Pasar el arreglo de tareas
        echo json_encode(['tareas' => $tareas], JSON_UNESCAPED_UNICODE);
    }

    public static function crear(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            //Iniciar la sesión
            session_start();

            //El id del proyecto que llega de la petición a esta API
            $proyectoId = $_POST['proyectoId'];

            //Se busca el proyecto con la url/id del proyecto
            $proyecto = Proyecto::where('url', $proyectoId);

            //Si no hay un proyecto
            //O el propietario del proyecto no es de la sesión
            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                //Construir una respuesta -> alerta
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un Error al agregar la tarea'
                ];

                echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);

                return;
            }
            
            //En caso de que si exista el proyecto y si sea el propietario correcto
            //Instanciar y crear la tarea
            
            $tarea = new Tarea($_POST); //$_POST con datos que llega desde la petición

            //Se le asgina el proyectoId de tarea del id de proyecto
            $tarea->proyectoId = $proyecto->id;

            //Se guarda los datos
            $resultado = $tarea->guardar();
            
            //Construir una respuesta -> una alerta
            $respuesta = [
                'tipo' => 'exito',
                'id' => $resultado['id'],
                'mensaje' => 'Tarea Creada Correctamente',
                'proyectoId' => $proyecto->id
            ];

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            
        }
    }

    public static function actualizar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            //Iniciar la sesión
            session_start();

            //Validar que el proyecto exista
            //Se busca el proyecto con el url/token del proyecto
            $proyecto = Proyecto::where('url', $_POST['proyectoId']);

            //Si no hay un proyecto
            //O el propietario del proyecto no es de la sesión
            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                //Construir una respuesta -> alerta
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un Error al actualizar la tarea'
                ];

                echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);

                return;
            }

            //En caso de que si exista el proyecto y si sea el propietario correcto
            //Instanciar y crear la tarea
            $tarea = new Tarea($_POST);

            //Se le asgina el proyectoId de tarea del id de proyecto
            $tarea->proyectoId = $proyecto->id;

            //Se guarda los cambios actualizados
            $resultado = $tarea->guardar();

            //Si el resultado tuvo exito -> true
            if($resultado) {
                //Construir una respuesta -> una alerta
                $respuesta = [
                    'tipo' => 'exito',
                    'id' => $tarea->id,
                    'proyectoId' => $proyecto->id,
                    'mensaje' => 'Actualizado Correctamente'
                ];

                //Enviar la respuesta a la petición
                echo json_encode(['respuesta' => $respuesta], JSON_UNESCAPED_UNICODE);
            }
        }
    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            //Iniciar la sesión
            session_start();

            //Validar que el proyecto exista
            //Se busca el proyecto con el url/token del proyecto
            $proyecto = Proyecto::where('url', $_POST['proyectoId']);

            //Si no hay un proyecto
            //O el propietario del proyecto no es de la sesión
            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                //Construir una respuesta -> alerta
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un Error al actualizar la tarea'
                ];

                echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);

                return;
            }

            //En caso de que si exista el proyecto y si sea el propietario correcto
            //Instanciar y crear la tarea
            $tarea = new Tarea($_POST);

            //Se elimina la tarea en la base datos y se obtiene resultado
            $resultado = $tarea->eliminar();

            //Construir un resultado arreglo -> una alerta
            $resultado = [
                'resultado' => $resultado,
                'mensaje' => 'Eliminado Correctamente',
                'tipo' => 'exito'
            ];

            //Enviar la respuesta del resultado a la petición
            echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
        }
    }
}