<?php

class VerClienteModelo {
    private $db;

    public function __construct(){
        $this->db = new Base;
    }
    
    public function todosClientes(){

        $this->db->query("SELECT * FROM usuario;"); 

 
        return $this->db->registros(); 

    }

    public function cliente($id){

        $this->db->query("SELECT * FROM usuario WHERE id = :id;"); 

        $this->db->bind(':id', $id);
 
        return $this->db->registro(); 

    }
    
    public function getRolCliente($id){

        $this->db->query("SELECT R.* FROM rol R, usuario U WHERE R.id = U.id_rol AND U.id = :id;"); 

        $this->db->bind(':id', $id);
 
        return $this->db->registro(); 

    }

    public function getRoles(){

        $this->db->query("SELECT * FROM rol;"); 

 
        return $this->db->registros(); 

    }


    public function buscarClientes($palabra) {
        $this->db->query("SELECT * FROM usuario WHERE nombre LIKE :palabra OR apellidos LIKE :palabra OR correo LIKE :palabra OR username LIKE :palabra;");
        
        $this->db->bind(':palabra', '%' . $palabra . '%');
    
        return $this->db->registros();
    }


    public function editCliente($datos, $id_usuario){

        if (empty($datos['contra'])) {
            $this->db->query("UPDATE usuario SET nombre = :nombre, apellidos = :apellidos, correo = :correo, username = :username, id_rol = :id_rol
                                WHERE id = :id_usuario");
    
            // Vincular los valores de actualización
            $this->db->bind(':nombre', trim($datos['nombre']));
            $this->db->bind(':apellidos', trim($datos['apellidos']));
            $this->db->bind(':correo', trim($datos['correo']));
            $this->db->bind(':username', trim($datos['username']));
            $this->db->bind(':id_rol', trim($datos['rol']));
            $this->db->bind(':id_usuario', trim($id_usuario));

        }else {
            
            $this->db->query("UPDATE usuario SET nombre = :nombre, apellidos = :apellidos, correo = :correo, 
                                username = :username, password = sha2(:password,256), id_rol = :id_rol
                                    WHERE id = :id_usuario");
    
            // Vincular los valores de actualización
            $this->db->bind(':nombre', trim($datos['nombre']));
            $this->db->bind(':apellidos', trim($datos['apellidos']));
            $this->db->bind(':correo', trim($datos['correo']));
            $this->db->bind(':username', trim($datos['username']));
            $this->db->bind(':password', trim($datos['contra']));
            $this->db->bind(':id_rol', trim($datos['rol']));
            $this->db->bind(':id_usuario', trim($id_usuario));
        }

        if ($this->db->execute()) {
            return true;
        }else {
            return false;
        }

    }

    public function borrarCliente($id){

        $this->db->query("DELETE FROM usuario WHERE id = :id");
        
        $this->db->bind(':id', trim($id));
        
        if ($this->db->execute()) {
            return true;
        }else{
            return false;
        }

    }

}