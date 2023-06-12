<?php

class Ropa extends Controlador{

    public function __construct(){
        Sesion::iniciarSesion($this->datos);
        
        $this->ropaModelo = $this->modelo('RopaModelo');

        $this->datos["menuActivo"] = "ropa";

    }
    
    public function index($error=''){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $nuevaRopa = $_POST;

            $nombreArchivo = $_FILES['imagenRopa']['name'];
            $ubicacionTemporal = $_FILES['imagenRopa']['tmp_name'];

            // Obtener el nombre del archivo sin la extensión
            $nombreImg = pathinfo($nombreArchivo, PATHINFO_FILENAME);

            // llamamos consulta y comprabamos que devuelva bien los resultados
            if ($this->ropaModelo->addRopas($nuevaRopa, $nombreImg, $this->datos['usuarioSesion']->id)) {

                $idUltimaPrenda = $this->ropaModelo->ultimoIdPrenda()->id;
                // Mover el archivo a una ubicación deseada
                $rutaDestino = RUTA_PUBLIC. "/img_prendas/". $idUltimaPrenda.$nombreImg . ".png";
                if (move_uploaded_file($ubicacionTemporal, $rutaDestino)) {
                    
                     
                    redireccionar('/ropa/creado');
                    
                } else {
                    redireccionar('/ropa/error_2');
                }
            }else {
                redireccionar('/ropa/error_1');
            }

        } elseif (isset($_GET['busqueda']) && !empty($_GET['busqueda'])) {
            $busqueda = $_GET['busqueda'];

            
            $this->datos['error'] = $error;
            
            $this->datos['ropasPrenda'] = $this->ropaModelo->buscarRopas($busqueda, $this->datos['usuarioSesion']->id);

            $this->datos['ropasSubcategoria'] = $this->ropaModelo->getSubcategoriaropas();
            $this->datos['temporadas'] = $this->ropaModelo->getTemporadas();
        
            $this->vista("ropas/index", $this->datos);     
          
        }elseif (isset($_GET['filtros'])) {
        
            // Obtener los datos de los ropas
            $ropas = $this->ropaModelo->getRopas($this->datos['usuarioSesion']->id);

            $filtro = isset($_GET['filtros']) ? $_GET['filtros'] : '';

            $resultados = array();

            if (!empty($filtro)) {
                foreach ($ropas as $ropa) {
                    if (in_array($ropa->id_subcategoria, (array)$filtro)) {
                        $resultados[] = $ropa;
                    }
                }
            } else {
                $resultados = $ropas;
            }


            $this->datos['error'] = $error;

            $this->datos['ropasPrenda'] = $resultados;
        
            $this->datos['ropasSubcategoria'] = $this->ropaModelo->getSubcategoriaRopas();
            $this->datos['temporadas'] = $this->ropaModelo->getTemporadas();

            $this->vista("ropas/index",$this->datos);
            
        }else{
            
            $this->datos['error'] = $error;

            $this->datos['ropasPrenda'] = $this->ropaModelo->getRopas($this->datos['usuarioSesion']->id);
        
            $this->datos['ropasSubcategoria'] = $this->ropaModelo->getSubcategoriaRopas();
            $this->datos['temporadas'] = $this->ropaModelo->getTemporadas();
        
            $this->vista("ropas/index",$this->datos);
        
        }
        
    }

    public function ver_ropa($id_ropa){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $editRopa = $_POST;

            $nombreArchivo = $_FILES['imagen']['name'];


            if (!empty($nombreArchivo)) {
                
                $ubicacionTemporal = $_FILES['imagen']['tmp_name'];

                // Obtener el nombre del archivo sin la extensión
                $nombreImg = pathinfo($nombreArchivo, PATHINFO_FILENAME);


                // llamamos consulta y comprabamos que devuelva bien los resultados
                if ($this->ropaModelo->editRopa($editRopa, $nombreImg, $this->datos['usuarioSesion']->id, $id_ropa)) {

                    // Mover el archivo a una ubicación deseada
                    $rutaDestino = RUTA_PUBLIC. "/img_prendas/". $id_ropa.$nombreImg . ".png";
                    if (move_uploaded_file($ubicacionTemporal, $rutaDestino)) {
                        
                        redireccionar('/ropa/editado');
                        
                    } else {
                        redireccionar('/ropa/error_2');
                    }
                }else {
                    redireccionar('/ropa/error_1');
                }

            }else {

                // llamamos consulta y comprabamos que devuelva bien los resultados
                if ($this->ropaModelo->editRopa($editRopa, $nombreImg, $this->datos['usuarioSesion']->id, $id_ropa)) {
                    
                    redireccionar('/ropa/editado');
                        
                }else {
                    redireccionar('/ropa/error_1');
                }
            }
            
            

        }else{
            
            $this->datos['ropa'] = $this->ropaModelo->getRopaSolo($this->datos['usuarioSesion']->id, $id_ropa);
        
            $this->datos['ropasSubcategoria'] = $this->ropaModelo->getSubcategoriaRopas();
            $this->datos['temporadas'] = $this->ropaModelo->getTemporadas();
            $this->datos['temporadaRopa'] = $this->ropaModelo->getTemporadasRopa($id_ropa);
            
        
            $this->vista("ropas/verRopa",$this->datos);
        }
        

    }

    public function borrar_ropa($id_ropa){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // print_r($id_ropa); exit();
            
            if ($this->ropaModelo->borrarRopa($this->datos['usuarioSesion']->id, $id_ropa)){

                redireccionar('/ropa/borrado');   
            }else {
                redireccionar('/ropa/error_3');
            }
        } else {

        }

    }
}


