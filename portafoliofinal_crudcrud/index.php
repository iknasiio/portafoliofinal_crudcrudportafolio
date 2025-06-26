<?php
include 'db.php';
$proyectos = $conn->query("SELECT * FROM proyectos ORDER BY created_at DESC LIMIT 3");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido | Portafolio de Marcelo</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Portafolio</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="#presentacion">Presentación</a></li>
                    <li class="nav-item"><a class="nav-link" href="#proyectos">Proyectos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contacto">Contacto</a></li>
                </ul>
                <a class="btn btn-light" href="login.php">Iniciar sesión</a>
            </div>
        </div>
    </nav>

    
    <div id="presentacion" class="container mt-5">
        <div class="row align-items-center">
            <div class="col-md-6 text-center">
                <img class="img-fluid rounded-circle" src="uploads/tu-imagen.jpg">">
                <h1 class="mt-3">Marcelo Arias</h1>
                <p>Portafolio orientado a un proyecto final mostrando distintas opciones.</p>
            </div>
            <div class="col-md-6">
                <h2>Habilidades</h2>
                <ul class="list-group">
                    <li class="list-group-item">HTML & CSS</li>
                    <li class="list-group-item">JavaScript</li>
                    <li class="list-group-item">PHP & MySQL</li>
                    <li class="list-group-item">React</li>
                    <li class="list-group-item">Git & GitHub</li>
                </ul>
            </div>
        </div>
    </div>

  
    <div id="proyectos" class="container mt-5">
        <h2 class="text-center">Proyectos recientes</h2>
        <div class="row">
            <?php while($row = $proyectos->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <?php if (!empty($row['imagen'])): ?>
                            <img src="uploads/<?= htmlspecialchars($row['imagen']) ?>" class="card-img-top" alt="Imagen de <?= htmlspecialchars($row['titulo']) ?>">
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
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <div id="contacto" class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h2>Contactos Directos</h2>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Teléfono:</strong> +123 456 789</li>
                    <li class="list-group-item"><strong>Correo:</strong> <a href="mailtoejemplo@example.com">ejemplo.mora@example.com</a></li>
                    <li class="list-group-item"><strong>Dirección:</strong> Calle Ficticia #123, Ciudad, País</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h2>Formulario de Contacto</h2>
                <form action="contact.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre:</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Mensaje:</label>
                        <textarea id="message" name="message" rows="5" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger">Enviar</button>
                </form>
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>