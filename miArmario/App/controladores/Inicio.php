<?php

class Inicio extends Controlador{

    public function __construct(){
        Sesion::iniciarSesion($this->datos);

        $this->inicioModelo=$this->modelo("InicioModelo");

    }

    public function index(){
        if ($_SERVER['REQUEST_METHOD']=='POST') {
        
            $datos=$_POST;
            // print_r($datos);
        }else {
            $this->vista("index", $this ->datos);
        }
    }

    public function editar_usuario(){

        if ($_SERVER['REQUEST_METHOD']=='POST') {
        
            $datos=$_POST;
            // print_r($datos); exit();

            if ($this->inicioModelo->editUser($datos, $this->datos['usuarioSesion']->id)) {

                $usuarioSesion = $this->inicioModelo->selectUsuario($this->datos['usuarioSesion']->id);
                Sesion::crearSesion($usuarioSesion);

                redireccionar('/');
            }
        }else {

            $this->vista("editUsuario", $this ->datos);
        }

    }
}
