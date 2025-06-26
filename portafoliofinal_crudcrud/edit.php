<?php
include 'auth.php';
include 'db.php';

$id = (int)$_GET['id']; // Aseguramos que el ID sea un entero

// Obtenemos los datos del proyecto actual
$stmt = $conn->prepare("SELECT * FROM proyectos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$proyecto = $result->fetch_assoc();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $url_github = trim($_POST['url_github']);
    $url_produccion = trim($_POST['url_produccion']);

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagenTmp = $_FILES['imagen']['tmp_name'];
        $imagenNombre = basename($_FILES['imagen']['name']);
        $uploadDir = "uploads/";
        $uploadFile = $uploadDir . $imagenNombre;

        if (move_uploaded_file($imagenTmp, $uploadFile)) {
            $stmt = $conn->prepare("UPDATE proyectos SET titulo = ?, descripcion = ?, url_github = ?, url_produccion = ?, imagen = ? WHERE id = ?");
            $stmt->bind_param("sssssi", $titulo, $descripcion, $url_github, $url_produccion, $imagenNombre, $id);
        } else {
            $error = "Error al subir la imagen.";
        }
    } else {
        $stmt = $conn->prepare("UPDATE proyectos SET titulo = ?, descripcion = ?, url_github = ?, url_produccion = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $titulo, $descripcion, $url_github, $url_produccion, $id);
    }

    $stmt->execute();
    $stmt->close();

    header("Location: proyectos.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proyecto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Portafolio</a>
        </div>
    </nav>

    <!-- Formulario para editar proyecto -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center">Editar Proyecto</h2>
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>
                        <form action="edit.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título:</label>
                                <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($proyecto['titulo']) ?>" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción:</label>
                                <textarea id="descripcion" name="descripcion" rows="5" class="form-control" required><?= htmlspecialchars($proyecto['descripcion']) ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="imagen" class="form-label">Imagen:</label>
                                <input type="file" id="imagen" name="imagen" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="url_github" class="form-label">URL GitHub:</label>
                                <input type="url" id="url_github" name="url_github" value="<?= htmlspecialchars($proyecto['url_github']) ?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="url_produccion" class="form-label">URL Producción:</label>
                                <input type="url" id="url_produccion" name="url_produccion" value="<?= htmlspecialchars($proyecto['url_produccion']) ?>" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-danger w-100">Guardar Cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>