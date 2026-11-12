<?php

session_start();

require_once 'conn.php';
require_once 'componentes/flash.php';

if (!isset($_SESSION["id_usuario"])) {

    header("Location: login.php");
    exit;

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $titulo = trim($_POST["titulo"]);
    $contenido = trim($_POST["contenido"]);
    $categoria = $_POST["categoria"];

    if (empty($titulo) || empty($contenido) || empty($categoria)) {

        echo "Todos los campos son obligatorios.";

    }
    else {

    $id_usuario = $_SESSION["id_usuario"];

    $sql = "INSERT INTO publicaciones 
            (titulo, contenido, fecha_creacion, id_usuario, id_categoria)
            VALUES (?, ?, NOW(), ?, ?)";

    $stmt = mysqli_prepare($conexion, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssii",
        $titulo,
        $contenido,
        $id_usuario,
        $categoria
    );

  if (mysqli_stmt_execute($stmt)) {
    guardarFlash("¡Publicación creada correctamente!");
    header("Location: index.php");
    exit;
} else {
    echo "Error al crear la publicación.";
}  

}

}

?>

<?php require_once 'componentes/header.php'; ?>


   <main>

    <div class="formulario-contenedor">

        <h2>Crear publicación</h2>

        <form action="" method="POST" class="formulario">

            <label>Título:</label>
            <input type="text" name="titulo" required>

            <label>Contenido:</label>
            <textarea name="contenido" required></textarea>

            <label>Categoría:</label>
            <select name="categoria" required>

                <option value="">Seleccionar categoría</option>
                <option value="1">Programación</option>
                <option value="2">Hardware</option>
                <option value="3">Videojuegos</option>
                <option value="4">Tecnología</option>
                <option value="5">Ciberseguridad</option>

            </select>

            <button type="submit">Publicar</button>

        </form>

    </div>

    </main>

 <?php require_once 'componentes/footer.php'; ?>

</body>
</html>