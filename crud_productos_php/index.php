<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión CRUD con DataTables</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
</head>
<body class="container py-4">

    <h1 class="mb-4">Gestión de Productos, Categorías y Clientes</h1>

    <!-- PRODUCTOS -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-primary mb-0">Productos</h2>
        <a href="create.php" class="btn btn-success">➕ Ingresar Producto</a>
    </div>

    <table id="productos" class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th><th>Nombre</th><th>Precio</th><th>Cantidad</th>
                <th>Categoría</th><th>Cliente</th><th>Email</th><th>Teléfono</th><th>Dirección</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT p.id, p.nombre AS nombre_producto, p.precio, p.cantidad,
                       c.nombre AS nombre_categoria,
                       cli.nombre AS nombre_cliente, cli.email, cli.telefono, cli.direccion
                FROM productos p
                LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
                LEFT JOIN clientes cli ON p.id_cliente = cli.id_cliente
                ORDER BY p.id";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()):
        ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['nombre_producto']) ?></td>
                <td>$<?= number_format($row['precio'],2) ?></td>
                <td><?= $row['cantidad'] ?></td>
                <td><?= htmlspecialchars($row['nombre_categoria'] ?? '—') ?></td>
                <td><?= htmlspecialchars($row['nombre_cliente'] ?? '—') ?></td>
                <td><?= htmlspecialchars($row['email']   ?? '—') ?></td>
                <td><?= htmlspecialchars($row['telefono']?? '—') ?></td>
                <td><?= htmlspecialchars($row['direccion']?? '—') ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">✏️</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('¿Eliminar producto?')">🗑️</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- CATEGORÍAS -->
    <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
        <h2 class="text-primary mb-0">Categorías</h2>
        <a href="create_categoria.php" class="btn btn-success">➕ Ingresar Categoría</a>
    </div>

    <table id="categorias" class="table table-bordered table-striped align-middle">
        <thead class="table-secondary">
            <tr>
                <th>ID</th><th>Nombre</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $catR = $conn->query("SELECT id_categoria, nombre FROM categorias ORDER BY id_categoria");
        while ($cat = $catR->fetch_assoc()):
        ?>
            <tr>
                <td><?= $cat['id_categoria'] ?></td>
                <td><?= htmlspecialchars($cat['nombre']) ?></td>
                <td>
                    <a href="edit_categoria.php?id=<?= $cat['id_categoria'] ?>" class="btn btn-warning btn-sm">✏️</a>
                    <a href="delete_categoria.php?id=<?= $cat['id_categoria'] ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('¿Eliminar categoría?')">🗑️</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- CLIENTES -->
    <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
        <h2 class="text-primary mb-0">Clientes</h2>
        <a href="create_cliente.php" class="btn btn-success">➕ Ingresar Cliente</a>
    </div>

    <table id="clientes" class="table table-bordered table-striped align-middle">
        <thead class="table-secondary">
            <tr>
                <th>ID</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Dirección</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $cliR = $conn->query("SELECT id_cliente, nombre, email, telefono, direccion FROM clientes ORDER BY id_cliente");
        while ($cli = $cliR->fetch_assoc()):
        ?>
            <tr>
                <td><?= $cli['id_cliente'] ?></td>
                <td><?= htmlspecialchars($cli['nombre']) ?></td>
                <td><?= htmlspecialchars($cli['email']     ?? '—') ?></td>
                <td><?= htmlspecialchars($cli['telefono']  ?? '—') ?></td>
                <td><?= htmlspecialchars($cli['direccion'] ?? '—') ?></td>
                <td>
                    <a href="edit_cliente.php?id=<?= $cli['id_cliente'] ?>" class="btn btn-warning btn-sm">✏️</a>
                    <a href="delete_cliente.php?id=<?= $cli['id_cliente'] ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('¿Eliminar cliente?')">🗑️</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#productos').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json'
                }
            });
            $('#categorias').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json'
                }
            });
            $('#clientes').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json'
                }
            });
        });
    </script>
</body>
</html>
