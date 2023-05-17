<?php

class Inicio extends Controlador{

    public function __construct(){
        Sesion::iniciarSesion($this->datos);

        

    }

    public function index(){
        if ($_SERVER['REQUEST_METHOD']=='POST') {
        
            $datos=$_POST;
            print_r($datos);
        }else {
            $this->vista("index", $this ->datos);
        }
    }
}
