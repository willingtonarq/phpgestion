<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['display']) && !empty($_POST['display'])) {
        $expression = $_POST['display'];
        
        if (preg_match('/^[0-9+\-*\/\.]+$/', $expression)) {
            try {
                $result = eval("return $expression;");
                echo "<h2>Resultado: $result</h2>";
            } catch (Exception $e) {
                echo "<h2>Error en la operación</h2>";
            }
        } else {
            echo "<h2>Expresión no válida</h2>";
        }
    } else {
        echo "<h2>No hay valores para calcular</h2>";
    }
} else {
    echo "<h2>Método no permitido</h2>";
}

?>

