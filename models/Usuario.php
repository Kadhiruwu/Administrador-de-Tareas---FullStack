<?php 
namespace Model;

class Usuario extends ActiveRecord{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->password_actual = $args['password_actual'] ?? '';
        $this->password_nuevo = $args['password_nuevo'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }

    //Validar el Login de Usuarios
    public function validarLogin(){
        
        if(!$this->email){
            self::$alertas['error'][] = 'El E-Mail es Obligatorio';
        }
        
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][] = 'Ingrese un email Verdadero';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'El password no puede ir vacio';
        }

   
        return self::$alertas;
    }

    //Validacion Para cuentas nuevas
    public function validarNuevaCuenta(){
        //se le agrega la clase de error
        if(!$this->nombre){
            self::$alertas['error'][] = 'El nombre es Obligatorio';
        }

        if(!$this->email){
            self::$alertas['error'][] = 'El E-Mail es Obligatorio';
        }

        if(!$this->password){
            self::$alertas['error'][] = 'El password no puede ir vacio';
        }

        if(strlen($this->password) < 6){
            self::$alertas['error'][] = 'El password debe tener más 5 de digitos';
        }
        
        if($this->password !== $this->password2){
            self::$alertas['error'][] = 'Los Passowrd no son iguales'; 
        }

        return self::$alertas;
    }

    //Hashea el password
    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);  
    }

    //Valida el password
    public function validarPassword(){
        if(!$this->password){
            self::$alertas['error'][] = 'El password no puede ir vacio';
        }

        if(strlen($this->password) < 6){
            self::$alertas['error'][] = 'El password debe tener más 5 de digitos';
        }
        return self::$alertas;
    }

    //Generar un token unico
    public function crearToken(){
        $this->token = uniqid(); //md5(uniqid()) solo 32 caractereres en la bd
    }

    //Valida el email en /olvide
    public function validarEmail(){
        if(!$this->email ){
            self::$alertas['error'][] = 'Tiene que llenar el campo';
        }

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][] = 'Ingrese un email Verdadero';
        }

        return self::$alertas;
    }
    //Validar el perfil
    public function validar_perfil()
    {
        if(!$this->nombre){
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }

        if(!$this->email){
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        return self::$alertas;
    }
    //Alertas nuevo password
    public function nuevo_password(){
        if(!$this->password_actual){
            self::$alertas['error'][]= 'Ingresa el password actual';
        }

        if(!$this->password_nuevo){
            self::$alertas['error'][]= 'Ingresa el password nuevo';
        }
        if(strlen($this->password_nuevo) < 6){
            self::$alertas['error'][] = 'El password debe tener más 5 de digitos';
        }
        return self::$alertas;
    }
    //Comprobar el password
    public function comprobar_password() : bool{
        return password_verify($this->password_actual, $this->password);
    }
}

?>