<?php
include 'db.php';

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) die("ID inválido.");

$stmt = $conn->prepare("SELECT * FROM clientes WHERE id_cliente = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$cliente = $stmt->get_result()->fetch_assoc();

if (!$cliente) die("Cliente no encontrado.");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    $update = $conn->prepare("UPDATE clientes SET nombre=?, email=?, telefono=?, direccion=? WHERE id_cliente=?");
    $update->bind_param("ssssi", $nombre, $email, $telefono, $direccion, $id);
    $update->execute();
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>Editar Cliente</h2>
    <form method="post">
        <div class="mb-3">
            <label>Nombre:</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($cliente['nombre']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($cliente['email']) ?>">
        </div>
        <div class="mb-3">
            <label>Teléfono:</label>
            <input type="text" name="telefono" class="form-control" value="<?= htmlspecialchars($cliente['telefono']) ?>">
        </div>
        <div class="mb-3">
            <label>Dirección:</label>
            <input type="text" name="direccion" class="form-control" value="<?= htmlspecialchars($cliente['direccion']) ?>">
        </div>
        <button class="btn btn-primary">Actualizar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>
