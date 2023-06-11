<?php

class Zapato extends Controlador{

    public function __construct(){
        Sesion::iniciarSesion($this->datos);
        
        $this->zapatoModelo = $this->modelo('ZapatoModelo');

        $this->datos["menuActivo"] = "zapato";

        
        
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

        // $this->datos["asesorias"] = $this->asesoriaModelo->getAsesorias();
        // foreach($this->datos["asesorias"] as $asesoria){
        //     $asesoria->acciones = $this->asesoriaModelo->getAccionesAsesoria($asesoria->id_asesoria);
        // }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $nuevoZapato = $_POST;

            $nombreArchivo = $_FILES['imagenZapato']['name'];
            $ubicacionTemporal = $_FILES['imagenZapato']['tmp_name'];

            // Obtener el nombre del archivo sin la extensión
            $nombreImg = pathinfo($nombreArchivo, PATHINFO_FILENAME);

            // llamamos consulta y comprabamos que devuelva bien los resultados
            if ($this->zapatoModelo->addZapatos($nuevoZapato, $nombreImg, $this->datos['usuarioSesion']->id)) {

                $idUltimaPrenda = $this->zapatoModelo->ultimoIdPrenda()->id;
                // Mover el archivo a una ubicación deseada
                $rutaDestino = RUTA_PUBLIC. "/img_prendas/". $idUltimaPrenda.$nombreImg . ".png";
                if (move_uploaded_file($ubicacionTemporal, $rutaDestino)) {
                    
                     
                    redireccionar('/zapato/creado');
                    
                } else {
                    redireccionar('/zapato/error_2');
                }
            }else {
                redireccionar('/zapato/creado/error_1');
            }

        }elseif (isset($_GET['filtros'])) {
            
            
            // Obtener los datos de los zapatos
            $zapatos = $this->zapatoModelo->getZapatos($this->datos['usuarioSesion']->id);

            // Obtener los parámetros del filtro
            // $marca = isset($_GET['marca']) ? $_GET['marca'] : '';
            // $talla = isset($_GET['talla']) ? $_GET['talla'] : '';
            // $color = isset($_GET['color']) ? $_GET['color'] : '';
            // $fechaInsercion = isset($_GET['fechaInsercion']) ? $_GET['fechaInsercion'] : '';

            $filtro = isset($_GET['filtros']) ? $_GET['filtros'] : '';
            // print_r($filtro); exit();

            $resultados = array();

            if (!empty($filtro)) {
                foreach ($zapatos as $zapato) {
                    if (in_array($zapato->id_subcategoria, (array)$filtro)) {
                        $resultados[] = $zapato;
                    }
                }
            } else {
                $resultados = $zapatos;
            }


            $this->datos['error'] = $error;

            $this->datos['zapatosPrenda'] = $resultados;
        
            // print_r($this->datos['zapatosPrenda']->id_subcategoria); exit();
        
            $this->datos['zapatosSubcategoria'] = $this->zapatoModelo->getSubcategoriaZapatos();
            $this->datos['temporadas'] = $this->zapatoModelo->getTemporadas();

            $this->vista("zapatos/index",$this->datos);

            


        } elseif (isset($_GET['busqueda']) && !empty($_GET['busqueda'])) {
            $busqueda = $_GET['busqueda'];

            
            $this->datos['error'] = $error;
            
            $this->datos['zapatosPrenda'] = $this->zapatoModelo->buscarZapatos($busqueda, $this->datos['usuarioSesion']->id);

            $this->datos['zapatosSubcategoria'] = $this->zapatoModelo->getSubcategoriaZapatos();
            $this->datos['temporadas'] = $this->zapatoModelo->getTemporadas();
        
            $this->vista("zapatos/index", $this->datos);     
          
            

        }else{
            
            $this->datos['error'] = $error;

            $this->datos['zapatosPrenda'] = $this->zapatoModelo->getZapatos($this->datos['usuarioSesion']->id);
        
            // print_r($this->datos['zapatosPrenda']); exit();
        
            $this->datos['zapatosSubcategoria'] = $this->zapatoModelo->getSubcategoriaZapatos();
            $this->datos['temporadas'] = $this->zapatoModelo->getTemporadas();
        
            $this->vista("zapatos/index",$this->datos);
        
        }
        
    }

    public function verZapato($id_zapato){

        
        $this->datos['zapato'] = $this->zapatoModelo->getZapatoSolo($this->datos['usuarioSesion']->id, $id_zapato);
        
        // print_r($this->datos['zapatosPrenda']); exit();
    
        $this->datos['zapatosSubcategoria'] = $this->zapatoModelo->getSubcategoriaZapatos();
        $this->datos['temporadas'] = $this->zapatoModelo->getTemporadas();
    
        $this->vista("zapatos/verZapato",$this->datos);

    }

    public function filtro(){
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $datos = $_GET;

            if (!isset($datos['fecha_ini']) || empty($datos['fecha_ini'])){     // Si fecha_ini esta vacio, le pongo la fecha de 6 meses atras
                $datos['fecha_ini'] = hoyMenos6Meses();
            }

            if (!isset($datos['fecha_fin']) || empty($datos['fecha_fin'])){     // Si fecha_fin esta vacio, le pongo fecha de hoy
                $datos['fecha_fin'] = date("Y-m-d");
            }


            $this->datos["estados"] = $this->asesoriaModelo->getEstados($datos);    // Cogemos todos los estados existentes
            if (!isset($datos['buscar'])){              // con esto vemos que entramos a filtro por primera vez, los selecciono todos
                $datos['estado'] = array_column($this->datos['estados'], 'id_estado');
            }

            if (!isset($datos['estado'])){              // Inicializo si esta vacio para que no de error
                $datos['estado'] = [];
            }

            if(!isset($datos['buscar'])){   // Si no esta definido buscar, lo defino con la cadena vacia
                $datos['buscar'] = '';
            }

            $this->datos["filtro"] = $datos;
            $this->datos["asesorias"] = $this->asesoriaModelo->getAsesoriasFiltro($datos);
            foreach($this->datos["asesorias"] as $asesoria){
                $asesoria->acciones = $this->asesoriaModelo->getAccionesAsesoria($asesoria->id_asesoria);
            }

            $this->vista("asesorias/index",$this->datos);
        } else {

        }
    }

}
