<?php
//** Desarrollo */
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(E_ALL);
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

//** Desarrollo */


// Ruta de la aplicacion	
define('RUTA_APP', dirname(dirname(__FILE__)));
define('RUTA_PUBLIC', dirname(dirname(dirname(__FILE__))).'\public');

// Ruta url, Ejemplo: http://localhost/atletismo
define('RUTA_URL', 'http://localhost/gilpabloTFG/miArmario');

define('NOMBRE_SITIO', 'Mi Armario');


// Configuracion de la Base de Datos
define('DB_HOST', '127.0.0.1');
define('DB_USUARIO', 'root');
define('DB_PASSWORD', '');
define('DB_NOMBRE', 'mi_armario');

