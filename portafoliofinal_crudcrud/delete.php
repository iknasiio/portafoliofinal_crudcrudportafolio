<?php
session_start();
include 'auth.php';
include 'db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']); // Aseguramos que el ID sea un entero válido

    // Consulta para eliminar el proyecto
    $stmt = $conn->prepare("DELETE FROM proyectos WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: proyectos.php");
        exit;
    } else {
        $error = "Error al eliminar el proyecto.";
    }
} else {
    $error = "ID de proyecto no válido.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Proyecto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <a href="proyectos.php" class="btn btn-primary">Volver a Proyectos</a>
    </div>
</body>
</html>