<?php

class InicioModelo {
    private $db;

    public function __construct(){
        $this->db = new Base;
    }

    public function editUser($datos, $id_usuario){

        if (empty($datos['contra'])) {
            $this->db->query("UPDATE usuario SET nombre = :nombre, apellidos = :apellidos, correo = :correo, username = :username
                                WHERE id = :id_usuario");
    
            // Vincular los valores de actualización
            $this->db->bind(':nombre', trim($datos['nombre']));
            $this->db->bind(':apellidos', trim($datos['apellidos']));
            $this->db->bind(':correo', trim($datos['correo']));
            $this->db->bind(':username', trim($datos['username']));
            $this->db->bind(':id_usuario', trim($id_usuario));

        }else {
            
            $this->db->query("UPDATE usuario SET nombre = :nombre, apellidos = :apellidos, correo = :correo, 
                                username = :username, password = sha2(:password,256)
                                    WHERE id = :id_usuario");
    
            // Vincular los valores de actualización
            $this->db->bind(':nombre', trim($datos['nombre']));
            $this->db->bind(':apellidos', trim($datos['apellidos']));
            $this->db->bind(':correo', trim($datos['correo']));
            $this->db->bind(':username', trim($datos['username']));
            $this->db->bind(':password', trim($datos['contra']));
            $this->db->bind(':id_usuario', trim($id_usuario));
        }

        if ($this->db->execute()) {
            return true;
        }else {
            return false;
        }


    }

    public function selectUsuario($id){
        
        $this->db->query("SELECT * FROM usuario WHERE id = :id");
                                    
        $this->db->bind(':id',$id);

        return $this->db->registro();
    }


}