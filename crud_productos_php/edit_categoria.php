<?php
include 'db.php';

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) die("ID inválido.");

$stmt = $conn->prepare("SELECT * FROM categorias WHERE id_categoria = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$categoria = $stmt->get_result()->fetch_assoc();

if (!$categoria) die("Categoría no encontrada.");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $update = $conn->prepare("UPDATE categorias SET nombre = ? WHERE id_categoria = ?");
    $update->bind_param("si", $nombre, $id);
    $update->execute();
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Categoría</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>Editar Categoría</h2>
    <form method="post">
        <div class="mb-3">
            <label>Nombre:</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($categoria['nombre']) ?>" required>
        </div>
        <button class="btn btn-primary">Actualizar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>
