<?php
// Recupera y muestra todos los eventos de la base de datos de eventos de BaseX en formato sin procesar.

include_once '../../load.php';

use BaseXClient\BaseXException;
use BaseXClient\Session;

try {
    // Crear una sesión con BaseX
    $session = new Session("localhost", 1984, "admin", "admin");

    try {
        $session->execute("open eventos");
        /**
        * @var string $input XQuery para obtener todos los eventos.
        */
        $input = 'for $a in ./eventos return $a';
        $query = $session->query($input);
        
        // Iterar a través de los resultados e imprimirlos
        while ($query->more()) {
            echo $query->next() . "<br />";
        }
        $query->close();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    // Cerrar la consulta y la sesión
    $session->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>