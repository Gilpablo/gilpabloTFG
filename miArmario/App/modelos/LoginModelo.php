<?php

class LoginModelo {
    private $db;

    public function __construct(){
        $this->db = new Base;
    }

    public function loginUsuario($datos){
        
        $this->db->query("SELECT * FROM usuario WHERE (username = :login or correo = :login) AND password = sha2(:password,256)");
                                    
        $this->db->bind(':login',$datos['usuario']);
        $this->db->bind(':password',$datos['pass']);

        return $this->db->registro();
    }

    public function addUsuario($datos){

        // print_r($datos); exit();

        $this->db->query("INSERT INTO usuario (nombre, apellidos, correo, username, password, id_rol) 
                            VALUES (:nombre_us, :apellidos_us, :correo_us, :username_us, sha2(:password_us,256), :id_rol_us)");

        //vinculamos los valores
        $this->db->bind(':nombre_us',trim($datos['nombre']));
        $this->db->bind(':apellidos_us',trim($datos['apellidos']));
        $this->db->bind(':correo_us',trim($datos['correo']));
        $this->db->bind(':username_us',trim($datos['usuario']));
        $this->db->bind(':password_us',trim($datos['pass']));
        $this->db->bind(':id_rol_us',trim(2));


        //ejecutamos
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }

    }

}