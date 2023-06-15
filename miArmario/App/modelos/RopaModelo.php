<?php

class RopaModelo {
    private $db;

    public function __construct(){
        $this->db = new Base;
    }


    public function getRopas($id_usuario){ 
  
        $this->db->query("SELECT P.* FROM prenda P 
                            INNER JOIN subcategoria S ON P.id_subcategoria = S.id 
                                INNER JOIN categoria C ON S.id_categoria = C.id 
                                    WHERE P.id_usuario = :id_usuario_ro AND C.nombre = 'ropas';"); 
 
        $this->db->bind(':id_usuario_ro',$id_usuario); 
 
        return $this->db->registros(); 
 
    } 

    public function ultimoIdPrenda(){

        $this->db->query("SELECT id FROM prenda ORDER BY id DESC LIMIT 1;");
        
        return $this->db->registro();

    }

    public function addSucategoriaRopa($nuevaSubcat){

        $this->db->query("INSERT INTO subcategoria (nombre, id_categoria) VALUES (:nombre, 1);");
        
        $this->db->bind(':nombre',trim($nuevaSubcat));


        if($this->db->execute()){
            return true;
        } else {
            return false;
        }

    }

    public function addRopas($datos, $img, $id_usuario){ 

        if (!empty($datos["subcategoriaRopaInput"])) {
            $this->db->query("INSERT INTO subcategoria (nombre, id_categoria) VALUES (:nombre, 1);");
        
            $this->db->bind(':nombre',trim($datos["subcategoriaRopaInput"]));

            $id_subcategoria = $this->db->executeLastId();

            $this->db->query("INSERT INTO prenda (nombre, descripcion, talla, color, marca, imagen, fecha_insercion, id_subcategoria , id_usuario) 
                                VALUES (:nombre_ro, :descripcion_ro, :talla_ro, :color_ro, :marca_ro, :imagen_ro, :fecha_ro, :id_subcategoria_ro, :id_usuario_ro)");
    
            //vinculamos los valores
            $this->db->bind(':nombre_ro',trim($datos['nombreRopa']));
            $this->db->bind(':descripcion_ro',trim($datos['descripcionRopa']));
            $this->db->bind(':talla_ro',trim($datos['tallaRopa']));
            $this->db->bind(':color_ro',trim($datos['colorRopa']));
            $this->db->bind(':marca_ro',trim($datos['marcaRopa']));
            $this->db->bind(':imagen_ro',trim($img));
            $this->db->bind(':fecha_ro',trim($datos['fecha_insercion']));
            $this->db->bind(':id_subcategoria_ro',trim($id_subcategoria));
            $this->db->bind(':id_usuario_ro',trim($id_usuario));
    
            $id_prenda = $this->db->executeLastId();
    
    
            // Insertar cada valor de $datos['temporadas'] en la tabla prendas_temporadas
            foreach ($datos['temporadas'] as $temporada) {
                $this->db->query("INSERT INTO prendas_temporadas (id_prenda, id_temporada) 
                                VALUES (:id_prenda, :id_temporada)");
    
                $this->db->bind(':id_prenda', $id_prenda);
                $this->db->bind(':id_temporada', trim($temporada));
    
                // Ejecutamos
                if($this->db->execute()){
    
                } else {
                    return false;
                }
            }
    
            return true;

        }else {
            
            $this->db->query("INSERT INTO prenda (nombre, descripcion, talla, color, marca, imagen, fecha_insercion, id_subcategoria , id_usuario) 
                                VALUES (:nombre_ro, :descripcion_ro, :talla_ro, :color_ro, :marca_ro, :imagen_ro, :fecha_ro, :id_subcategoria_ro, :id_usuario_ro)");
    
            //vinculamos los valores
            $this->db->bind(':nombre_ro',trim($datos['nombreRopa']));
            $this->db->bind(':descripcion_ro',trim($datos['descripcionRopa']));
            $this->db->bind(':talla_ro',trim($datos['tallaRopa']));
            $this->db->bind(':color_ro',trim($datos['colorRopa']));
            $this->db->bind(':marca_ro',trim($datos['marcaRopa']));
            $this->db->bind(':imagen_ro',trim($img));
            $this->db->bind(':fecha_ro',trim($datos['fecha_insercion']));
            $this->db->bind(':id_subcategoria_ro',trim($datos['subcategoriaRopa']));
            $this->db->bind(':id_usuario_ro',trim($id_usuario));
    
            $id_prenda = $this->db->executeLastId();
    
    
            // Insertar cada valor de $datos['temporadas'] en la tabla prendas_temporadas
            foreach ($datos['temporadas'] as $temporada) {
                $this->db->query("INSERT INTO prendas_temporadas (id_prenda, id_temporada) 
                                VALUES (:id_prenda, :id_temporada)");
    
                $this->db->bind(':id_prenda', $id_prenda);
                $this->db->bind(':id_temporada', trim($temporada));
    
                // Ejecutamos
                if($this->db->execute()){
    
                } else {
                    return false;
                }
            }
    
            return true;
        }

        
 
    } 


    public function getSubcategoriaRopas(){ 
  
        $this->db->query("SELECT * FROM subcategoria
                            WHERE id_categoria  = 1;"); 
 
        // $this->db->bind(':id_subcategoria_ro',$id_subcategoria); 
 
        return $this->db->registros(); 
 
    }

    public function getTemporadas(){

        $this->db->query("SELECT * FROM temporada;");
 
        return $this->db->registros(); 

    }

    public function buscarRopas($palabra, $id_usuario){

        $this->db->query("SELECT P.* FROM prenda P 
                            INNER JOIN subcategoria S ON P.id_subcategoria = S.id 
                                INNER JOIN categoria C ON S.id_categoria = C.id 
                                    WHERE P.id_usuario = :id_usuario_ro AND C.nombre = 'ropas' 
                                        AND (P.nombre LIKE :palabra OR P.descripcion LIKE :palabra 
                                            OR P.talla LIKE :palabra OR P.color LIKE :palabra 
                                                OR P.marca LIKE :palabra OR P.imagen LIKE :palabra);");

        $this->db->bind(':id_usuario_ro', trim($id_usuario));
        $this->db->bind(':palabra', '%' . $palabra . '%');

        return $this->db->registros();
    }

    public function getRopasTemp($datos, $id_usuario){ 

        print_r($datos); exit();
  
        $this->db->query("SELECT P.* FROM prenda P 
                            INNER JOIN subcategoria S ON P.id_subcategoria = S.id 
                                INNER JOIN categoria C ON S.id_categoria = C.id 
                                    WHERE P.id_usuario = :id_usuario_ro AND C.nombre = 'ropas';"); 
 
        $this->db->bind(':id_usuario_ro',trim($id_usuario)); 
 
        return $this->db->registros(); 
 
    }

    public function getRopaSolo($id_usuario, $id_ropa){

        $this->db->query("SELECT * FROM prenda WHERE id_usuario = :id_usuario_ro AND id = :id_ropa_ro;"); 
 
        $this->db->bind(':id_usuario_ro',trim($id_usuario)); 
        $this->db->bind(':id_ropa_ro',trim($id_ropa)); 
 
        return $this->db->registro(); 

    }

    public function getTemporadasRopa($id_ropa){

        $this->db->query("SELECT * FROM prendas_temporadas WHERE id_prenda = :id_ropa_ro;"); 

        $this->db->bind(':id_ropa_ro',trim($id_ropa));
 
        return $this->db->registros(); 
    }


    public function editRopa($datos, $img, $id_usuario, $id_ropa){ 

        if (empty($img)) {
            
            $this->db->query("UPDATE prenda SET nombre = :nombre_ro, descripcion = :descripcion_ro, talla = :talla_ro, color = :color_ro, 
                                marca = :marca_ro, fecha_insercion = :fecha_ro, id_subcategoria = :id_subcategoria_ro 
                                    WHERE id_usuario = :id_usuario_ro AND id = :id_ropa_ro");

            $this->db->bind(':nombre_ro', trim($datos['nombre']));
            $this->db->bind(':descripcion_ro', trim($datos['descripcion']));
            $this->db->bind(':talla_ro', trim($datos['talla']));
            $this->db->bind(':color_ro', trim($datos['color']));
            $this->db->bind(':marca_ro', trim($datos['marca']));
            $this->db->bind(':fecha_ro', trim($datos['fecha_insercion']));
            $this->db->bind(':id_subcategoria_ro', trim($datos['subcategoriaRopa']));
            $this->db->bind(':id_usuario_ro', trim($id_usuario));
            $this->db->bind(':id_ropa_ro', trim($id_ropa));

            // Ejecutar la consulta de actualización
            if ($this->db->execute()) {
                // Borramos los registros existentes de prendas_temporadas asociados a la prenda actual
                $this->db->query("DELETE FROM prendas_temporadas WHERE id_prenda = :id_prenda");
                $this->db->bind(':id_prenda', trim($id_ropa));
                $this->db->execute();

                // Insertar cada valor de $datos['temporadas'] en la tabla prendas_temporadas
                foreach ($datos['temporadas'] as $temporada) {
                    $this->db->query("INSERT INTO prendas_temporadas (id_prenda, id_temporada) 
                                    VALUES (:id_prenda, :id_temporada)");
                    $this->db->bind(':id_prenda', trim($id_ropa));
                    $this->db->bind(':id_temporada', trim($temporada));
                    $this->db->execute();
                }

                return true;
            } else {
                return false;
            }


        }else {

            // Obtener el nombre del archivo de la imagen actual en la base de datos
            $this->db->query("SELECT imagen FROM prenda WHERE id_usuario = :id_usuario_ro AND id = :id_ropa_ro");

            $this->db->bind(':id_usuario_ro', trim($id_usuario));
            $this->db->bind(':id_ropa_ro', trim($id_ropa));

            $imagenAnterior = $this->db->registro()->imagen;

            // Actualizar la consulta de actualización
            $this->db->query("UPDATE prenda SET nombre = :nombre_ro, descripcion = :descripcion_ro, talla = :talla_ro, color = :color_ro, 
                            marca = :marca_ro, imagen = :imagen_ro, fecha_insercion = :fecha_ro, id_subcategoria = :id_subcategoria_ro 
                            WHERE id_usuario = :id_usuario_ro AND id = :id_ropa_ro");

            // Vincular los valores de actualización
            $this->db->bind(':nombre_ro', trim($datos['nombre']));
            $this->db->bind(':descripcion_ro', trim($datos['descripcion']));
            $this->db->bind(':talla_ro', trim($datos['talla']));
            $this->db->bind(':color_ro', trim($datos['color']));
            $this->db->bind(':marca_ro', trim($datos['marca']));
            $this->db->bind(':imagen_ro', trim($img));
            $this->db->bind(':fecha_ro', trim($datos['fecha_insercion']));
            $this->db->bind(':id_subcategoria_ro', trim($datos['subcategoriaRopa']));
            $this->db->bind(':id_usuario_ro', trim($id_usuario));
            $this->db->bind(':id_ropa_ro', trim($id_ropa));


            // Ejecutar la consulta de actualización
            if ($this->db->execute()) {
                // Eliminar la imagen anterior si existe
                $rutaImagenAnterior = RUTA_PUBLIC . "/img_prendas/" . $id_ropa.$imagenAnterior . ".png";
                if (file_exists($rutaImagenAnterior)) {
                    unlink($rutaImagenAnterior);
                }

                // Borramos los registros existentes de prendas_temporadas asociados a la prenda actual
                $this->db->query("DELETE FROM prendas_temporadas WHERE id_prenda = :id_prenda");
                $this->db->bind(':id_prenda', trim($id_ropa));
                $this->db->execute();

                // Insertar cada valor de $datos['temporadas'] en la tabla prendas_temporadas
                foreach ($datos['temporadas'] as $temporada) {
                    $this->db->query("INSERT INTO prendas_temporadas (id_prenda, id_temporada) 
                                    VALUES (:id_prenda, :id_temporada)");
                    $this->db->bind(':id_prenda', trim($id_ropa));
                    $this->db->bind(':id_temporada', trim($temporada));
                    $this->db->execute();
                }

                return true;
            } else {
                return false;
            }

            
        }
        
 
    } 


    public function borrarRopa($id_usuario, $id_ropa){
        
        // Eliminar registros relacionados en la tabla prendas_temporadas
        $this->db->query("DELETE FROM prendas_temporadas WHERE id_prenda = :id_ropa_ro");
        $this->db->bind(':id_ropa_ro', trim($id_ropa));
        $this->db->execute();

        // Obtener el nombre del archivo de la imagen actual en la base de datos
        $this->db->query("SELECT imagen FROM prenda WHERE id_usuario = :id_usuario_ro AND id = :id_ropa_ro");

        $this->db->bind(':id_usuario_ro', trim($id_usuario));
        $this->db->bind(':id_ropa_ro', trim($id_ropa));

        $imagenAnterior = $this->db->registro()->imagen;


        $this->db->query("DELETE FROM prenda WHERE id_usuario = :id_usuario_ro AND id = :id_ropa_ro");

        $this->db->bind(':id_usuario_ro', trim($id_usuario));
        $this->db->bind(':id_ropa_ro', trim($id_ropa));

        if ($this->db->execute()) {
            // Eliminar la imagen de la ruta
            $rutaImagenAnterior = RUTA_PUBLIC . "/img_prendas/" . $id_ropa.$imagenAnterior . ".png";
            if (file_exists($rutaImagenAnterior)) {
                unlink($rutaImagenAnterior);
            }

            return true;
        }else{
            return false;
        }
    }

    public function obtenerConjuntosPorPrenda($id_usuario, $id_prenda) {

        $this->db->query("SELECT * FROM conjunto WHERE id IN (SELECT id_conjunto FROM prendas_conjuntos WHERE id_prenda = :id_prenda) AND id_usuario = :id_usuario");
    
        $this->db->bind(':id_prenda', $id_prenda);
        $this->db->bind(':id_usuario', $id_usuario);
    
        return $this->db->registros();
    }


}
