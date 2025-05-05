<?php
// Descripción: Inserta un nuevo evento en la base de datos de eventos de BaseX utilizando datos de un formulario POST.

include_once '../../load.php';

use BaseXClient\BaseXException;
use BaseXClient\Session;

/**
* @var string $nombre El nombre del evento de los datos POST, depurado.
* @var string $fecha La fecha del evento de los datos POST, depurado.
* @var string $descripcion La descripción del evento de los datos POST, depurado.
*/
$nombre = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '';
$fecha = isset($_POST['fecha']) ? htmlspecialchars($_POST['fecha']) : '';
$descripcion = isset($_POST['descripcion']) ? htmlspecialchars($_POST['descripcion']) : '';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "⚠️ Acceso inválido. Por favor, usa el formulario.";
    exit;
}

try {
    $session = new Session("localhost", 1984, "admin", "admin");
    $session->execute("open eventos");

    // Obtener el mayor ID existente y sumar 1
  /**
  * @var string $queryId XQuery para calcular el siguiente ID disponible.
  * @var string $id El nuevo ID de evento calculado.
  */
    $queryId = <<<XQ
XQUERY
  let \$ids := //evento/id
  return if (empty(\$ids)) then 1 else max(\$ids) + 1
XQ;

    $id = trim($session->execute($queryId));

    // Insertar nuevo evento
    /**
    * @var string $xqueryInsert XQuery para insertar el nuevo evento en la base de datos.
    */
    $xqueryInsert = <<<XQ
XQUERY
  insert node
    <evento>
      <id>$id</id>
      <nombre>$nombre</nombre>
      <fecha>$fecha</fecha>
      <descripcion>$descripcion</descripcion>
    </evento>
  into /eventos
XQ;

    $session->execute($xqueryInsert);
    echo "<p>✅ Evento insertado correctamente con ID $id.</p>";

    // Mostrar eventos actualizados
    $result = $session->execute("XQUERY //evento");
    echo "<h3>📋 Eventos actuales:</h3>";
    echo "<pre>" . htmlspecialchars($result) . "</pre>";

    $session->close();
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
echo '<a href="ver_eventos.php">Ver la lista de eventos</a>';
?>