<?php 

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{
    public static function login(Router $router){
        $alertas =[];
       
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //$usuario = new Usuario($_POST); o solo esto para autocompletar en el value
            //$usuario->sincronizar($_POST); para autocompletar en el value
            $usuario = new Usuario($_POST);

            $alertas=$usuario->validarLogin();

            if(empty($alertas)){
                //Verificar que el usuario exista
                $usuario = Usuario::where('email', $usuario->email);
                
                if(!$usuario || !$usuario->confirmado){
                    Usuario::setAlerta('error', 'El usuario no existe o no está confirmado');
                }else{
                    //el usuario si existe
                    //el password que escribimos, despues el hasheado, q lo tiene el usuario - RETORNA TRUE O FALSE
                    if(password_verify($_POST['password'], $usuario->password)){ 

                        //Iniciar la sesion
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //Redireccionar 
                        header('Location: /dashboard');
                    }else{
                        Usuario::setAlerta('error', 'El password es incorrecto');
                    }
                }
              
            }
        }

        $alertas=Usuario::getAlertas();
        //Render a la vista
        $router->render('auth/login',[
            'titulo' => 'Iniciar Sesion', //lo primero es la variable, aunq no parezca
            'alertas' => $alertas //lo primero es la variable, que pasa para que se muestre, ejemplo en el value
        ]);
    }

    public static function logout(){
        session_start();
        $_SESSION=[];
        header('Location: /');

    }

    public static function crear(Router $router){
        $alertas = [];
        $usuario = new Usuario();


        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $usuario = new Usuario($_POST);
            
            $alertas = $usuario->validarNuevaCuenta();
            if(empty($alertas)){
                $existeUsuario = Usuario::where('email', $usuario->email); //columna y lo que queremos comparar
                if($existeUsuario){
                    Usuario::setAlerta('error', 'El usuario ya existe');
                    $alertas = Usuario::getAlertas();
                }else{
                    //Hashear el password
                    $usuario->hashPassword();

                    //Eliminar password2
                    unset($usuario->password2);

                    //Generar un token
                    $usuario->crearToken();

                    //Crear el nuevo Usuario
                    $resultado=$usuario->guardar();

                    //Enviar email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarConfirmacion();
                    
                    if($resultado){
                        header('Location: /mensaje');
                    }
                }
            }
         
        }

        //Render a la vista
        $router->render('auth/crear',[
            'titulo' => 'Crea Cuenta', //lo primero es la variable, aunq no parezca
            'usuario' => $usuario, //lo primero es la variable, que pasa para que se muestre, ejemplo en el value
            'alertas' => $alertas
        ]);
    }

    public static function olvide(Router $router){
       $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();

            if(empty($alertas)){
                //Buscar el usuario en la base de datos
                $usuario = Usuario::where('email', $usuario->email);

                if($usuario && $usuario->confirmado === "1"){
                    //Encontró al usuario - Genera nuevo token
                    $usuario->crearToken();
                    unset($usuario->password2); //opcional

                    //Actualizar el Usuario en la base de datos
                    $usuario->guardar();

                    //Enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    //Imprimir la alerta
                    Usuario::setAlerta('exito', 'Revisa tu email, hemos enviado instrucciones');
                }else{
                    Usuario::setAlerta('error', 'El usuario no existe o aun no está validado');
                }
            }   
        }

        $alertas=Usuario::getAlertas();
        $router->render('auth/olvide',[
            'titulo' => 'Cambiar Password', //lo primero es la variable, aunq no parezca
            'alertas' => $alertas
        ]);
    }

    public static function reestablecer(Router $router){
        $token = s($_GET['token']);
        $mostrar = true;
        //$alertas = [];
        if(!$token) header('Location: /');

        //Identificar el usuario con este token
        $usuario = Usuario::where('token', $token);
        if(empty($usuario)){
             Usuario::setAlerta('error', 'Token no valido');
             $mostrar = false;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Añadir el nuevo password
            $usuario->sincronizar($_POST);
       
            //Validar el password
            $alertas = $usuario->validarPassword();

            if(empty($alertas)){
                //hashear el nuevo password
                $usuario->hashPassword();

                //Eliminar el token
                $usuario->token=null;
                //Guardar el usuario
                $resultado = $usuario->guardar();
                //Redireccionar
                if($resultado){
                header('Location: /');
                }

            }
        }

        $alertas=Usuario::getAlertas();
        $router->render('auth/reestablecer',[
            'titulo' => 'Reestablece Password', //lo primero es la variable, aunq no parezca
            'alertas' => $alertas,
            'mostrar' => $mostrar
        ]);
    }

    public static function mensaje(Router $router){
        $router->render('auth/mensaje',[
            'titulo' => 'Mensaje de Confirmación' //lo primero es la variable, aunq no parezca
        ]);

    }

    public static function confirmar(Router $router){
        $alertas = [];
        $token = s($_GET['token']);
        if(!$token) header('Location: /'); //si no hay token, te manda al login

        //Encotrar al usuario con ese token
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
            //No se encontró el usuario con ese token
            Usuario::setAlerta('error', 'El token no es valido');
        }else{
            //Confirmar la cuenta
            $usuario->confirmado=1;
            $usuario->token=null;

            //eliminar el password2 del objeto
            unset($usuario->password2);

            //guardar en la base de datos
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta Confirmada correctamente');
        }
            //retornamos las alertas
            $alertas=Usuario::getAlertas();
            
        $router->render('auth/confirmar',[
            'titulo' => 'Confirmar Cuenta', //lo primero es la variable, aunq no parezca
            'alertas' => $alertas
        ]);
    }

}

?>