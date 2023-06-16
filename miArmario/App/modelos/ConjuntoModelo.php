<?php

class ConjuntoModelo {
    private $db;

    public function __construct(){
        $this->db = new Base;
    }

    public function getConjuntos($id_usuario){ 
  
        $this->db->query("SELECT * FROM conjunto WHERE id_usuario = :id_usuario;"); 
 
        $this->db->bind(':id_usuario',$id_usuario); 
 
        return $this->db->registros(); 
 
    } 

    public function getIdConjuntosTemporadas($datos) {
        $conjuntos = array();
    
        foreach ($datos as $id) {
            $this->db->query("SELECT id_conjunto FROM conjuntos_temporadas WHERE id_temporada = :id_temporada");
            $this->db->bind(':id_temporada', $id);
            $resultado = $this->db->registros();
    
            if (!empty($resultado)) {
                foreach ($resultado as $fila) {
                    $conjuntos[] = $fila->id_conjunto;
                }
            }
        }
        
        
        return $conjuntos;
    }
    
    

    public function ultimoIdConjunto(){

        $this->db->query("SELECT id FROM conjunto ORDER BY id DESC LIMIT 1;");
        
        return $this->db->registro();

    }


    public function addConjuntos($datos, $img, $id_usuario){ 

        // print_r($datos); exit();
        $nombreImg = str_replace(' ', '_', $datos["nombreConjunto"]);

        $this->db->query("INSERT INTO conjunto (nombre, descripcion, fecha_creacion, imagen_conjunto, id_usuario) 
                            VALUES (:nombre_co, :descripcion_co, :fecha_co, :imagen_co, :id_usuario_co)");

        //vinculamos los valores
        $this->db->bind(':nombre_co', trim($datos['nombreConjunto']));
        $this->db->bind(':descripcion_co', trim($datos['descripcionConjunto']));
        $this->db->bind(':imagen_co', empty($img) ? null : trim($nombreImg));
        $this->db->bind(':fecha_co', trim($datos['fecha_creacionConjunto']));
        $this->db->bind(':id_usuario_co', trim($id_usuario));

        $id_conjunto = $this->db->executeLastId();

        // Insertar cada valor de $datos['temporadas'] en la tabla conjuntos_temporadas
        foreach ($datos['temporadas'] as $temporada) {
            $this->db->query("INSERT INTO conjuntos_temporadas (id_conjunto, id_temporada) 
                                VALUES (:id_conjunto, :id_temporada)");

            $this->db->bind(':id_conjunto', $id_conjunto);
            $this->db->bind(':id_temporada', trim($temporada));

            // Ejecutamos
            if (!$this->db->execute()) {
                return false;
            }
        }

        // Insertar cada valor de $datos['prendasSeleccionadas'] en la tabla prendas_conjuntos
        foreach ($datos['prendasSeleccionadas'] as $prenda) {
            $this->db->query("INSERT INTO prendas_conjuntos (id_prenda, id_conjunto) 
                                VALUES (:id_prenda, :id_conjunto)");

            $this->db->bind(':id_conjunto', $id_conjunto);
            $this->db->bind(':id_prenda', trim($prenda));

            // Ejecutamos
            if (!$this->db->execute()) {
                return false;
            }
        }

        return true;
    }



    public function getPrendas($id_usuario){ 
  
        $this->db->query("SELECT * FROM prenda where id_usuario = :id_usuario;"); 

        
        $this->db->bind(':id_usuario', trim($id_usuario));
 
        return $this->db->registros(); 
 
    }


    public function getRopaSubcategorias(){ 
  
        $this->db->query("SELECT * FROM subcategoria WHERE id_categoria  = 1;"); 
 
        return $this->db->registros(); 
 
    }

    public function getZapatosSubcategorias(){ 
  
        $this->db->query("SELECT * FROM subcategoria WHERE id_categoria  = 2;"); 
 
        return $this->db->registros(); 
 
    }
    
    public function getComplementosSubcategorias(){ 
  
        $this->db->query("SELECT * FROM subcategoria WHERE id_categoria  = 3;"); 
 
        return $this->db->registros(); 
 
    }

    public function getTemporadas(){

        $this->db->query("SELECT * FROM temporada;");
 
        return $this->db->registros(); 

    }

    public function buscarConjuntos($palabra, $id_usuario){

        $this->db->query("SELECT * FROM conjunto WHERE id_usuario = :id_usuario_co 
                            AND (nombre LIKE :palabra OR descripcion LIKE :palabra OR imagen_conjunto LIKE :palabra);");

        $this->db->bind(':id_usuario_co', trim($id_usuario));
        $this->db->bind(':palabra', '%' . $palabra . '%');

        return $this->db->registros();
    }

    public function filtrarConjuntos($ids, $id_usuario) {
        $idsString = implode(',', $ids); // Convertir el array de IDs a una cadena separada por comas
    
        $this->db->query("SELECT * FROM conjunto WHERE id_usuario = :id_usuario_co AND id IN ($idsString)");
    
        $this->db->bind(':id_usuario_co', trim($id_usuario));
    
        return $this->db->registros();
    }


    public function getConjuntoSolo($id_usuario, $id_conjunto){

        $this->db->query("SELECT * FROM conjunto WHERE id_usuario = :id_usuario_co AND id = :id_conjunto_co;"); 
 
        $this->db->bind(':id_usuario_co',trim($id_usuario)); 
        $this->db->bind(':id_conjunto_co',trim($id_conjunto)); 
 
        return $this->db->registro(); 

    }

    public function getTemporadasConjunto($id_conjunto){

        $this->db->query("SELECT * FROM conjuntos_temporadas WHERE id_conjunto = :id_conjunto_co;"); 

        $this->db->bind(':id_conjunto_co',trim($id_conjunto));
 
        return $this->db->registros(); 
    }


    public function editConjunto($datos, $img, $id_usuario, $id_conjunto){ 

        $nombreImg = str_replace(' ', '_', $datos["nombre"]);

        if (empty($img)) {
            
            $this->db->query("UPDATE conjunto SET nombre = :nombre_co, descripcion = :descripcion_co, fecha_creacion = :fecha_co 
                                    WHERE id_usuario = :id_usuario_co AND id = :id_conjunto_co");

            $this->db->bind(':nombre_co', trim($datos['nombre']));
            $this->db->bind(':descripcion_co', trim($datos['descripcion']));
            $this->db->bind(':fecha_co', trim($datos['fecha_creacion']));
            $this->db->bind(':id_usuario_co', trim($id_usuario));
            $this->db->bind(':id_conjunto_co', trim($id_conjunto));

            // Ejecutar la consulta de actualización
            if ($this->db->execute()) {
                // Borramos los registros existentes de conjuntos_temporadas asociados a la prenda actual
                $this->db->query("DELETE FROM conjuntos_temporadas WHERE id_conjunto = :id_conjunto");
                $this->db->bind(':id_conjunto', trim($id_conjunto));
                $this->db->execute();

                // Insertar cada valor de $datos['temporadas'] en la tabla conjuntos_temporadas
                foreach ($datos['temporadas'] as $temporada) {
                    $this->db->query("INSERT INTO conjuntos_temporadas (id_conjunto, id_temporada) 
                                    VALUES (:id_conjunto, :id_temporada)");
                    $this->db->bind(':id_conjunto', trim($id_conjunto));
                    $this->db->bind(':id_temporada', trim($temporada));
                    $this->db->execute();
                }


                // Borramos los registros existentes de prendas_conjuntos asociados a la prenda actual
                $this->db->query("DELETE FROM prendas_conjuntos WHERE id_conjunto = :id_conjunto");
                $this->db->bind(':id_conjunto', trim($id_conjunto));
                $this->db->execute();

                // Insertar cada valor de $datos['prendasSeleccionadas'] en la tabla prendas_conjuntos
                foreach ($datos['prendasSeleccionadas'] as $prenda) {
                    $this->db->query("INSERT INTO prendas_conjuntos (id_prenda, id_conjunto) 
                                        VALUES (:id_prenda, :id_conjunto)");

                    $this->db->bind(':id_conjunto', $id_conjunto);
                    $this->db->bind(':id_prenda', trim($prenda));

                    $this->db->execute();
                   
                }

                return true;
            } else {
                return false;
            }


        }else {

            // Obtener el nombre del archivo de la imagen actual en la base de datos
            $this->db->query("SELECT imagen_conjunto FROM conjunto WHERE id_usuario = :id_usuario_co AND id = :id_conjunto_co");

            $this->db->bind(':id_usuario_co', trim($id_usuario));
            $this->db->bind(':id_conjunto_co', trim($id_conjunto));

            $imagenAnterior = $this->db->registro()->imagen_conjunto;

            // Actualizar la consulta de actualización
            $this->db->query("UPDATE conjunto SET nombre = :nombre_co, descripcion = :descripcion_co, 
                                imagen_conjunto = :imagen_co, fecha_creacion = :fecha_co
                                    WHERE id_usuario = :id_usuario_co AND id = :id_conjunto_co");

            // Vincular los valores de actualización
            $this->db->bind(':nombre_co', trim($datos['nombre']));
            $this->db->bind(':descripcion_co', trim($datos['descripcion']));
            $this->db->bind(':imagen_co', trim($nombreImg));
            $this->db->bind(':fecha_co', trim($datos['fecha_creacion']));
            $this->db->bind(':id_usuario_co', trim($id_usuario));
            $this->db->bind(':id_conjunto_co', trim($id_conjunto));


            // Ejecutar la consulta de actualización
            if ($this->db->execute()) {

                if (empty($imagenAnterior)) {
                    
                    // Borramos los registros existentes de conjuntos_temporadas asociados a la prenda actual
                    $this->db->query("DELETE FROM conjuntos_temporadas WHERE id_conjunto = :id_conjunto");
                    $this->db->bind(':id_conjunto', trim($id_conjunto));
                    $this->db->execute();

                    // Insertar cada valor de $datos['temporadas'] en la tabla conjuntos_temporadas
                    foreach ($datos['temporadas'] as $temporada) {
                        $this->db->query("INSERT INTO conjuntos_temporadas (id_conjunto, id_temporada) 
                                        VALUES (:id_conjunto, :id_temporada)");
                        $this->db->bind(':id_conjunto', trim($id_conjunto));
                        $this->db->bind(':id_temporada', trim($temporada));
                        $this->db->execute();
                    }

                    // Borramos los registros existentes de prendas_conjuntos asociados a la prenda actual
                    $this->db->query("DELETE FROM prendas_conjuntos WHERE id_conjunto = :id_conjunto");
                    $this->db->bind(':id_prenda', trim($id_conjunto));
                    $this->db->execute();

                    // Insertar cada valor de $datos['prendasSeleccionadas'] en la tabla prendas_conjuntos
                    foreach ($datos['prendasSeleccionadas'] as $prenda) {
                        $this->db->query("INSERT INTO prendas_conjuntos (id_prenda, id_conjunto) 
                                            VALUES (:id_prenda, :id_conjunto)");

                        $this->db->bind(':id_conjunto', $id_conjunto);
                        $this->db->bind(':id_prenda', trim($prenda));

                        $this->db->execute();
                    
                    }

                    return true;
                }else {
                   
                    // Eliminar la imagen anterior si existe
                    $rutaImagenAnterior = RUTA_PUBLIC . "/img_conjuntos/" . $id_conjunto.$imagenAnterior . ".png";
                    if (file_exists($rutaImagenAnterior)) {
                        unlink($rutaImagenAnterior);
                    }
            
                    // Borramos los registros existentes de prendas_temporadas asociados a la prenda actual
                    $this->db->query("DELETE FROM conjuntos_temporadas WHERE id_conjunto = :id_conjunto");
                    $this->db->bind(':id_conjunto', trim($id_conjunto));
                    $this->db->execute();
    
                    // Insertar cada valor de $datos['temporadas'] en la tabla prendas_temporadas
                    foreach ($datos['temporadas'] as $temporada) {
                        $this->db->query("INSERT INTO conjuntos_temporadas (id_conjunto, id_temporada) 
                                        VALUES (:id_conjunto, :id_temporada)");
                        $this->db->bind(':id_conjunto', trim($id_conjunto));
                        $this->db->bind(':id_temporada', trim($temporada));
                        $this->db->execute();
                    }

                    // Borramos los registros existentes de prendas_conjuntos asociados a la prenda actual
                    $this->db->query("DELETE FROM prendas_conjuntos WHERE id_conjunto = :id_conjunto");
                    $this->db->bind(':id_prenda', trim($id_conjunto));
                    $this->db->execute();

                    // Insertar cada valor de $datos['prendasSeleccionadas'] en la tabla prendas_conjuntos
                    foreach ($datos['prendasSeleccionadas'] as $prenda) {
                        $this->db->query("INSERT INTO prendas_conjuntos (id_prenda, id_conjunto) 
                                            VALUES (:id_prenda, :id_conjunto)");

                        $this->db->bind(':id_conjunto', $id_conjunto);
                        $this->db->bind(':id_prenda', trim($prenda));

                        $this->db->execute();
                    
                    }
    
                    return true;
                }

            } else {
                return false;
            }

            
        }
        
 
    } 


    public function borrarConjunto($id_usuario, $id_conjunto){
        
        // Eliminar registros relacionados en la tabla conjuntos_temporadas
        $this->db->query("DELETE FROM conjuntos_temporadas WHERE id_conjunto = :id_conjunto_co");
        $this->db->bind(':id_conjunto_co', trim($id_conjunto));
        $this->db->execute();

        // Eliminar registros relacionados en la tabla prendas_conjuntos
        $this->db->query("DELETE FROM prendas_conjuntos WHERE id_conjunto = :id_conjunto_co");
        $this->db->bind(':id_conjunto_co', trim($id_conjunto));
        $this->db->execute();

        // Obtener el nombre del archivo de la imagen actual en la base de datos
        $this->db->query("SELECT imagen_conjunto FROM conjunto WHERE id_usuario = :id_usuario_co AND id = :id_conjunto_co");

        $this->db->bind(':id_usuario_co', trim($id_usuario));
        $this->db->bind(':id_conjunto_co', trim($id_conjunto));

        $imagenAnterior = $this->db->registro()->imagen_conjunto;


        $this->db->query("DELETE FROM conjunto WHERE id_usuario = :id_usuario_co AND id = :id_conjunto_co");

        $this->db->bind(':id_usuario_co', trim($id_usuario));
        $this->db->bind(':id_conjunto_co', trim($id_conjunto));

        if ($this->db->execute()) {
            // Eliminar la imagen de la ruta
            $rutaImagenAnterior = RUTA_PUBLIC . "/img_conjuntos/" . $id_conjunto.$imagenAnterior . ".png";
            if (file_exists($rutaImagenAnterior)) {
                unlink($rutaImagenAnterior);
            }

            return true;
        }else{
            return false;
        }
    }

    public function obtenerPrendasPorConjunto($id_usuario, $id_conjunto) {

        $this->db->query("SELECT * FROM prenda WHERE id IN (SELECT id_prenda FROM prendas_conjuntos WHERE id_conjunto = :id_conjunto) AND id_usuario = :id_usuario");
    
        $this->db->bind(':id_conjunto', $id_conjunto);
        $this->db->bind(':id_usuario', $id_usuario);
    
        return $this->db->registros();
    }
    

}
