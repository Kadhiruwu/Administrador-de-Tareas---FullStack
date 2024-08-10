<?php 

namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Model\Proyecto;


class DashboardController{
    public static function index(Router $router){
        session_start();
        isAuth();//proteger la pagina

        $id = $_SESSION['id'];
        $proyectos = Proyecto::belongsTo('propietarioId', $id);
        $router->render('dashboard/index',[
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos
        ]);
    }   

    public static function crear_proyecto(Router $router){
        session_start();
        isAuth();//proteger la pagina
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $proyecto = new Proyecto($_POST);

           //Validacion
            $alertas = $proyecto->validarProyecto();

            if(empty($alertas)){
                //Generar una URL unica
                $hash = md5(uniqid());
                $proyecto->url=$hash;

                //Almacenar el creador del proyecto
                $proyecto->propietarioId = $_SESSION['id'];

                //Guardar el proyecto
                $proyecto->guardar();

                //Redireccionar
                header('Location: /proyecto?id=' . $proyecto->url);
            }
        }

        $router->render('dashboard/crear-proyecto',[
            'titulo' => 'Crear un Proyecto',
            'alertas' => $alertas
        ]);
    }  

    
    public static function proyecto(Router $router){
        session_start();
        isAuth();//proteger la pagina
        $token = $_GET['id'];

        if(!$token){
            header('Location: /dashboard');
        }

        //Revisar que la persona que visita el proyecto, sea el propietario
        $proyecto = Proyecto::where('url', $token);
        if($proyecto->propietarioId !== $_SESSION['id']){
            header('Location: /dashboard');
        }

        $router->render('dashboard/proyecto',[
            'titulo' => $proyecto->proyecto
        ]);
    }  

    public static function perfil(Router $router){
        session_start();
        $alertas = [];
        $usuario = Usuario::find($_SESSION['id']);
        isAuth();//proteger la pagina

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);

            $alertas = $usuario->validar_perfil();

            if(empty($alertas)){
                //Verificar que no se repita el correo en 2 usuarios
                $existeUsuario = Usuario::where('email', $usuario->email);
                if($existeUsuario && $existeUsuario->id !== $usuario->id){
                    //Mensaje de error
                    Usuario::setAlerta('error', 'Este correo ya está siendo usado, ingresa otro');
                    $alertas = $usuario->getAlertas();
                }else{
                    //Guardar cambios - el registro
                    //Guardar el usuario
                $usuario->guardar();
                Usuario::setAlerta('exito', 'Cambios guardados Correctamente');
                $alertas = $usuario->getAlertas();

                //Asignar el nombre nuevo a la barra
                $_SESSION['nombre'] = $usuario->nombre;
                }

            }

        }

        $router->render('dashboard/perfil',[
            'titulo' => 'Perfil',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }  

    public static function cambiar_password(Router $router){
        session_start();
        isAuth();
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario = Usuario::find($_SESSION['id']);
            //Sincronizar con los datos del usuario
            $usuario->sincronizar($_POST);

            $alertas = $usuario->nuevo_password();
            if(empty($alertas)){
                $resultado = $usuario->comprobar_password();    
                if($resultado){
                    $usuario->password = $usuario->password_nuevo;

                    //Borrar passwords
                    unset($usuario->password_actual);
                    unset($usuario->password_nuevo);

                    //Hashear el password nuevo
                    $usuario->hashPassword();

                    //Actualizar 
                    $resultado = $usuario->guardar();

                    if($resultado){
                        Usuario::setAlerta('exito','La contraseña ha sido cambiada correctamente');
                        $alertas = $usuario->getAlertas();
                    }

                }else{
                    Usuario::setAlerta('error','La contraseña no es correcta');
                    $alertas = $usuario->getAlertas();
                }
            }
        }

        $router->render('dashboard/cambiar-password',[
            'titulo' => 'Cambiar Password',
            'alertas' => $alertas
        ]);

    }

}



?>