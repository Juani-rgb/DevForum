
<?php


session_start();

require_once 'conn.php';


$categoriaGuardada = $_COOKIE['ultima_categoria'] ?? '';


if (isset($_GET['categoria'])) {

    $categoria = trim($_GET['categoria']);

    setcookie("ultima_categoria", $categoria, time() + (30 * 24 * 60 * 60), "/");

} else {

    $categoria = $categoriaGuardada;

}

$buscar = trim($_GET['buscar'] ?? '');

$sql = "SELECT 
            publicaciones.id_publicacion,
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
        WHERE 
            (publicaciones.titulo LIKE ? OR publicaciones.contenido LIKE ? OR ? = '')
            AND (categorias.nombre = ? OR ? = '')
        ORDER BY publicaciones.fecha_creacion DESC";

$buscarSQL = "%" . $buscar . "%";

$stmt = mysqli_prepare($conexion, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "sssss",
    $buscarSQL,
    $buscarSQL,
    $buscar,
    $categoria,
    $categoria
);

mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

?>



<?php require_once 'componentes/header.php'; ?>


    <?php if (isset($_GET['publicacion']) && $_GET['publicacion'] == 'creada'): ?>
    <p class="mensaje-exito">
        ¡Publicación creada correctamente! Ya está disponible en DevForum.
    </p>
    <?php endif; ?>





    <main>

        
        <section class="bienvenida">
            <h2>Bienvenido a DevForum</h2>
            <p>Un espacio para compartir ideas, aprender y hablar sobre tecnología.</p>
        </section>

        
        <section class="herramientas">

    <form action="index.php" method="GET">

        <input 
            type="text" 
            name="buscar" 
            placeholder="Buscar publicaciones..."
        >

    <select name="categoria">

    <option value="" <?php if ($categoria == "") echo "selected"; ?>>
        Todas las categorías
    </option>

    <option value="Programación" <?php if ($categoria == "Programación") echo "selected"; ?>>
        Programación
    </option>

    <option value="Hardware" <?php if ($categoria == "Hardware") echo "selected"; ?>>
        Hardware
    </option>

    <option value="Videojuegos" <?php if ($categoria == "Videojuegos") echo "selected"; ?>>
        Videojuegos
    </option>

    <option value="Tecnología" <?php if ($categoria == "Tecnología") echo "selected"; ?>>
        Tecnología
    </option>

    <option value="Ciberseguridad" <?php if ($categoria == "Ciberseguridad") echo "selected"; ?>>
        Ciberseguridad
    </option>

    </select>

        <button type="submit">Buscar</button>

    </form>

</section>

        
    

        
        <section class="contenido">

    <div class="encabezado-publicaciones">

        <h2>Publicaciones recientes</h2>

        <?php if (isset($_SESSION["id_usuario"])): ?>

            <a href="publicar.php" class="boton-publicar">
                + Crear publicación
            </a>

        <?php else: ?>

            <p class="mensaje-login">
                Para publicar tenés que <a href="login.php">iniciar sesión</a>.
            </p>

        <?php endif; ?>

    </div>

        <?php while ($publicacion = mysqli_fetch_assoc($resultado)): ?>

        <article class="publicacion">

        <span class="categoria">
            <?php echo htmlspecialchars($publicacion["categoria"]); ?>
        </span>

        <h3>
            <?php echo htmlspecialchars($publicacion["titulo"]); ?>
        </h3>

        <p>
            <?php echo htmlspecialchars($publicacion["contenido"]); ?>
        </p>

        <div class="informacion-publicacion">
            <small>Por <?php echo htmlspecialchars($publicacion["autor"]); ?></small>
            <small><?php echo htmlspecialchars($publicacion["fecha_creacion"]); ?></small>
        </div>

        <a href="ver-publicacion.php?id=<?php echo $publicacion['id_publicacion']; ?>" class="ver-publicacion">
        Ver publicación
        </a>

    </article>

    <?php endwhile; ?>

</section>
</main>

    
    <?php require_once 'componentes/footer.php'; ?>

</body>
</html>
