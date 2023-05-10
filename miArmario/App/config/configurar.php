<?php
//** Desarrollo */
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(E_ALL);
//** Desarrollo */


// Ruta de la aplicacion	
define('RUTA_APP', dirname(dirname(__FILE__)));

// Ruta url, Ejemplo: http://localhost/atletismo
define('RUTA_URL', 'http://localhost/gilpabloTFG/miArmario');

define('NOMBRE_SITIO', 'Mi Armario');


// Configuracion de la Base de Datos
define('DB_HOST', 'localhost');
define('DB_USUARIO', 'root');
define('DB_PASSWORD', 'root');
define('DB_NOMBRE', 'mi_armario');

