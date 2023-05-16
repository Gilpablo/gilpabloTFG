<?php

class ZapatoModelo {
    private $db;

    public function __construct(){
        $this->db = new Base;
    }

    public function getZapatos($id_usuario){
 
        $this->db->query("SELECT * FROM prenda P
                            INNER JOIN subcategoria S ON P.id_subcategoria = S.id
                                INNER JOIN categoria C ON S.id_categoria = C.id
                                    WHERE P.id_usuario = :id_usuario AND C.nombre = 'zapatos';");

        $this->db->bind(':id_usuario',$id_usuario);

        return $this->db->registros();

    }


}
