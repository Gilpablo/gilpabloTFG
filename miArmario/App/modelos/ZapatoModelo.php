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
                            VALUES (:nombre_za, :descripcion_za, :talla_za, :color_za, :marca_za, :imagen_za, NOW(), :id_subcategoria_za, :id_usuario_za)");

        //vinculamos los valores
        $this->db->bind(':nombre_za',trim($datos['nombreZapato']));
        $this->db->bind(':descripcion_za',trim($datos['descripcionZapato']));
        $this->db->bind(':talla_za',trim($datos['tallaZapato']));
        $this->db->bind(':color_za',trim($datos['colorZapato']));
        $this->db->bind(':marca_za',trim($datos['marcaZapato']));
        $this->db->bind(':imagen_za',trim($img));
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

}
