<?php
// Descripción: Lee y muestra todos los eventos de la base de datos de eventos de BaseX en formato de lista.

include_once '../../load.php';

use BaseXClient\BaseXException;
use BaseXClient\Session;

try {
    $session = new Session("localhost", 1984, "admin", "admin");

    // Abre la base de datos
    $session->execute("OPEN eventos");

    // Consulta XQuery para obtener todos los eventos
    /**
    * @var string $input XQuery para obtener todos los eventos.
    */
    $input = 'for $e in //evento return $e';
    $query = $session->query($input);
    /**
    * @var string $result Cadena XML sin formato que contiene todos los eventos.
    */
    $result = $query->execute();

    // Carga los datos XML
    /**
    * @var SimpleXMLElement $xml XML analizado que contiene todos los datos del evento.
    */
    $xml = simplexml_load_string("<eventos>$result</eventos>");

    echo "<h1>Contenido de la Base de Datos</h1>";

    echo "<ul>";
    foreach ($xml->evento as $evento) {
        echo "<li>";
        echo "<strong>ID:</strong> " . htmlentities($evento->id) . "<br>";
        echo "<strong>Nombre:</strong> " . htmlentities($evento->nombre) . "<br>";
        echo "<strong>Fecha:</strong> " . htmlentities($evento->fecha) . "<br>";
        echo "<strong>Descripción:</strong> " . htmlentities($evento->descripcion);
        echo "</li><br>";
    }
    echo "</ul>";

    // Cierra la consulta
    $query->close();

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    if (isset($session)) {
        $session->close();
    }
}
?>