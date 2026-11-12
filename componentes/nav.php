<nav>
    <a href="index.php">Inicio</a>

    <?php if (isset($_SESSION["id_usuario"])): ?>

        <a href="logout.php">Cerrar sesión</a>

        <span>Hola, <?php echo htmlspecialchars($_SESSION["nombre"]); ?></span>

    <?php else: ?>

        <a href="login.php">Iniciar sesión</a>
        <a href="registro.php">Registrarse</a>

    <?php endif; ?>
</nav>