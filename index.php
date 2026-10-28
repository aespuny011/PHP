<?php
//PREGUNTAS CORTAS:
//1. En listarLibros() has usado query() en un caso y prepare() en otro. ¿Por qué? ¿Qué pasaría si escribieras $pdo->query("SELECT * FROM libros WHERE genero = '$genero'") y alguien enviara genero=' OR '1'='1?
//RESPUESTA 1:
//2. ¿Qué devuelve execute()? ¿Dónde están entonces las filas del resultado?
//RESPUESTA 2:
//3. Pulsa dos veces seguidas Prestar en el mismo libro (por ejemplo, abriendo el listado en dos pestañas). ¿Qué devuelve rowCount() la segunda vez y por qué?
//RESPUESTA 3:

//Inicialización entorno
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Includes
include(__DIR__.'/src/vars.php');
include(__DIR__.'/src/functions.php');
//Obtengo todos los libros y prestamos
$reservas = getPersistentData([
    'dsn' => 'mysql:dbname=biblioteca;host=localhost',
    'username' => 'root',
    'password' => ''
],'db');

//Obtengo filtros, si los hay
$filtros = getValidFiltersFromQueryString();

//Las filtro, si hay filtros
if(!empty($filtros)){
    $reservas = array_filter($reservas, function($reserva) use($filtros){
        return filtraFechaPista($reserva, $filtros);
    });
}

include(__DIR__.'/src/templates/index.tpl.php');
?>