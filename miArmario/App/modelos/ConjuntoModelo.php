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

    public function ultimoIdConjunto(){

        $this->db->query("SELECT id FROM conjunto ORDER BY id DESC LIMIT 1;");
        
        return $this->db->registro();

    }


    public function addConjuntos($datos, $img, $id_usuario){ 
            
        // print_r($datos); exit();

        $this->db->query("INSERT INTO conjunto (nombre, descripcion, fecha_creacion, imagen_conjunto, id_usuario) 
                            VALUES (:nombre_co, :descripcion_co, :fecha_co, :imagen_co, :id_usuario_co)");

        //vinculamos los valores
        $this->db->bind(':nombre_co',trim($datos['nombreConjunto']));
        $this->db->bind(':descripcion_co',trim($datos['descripcionConjunto']));
        $this->db->bind(':imagen_co',trim($img));
        $this->db->bind(':fecha_co',trim($datos['fecha_creacionConjunto']));
        $this->db->bind(':id_usuario_co',trim($id_usuario));

        $id_conjunto = $this->db->executeLastId();


        // Insertar cada valor de $datos['temporadas'] en la tabla conjuntos_temporadas
        foreach ($datos['temporadas'] as $temporada) {
            $this->db->query("INSERT INTO conjuntos_temporadas (id_conjunto, id_temporada) 
                                VALUES (:id_conjunto, :id_temporada)");

            $this->db->bind(':id_conjunto', $id_conjunto);
            $this->db->bind(':id_temporada', trim($temporada));

            // Ejecutamos
            if($this->db->execute()){

            } else {
                return false;
            }
        }

        return true;
    }


    public function getPrendas(){ 
  
        $this->db->query("SELECT * FROM prenda;"); 
 
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

        $this->db->query("SELECT P.* FROM prenda P 
                            INNER JOIN subcategoria S ON P.id_subcategoria = S.id 
                                INNER JOIN categoria C ON S.id_categoria = C.id 
                                    WHERE P.id_usuario = :id_usuario_co AND C.nombre = 'conjuntos' 
                                        AND (P.nombre LIKE :palabra OR P.descripcion LIKE :palabra 
                                            OR P.talla LIKE :palabra OR P.color LIKE :palabra 
                                                OR P.marca LIKE :palabra OR P.imagen LIKE :palabra);");

        $this->db->bind(':id_usuario_co', trim($id_usuario));
        $this->db->bind(':palabra', '%' . $palabra . '%');

        return $this->db->registros();
    }

    public function getConjuntosTemp($datos, $id_usuario){ 

        print_r($datos); exit();
  
        $this->db->query("SELECT P.* FROM prenda P 
                            INNER JOIN subcategoria S ON P.id_subcategoria = S.id 
                                INNER JOIN categoria C ON S.id_categoria = C.id 
                                    WHERE P.id_usuario = :id_usuario_co AND C.nombre = 'conjuntos';"); 
 
        $this->db->bind(':id_usuario_co',trim($id_usuario)); 
 
        return $this->db->registros(); 
 
    }

    public function getConjuntoSolo($id_usuario, $id_conjunto){

        $this->db->query("SELECT * FROM prenda WHERE id_usuario = :id_usuario_co AND id = :id_conjunto_co;"); 
 
        $this->db->bind(':id_usuario_co',trim($id_usuario)); 
        $this->db->bind(':id_conjunto_co',trim($id_conjunto)); 
 
        return $this->db->registro(); 

    }

    public function getTemporadasConjunto($id_conjunto){

        $this->db->query("SELECT * FROM prendas_temporadas WHERE id_prenda = :id_conjunto_co;"); 

        $this->db->bind(':id_conjunto_co',trim($id_conjunto));
 
        return $this->db->registros(); 
    }


    public function editConjunto($datos, $img, $id_usuario, $id_conjunto){ 

        if (empty($img)) {
            
            $this->db->query("UPDATE prenda SET nombre = :nombre_co, descripcion = :descripcion_co, talla = :talla_co, color = :color_co, 
                                marca = :marca_co, fecha_insercion = :fecha_co, id_subcategoria = :id_subcategoria_co 
                                    WHERE id_usuario = :id_usuario_co AND id = :id_conjunto_co");

            $this->db->bind(':nombre_co', trim($datos['nombre']));
            $this->db->bind(':descripcion_co', trim($datos['descripcion']));
            $this->db->bind(':talla_co', trim($datos['talla']));
            $this->db->bind(':color_co', trim($datos['color']));
            $this->db->bind(':marca_co', trim($datos['marca']));
            $this->db->bind(':fecha_co', trim($datos['fecha_insercion']));
            $this->db->bind(':id_subcategoria_co', trim($datos['subcategoriaConjunto']));
            $this->db->bind(':id_usuario_co', trim($id_usuario));
            $this->db->bind(':id_conjunto_co', trim($id_conjunto));

            // Ejecutar la consulta de actualización
            if ($this->db->execute()) {
                // Borramos los registros existentes de prendas_temporadas asociados a la prenda actual
                $this->db->query("DELETE FROM prendas_temporadas WHERE id_prenda = :id_prenda");
                $this->db->bind(':id_prenda', trim($id_conjunto));
                $this->db->execute();

                // Insertar cada valor de $datos['temporadas'] en la tabla prendas_temporadas
                foreach ($datos['temporadas'] as $temporada) {
                    $this->db->query("INSERT INTO prendas_temporadas (id_prenda, id_temporada) 
                                    VALUES (:id_prenda, :id_temporada)");
                    $this->db->bind(':id_prenda', trim($id_conjunto));
                    $this->db->bind(':id_temporada', trim($temporada));
                    $this->db->execute();
                }

                return true;
            } else {
                return false;
            }


        }else {

            // Obtener el nombre del archivo de la imagen actual en la base de datos
            $this->db->query("SELECT imagen FROM prenda WHERE id_usuario = :id_usuario_co AND id = :id_conjunto_co");

            $this->db->bind(':id_usuario_co', trim($id_usuario));
            $this->db->bind(':id_conjunto_co', trim($id_conjunto));

            $imagenAnterior = $this->db->registro()->imagen;

            // Actualizar la consulta de actualización
            $this->db->query("UPDATE prenda SET nombre = :nombre_co, descripcion = :descripcion_co, talla = :talla_co, color = :color_co, 
                            marca = :marca_co, imagen = :imagen_co, fecha_insercion = :fecha_co, id_subcategoria = :id_subcategoria_co 
                            WHERE id_usuario = :id_usuario_co AND id = :id_conjunto_co");

            // Vincular los valores de actualización
            $this->db->bind(':nombre_co', trim($datos['nombre']));
            $this->db->bind(':descripcion_co', trim($datos['descripcion']));
            $this->db->bind(':talla_co', trim($datos['talla']));
            $this->db->bind(':color_co', trim($datos['color']));
            $this->db->bind(':marca_co', trim($datos['marca']));
            $this->db->bind(':imagen_co', trim($img));
            $this->db->bind(':fecha_co', trim($datos['fecha_insercion']));
            $this->db->bind(':id_subcategoria_co', trim($datos['subcategoriaConjunto']));
            $this->db->bind(':id_usuario_co', trim($id_usuario));
            $this->db->bind(':id_conjunto_co', trim($id_conjunto));


            // Ejecutar la consulta de actualización
            if ($this->db->execute()) {
                // Eliminar la imagen anterior si existe
                $rutaImagenAnterior = RUTA_PUBLIC . "/img_prendas/" . $id_conjunto.$imagenAnterior . ".png";
                if (file_exists($rutaImagenAnterior)) {
                    unlink($rutaImagenAnterior);
                }

                // Borramos los registros existentes de prendas_temporadas asociados a la prenda actual
                $this->db->query("DELETE FROM prendas_temporadas WHERE id_prenda = :id_prenda");
                $this->db->bind(':id_prenda', trim($id_conjunto));
                $this->db->execute();

                // Insertar cada valor de $datos['temporadas'] en la tabla prendas_temporadas
                foreach ($datos['temporadas'] as $temporada) {
                    $this->db->query("INSERT INTO prendas_temporadas (id_prenda, id_temporada) 
                                    VALUES (:id_prenda, :id_temporada)");
                    $this->db->bind(':id_prenda', trim($id_conjunto));
                    $this->db->bind(':id_temporada', trim($temporada));
                    $this->db->execute();
                }

                return true;
            } else {
                return false;
            }

            
        }
        
 
    } 


    public function borrarConjunto($id_usuario, $id_conjunto){
        
        // Eliminar registros relacionados en la tabla prendas_temporadas
        $this->db->query("DELETE FROM prendas_temporadas WHERE id_prenda = :id_conjunto_co");
        $this->db->bind(':id_conjunto_co', trim($id_conjunto));
        $this->db->execute();

        // Obtener el nombre del archivo de la imagen actual en la base de datos
        $this->db->query("SELECT imagen FROM prenda WHERE id_usuario = :id_usuario_co AND id = :id_conjunto_co");

        $this->db->bind(':id_usuario_co', trim($id_usuario));
        $this->db->bind(':id_conjunto_co', trim($id_conjunto));

        $imagenAnterior = $this->db->registro()->imagen;


        $this->db->query("DELETE FROM prenda WHERE id_usuario = :id_usuario_co AND id = :id_conjunto_co");

        $this->db->bind(':id_usuario_co', trim($id_usuario));
        $this->db->bind(':id_conjunto_co', trim($id_conjunto));

        if ($this->db->execute()) {
            // Eliminar la imagen de la ruta
            $rutaImagenAnterior = RUTA_PUBLIC . "/img_prendas/" . $id_conjunto.$imagenAnterior . ".png";
            if (file_exists($rutaImagenAnterior)) {
                unlink($rutaImagenAnterior);
            }

            return true;
        }else{
            return false;
        }
    }

}
