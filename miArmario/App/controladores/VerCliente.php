<?php

class VerCliente extends Controlador{

    public function __construct(){
        Sesion::iniciarSesion($this->datos);
        
        $this->verClienteModelo = $this->modelo('VerClienteModelo');

        $this->datos["menuActivo"] = "verCliente";

        $this->datos['rolesPermitidos'] = [1];         // Definimos los roles que tendran acceso
                                                            // Comprobamos si tiene privilegios
        if (!tienePrivilegios($this->datos['usuarioSesion']->id_rol,$this->datos['rolesPermitidos'])) {
            // echo "No tienes privilegios!!!";
            // exit();
            redireccionar('/');
        }

    }

    public function index(){

        if  (isset($_GET['busqueda']) && !empty($_GET['busqueda'])) {
            $busqueda = $_GET['busqueda'];

            
            $this->datos['clientes'] = $this->verClienteModelo->buscarClientes($busqueda);
        
            $this->vista("verClientes/index",$this->datos);
          
        }else{

            $this->datos['clientes'] = $this->verClienteModelo->todosClientes();

            $this->vista("verClientes/index",$this->datos);
        }

    }


    public function editar_cliente($id_cliente){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $nuevosDatos = $_POST;

            // print_r($nuevosDatos); exit();

            if ($this->verClienteModelo->editCliente($nuevosDatos, $id_cliente)) {

                redireccionar('/verCliente');

            }

        }else {

            $this->datos['cliente'] = $this->verClienteModelo->cliente($id_cliente);

            $this->datos['rolCliente'] = $this->verClienteModelo->getRolCliente($id_cliente);

            $this->datos['roles'] = $this->verClienteModelo->getRoles();

            $this->vista("verClientes/editCliente",$this->datos);

        }

    }

    public function add_cliente(){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $cliente = $_POST;

            // print_r($nuevosDatos); exit();

            if ($this->verClienteModelo->addCliente($cliente)) {

                redireccionar('/verCliente');

            }

        }else {

            $this->datos['roles'] = $this->verClienteModelo->getRoles();

            $this->vista("verClientes/addCliente",$this->datos);

        }

    }

    public function borrar_cliente($id){

        if ($this->verClienteModelo->borrarCliente($id)){

            redireccionar('/verCliente');   
        }
    }

    

}
