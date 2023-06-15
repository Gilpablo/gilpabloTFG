<?php

class ComplementoModelo {
    private $db;

    public function __construct(){
        $this->db = new Base;
    }

    public function getComplementos($id_usuario){ 
  
        $this->db->query("SELECT P.* FROM prenda P 
                            INNER JOIN subcategoria S ON P.id_subcategoria = S.id 
                                INNER JOIN categoria C ON S.id_categoria = C.id 
                                    WHERE P.id_usuario = :id_usuario_co AND C.nombre = 'complementos';"); 
 
        $this->db->bind(':id_usuario_co',$id_usuario); 
 
        return $this->db->registros(); 
 
    } 

    public function ultimoIdPrenda(){

        $this->db->query("SELECT id FROM prenda ORDER BY id DESC LIMIT 1;");
        
        return $this->db->registro();

    }


    public function addComplementos($datos, $img, $id_usuario){ 
            
        
        $this->db->query("INSERT INTO prenda (nombre, descripcion, talla, color, marca, imagen, fecha_insercion, id_subcategoria , id_usuario) 
                            VALUES (:nombre_co, :descripcion_co, :talla_co, :color_co, :marca_co, :imagen_co, :fecha_co, :id_subcategoria_co, :id_usuario_co)");

        //vinculamos los valores
        $this->db->bind(':nombre_co',trim($datos['nombreComplemento']));
        $this->db->bind(':descripcion_co',trim($datos['descripcionComplemento']));
        $this->db->bind(':talla_co',trim($datos['tallaComplemento']));
        $this->db->bind(':color_co',trim($datos['colorComplemento']));
        $this->db->bind(':marca_co',trim($datos['marcaComplemento']));
        $this->db->bind(':imagen_co',trim($img));
        $this->db->bind(':fecha_co',trim($datos['fecha_insercion']));
        $this->db->bind(':id_subcategoria_co',trim($datos['subcategoriaComplemento']));
        $this->db->bind(':id_usuario_co',trim($id_usuario));

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


    public function getSubcategoriaComplementos(){ 
  
        $this->db->query("SELECT * FROM subcategoria
                            WHERE id_categoria  = 3;"); 
 
        // $this->db->bind(':id_subcategoria_ro',$id_subcategoria); 
 
        return $this->db->registros(); 
 
    }

    public function getTemporadas(){

        $this->db->query("SELECT * FROM temporada;");
 
        return $this->db->registros(); 

    }

    public function buscarComplementos($palabra, $id_usuario){

        $this->db->query("SELECT P.* FROM prenda P 
                            INNER JOIN subcategoria S ON P.id_subcategoria = S.id 
                                INNER JOIN categoria C ON S.id_categoria = C.id 
                                    WHERE P.id_usuario = :id_usuario_co AND C.nombre = 'complementos' 
                                        AND (P.nombre LIKE :palabra OR P.descripcion LIKE :palabra 
                                            OR P.talla LIKE :palabra OR P.color LIKE :palabra 
                                                OR P.marca LIKE :palabra OR P.imagen LIKE :palabra);");

        $this->db->bind(':id_usuario_co', trim($id_usuario));
        $this->db->bind(':palabra', '%' . $palabra . '%');

        return $this->db->registros();
    }

    public function getComplementosTemp($datos, $id_usuario){ 

        print_r($datos); exit();
  
        $this->db->query("SELECT P.* FROM prenda P 
                            INNER JOIN subcategoria S ON P.id_subcategoria = S.id 
                                INNER JOIN categoria C ON S.id_categoria = C.id 
                                    WHERE P.id_usuario = :id_usuario_co AND C.nombre = 'complementos';"); 
 
        $this->db->bind(':id_usuario_co',trim($id_usuario)); 
 
        return $this->db->registros(); 
 
    }

    public function getComplementoSolo($id_usuario, $id_complemento){

        $this->db->query("SELECT * FROM prenda WHERE id_usuario = :id_usuario_co AND id = :id_complemento_co;"); 
 
        $this->db->bind(':id_usuario_co',trim($id_usuario)); 
        $this->db->bind(':id_complemento_co',trim($id_complemento)); 
 
        return $this->db->registro(); 

    }

    public function getTemporadasComplemento($id_complemento){

        $this->db->query("SELECT * FROM prendas_temporadas WHERE id_prenda = :id_complemento_co;"); 

        $this->db->bind(':id_complemento_co',trim($id_complemento));
 
        return $this->db->registros(); 
    }


    public function editComplemento($datos, $img, $id_usuario, $id_complemento){ 

        if (empty($img)) {
            
            $this->db->query("UPDATE prenda SET nombre = :nombre_co, descripcion = :descripcion_co, talla = :talla_co, color = :color_co, 
                                marca = :marca_co, fecha_insercion = :fecha_co, id_subcategoria = :id_subcategoria_co 
                                    WHERE id_usuario = :id_usuario_co AND id = :id_complemento_co");

            $this->db->bind(':nombre_co', trim($datos['nombre']));
            $this->db->bind(':descripcion_co', trim($datos['descripcion']));
            $this->db->bind(':talla_co', trim($datos['talla']));
            $this->db->bind(':color_co', trim($datos['color']));
            $this->db->bind(':marca_co', trim($datos['marca']));
            $this->db->bind(':fecha_co', trim($datos['fecha_insercion']));
            $this->db->bind(':id_subcategoria_co', trim($datos['subcategoriaComplemento']));
            $this->db->bind(':id_usuario_co', trim($id_usuario));
            $this->db->bind(':id_complemento_co', trim($id_complemento));

            // Ejecutar la consulta de actualización
            if ($this->db->execute()) {
                // Borramos los registros existentes de prendas_temporadas asociados a la prenda actual
                $this->db->query("DELETE FROM prendas_temporadas WHERE id_prenda = :id_prenda");
                $this->db->bind(':id_prenda', trim($id_complemento));
                $this->db->execute();

                // Insertar cada valor de $datos['temporadas'] en la tabla prendas_temporadas
                foreach ($datos['temporadas'] as $temporada) {
                    $this->db->query("INSERT INTO prendas_temporadas (id_prenda, id_temporada) 
                                    VALUES (:id_prenda, :id_temporada)");
                    $this->db->bind(':id_prenda', trim($id_complemento));
                    $this->db->bind(':id_temporada', trim($temporada));
                    $this->db->execute();
                }

                return true;
            } else {
                return false;
            }


        }else {

            // Obtener el nombre del archivo de la imagen actual en la base de datos
            $this->db->query("SELECT imagen FROM prenda WHERE id_usuario = :id_usuario_co AND id = :id_complemento_co");

            $this->db->bind(':id_usuario_co', trim($id_usuario));
            $this->db->bind(':id_complemento_co', trim($id_complemento));

            $imagenAnterior = $this->db->registro()->imagen;

            // Actualizar la consulta de actualización
            $this->db->query("UPDATE prenda SET nombre = :nombre_co, descripcion = :descripcion_co, talla = :talla_co, color = :color_co, 
                            marca = :marca_co, imagen = :imagen_co, fecha_insercion = :fecha_co, id_subcategoria = :id_subcategoria_co 
                            WHERE id_usuario = :id_usuario_co AND id = :id_complemento_co");

            // Vincular los valores de actualización
            $this->db->bind(':nombre_co', trim($datos['nombre']));
            $this->db->bind(':descripcion_co', trim($datos['descripcion']));
            $this->db->bind(':talla_co', trim($datos['talla']));
            $this->db->bind(':color_co', trim($datos['color']));
            $this->db->bind(':marca_co', trim($datos['marca']));
            $this->db->bind(':imagen_co', trim($img));
            $this->db->bind(':fecha_co', trim($datos['fecha_insercion']));
            $this->db->bind(':id_subcategoria_co', trim($datos['subcategoriaComplemento']));
            $this->db->bind(':id_usuario_co', trim($id_usuario));
            $this->db->bind(':id_complemento_co', trim($id_complemento));


            // Ejecutar la consulta de actualización
            if ($this->db->execute()) {
                // Eliminar la imagen anterior si existe
                $rutaImagenAnterior = RUTA_PUBLIC . "/img_prendas/" . $id_complemento.$imagenAnterior . ".png";
                if (file_exists($rutaImagenAnterior)) {
                    unlink($rutaImagenAnterior);
                }

                // Borramos los registros existentes de prendas_temporadas asociados a la prenda actual
                $this->db->query("DELETE FROM prendas_temporadas WHERE id_prenda = :id_prenda");
                $this->db->bind(':id_prenda', trim($id_complemento));
                $this->db->execute();

                // Insertar cada valor de $datos['temporadas'] en la tabla prendas_temporadas
                foreach ($datos['temporadas'] as $temporada) {
                    $this->db->query("INSERT INTO prendas_temporadas (id_prenda, id_temporada) 
                                    VALUES (:id_prenda, :id_temporada)");
                    $this->db->bind(':id_prenda', trim($id_complemento));
                    $this->db->bind(':id_temporada', trim($temporada));
                    $this->db->execute();
                }

                return true;
            } else {
                return false;
            }

            
        }
        
 
    } 


    public function borrarComplemento($id_usuario, $id_complemento){
        
        // Eliminar registros relacionados en la tabla prendas_temporadas
        $this->db->query("DELETE FROM prendas_temporadas WHERE id_prenda = :id_complemento_co");
        $this->db->bind(':id_complemento_co', trim($id_complemento));
        $this->db->execute();

        // Obtener el nombre del archivo de la imagen actual en la base de datos
        $this->db->query("SELECT imagen FROM prenda WHERE id_usuario = :id_usuario_co AND id = :id_complemento_co");

        $this->db->bind(':id_usuario_co', trim($id_usuario));
        $this->db->bind(':id_complemento_co', trim($id_complemento));

        $imagenAnterior = $this->db->registro()->imagen;


        $this->db->query("DELETE FROM prenda WHERE id_usuario = :id_usuario_co AND id = :id_complemento_co");

        $this->db->bind(':id_usuario_co', trim($id_usuario));
        $this->db->bind(':id_complemento_co', trim($id_complemento));

        if ($this->db->execute()) {
            // Eliminar la imagen de la ruta
            $rutaImagenAnterior = RUTA_PUBLIC . "/img_prendas/" . $id_complemento.$imagenAnterior . ".png";
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
