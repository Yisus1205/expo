<?php
include 'db.php';

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    die("ID inválido.");
}

$stmt = $conn->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$producto = $result->fetch_assoc();

if (!$producto) {
    die("Producto no encontrado.");
}

$stmt_cat = $conn->prepare("SELECT * FROM categorias WHERE id_categoria = ?");
$stmt_cat->bind_param("i", $producto['id_categoria']);
$stmt_cat->execute();
$result_cat = $stmt_cat->get_result();
$categoria = $result_cat->fetch_assoc();

$stmt_cli = $conn->prepare("SELECT * FROM clientes WHERE id_cliente = ?");
$stmt_cli->bind_param("i", $producto['id_cliente']);
$stmt_cli->execute();
$result_cli = $stmt_cli->get_result();
$cliente = $result_cli->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre       = $_POST['nombre'];
    $descripcion  = $_POST['descripcion'];
    $precio       = $_POST['precio'];
    $cantidad     = $_POST['cantidad'];
    $nombre_categoria = $_POST['nombre_categoria'];
    $nombre_cliente   = $_POST['nombre_cliente'];
    $email_cliente    = $_POST['email_cliente'];
    $telefono_cliente = $_POST['telefono_cliente'];
    $direccion_cliente= $_POST['direccion_cliente'];

    $stmt_update_cat = $conn->prepare("UPDATE categorias SET nombre=? WHERE id_categoria=?");
    $stmt_update_cat->bind_param("si", $nombre_categoria, $producto['id_categoria']);
    $stmt_update_cat->execute();

    $stmt_update_cli = $conn->prepare("UPDATE clientes SET nombre=?, email=?, telefono=?, direccion=? WHERE id_cliente=?");
    $stmt_update_cli->bind_param("ssssi", $nombre_cliente, $email_cliente, $telefono_cliente, $direccion_cliente, $producto['id_cliente']);
    $stmt_update_cli->execute();

    $stmt_update_prod = $conn->prepare("UPDATE productos SET nombre=?, descripcion=?, precio=?, cantidad=? WHERE id=?");
    $stmt_update_prod->bind_param("ssdii", $nombre, $descripcion, $precio, $cantidad, $id);
    $stmt_update_prod->execute();

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>Editar Producto</h2>
    <form method="post">
        <h4>Producto</h4>
        <div class="mb-3">
            <label>Nombre:</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Descripción:</label>
            <textarea name="descripcion" class="form-control"><?= htmlspecialchars($producto['descripcion']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Precio:</label>
            <input type="number" step="0.01" name="precio" class="form-control" value="<?= htmlspecialchars($producto['precio']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Cantidad:</label>
            <input type="number" name="cantidad" class="form-control" value="<?= htmlspecialchars($producto['cantidad']) ?>" required>
        </div>

        <h4>Categoría Asociada</h4>
        <div class="mb-3">
            <label>Nombre Categoría:</label>
            <input type="text" name="nombre_categoria" class="form-control" value="<?= htmlspecialchars($categoria['nombre']) ?>" required>
        </div>

        <h4>Cliente Asociado</h4>
        <div class="mb-3">
            <label>Nombre Cliente:</label>
            <input type="text" name="nombre_cliente" class="form-control" value="<?= htmlspecialchars($cliente['nombre']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Email Cliente:</label>
            <input type="email" name="email_cliente" class="form-control" value="<?= htmlspecialchars($cliente['email']) ?>">
        </div>
        <div class="mb-3">
            <label>Teléfono Cliente:</label>
            <input type="text" name="telefono_cliente" class="form-control" value="<?= htmlspecialchars($cliente['telefono']) ?>">
        </div>
        <div class="mb-3">
            <label>Dirección Cliente:</label>
            <input type="text" name="direccion_cliente" class="form-control" value="<?= htmlspecialchars($cliente['direccion']) ?>">
        </div>

        <button class="btn btn-primary">Actualizar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>
