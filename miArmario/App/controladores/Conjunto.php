<?php

class Conjunto extends Controlador{

    public function __construct(){
        Sesion::iniciarSesion($this->datos);
        
        $this->conjuntoModelo = $this->modelo('ConjuntoModelo');

        $this->datos["menuActivo"] = "conjunto";

        
        
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

        if  (isset($_GET['busqueda']) && !empty($_GET['busqueda'])) {
            $busqueda = $_GET['busqueda'];

            
            $this->datos['error'] = $error;
            
            $this->datos['conjuntosPrenda'] = $this->conjuntoModelo->buscarConjuntos($busqueda, $this->datos['usuarioSesion']->id);

            $this->datos['conjuntosSubcategoria'] = $this->conjuntoModelo->getSubcategoriaConjuntos();
            $this->datos['temporadas'] = $this->conjuntoModelo->getTemporadas();
        
            $this->vista("conjuntos/index", $this->datos);     
          
        }elseif (isset($_GET['filtros'])) {
        
            // Obtener los datos de los conjuntos
            $conjuntos = $this->conjuntoModelo->getConjuntos($this->datos['usuarioSesion']->id);

            $filtro = isset($_GET['filtros']) ? $_GET['filtros'] : '';

            $resultados = array();

            if (!empty($filtro)) {
                foreach ($conjuntos as $conjunto) {
                    if (in_array($conjunto->id_subcategoria, (array)$filtro)) {
                        $resultados[] = $conjunto;
                    }
                }
            } else {
                $resultados = $conjuntos;
            }


            $this->datos['error'] = $error;

            $this->datos['conjuntosPrenda'] = $resultados;
        
            $this->datos['conjuntosSubcategoria'] = $this->conjuntoModelo->getSubcategoriaConjuntos();
            $this->datos['temporadas'] = $this->conjuntoModelo->getTemporadas();

            $this->vista("conjuntos/index",$this->datos);
            
        }else{
            
            $this->datos['error'] = $error;

            $this->datos['conjuntosPrenda'] = $this->conjuntoModelo->getConjuntos($this->datos['usuarioSesion']->id);
        
            $this->datos['temporadas'] = $this->conjuntoModelo->getTemporadas();
        
            $this->vista("conjuntos/index",$this->datos);
        
        }
        
    }

    public function add_conjunto(){


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $nuevoConjunto = $_POST;

            print_r($nuevoConjunto); exit();

            // Obtener el nombre del conjunto sin espacios
            $nombreImg = str_replace(' ', '_', $nuevoConjunto["nombreConjunto"]);
            $ubicacionTemporal = $_FILES['imagenConjunto']['tmp_name'];

            // llamamos consulta y comprabamos que devuelva bien los resultados
            if ($this->conjuntoModelo->addConjuntos($nuevoConjunto, $nombreImg, $this->datos['usuarioSesion']->id)) {

                $idUltimoConjunto = $this->conjuntoModelo->ultimoIdConjunto()->id;
                // Mover el archivo a una ubicación deseada
                $rutaDestino = RUTA_PUBLIC. "/img_conjuntos/". $idUltimoConjunto.$nombreImg . ".png";
                if (move_uploaded_file($ubicacionTemporal, $rutaDestino)) {
                    
                     
                    redireccionar('/conjunto/creado');
                    
                } else {
                    redireccionar('/conjunto/error_2');
                }
            }else {
                redireccionar('/conjunto/error_1');
            }

        } else{

            $this->datos['prendas'] = $this->conjuntoModelo->getPrendas();

            $this->datos['temporadas'] = $this->conjuntoModelo->getTemporadas();

            $this->datos["ropasSubcategorias"] = $this->conjuntoModelo->getRopaSubcategorias();
            $this->datos["zapatosSubcategorias"] = $this->conjuntoModelo->getZapatosSubcategorias();
            $this->datos["complementosSubcategorias"] = $this->conjuntoModelo->getComplementosSubcategorias();
            
            $this->vista("conjuntos/addConjunto",$this->datos);
        
        }
    }

    public function ver_conjunto($id_conjunto){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $editConjunto = $_POST;

            $nombreArchivo = $_FILES['imagen']['name'];


            if (!empty($nombreArchivo)) {
                
                $ubicacionTemporal = $_FILES['imagen']['tmp_name'];

                // Obtener el nombre del archivo sin la extensión
                $nombreImg = pathinfo($nombreArchivo, PATHINFO_FILENAME);


                // llamamos consulta y comprabamos que devuelva bien los resultados
                if ($this->conjuntoModelo->editConjunto($editConjunto, $nombreImg, $this->datos['usuarioSesion']->id, $id_conjunto)) {

                    // Mover el archivo a una ubicación deseada
                    $rutaDestino = RUTA_PUBLIC. "/img_prendas/". $id_conjunto.$nombreImg . ".png";
                    if (move_uploaded_file($ubicacionTemporal, $rutaDestino)) {
                        
                        redireccionar('/conjunto/editado');
                        
                    } else {
                        redireccionar('/conjunto/error_2');
                    }
                }else {
                    redireccionar('/conjunto/error_1');
                }

            }else {

                // llamamos consulta y comprabamos que devuelva bien los resultados
                if ($this->conjuntoModelo->editConjunto($editConjunto, $nombreImg, $this->datos['usuarioSesion']->id, $id_conjunto)) {
                    
                    redireccionar('/conjunto/editado');
                        
                }else {
                    redireccionar('/conjunto/error_1');
                }
            }
            
            

        }else{
            
            $this->datos['conjunto'] = $this->conjuntoModelo->getConjuntoSolo($this->datos['usuarioSesion']->id, $id_conjunto);
        
            $this->datos['temporadas'] = $this->conjuntoModelo->getTemporadas();
            $this->datos['temporadaConjunto'] = $this->conjuntoModelo->getTemporadasConjunto($id_conjunto);
            
        
            $this->vista("conjuntos/verConjunto",$this->datos);
        }
        

    }

    public function borrar_conjunto($id_conjunto){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // print_r($id_conjunto); exit();
            
            if ($this->conjuntoModelo->borrarConjunto($this->datos['usuarioSesion']->id, $id_conjunto)){

                redireccionar('/conjunto/borrado');   
            }else {
                redireccionar('/conjunto/error_3');
            }
        } else {

        }

    }

}
