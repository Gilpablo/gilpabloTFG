<?php

class Complemento extends Controlador{

    public function __construct(){
        Sesion::iniciarSesion($this->datos);
        
        $this->complementoModelo = $this->modelo('ComplementoModelo');

        $this->datos["menuActivo"] = "complemento";

        
        
        // $this->datos["usuarioSesion"]->roles = $this->asesoriaModelo->getRolesProfesor($this->datos["usuarioSesion"]->id_profesor);
        // $this->datos["usuarioSesion"]->id_rol = obtenerRol($this->datos["usuarioSesion"]->roles);

        // $this->datos['rolesPermitidos'] = [100,200,300];         // Definimos los roles que tendran acceso
        //                                                     // Comprobamos si tiene privilegios
        // if (!tienePrivilegios($this->datos['usuarioSesion']->id_rol,$this->datos['rolesPermitidos'])) {
        //     echo "No tienes privilegios!!!";
        //     exit();
        //     // redireccionar('/');
        // }
    }

    public function index($error=''){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $nuevaComplemento = $_POST;

            $nombreArchivo = $_FILES['imagenComplemento']['name'];
            $ubicacionTemporal = $_FILES['imagenComplemento']['tmp_name'];

            // Obtener el nombre del archivo sin la extensión
            $nombreImg = pathinfo($nombreArchivo, PATHINFO_FILENAME);

            // llamamos consulta y comprabamos que devuelva bien los resultados
            if ($this->complementoModelo->addComplementos($nuevaComplemento, $nombreImg, $this->datos['usuarioSesion']->id)) {

                $idUltimaPrenda = $this->complementoModelo->ultimoIdPrenda()->id;
                // Mover el archivo a una ubicación deseada
                $rutaDestino = RUTA_PUBLIC. "/img_prendas/". $idUltimaPrenda.$nombreImg . ".png";
                if (move_uploaded_file($ubicacionTemporal, $rutaDestino)) {
                    
                     
                    redireccionar('/complemento/creado');
                    
                } else {
                    redireccionar('/complemento/error_2');
                }
            }else {
                redireccionar('/complemento/error_1');
            }

        } elseif (isset($_GET['busqueda']) && !empty($_GET['busqueda'])) {
            $busqueda = $_GET['busqueda'];

            
            $this->datos['error'] = $error;
            
            $this->datos['complementosPrenda'] = $this->complementoModelo->buscarComplementos($busqueda, $this->datos['usuarioSesion']->id);

            $this->datos['complementosSubcategoria'] = $this->complementoModelo->getSubcategoriaComplementos();
            $this->datos['temporadas'] = $this->complementoModelo->getTemporadas();
        
            $this->vista("complementos/index", $this->datos);     
          
        }elseif (isset($_GET['filtros'])) {
        
            // Obtener los datos de los complementos
            $complementos = $this->complementoModelo->getComplementos($this->datos['usuarioSesion']->id);

            $filtro = isset($_GET['filtros']) ? $_GET['filtros'] : '';

            $resultados = array();

            if (!empty($filtro)) {
                foreach ($complementos as $complemento) {
                    if (in_array($complemento->id_subcategoria, (array)$filtro)) {
                        $resultados[] = $complemento;
                    }
                }
            } else {
                $resultados = $complementos;
            }


            $this->datos['error'] = $error;

            $this->datos['complementosPrenda'] = $resultados;
        
            $this->datos['complementosSubcategoria'] = $this->complementoModelo->getSubcategoriaComplementos();
            $this->datos['temporadas'] = $this->complementoModelo->getTemporadas();

            $this->vista("complementos/index",$this->datos);
            
        }else{
            
            $this->datos['error'] = $error;

            $this->datos['complementosPrenda'] = $this->complementoModelo->getComplementos($this->datos['usuarioSesion']->id);
        
            $this->datos['complementosSubcategoria'] = $this->complementoModelo->getSubcategoriaComplementos();
            $this->datos['temporadas'] = $this->complementoModelo->getTemporadas();
        
            $this->vista("complementos/index",$this->datos);
        
        }
        
    }

    public function ver_complemento($id_complemento){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $editComplemento = $_POST;

            $nombreArchivo = $_FILES['imagen']['name'];


            if (!empty($nombreArchivo)) {
                
                $ubicacionTemporal = $_FILES['imagen']['tmp_name'];

                // Obtener el nombre del archivo sin la extensión
                $nombreImg = pathinfo($nombreArchivo, PATHINFO_FILENAME);


                // llamamos consulta y comprabamos que devuelva bien los resultados
                if ($this->complementoModelo->editComplemento($editComplemento, $nombreImg, $this->datos['usuarioSesion']->id, $id_complemento)) {

                    // Mover el archivo a una ubicación deseada
                    $rutaDestino = RUTA_PUBLIC. "/img_prendas/". $id_complemento.$nombreImg . ".png";
                    if (move_uploaded_file($ubicacionTemporal, $rutaDestino)) {
                        
                        redireccionar('/complemento/editado');
                        
                    } else {
                        redireccionar('/complemento/error_2');
                    }
                }else {
                    redireccionar('/complemento/error_1');
                }

            }else {

                // llamamos consulta y comprabamos que devuelva bien los resultados
                if ($this->complementoModelo->editComplemento($editComplemento, $nombreImg, $this->datos['usuarioSesion']->id, $id_complemento)) {
                    
                    redireccionar('/complemento/editado');
                        
                }else {
                    redireccionar('/complemento/error_1');
                }
            }
            
            

        }else{
            
            $this->datos['complemento'] = $this->complementoModelo->getComplementoSolo($this->datos['usuarioSesion']->id, $id_complemento);

            $this->datos['conjuntosPrenda'] = $this->complementoModelo->obtenerConjuntosPorPrenda($this->datos['usuarioSesion']->id, $id_complemento);
        
            $this->datos['complementosSubcategoria'] = $this->complementoModelo->getSubcategoriaComplementos();
            $this->datos['temporadas'] = $this->complementoModelo->getTemporadas();
            $this->datos['temporadaComplemento'] = $this->complementoModelo->getTemporadasComplemento($id_complemento);
            
        
            $this->vista("complementos/verComplemento",$this->datos);
        }
        

    }

    public function borrar_complemento($id_complemento){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // print_r($id_complemento); exit();
            
            if ($this->complementoModelo->borrarComplemento($this->datos['usuarioSesion']->id, $id_complemento)){

                redireccionar('/complemento/borrado');   
            }else {
                redireccionar('/complemento/error_3');
            }
        } else {

        }

    }

}
