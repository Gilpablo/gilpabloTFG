<?php

class HistorialUsoModelo {
    private $db;

    public function __construct(){
        $this->db = new Base;
    }

    public function getConjuntosHistorial($id_usuario){ 
  
        $this->db->query("SELECT * FROM historialuso H, conjunto C WHERE H.id_conjunto = C.id 
                            AND H.id_usuario = :id_usuario ORDER BY `H`.`fecha` DESC;"); 
 
        $this->db->bind(':id_usuario',$id_usuario); 
 
        return $this->db->registros(); 
 
    } 

    public function getPrendas($id_usuario){ 
  
        $this->db->query("SELECT * FROM prenda where id_usuario = :id_usuario;"); 

        
        $this->db->bind(':id_usuario', trim($id_usuario));
 
        return $this->db->registros(); 
 
    }

    public function getTemporadas(){

        $this->db->query("SELECT * FROM temporada;");
 
        return $this->db->registros(); 

    }

    public function addHistorial($datos, $id_conjunto, $id_usuario){

        $this->db->query("INSERT INTO historialuso (id_usuario, id_conjunto, evento_dia, fecha) VALUES (:id_usuario, :id_conjunto, :nombre, :fecha);");

        $this->db->bind(':id_usuario', trim($id_usuario));
        $this->db->bind(':id_conjunto', trim($id_conjunto));
        $this->db->bind(':nombre', trim($datos["nombreHistorial"]));
        $this->db->bind(':fecha', trim($datos["fecha_historial"]));

        if ($this->db->execute()) {
            return true;
        }else{
            return false;
        }
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

    public function filtrarConjuntos($ids, $id_usuario) {
        $idsString = implode(',', $ids); // Convertir el array de IDs a una cadena separada por comas
    
        $this->db->query("SELECT * FROM conjunto WHERE id_usuario = :id_usuario_co AND id IN ($idsString)");
    
        $this->db->bind(':id_usuario_co', trim($id_usuario));
    
        return $this->db->registros();
    }

    public function borrarHistorial($id_historial){

        $this->db->query("DELETE FROM historialuso WHERE id_historial = :id_historial");
        
        $this->db->bind(':id_historial', trim($id_historial));
        
        if ($this->db->execute()) {
            return true;
        }else{
            return false;
        }

    }

    public function buscarConjuntosHistorial($palabra, $id_usuario) {
        $this->db->query("SELECT * FROM historialuso H, conjunto C WHERE H.id_conjunto = C.id 
                            AND H.id_usuario = :id_usuario 
                                AND (H.evento_dia LIKE :palabra OR H.fecha LIKE :palabra OR C.nombre LIKE :palabra 
                                    OR C.descripcion LIKE :palabra OR C.fecha_creacion LIKE :palabra OR C.imagen_conjunto LIKE :palabra)
                                        ORDER BY H.fecha DESC;");
        
        $this->db->bind(':id_usuario', trim($id_usuario));
        $this->db->bind(':palabra', '%' . $palabra . '%');
    
        return $this->db->registros();
    }
    

}