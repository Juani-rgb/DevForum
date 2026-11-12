
<?php

// Detectamos si estamos trabajando en XAMPP o en InfinityFree
$esLocal = (
    $_SERVER['HTTP_HOST'] === 'localhost' ||
    $_SERVER['HTTP_HOST'] === '127.0.0.1'
);

if ($esLocal) {

    // CONEXIÓN LOCAL (XAMPP)
    define('BASE_URL', '/parcial2');

    $host = '127.0.0.1';
    $user = 'root';
    $pass = '';
    $baseDatos = 'devforum';
    $puerto = 3306;

} else {

    // CONEXIÓN EN INFINITYFREE
    define('BASE_URL', '');

    $host = 'sqlXXX.infinityfree.com';
    $user = 'if0_XXXXXXXX';
    $pass = 'TU_CLAVE_DE_BASE_DE_DATOS';
    $baseDatos = 'if0_XXXXXXXX_devforum';
    $puerto = 3306;

}

// Conectamos con MySQL
$conexion = mysqli_connect(
    $host,
    $user,
    $pass,
    $baseDatos,
    $puerto
);

// Controlamos posibles errores
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Configuramos los caracteres
mysqli_set_charset($conexion, "utf8mb4");

?>
