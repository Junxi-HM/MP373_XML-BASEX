<?php
//Gestiona la creación y eliminación de la base de datos 'resultadoseconomicos' en BaseX.

include_once '../../load.php';

use BaseXClient\Session;

/**
* Crea una nueva base de datos en BaseX.
* @param string $dbName El nombre de la base de datos que se creará.
*/
function createDatabase($dbName) {
    try {
        $session = new Session("localhost", 1984, "admin", "admin");
        $session->execute("CREATE DB $dbName");
        echo "<p>✅ Base de datos '$dbName' creada correctamente.</p>";
        $session->close();
    } catch (Exception $e) {
        echo "❌ Error al crear la base de datos: " . $e->getMessage();
    }
}

/**
* Elimina una base de datos existente en BaseX.
* @param string $dbName El nombre de la base de datos que se eliminará.
*/
function deleteDatabase($dbName) {
    try {
        $session = new Session("localhost", 1984, "admin", "admin");
        $session->execute("DROP DB $dbName");
        echo "<p>✅ Base de datos '$dbName' eliminada correctamente.</p>";
        $session->close();
    } catch (Exception $e) {
        echo "❌ Error al eliminar la base de datos: " . $e->getMessage();
    }
}

/**
* @var string $action La acción a realizar ('crear' o 'eliminar') de la solicitud POST.
* @var string $dbName El nombre de la base de datos ('resultadoseconomicos').
*/
$action = isset($_POST['action']) ? $_POST['action'] : '';
$dbName = 'resultadoseconomicos';

if ($action === 'create') {
    createDatabase($dbName);
} elseif ($action === 'delete') {
    deleteDatabase($dbName);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Base de Datos Resultados Económicos</title>
</head>
<body>
    <h2>Gestionar Base de Datos Resultados Económicos</h2>
    <form action="resultadoseconomicos.php" method="post">
        <button type="submit" name="action" value="create">Crear Base de Datos</button>
        <button type="submit" name="action" value="delete">Eliminar Base de Datos</button>
    </form>
    <br>
    <a href="ver_eventos.php">Volver a la lista de eventos</a>
</body>
</html>