<?php
// Muestra una lista de todos los eventos almacenados en la base de datos 'eventos' de BaseX en formato de tabla.

include_once '../../load.php';

use BaseXClient\BaseXException;
use BaseXClient\Session;

try {
    // Conectar a BaseX
    $session = new Session("localhost", 1984, "admin", "admin");

    // Ejecutar la consulta XQuery para obtener todos los eventos
    $session->execute("open eventos");
    /**
    * @var string $input XQuery para obtener todos los eventos.
    */
    $input = 'for $a in ./eventos return $a';
    $query = $session->query($input);
    
    // Obtener la cadena XML de la consulta
    /**
    * @var string $xmlString Cadena XML sin procesar devuelta por la consulta.
    */
    $xmlString = $query->execute();
    
    //Cerrar la consulta
    $query->close();
    
    // Cerrar la sesión en BaseX
    $session->close();

    // Convertir la cadena XML en un objeto SimpleXML
    /**
    * @var SimpleXMLElement $xml XML analizado que contiene todos los datos del evento.
    */
    $xml = simplexml_load_string($xmlString);
} catch (Exception $e) {
    die("❌ Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Eventos</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        form { text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Lista de Eventos</h2>

    <!-- Formulario para refrescar la lista -->
    <form action="ver_eventos.php" method="post">
        <button type="submit">Refrescar lista</button>
    </form>

    <?php if($xml && isset($xml->evento)): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Descripción</th>
            </tr>
            <?php foreach($xml->evento as $evento): ?>
                <tr>
                    <td><?php echo htmlspecialchars($evento->id); ?></td>
                    <td><?php echo htmlspecialchars($evento->nombre); ?></td>
                    <td><?php echo htmlspecialchars($evento->fecha); ?></td>
                    <td><?php echo htmlspecialchars($evento->descripcion); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p style="text-align:center;">No hay eventos registrados.</p>
    <?php endif; ?>
    <a href="../../eventos.html"><p style="text-align: center">Ir a Formulario de Eventos</p></a>
</body>
</html>