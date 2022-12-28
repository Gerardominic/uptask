<?php 


namespace Model;

Class Usuario extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        //Para guardar nueva contraseña
        $this->password_actual = $args['password_actual'] ?? '';
        $this->password_nuevo = $args['password_nuevo'] ?? '';
        //----
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;

    }

    /**
     * Valida el Login de Usuarios
     * @access public
     * @return $alertas - Las alertas en caso de error de validación
     */
    public function validarLogin(){
        if(!$this->email){
            self::$alertas['error'][] = 'El Email del Usuario es Obligatorio';
        }

        //Si no es un correo
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][] = 'Email no válido';
        }

        if(!$this->password){
            self::$alertas['error'][] = 'La Contraseña no puede ir vacia';
        }

        return self::$alertas;
    }

    /**
     * Validación para cuentas nuevas
     * @return Array $alertas - Todas las alertas del modelo al validar en caso de que haya un error  
     */ 
    public function validarNuevaCuenta(){
        if(!$this->nombre){
            self::$alertas['error'][] = 'El Nombre del Usuario es Obligatorio';
        }

        if(!$this->email){
            self::$alertas['error'][] = 'El Email del Usuario es Obligatorio';
        }

        if(!$this->password){
            self::$alertas['error'][] = 'La Contraseña no puede ir vacia';
        }

        
        if(strlen($this->password) < 6){
            self::$alertas['error'][] = 'La Contraseña debe contener al menos 6 caracteres';
        }

        //Verificar contraseñas iguales
        do {
            //Si no repite la contraseña
            if(!$this->password2){
                self::$alertas['error'][] = 'Por favor repetir la Contraseña';
                break;
            }

            //Si password1 es diferente a password2 (El de confirmar contraseña)
            if($this->password !== $this->password2){
                self::$alertas['error'][] = 'Las Contraseñas son diferentes';
                break;
            }
        }while(0);
        
        return self::$alertas;
    }

    /**
     * Función que valida los campos de perfil del usuario, para verificar si envió los datos correctamente
     * @return Array `$alertas` - Las alertas del modelo al validar en caso de hayar errores
     */
    public function validar_perfil(){
        if(!$this->nombre){
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }

        if(!$this->email){
            self::$alertas['error'][] = 'El Correo es Obligatorio';
        }

         //Si no es un correo
         if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][] = 'Email no válido';
        }

        return self::$alertas;
    }

    /**
     * Valida un email
     */
    public function validarEmail(){
        if(!$this->email){
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }

        //Si no es un correo
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][] = 'Email no válido';
        }

        return self::$alertas;
    }    

    /**
     * Valida el Password 
     * @access public
     * @return $alertas Las alertas en caso de error en la validación
     */
    public function validarPassword(){
        if(!$this->password){
            self::$alertas['error'][] = 'La Contraseña no puede ir vacia';
        }

        
        if(strlen($this->password) < 6){
            self::$alertas['error'][] = 'La Contraseña debe contener al menos 6 caracteres';
        }

        return self::$alertas;
    }

    /**
     * Función para validar password nuevo
     * @return $alertas Las alertas en caso de error en la validación
     */
    public function nuevo_password() : array{
        //Si no ingresó el password actual, es decir, si el campo está vacio
        if(!$this->password_actual){
            self::$alertas['error'][] = 'La Contraseña Actual no puede ir vacio';
        }

        if(!$this->password_nuevo){
            self::$alertas['error'][] = 'La Contraseña Nueva no puede ir vacio';
        }

        //Si al ingresar password son menos de 6 caracteres
        if(strlen($this->password_nuevo) < 6){
            self::$alertas['error'][] = 'La Contraseña debe contener al menos 6 caracteres';
        }

        return self::$alertas;
    }

    /**
     * Función para comprobar el password actual del usuario
     * @return Bool - Si es la contraseña correcta del usuario
     */
    public function comprobarPassword() : bool{
        return password_verify($this->password_actual, $this->password);
    }

    /**
     * Hashea el password, es decir, lo encripta
     */
    public function hashPassword() : void{
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    /**
     * Genera un Token a la cuenta del usuario en la base de datos
     */
    public function crearToken() : void{
        $this->token = uniqid();
    }
}

?>