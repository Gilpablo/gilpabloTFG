<?php

class HistorialUso extends Controlador{

    public function __construct(){
        Sesion::iniciarSesion($this->datos);
        
        $this->historialUsoModelo = $this->modelo('HistorialUsoModelo');

        $this->datos["menuActivo"] = "historialUso";

        
    }

    public function index(){

        if  (isset($_GET['busqueda']) && !empty($_GET['busqueda'])) {
            $busqueda = $_GET['busqueda'];

            
            $this->datos['conjuntosHistorial'] = $this->historialUsoModelo->buscarConjuntosHistorial($busqueda, $this->datos['usuarioSesion']->id);

            $this->datos['temporadas'] = $this->historialUsoModelo->getTemporadas();
        
            $this->vista("historialUsos/index",$this->datos);  
          
        }elseif (isset($_GET['filtros'])) {
        
            $filtro = isset($_GET['filtros']) ? $_GET['filtros'] : '';

            $idConjuntosTemporadas = $this->historialUsoModelo->getIdConjuntosTemporadas($filtro);
            

            if (empty($idConjuntosTemporadas)) {

                $this->datos['conjuntosHistorial'] = $idConjuntosTemporadas;

            }else {

                $this->datos['conjuntosHistorial'] = $this->historialUsoModelo->filtrarConjuntos($idConjuntosTemporadas, $this->datos['usuarioSesion']->id);
            }

            $this->datos['temporadas'] = $this->historialUsoModelo->getTemporadas();

            $this->vista("historialUsos/index", $this->datos);
  
            
        }else{

            $this->datos['conjuntosHistorial'] = $this->historialUsoModelo->getConjuntosHistorial($this->datos['usuarioSesion']->id);

            $this->datos['prendas'] = $this->historialUsoModelo->getPrendas($this->datos['usuarioSesion']->id);
            
            $this->datos['temporadas'] = $this->historialUsoModelo->getTemporadas();

            $this->vista("historialUsos/index",$this->datos);
        }

    }


    public function add_historial($id_conjunto){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $evento = $_POST;

            if ($this->historialUsoModelo->addHistorial($evento, $id_conjunto, $this->datos['usuarioSesion']->id)) {

                redireccionar('/conjunto/ver_conjunto/'.$id_conjunto);

            }

        }

    }

    public function borrar_historial($id){

        if ($this->historialUsoModelo->borrarHistorial($id)){

            redireccionar('/historialUso');   
        }
    }

}
