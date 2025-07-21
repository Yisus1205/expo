<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_categoria = $_POST['nombre_categoria'];

    $stmt = $conn->prepare("INSERT INTO categorias (nombre) VALUES (?)");
    $stmt->bind_param("s", $nombre_categoria);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Categoría</title>
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
        <h2>Registrar Categoría</h2>
        <form method="post">
            <div class="mb-3">
                <label>Nombre de la Categoría:</label>
                <input type="text" name="nombre_categoria" class="form-control" required>
            </div>
            <button class="btn btn-primary w-100">Guardar Categoría</button>
            <a href="index.php" class="btn btn-secondary w-100 mt-2">Cancelar</a>
        </form>
    </div>
</body>
</html>
