<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Dashboard</span>
        </div>
    </nav>

    <section class="container text-center">
        <h2 class="mb-4">Gestión de Productos</h2>

        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <form action="./views/productos/listar.php" method="get">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-card-list me-1"></i> Listar Productos
                </button>
            </form>

            <form action="./views/productos/registrar.php" method="get">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-plus-circle me-1"></i> Registrar Producto
                </button>
            </form>

            <form action="./views/productos/editar.php" method="get">
                <button type="submit" class="btn btn-warning text-white">
                    <i class="bi bi-pencil-square me-1"></i> Editar Producto
                </button>
            </form>
        </div>
    </section>

    <footer class="text-center mt-5 text-muted">
        <p>&copy; 2025 - Tu Empresa</p>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>