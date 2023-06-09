<?php

class ZapatoModelo {
    private $db;

    public function __construct(){
        $this->db = new Base;
    }


    public function getZapatos($id_usuario){ 
  
        $this->db->query("SELECT P.* FROM prenda P 
                            INNER JOIN subcategoria S ON P.id_subcategoria = S.id 
                                INNER JOIN categoria C ON S.id_categoria = C.id 
                                    WHERE P.id_usuario = :id_usuario_za AND C.nombre = 'zapatos';"); 
 
        $this->db->bind(':id_usuario_za',$id_usuario); 
 
        return $this->db->registros(); 
 
    } 

    public function ultimoIdPrenda(){

        $this->db->query("SELECT id FROM prenda ORDER BY id DESC LIMIT 1;");
        
        return $this->db->registro();

    }


    public function addZapatos($datos, $img, $id_usuario){ 

        $this->db->query("INSERT INTO prenda (nombre, descripcion, talla, color, marca, imagen, fecha_insercion, id_subcategoria , id_usuario) 
                            VALUES (:nombre_za, :descripcion_za, :talla_za, :color_za, :marca_za, :imagen_za, :fecha_za, :id_subcategoria_za, :id_usuario_za)");

        //vinculamos los valores
        $this->db->bind(':nombre_za',trim($datos['nombreZapato']));
        $this->db->bind(':descripcion_za',trim($datos['descripcionZapato']));
        $this->db->bind(':talla_za',trim($datos['tallaZapato']));
        $this->db->bind(':color_za',trim($datos['colorZapato']));
        $this->db->bind(':marca_za',trim($datos['marcaZapato']));
        $this->db->bind(':imagen_za',trim($img));
        $this->db->bind(':fecha_za',trim($datos['fecha_insercion']));
        $this->db->bind(':id_subcategoria_za',trim($datos['subcategoriaZapato']));
        $this->db->bind(':id_usuario_za',trim($id_usuario));

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


    public function getSubcategoriaZapatos(){ 
  
        $this->db->query("SELECT * FROM subcategoria
                            WHERE id_categoria  = 2;"); 
 
        // $this->db->bind(':id_subcategoria_za',$id_subcategoria); 
 
        return $this->db->registros(); 
 
    }

    public function getTemporadas(){

        $this->db->query("SELECT * FROM temporada;");
 
        return $this->db->registros(); 

    }

    public function buscarZapatos($palabra, $id_usuario){

        $this->db->query("SELECT P.* FROM prenda P 
                            INNER JOIN subcategoria S ON P.id_subcategoria = S.id 
                                INNER JOIN categoria C ON S.id_categoria = C.id 
                                    WHERE P.id_usuario = :id_usuario_za AND C.nombre = 'zapatos' 
                                        AND (P.nombre LIKE :palabra OR P.descripcion LIKE :palabra 
                                            OR P.talla LIKE :palabra OR P.color LIKE :palabra 
                                                OR P.marca LIKE :palabra OR P.imagen LIKE :palabra);");

        $this->db->bind(':id_usuario_za', trim($id_usuario));
        $this->db->bind(':palabra', '%' . $palabra . '%');

        return $this->db->registros();
    }

    public function getZapatosTemp($datos, $id_usuario){ 

        print_r($datos); exit();
  
        $this->db->query("SELECT P.* FROM prenda P 
                            INNER JOIN subcategoria S ON P.id_subcategoria = S.id 
                                INNER JOIN categoria C ON S.id_categoria = C.id 
                                    WHERE P.id_usuario = :id_usuario_za AND C.nombre = 'zapatos';"); 
 
        $this->db->bind(':id_usuario_za',trim($id_usuario)); 
 
        return $this->db->registros(); 
 
    }

    public function getZapatoSolo($id_usuario, $id_zapato){

        $this->db->query("SELECT * FROM prenda WHERE id_usuario = :id_usuario_za AND id = :id_zapato_za;"); 
 
        $this->db->bind(':id_usuario_za',trim($id_usuario)); 
        $this->db->bind(':id_zapato_za',trim($id_zapato)); 
 
        return $this->db->registro(); 

    }

    public function getTemporadasZapato($id_zapato){

        $this->db->query("SELECT * FROM prendas_temporadas WHERE id_prenda = :id_zapato_za;"); 

        $this->db->bind(':id_zapato_za',trim($id_zapato));
 
        return $this->db->registros(); 
    }


    public function editZapato($datos, $img, $id_usuario, $id_zapato){ 

        if (empty($img)) {
            
            $this->db->query("UPDATE prenda SET nombre = :nombre_za, descripcion = :descripcion_za, talla = :talla_za, color = :color_za, 
                                marca = :marca_za, fecha_insercion = :fecha_za, id_subcategoria = :id_subcategoria_za 
                                    WHERE id_usuario = :id_usuario_za AND id = :id_zapato_za");

            $this->db->bind(':nombre_za', trim($datos['nombre']));
            $this->db->bind(':descripcion_za', trim($datos['descripcion']));
            $this->db->bind(':talla_za', trim($datos['talla']));
            $this->db->bind(':color_za', trim($datos['color']));
            $this->db->bind(':marca_za', trim($datos['marca']));
            $this->db->bind(':fecha_za', trim($datos['fecha_insercion']));
            $this->db->bind(':id_subcategoria_za', trim($datos['subcategoriaZapato']));
            $this->db->bind(':id_usuario_za', trim($id_usuario));
            $this->db->bind(':id_zapato_za', trim($id_zapato));

            // Ejecutar la consulta de actualización
            if ($this->db->execute()) {
                // Borramos los registros existentes de prendas_temporadas asociados a la prenda actual
                $this->db->query("DELETE FROM prendas_temporadas WHERE id_prenda = :id_prenda");
                $this->db->bind(':id_prenda', trim($id_zapato));
                $this->db->execute();

                // Insertar cada valor de $datos['temporadas'] en la tabla prendas_temporadas
                foreach ($datos['temporadas'] as $temporada) {
                    $this->db->query("INSERT INTO prendas_temporadas (id_prenda, id_temporada) 
                                    VALUES (:id_prenda, :id_temporada)");
                    $this->db->bind(':id_prenda', trim($id_zapato));
                    $this->db->bind(':id_temporada', trim($temporada));
                    $this->db->execute();
                }

                return true;
            } else {
                return false;
            }


        }else {

            // Obtener el nombre del archivo de la imagen actual en la base de datos
            $this->db->query("SELECT imagen FROM prenda WHERE id_usuario = :id_usuario_za AND id = :id_zapato_za");

            $this->db->bind(':id_usuario_za', trim($id_usuario));
            $this->db->bind(':id_zapato_za', trim($id_zapato));

            $imagenAnterior = $this->db->registro()->imagen;

            // Actualizar la consulta de actualización
            $this->db->query("UPDATE prenda SET nombre = :nombre_za, descripcion = :descripcion_za, talla = :talla_za, color = :color_za, 
                            marca = :marca_za, imagen = :imagen_za, fecha_insercion = :fecha_za, id_subcategoria = :id_subcategoria_za 
                            WHERE id_usuario = :id_usuario_za AND id = :id_zapato_za");

            // Vincular los valores de actualización
            $this->db->bind(':nombre_za', trim($datos['nombre']));
            $this->db->bind(':descripcion_za', trim($datos['descripcion']));
            $this->db->bind(':talla_za', trim($datos['talla']));
            $this->db->bind(':color_za', trim($datos['color']));
            $this->db->bind(':marca_za', trim($datos['marca']));
            $this->db->bind(':imagen_za', trim($img));
            $this->db->bind(':fecha_za', trim($datos['fecha_insercion']));
            $this->db->bind(':id_subcategoria_za', trim($datos['subcategoriaZapato']));
            $this->db->bind(':id_usuario_za', trim($id_usuario));
            $this->db->bind(':id_zapato_za', trim($id_zapato));


            // Ejecutar la consulta de actualización
            if ($this->db->execute()) {
                // Eliminar la imagen anterior si existe
                $rutaImagenAnterior = RUTA_PUBLIC . "/img_prendas/" . $id_zapato.$imagenAnterior . ".png";
                if (file_exists($rutaImagenAnterior)) {
                    unlink($rutaImagenAnterior);
                }

                // Borramos los registros existentes de prendas_temporadas asociados a la prenda actual
                $this->db->query("DELETE FROM prendas_temporadas WHERE id_prenda = :id_prenda");
                $this->db->bind(':id_prenda', trim($id_zapato));
                $this->db->execute();

                // Insertar cada valor de $datos['temporadas'] en la tabla prendas_temporadas
                foreach ($datos['temporadas'] as $temporada) {
                    $this->db->query("INSERT INTO prendas_temporadas (id_prenda, id_temporada) 
                                    VALUES (:id_prenda, :id_temporada)");
                    $this->db->bind(':id_prenda', trim($id_zapato));
                    $this->db->bind(':id_temporada', trim($temporada));
                    $this->db->execute();
                }

                return true;
            } else {
                return false;
            }

            
        }
        
 
    } 


    public function borrarZapato($id_usuario, $id_zapato){
        
        // Eliminar registros relacionados en la tabla prendas_temporadas
        $this->db->query("DELETE FROM prendas_temporadas WHERE id_prenda = :id_zapato_za");
        $this->db->bind(':id_zapato_za', trim($id_zapato));
        $this->db->execute();

        // Obtener el nombre del archivo de la imagen actual en la base de datos
        $this->db->query("SELECT imagen FROM prenda WHERE id_usuario = :id_usuario_za AND id = :id_zapato_za");

        $this->db->bind(':id_usuario_za', trim($id_usuario));
        $this->db->bind(':id_zapato_za', trim($id_zapato));

        $imagenAnterior = $this->db->registro()->imagen;


        $this->db->query("DELETE FROM prenda WHERE id_usuario = :id_usuario_za AND id = :id_zapato_za");

        $this->db->bind(':id_usuario_za', trim($id_usuario));
        $this->db->bind(':id_zapato_za', trim($id_zapato));

        if ($this->db->execute()) {
            // Eliminar la imagen de la ruta
            $rutaImagenAnterior = RUTA_PUBLIC . "/img_prendas/" . $id_zapato.$imagenAnterior . ".png";
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
