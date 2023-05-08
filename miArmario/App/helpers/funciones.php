<?php

    //Para redireccionar la pagina
    function redireccionar($pagina){
        header('location: '.RUTA_URL.$pagina);
    }


    function formatoFecha($fechaIngles){
        return date("d/m/Y H:i:s", strtotime($fechaIngles));     // Obetnemos el formato de fecha en español
    }


    function hoyMenos6Meses(){
        $fecha_actual = date("Y-m-d");
        return date("Y-m-d",strtotime($fecha_actual."- 6 month"));
    }


    function tienePrivilegios($rol_usuario,$rolesPermitidos){
        // si $rolesPermitidos es vacio, se tendran privilegios
        if (empty($rolesPermitidos) || in_array($rol_usuario, $rolesPermitidos)) {
            return true;
        }
    }


    function obtenerRol($roles){
        $id_rol = 0;
        foreach($roles as $rol){
            if($rol->id_departamento==1){
                if($rol->id_rol==30){
                    $id_rol = 100;                  // Crea Asesoria
                }
            }elseif($rol->id_departamento==2){      // Asesores
                if($rol->id_rol==20){
                    $id_rol = 200;
                }
                if($rol->id_rol==10){
                    $id_rol = 300;                  // el root
                }
            }
        }

        return $id_rol;
    }
    

    function email_informativo_asesoria($email_destino,$nombre_destino){
        $to = $email_destino;
        $nombreTo = $nombre_destino;
        $asunto = 'Asesoria Creada [No responder a este correo]';
        $cuerpo ="Estimado/a  {$nombre_destino}, le informamos que:
                    <br> Su consulta se ha registrado correctamente. 
                    <br><br> Esta actuación está financiada por la Unión Europea y el Mto. de Educación y Formación Profesional con el Plan de Recuperación, transformación y Resiliencia (fondos MRR). 
                    <br><br> Un Saludo
                    <br> El equipo de Orientación del CPIFP Bajo Aragón.";
        return EnviarEmail::sendEmail($to,$nombreTo,$asunto,$cuerpo);
    }


    function email_aviso_asesores($emails,$nombres){
        $to = $emails;
        $nombreTo = $nombres;
        $asunto = 'Asesoria Creada [No responder a este correo]';
        $cuerpo ="Se ha creado una nueva asesoria. Revisa si necesita tu atención. Gracias";
        return EnviarEmail::sendEmailMultiple($to,$nombreTo,$asunto,$cuerpo);
    }
