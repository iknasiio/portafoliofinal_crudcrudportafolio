<?php
include 'auth.php';
include 'db.php';

$proyectos = $conn->query("SELECT * FROM proyectos ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos | Portafolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Portafolio</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                
                </ul>
                <a href="index.php" class="btn btn-light">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

   
    <div class="container mt-5">
        <div class="d-flex justify-content-end">
            <a href="add.php" class="btn btn-danger">Crear Proyecto</a>
        </div>
    </div>

    
    <div class="container mt-5">
        <h2 class="text-center">Todos los Proyectos</h2>
        <div class="row">
            <?php while ($row = $proyectos->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        
                        <?php if (!empty($row['imagen'])): ?>
                            <img src="uploads/<?= htmlspecialchars($row['imagen']) ?>" class="card-img-top" alt="Imagen de <?= htmlspecialchars($row['titulo']) ?>">
                        <?php else: ?>
                            <img src="uploads/default.jpg" class="card-img-top" alt="Imagen por defecto">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['titulo']) ?></h5>
                            <p class="card-text"><?= nl2br(htmlspecialchars($row['descripcion'])) ?></p>
                            <div class="d-flex justify-content-between">
                                <?php if (!empty($row['url_github'])): ?>
                                    <a href="<?= htmlspecialchars($row['url_github']) ?>" class="btn btn-danger" target="_blank">GitHub</a>
                                <?php endif; ?>
                                <?php if (!empty($row['url_produccion'])): ?>
                                    <a href="<?= htmlspecialchars($row['url_produccion']) ?>" class="btn btn-danger" target="_blank">Enlace</a>
                                <?php endif; ?>
                            </div>
                            <div class="mt-3">
                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning w-100 mb-2">Editar</a>
                                <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger w-100">Eliminar</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>