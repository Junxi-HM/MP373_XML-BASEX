<?php
// Permite editar un evento existente en la base de datos de eventos de BaseX por ID.

include_once '../../load.php';

use BaseXClient\Session;

/**
* @var string $id El ID del evento pasado mediante la solicitud GET, depurado.
* @var string $action La acción a realizar ('actualizar') desde la solicitud POST.
*/
$id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';
$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    /**
    * @var string $nombre El nombre del evento actualizado a partir de los datos POST, depurado.
    * @var string $fecha La fecha del evento actualizada a partir de los datos POST, depurada.
    * @var string $descripcion La descripción del evento actualizada a partir de los datos POST, depurada.
    */
    $nombre = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '';
    $fecha = isset($_POST['fecha']) ? htmlspecialchars($_POST['fecha']) : '';
    $descripcion = isset($_POST['descripcion']) ? htmlspecialchars($_POST['descripcion']) : '';

    try {
        $session = new Session("localhost", 1984, "admin", "admin");
        $session->execute("open eventos");

        // Actualizar evento por ID
        /**
        * @var string $xqueryUpdate XQuery para actualizar los detalles del evento.
        */
        $xqueryUpdate = <<<XQ
XQUERY
replace node //evento[id='$id']/nombre with <nombre>$nombre</nombre>,
replace node //evento[id='$id']/fecha with <fecha>$fecha</fecha>,
replace node //evento[id='$id']/descripcion with <descripcion>$descripcion</descripcion>
XQ;
        $session->execute($xqueryUpdate);
        echo "<p>✅ Evento con ID $id actualizado correctamente.</p>";
        echo '<a href="ver_eventos.php">Volver a la lista de eventos</a>';

        $session->close();
        exit;
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage();
        exit;
    }
}

if (empty($id)) {
    echo "⚠️ ID no proporcionado.";
    exit;
}

try {
    $session = new Session("localhost", 1984, "admin", "admin");
    $session->execute("open eventos");

    // Consulta para obtener el evento por ID
    /**
    * @var string $input XQuery para obtener el evento por ID.
    */
    $input = "for \$e in //evento[id='$id'] return \$e";
    $query = $session->query($input);
    /**
    * @var string $result Cadena XML sin procesar que contiene los datos del evento.
    */
    $result = $query->execute();
    $query->close();


    $xml = simplexml_load_string("<eventos>$result</eventos>");

    if ($xml->evento) {
        $evento = $xml->evento;
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Editar Evento ID <?php echo $id; ?></title>
        </head>
        <body>
            <h2>Editar Evento ID <?php echo $id; ?></h2>
            <form action="EditarEvento.php?id=<?php echo $id; ?>" method="post">
                <input type="hidden" name="action" value="update">
                <label>Nombre: <input type="text" name="nombre" value="<?php echo htmlentities($evento->nombre); ?>" required></label><br>
                <label>Fecha: <input type="date" name="fecha" value="<?php echo htmlentities($evento->fecha); ?>" required></label><br>
                <label>Descripción:<br>
                    <textarea name="descripcion" rows="4" cols="40" required><?php echo htmlentities($evento->descripcion); ?></textarea>
                </label><br><br>
                <button type="submit">Guardar Cambios</button>
            </form>
            <br>
            <a href="ver_eventos.php">Volver a la lista de eventos</a>
        </body>
        </html>
        <?php
    } else {
        echo "<p>⚠️ No se encontró ningún evento con ID $id.</p>";
        echo '<a href="ver_eventos.php">Ver la lista de eventos</a>';
        echo "<br>";
        echo '<a href="eventos.html">Volver a la formulario de eventos</a>';
    }

    $session->close();
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>