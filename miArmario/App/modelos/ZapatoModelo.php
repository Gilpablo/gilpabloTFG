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


    public function getSubcategoriaZapatos(){ 
  
        $this->db->query("SELECT * FROM subcategoria
                            WHERE id_categoria  = 2;"); 
 
        // $this->db->bind(':id_subcategoria_za',$id_subcategoria); 
 
        return $this->db->registros(); 
 
    }
}
