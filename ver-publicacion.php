
<?php

session_start();

require_once 'conn.php';
require_once 'componentes/flash.php';


$id = $_GET['id'] ?? '';


if (!filter_var($id, FILTER_VALIDATE_INT) || $id <= 0) {

    $publicacion = null;

} else {

    $sql = "SELECT 
                publicaciones.titulo,
                publicaciones.contenido,
                publicaciones.fecha_creacion,
                usuarios.nombre AS autor,
                categorias.nombre AS categoria
            FROM publicaciones
            INNER JOIN usuarios
                ON publicaciones.id_usuario = usuarios.id_usuario
            INNER JOIN categorias
                ON publicaciones.id_categoria = categorias.id_categoria
            WHERE publicaciones.id_publicacion = ?";

    $stmt = mysqli_prepare($conexion, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    $publicacion = mysqli_fetch_assoc($resultado);
}

if ($publicacion && $_SERVER["REQUEST_METHOD"] == "POST") {

    $contenido = trim($_POST["contenido"] ?? '');

    if (!isset($_SESSION["id_usuario"])) {

        $errorComentario = "Tenés que iniciar sesión para comentar.";

    } elseif (empty($contenido)) {

        $errorComentario = "El comentario no puede estar vacío.";

    } else {

        $id_usuario = $_SESSION["id_usuario"];

        $sqlComentario = "INSERT INTO comentarios
                          (contenido, fecha_creacion, id_usuario, id_publicacion)
                          VALUES (?, NOW(), ?, ?)";

        $stmtComentario = mysqli_prepare($conexion, $sqlComentario);

        mysqli_stmt_bind_param($stmtComentario, "sii", $contenido, $id_usuario, $id);

       if (mysqli_stmt_execute($stmtComentario)) {
    guardarFlash("¡Comentario publicado correctamente!");
    header("Location: ver-publicacion.php?id=" . $id);
    exit;
    }   else {

            $errorComentario = "No se pudo publicar el comentario.";

        }
    }
}

$comentarios = null;

if ($publicacion) {

    $sqlComentarios = "SELECT 
                            comentarios.contenido,
                            comentarios.fecha_creacion,
                            usuarios.nombre AS autor
                       FROM comentarios
                       INNER JOIN usuarios
                           ON comentarios.id_usuario = usuarios.id_usuario
                       WHERE comentarios.id_publicacion = ?
                       ORDER BY comentarios.fecha_creacion DESC";

    $stmtComentarios = mysqli_prepare($conexion, $sqlComentarios);

    mysqli_stmt_bind_param($stmtComentarios, "i", $id);

    mysqli_stmt_execute($stmtComentarios);

    $comentarios = mysqli_stmt_get_result($stmtComentarios);
}


?>


<?php require_once 'componentes/header.php'; ?>


    <main>
        <?php mostrarFlash(); ?>

        <?php if ($publicacion): ?>

            <article class="publicacion">

                <span class="categoria">
                    <?php echo htmlspecialchars($publicacion['categoria']); ?>
                </span>

                <h2>
                    <?php echo htmlspecialchars($publicacion['titulo']); ?>
                </h2>

                <p>
                    <?php echo htmlspecialchars($publicacion['contenido']); ?>
                </p>

                <div class="informacion-publicacion">
                    <small>Por <?php echo htmlspecialchars($publicacion['autor']); ?></small>
                    <small><?php echo htmlspecialchars($publicacion['fecha_creacion']); ?></small>
                </div>

            </article>

            <?php if (isset($_SESSION["id_usuario"])): ?>

    <h3>Dejá tu comentario</h3>

   <form method="POST" class="formulario-comentario">
        <textarea name="contenido" placeholder="Escribí tu comentario..." required></textarea>

        <button type="submit">Comentar</button>
    </form>

  <?php else: ?>

    <p>Para comentar tenés que <a href="login.php">iniciar sesión</a>.</p>

    <?php endif; ?>

<?php if (isset($errorComentario)): ?>
    <p><?php echo htmlspecialchars($errorComentario); ?></p>
<?php endif; ?>

<h3>Comentarios</h3>

<?php if ($comentarios && mysqli_num_rows($comentarios) > 0): ?>

    <?php while ($comentario = mysqli_fetch_assoc($comentarios)): ?>

        <div class="comentario">

            <p>
                <?php echo htmlspecialchars($comentario['contenido']); ?>
            </p>

            <div class="informacion-publicacion">
                <small>Por <?php echo htmlspecialchars($comentario['autor']); ?></small>
                <small><?php echo htmlspecialchars($comentario['fecha_creacion']); ?></small>
            </div>

        </div>

    <?php endwhile; ?>

<?php else: ?>

    <p>Todavía no hay comentarios.</p>

<?php endif; ?>

        <?php else: ?>

            <p>La publicación no existe.</p>

        <?php endif; ?>

    </main>

   <?php require_once 'componentes/footer.php'; ?>

</body>
</html>