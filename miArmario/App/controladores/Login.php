<?php

class Login extends Controlador{
    public function __construct(){
        $this->loginModelo=$this->modelo("LoginModelo");
        
    }

    public function index($error=''){
        //trim(quita los espacios de delante y detras)
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            $this->datos['usuario']=trim($_POST['usuario']);
            $this->datos['pass']=trim($_POST['pass']);
            
            $usuarioSesion = $this->loginModelo->loginUsuario($this->datos);
            
            
            if (isset($usuarioSesion)&& !empty($usuarioSesion)) {
                Sesion::crearSesion($usuarioSesion);
                
                redireccionar('/inicio');

            }else{
                
                redireccionar('/login/index/error_1');
            }
            
            
        }else {

            if (Sesion::sesionCreada()) {
                redireccionar('/');
            }

            $this->datos['error'] = $error;

            $this->vista('login', $this->datos);
        }
    }


    public function add_usuario($error=''){

        //trim(quita los espacios de delante y detras)
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            $this->datos['nuevoUsuario']=$_POST;
            
            
            // $usuarioSesion = $this->loginModelo->loginUsuario($this->datos);
            // print_r($usuarioSesion); exit();
            
            // if (isset($usuarioSesion)&& !empty($usuarioSesion) &&  $this->loginModelo->addUsuario($this->datos['nuevoUsuario'])) {
            //     Sesion::crearSesion($usuarioSesion);
                
            //     redireccionar('/inicio');

            // }else{
                
            //     redireccionar('/login/index/error_1');
            // }
            if ($this->loginModelo->addUsuario($this->datos['nuevoUsuario'])) {

                redireccionar('/login/index/creado');

            }else{
                
                redireccionar('/login/index/error_1');
            }
            
            
        }else {

            if (Sesion::sesionCreada()) {

                $usuarioSesion = $this->loginModelo->loginUsuario($this->datos);

                if($usuarioSesion->id == 1){
                    $this->datos['error'] = $error;

                    $this->vista('add_usuario', $this->datos);
                }else {
                    redireccionar('/');
                }
                
            }

            
            $this->vista('add_usuario', $this->datos);
            
        }
    }
    
    public function logout(){
        
        Sesion::cerrarSesion();
        redireccionar('/');
    }
}