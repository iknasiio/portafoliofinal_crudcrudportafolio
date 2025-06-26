<?php
include 'auth.php';
include 'db.php';

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
            $stmt = $conn->prepare("INSERT INTO proyectos (titulo, descripcion, url_github, url_produccion, imagen) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $titulo, $descripcion, $url_github, $url_produccion, $imagenNombre);
            $stmt->execute();
            $stmt->close();

            header("Location: proyectos.php");
            exit;
        } else {
            $error = "Error al subir la imagen.";
        }
    } else {
        $error = "Debe subir una imagen válida.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Proyecto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Portafolio</a>
        </div>
    </nav>

    <!-- Formulario para agregar proyecto -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center">Agregar Proyecto</h2>
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>
                        <form action="add.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título:</label>
                                <input type="text" id="titulo" name="titulo" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción:</label>
                                <textarea id="descripcion" name="descripcion" rows="5" class="form-control" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="imagen" class="form-label">Imagen:</label>
                                <input type="file" id="imagen" name="imagen" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="url_github" class="form-label">URL GitHub:</label>
                                <input type="url" id="url_github" name="url_github" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="url_produccion" class="form-label">URL Producción:</label>
                                <input type="url" id="url_produccion" name="url_produccion" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-danger w-100">Agregar Proyecto</button>
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