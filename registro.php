
<?php

session_start();

require_once 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = trim($_POST["nombre"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($nombre) || empty($email) || empty($password)) {
        echo "Todos los campos son obligatorios.";
    }
    else {

    $sql = "SELECT id_usuario FROM usuarios WHERE email = ?";

    $stmt = mysqli_prepare($conexion, $sql);

    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado) > 0) {
        echo "Este email ya está registrado.";
    }
     else {

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, email, password, rol)
        VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conexion, $sql);

    $rol = "usuario";

    mysqli_stmt_bind_param($stmt, "ssss", $nombre, $email, $passwordHash, $rol);

    if (mysqli_stmt_execute($stmt)) {
    header("Location: login.php");
    exit;
} else {
    echo "Error al registrar el usuario.";
}
    }

}

}

?>

<?php require_once 'componentes/header.php'; ?>

   <main>

    <div class="formulario-contenedor">

        <h2>Crear una cuenta</h2>

        <form action="" method="POST" class="formulario">

            <label>Nombre:</label>
            <input type="text" name="nombre" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Contraseña:</label>
            <input type="password" name="password" required>

            <button type="submit">Registrarse</button>
            
        </form>

        <p class="enlace-formulario">
            ¿Ya tenés una cuenta? <a href="login.php">Iniciá sesión</a>
        </p>

    </div>

</main>

   <?php require_once 'componentes/footer.php'; ?>

</body>
</html>
