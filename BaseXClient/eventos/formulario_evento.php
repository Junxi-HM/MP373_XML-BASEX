<?php
// Proporciona un formulario HTML para que los usuarios introduzcan los detalles de nuevos eventos que se insertarán en la base de datos.
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Añadir Evento</title>
</head>
<body>
  <h2>Nuevo Evento</h2>
  <form action="insertar.php" method="post">
    <label>Nombre: <input type="text" name="nombre" required></label><br>
    <label>Fecha: <input type="date" name="fecha" required></label><br>
    <label>Descripción:<br>
      <textarea name="descripcion" rows="4" cols="40" required></textarea>
    </label><br><br>
    <button type="submit">Guardar evento</button>
  </form>
</body>
</html>