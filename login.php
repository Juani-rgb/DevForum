<?php

session_start();


require_once 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($email) || empty($password)) {

        echo "Todos los campos son obligatorios.";

    }
    else {

    $sql = "SELECT id_usuario, nombre, email, password, rol
            FROM usuarios
            WHERE email = ?";

    $stmt = mysqli_prepare($conexion, $sql);

    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    $usuario = mysqli_fetch_assoc($resultado);

    if (!$usuario) {

        echo "El email o la contraseña son incorrectos.";

    }

    else {

    if (password_verify($password, $usuario["password"])) {

    session_regenerate_id(true);

    $_SESSION["id_usuario"] = $usuario["id_usuario"];
    $_SESSION["nombre"] = $usuario["nombre"];
    $_SESSION["rol"] = $usuario["rol"];

    header("Location: index.php");
    exit;

}
    else {

        echo "El email o la contraseña son incorrectos.";

    }

}

}

}   

?>

<?php require_once 'componentes/header.php'; ?>

   <main>

    <section class="formulario-contenedor">

        <h2>Iniciar sesión</h2>

        <form action="" method="POST" class="formulario">

            <label>Email:</label>
            <input type="email" name="email" placeholder="Ingresá tu email" required>

            <label>Contraseña:</label>
            <input type="password" name="password" placeholder="Ingresá tu contraseña" required>

            <button type="submit">Ingresar</button>

        </form>

        <p class="enlace-formulario">
            ¿Todavía no tenés cuenta? <a href="registro.php">Registrate</a>
        </p>

    </section>

</main>

  <?php require_once 'componentes/footer.php'; ?>

</body>
</html>