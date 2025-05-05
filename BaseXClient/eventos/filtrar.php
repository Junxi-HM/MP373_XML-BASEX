<?php
//Recupera y muestra un evento específico de la base de datos BaseX según la identificación proporcionada.
include_once '../../load.php';

use BaseXClient\Session;

/**
* Lógica principal para obtener y mostrar un evento por ID.
* @var string $id El ID del evento transmitido mediante una solicitud GET, depurado con htmlspecialchars.
*/

$id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';

if (empty($id)) {
    echo "⚠️ ID no proporcionado.";
    exit;
}

try {
    $session = new Session("localhost", 1984, "admin", "admin");
    $session->execute("open eventos");

    // Consulta para obtener evento por ID
    $input = "for \$e in //evento[id='$id'] return \$e";
    $query = $session->query($input);
    $result = $query->execute();
    $query->close();

   // Analizar resultado XML, analizado que contiene los datos del evento.
    $xml = simplexml_load_string("<eventos>$result</eventos>");

    echo "<h2>Evento con ID $id</h2>";
    if ($xml->evento) {
        /**
        * @var SimpleXMLElement $evento Los datos del evento individual extraídos de XML.
        */
        $evento = $xml->evento;
        echo "<ul>";
        echo "<li><strong>ID:</strong> " . htmlentities($evento->id) . "</li>";
        echo "<li><strong>Nombre:</strong> " . htmlentities($evento->nombre) . "</li>";
        echo "<li><strong>Fecha:</strong> " . htmlentities($evento->fecha) . "</li>";
        echo "<li><strong>Descripción:</strong> " . htmlentities($evento->descripcion) . "</li>";
        echo "</ul>";
        echo '<a href="ver_eventos.php">Volver a la lista de eventos</a>';
    } else {
        echo "<p>⚠️ No se encontró ningún evento con ID $id.</p>";
    }

    $session->close();
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>