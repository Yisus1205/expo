<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_cliente = $_POST['nombre_cliente'];
    $email          = $_POST['email'];
    $telefono       = $_POST['telefono'];
    $direccion      = $_POST['direccion'];

    $stmt = $conn->prepare(
        "INSERT INTO clientes (nombre, email, telefono, direccion) VALUES (?, ?, ?, ?)"
    );
    $stmt->bind_param("ssss", $nombre_cliente, $email, $telefono, $direccion);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Cliente</title>
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
        <h2>Registrar Cliente</h2>
        <form method="post">
            <div class="mb-3">
                <label>Nombre:</label>
                <input type="text" name="nombre_cliente" class="form-control" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Email:</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Teléfono:</label>
                    <input type="text" name="telefono" class="form-control">
                </div>
            </div>
            <div class="mb-3">
                <label>Dirección:</label>
                <input type="text" name="direccion" class="form-control">
            </div>
            <button class="btn btn-success w-100">Guardar Cliente</button>
            <a href="index.php" class="btn btn-secondary w-100 mt-2">Cancelar</a>
        </form>
    </div>
</body>
</html>
