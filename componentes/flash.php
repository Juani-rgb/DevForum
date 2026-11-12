<?php

function guardarFlash($mensaje) {
    $_SESSION["flash"] = $mensaje;
}

function mostrarFlash() {

    if (isset($_SESSION["flash"])) {

        echo '<p class="mensaje-flash">' .
             htmlspecialchars($_SESSION["flash"]) .
             '</p>';

        unset($_SESSION["flash"]);
    }
}

?>