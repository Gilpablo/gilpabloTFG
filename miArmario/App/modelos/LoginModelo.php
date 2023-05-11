<?php

class LoginModelo {
    private $db;

    public function __construct(){
        $this->db = new Base;
    }

    public function loginUsuario($datos){
        
        $this->db->query("SELECT * FROM usuario WHERE username = :login or correo = :login AND password = sha2(:password,256)");
                                    
        $this->db->bind(':login',$datos['usuario']);
        $this->db->bind(':password',$datos['pass']);

        return $this->db->registro();
    }

}