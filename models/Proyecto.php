<?php 

namespace Model;

class Proyecto extends ActiveRecord {
    //Base de datos
    protected static $tabla = 'proyectos';
    protected static $columnasDB = ['id', 'proyecto', 'url', 'propietarioId'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->proyecto = $args['proyecto'] ?? '';
        $this->url = $args['url'] ?? '';
        $this->propietarioId = $args['propietarioId'] ?? '';
    }

    /**
     * Función para validar en la creación del proyecto
     * @return Array - Las alertas en caso de errores
     */
    public function validarProyecto(){
        if(!$this->proyecto){
            self::$alertas['error'][] = 'El Nombre del Proyecto es Obligatorio';
        }

        return self::$alertas;
    }
}