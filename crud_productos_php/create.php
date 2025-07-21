<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre       = $_POST['nombre'];
    $descripcion  = $_POST['descripcion'];
    $precio       = $_POST['precio'];
    $cantidad     = $_POST['cantidad'];
    $id_categoria = $_POST['id_categoria'];
    $id_cliente   = $_POST['id_cliente'];

    $stmt = $conn->prepare(
        "INSERT INTO productos (nombre, descripcion, precio, cantidad, id_categoria, id_cliente)
         VALUES (?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("ssdiii", $nombre, $descripcion, $precio, $cantidad, $id_categoria, $id_cliente);
    $stmt->execute();

    header("Location: index.php");
    exit;
}

$categorias = $conn->query("SELECT id_categoria, nombre FROM categorias")->fetch_all(MYSQLI_ASSOC);
$clientes   = $conn->query("SELECT id_cliente, nombre FROM clientes")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #fce4ec, #e1f5fe);
            font-family: 'Segoe UI', sans-serif;
            color: #333;
        }
        .form-card {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        h2 {
            color: #7c4dff;
            font-weight: bold;
        }
        .btn-success {
            background-color: #00bfa5;
            border-color: #00bfa5;
        }
        .btn-success:hover {
            background-color: #1de9b6;
        }
        .btn-primary {
            background-color: #ba68c8;
            border-color: #ba68c8;
        }
        .btn-primary:hover {
            background-color: #ab47bc;
        }
        label {
            font-weight: 600;
            color: #555;
        }
        input.form-control, textarea.form-control, select.form-select {
            border-radius: 0.75rem;
        }
        hr {
            border-top: 2px dashed #ddd;
        }
    </style>
</head>
<body class="container py-5">
    <div class="form-card">
        <h2>Registrar Producto</h2>
        <form method="post">
            <div class="mb-3">
                <label>Nombre:</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Descripción:</label>
                <textarea name="descripcion" class="form-control"></textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Precio:</label>
                    <input type="number" step="0.01" name="precio" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Cantidad:</label>
                    <input type="number" name="cantidad" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Categoría:</label>
                    <select name="id_categoria" class="form-select" required>
                        <option value="" disabled selected>Seleccionar</option>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?= $cat['id_categoria'] ?>"><?= htmlspecialchars($cat['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Cliente:</label>
                    <select name="id_cliente" class="form-select" required>
                        <option value="" disabled selected>Seleccionar</option>
                        <?php foreach ($clientes as $cli): ?>
                            <option value="<?= $cli['id_cliente'] ?>"><?= htmlspecialchars($cli['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <button class="btn btn-success w-100">Guardar Producto</button>
            <a href="index.php" class="btn btn-secondary w-100 mt-2">Cancelar</a>
        </form>
    </div>
</body>
</html>
