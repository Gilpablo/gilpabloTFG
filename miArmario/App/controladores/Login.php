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

    public function logout(){
        
        Sesion::cerrarSesion();
        redireccionar('/');
    }
}