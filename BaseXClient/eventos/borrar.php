<?php
// Elimina un evento de la base de datos de eventos de BaseX según el ID proporcionado.

include_once '../../load.php';

use BaseXClient\Session;

/**
* @var string $id El ID del evento transmitido mediante la solicitud POST, depurado.
*/
$id = isset($_POST['id']) ? htmlspecialchars($_POST['id']) : '';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "⚠️ Acceso inválido. Por favor, usa el formulario.";
    exit;
}

if (empty($id)) {
    echo "⚠️ ID no proporcionado.";
    exit;
}

try {
    $session = new Session("localhost", 1984, "admin", "admin");
    $session->execute("open eventos");

    // Eliminar evento por ID
    /**
    * @var string $xqueryDelete XQuery para eliminar el evento con el ID especificado.
    */
    $xqueryDelete = <<<XQ
XQUERY
delete node //evento[id='$id']
XQ;
    $session->execute($xqueryDelete);
    echo "<p>✅ Evento con ID $id eliminado correctamente.</p>";
    echo '<a href="ver_eventos.php">Volver a la lista de eventos</a>';

    $session->close();
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>